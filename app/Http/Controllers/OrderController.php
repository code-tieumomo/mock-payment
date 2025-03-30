<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Services\MomoService;
use App\Services\OrderService;
use App\Services\UtilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function __construct(
        public OrderService $orderService,
        public MomoService  $momoService
    )
    {
    }


    public function store(CreateOrderRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $user = $request->header('Authorization');
            $apiKey = str_replace('Bearer ', '', $user);
            $user = User::where('api_key', $apiKey)->first();

            $order = $this->orderService->createOrder($validated, $user);
            $payUrl = $this->momoService->atm($order);
            if (!$payUrl) {
                throw new \Exception('Failed to create payment URL');
            }

            DB::commit();

            return response()->json([
                'message' => 'Order created successfully',
                'data' => [
                    'order' => $order,
                    'pay_url' => $payUrl,
                ],
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Error occurred while creating order item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function success(Order $order)
    {
        return Inertia::render('OrderSuccess', [
            'order' => $order,
        ]);
    }

    public function cancel(Order $order)
    {

    }

    public function failure(Order $order)
    {

    }

    public function webhook(Order $order, Request $request)
    {
        Log::debug('Webhook received', [
            'request' => $request->all(),
        ]);

        $orderId = $request->input('orderId');
        if ($orderId != $order->id) {
            return response()->json([
                'message' => 'Order ID mismatch',
            ], 400);
        }

        $resultCode = $request->input('resultCode');
        if (in_array($resultCode, [0, 7002])) {
            $order->status = 'paid';
            $order->save();
        }

        return response()->json([], 204);
    }

    public function history()
    {
        $orders = Auth::user()->orders()
            ->with('orderItems')
            ->orderBy('created_at', 'desc')
            ->get();

        $orders->each(function (Order $order) {
            $order->grand_total = UtilService::moneyFormat($order->grand_total);
            $order->total_price = UtilService::moneyFormat($order->total_price);
            $order->discount = UtilService::moneyFormat($order->discount);
            $order->total_discount = UtilService::moneyFormat($order->total_discount);
            $order->tax = UtilService::moneyFormat($order->tax);
            $order->total_tax = UtilService::moneyFormat($order->total_tax);
            $order->shipping_cost = UtilService::moneyFormat($order->shipping_cost);

            $order->total_item_discount = $order->orderItems->sum('discount');
            $order->total_item_discount = UtilService::moneyFormat($order->total_item_discount);

            $order->total_item_tax = $order->orderItems->sum('tax');
            $order->total_item_tax = UtilService::moneyFormat($order->total_item_tax);

            $order->orderItems->each(function (OrderItem $orderItem) {
                $orderItem->total_price = UtilService::moneyFormat(
                    $orderItem->price * $orderItem->quantity
                );

                $orderItem->price = UtilService::moneyFormat($orderItem->price);
                $orderItem->quantity = UtilService::moneyFormat($orderItem->quantity);
                $orderItem->discount = UtilService::moneyFormat($orderItem->discount);
                $orderItem->tax = UtilService::moneyFormat($orderItem->tax);
            });
        });

        return Inertia::render('OrderHistory', [
            'orders' => $orders,
        ]);
    }
}
