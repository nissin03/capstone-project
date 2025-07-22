<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAmount = 30000;
        $percentageChange = 2.25;
        $date = '2023-06-25';

        return Inertia::render('Admin/Dashboard', [
            'user' => 'John Robin',
            'reservationSummary' => [
                'totalAmount' => $totalAmount,
                'percentageChange' => $percentageChange,
                'date' => $date,
            ],
        ]);
    }
}
