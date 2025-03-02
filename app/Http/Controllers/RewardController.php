<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class RewardController extends Controller
{
    public function index()
    {
        // Dummy data ng rewardsSS
        $rewards = [
            ['id' => 1, 'title' => 'Free Coffee', 'description' => 'Enjoy a hot cup of coffee!', 'points_required' => 100, 'image' => '/images/coffee.jpg'],
            ['id' => 2, 'title' => 'Discount Voucher', 'description' => 'Get a 10% discount on your next purchase.', 'points_required' => 200, 'image' => '/images/discount.jpg'],
            ['id' => 3, 'title' => 'Gift Item', 'description' => 'Receive a special gift.', 'points_required' => 500, 'image' => '/images/gift.jpg'],
        ];

        // Dummy user points (gawin itong dynamic kapag may database na)
        $userPoints = 250;

        return Inertia::render('User/Rewards', [
            'rewards' => $rewards,
            'userPoints' => $userPoints
        ]);
    }

    public function redeem($id)
    {
        return redirect()->back()->with('message', 'Redemption successful!');
    }
}
