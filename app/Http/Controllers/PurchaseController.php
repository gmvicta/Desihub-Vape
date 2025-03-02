<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    public function index()
    {
        // Example vape shop purchases (Replace with DB data later)
        $purchases = [
            ['id' => 1, 'product' => ['name' => 'GeekVape Aegis X', 'price' => 75.99], 'status' => 'Completed'],
            ['id' => 2, 'product' => ['name' => 'Vaporesso XROS 3', 'price' => 32.50], 'status' => 'Pending'],
            ['id' => 3, 'product' => ['name' => 'SMOK Nord 5 Kit', 'price' => 40.00], 'status' => 'Cancelled'],
        ];

        return Inertia::render('User/Purchase', [
            'purchases' => $purchases,
        ]);
    }
}
