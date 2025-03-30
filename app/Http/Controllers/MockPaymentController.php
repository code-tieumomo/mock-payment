<?php

namespace App\Http\Controllers;

use App\Services\MomoService;
use Illuminate\Http\Request;

class MockPaymentController extends Controller
{
    public function __construct(
        public MomoService $momoService,
    )
    {
    }

    public function atm(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000|max:50000000',
            'redirect_url' => 'required|url',
            'order_info' => 'nullable|string',
        ]);

        return $this->momoService->atm($request->all());
    }
}
