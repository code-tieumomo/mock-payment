<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Arr;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createOrder(array $orderData, User $user)
    {
        $orderItems = collect($orderData['order_items']);

        $totalPrice = $orderItems->sum(function ($item) {
            return $item['price'] * ($item['quantity']);
        });

        $orderDiscount = Arr::get($orderData, 'discount', 0);
        $itemDiscount = $orderItems->sum(function ($item) {
            return ($item['discount'] ?? 0) * ($item['quantity']);
        });

        $orderTax = Arr::get($orderData, 'tax', 0);
        $itemTax = $orderItems->sum(function ($item) {
            return $item['tax'] ?? 0;
        });

        $shippingCost = Arr::get($orderData, 'shipping_cost', 0);

        $grandTotal = $totalPrice - $orderDiscount - $itemDiscount + $shippingCost + $orderTax + $itemTax;

        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $totalPrice,
            'discount' => $orderDiscount,
            'total_discount' => $itemDiscount + $orderDiscount,
            'tax' => $orderTax,
            'total_tax' => $itemTax + $orderTax,
            'shipping_cost' => $shippingCost,
            'grand_total' => $grandTotal,
            'currency' => Arr::get($orderData, 'currency', 'VND'),
            'payment_method' => 'MOMO',
            'status' => 'pending',
            'success_url' => Arr::get($orderData, 'success_url'),
            'cancel_url' => Arr::get($orderData, 'cancel_url'),
            'failure_url' => Arr::get($orderData, 'failure_url'),
            'extras' => Arr::get($orderData, 'extras'),
        ]);

        $orderItems->each(function ($item) use ($order) {
            $total = $item['price'] * ($item['quantity']);
            $discount = Arr::get($item, 'discount', 0);
            $tax = Arr::get($item, 'tax', 0);

            $order->orderItems()->create([
                'name' => $item['name'],
                'price' => $item['price'],
                'discount' => Arr::get($item, 'discount', 0),
                'tax' => Arr::get($item, 'tax', 0),
                'grand_total' => $total - $discount + $tax,
                'quantity' => $item['quantity'],
                'thumbnail' => Arr::get($item, 'thumbnail'),
                'extras' => Arr::get($item, 'extras'),
            ]);
        });

        return $order;
    }
}
