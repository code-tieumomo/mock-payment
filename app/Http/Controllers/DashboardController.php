<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $orderCount = Auth::user()->orders()
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        $revenue = Auth::user()->orders()
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('status', 'paid')
            ->sum('grand_total');

        return Inertia::render('Dashboard', [
            'orderCount' => number_format($orderCount),
            'revenue' => number_format($revenue),
        ]);
    }
}
