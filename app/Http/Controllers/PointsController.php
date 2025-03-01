<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLoyaltyPoints;
use App\Models\Transaction;
use App\Models\User;

class PointsController extends Controller
{
    // Magdagdag ng Loyalty Points
    public function earnPoints(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $loyalty = UserLoyaltyPoints::firstOrCreate(['user_id' => $user->id]);

        // Magdagdag ng points
        $loyalty->increment('loyalty_points', $request->points);

        // I-save ang transaction
        Transaction::create([
            'user_id' => $user->id,
            'loyalty_id' => $loyalty->id,
            'points' => $request->points,
            'type' => 'earn',
        ]);

        return response()->json([
            'message' => 'Points added successfully!',
            'new_balance' => $loyalty->loyalty_points
        ]);
    }

    // Mag-redeem ng Loyalty Points
    public function redeemPoints(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $loyalty = UserLoyaltyPoints::where('user_id', $user->id)->firstOrFail();

        if ($loyalty->loyalty_points < $request->points) {
            return response()->json(['message' => 'Insufficient points'], 400);
        }

        // Bawasan ang points
        $loyalty->decrement('loyalty_points', $request->points);

        // I-save ang transaction
        Transaction::create([
            'user_id' => $user->id,
            'loyalty_id' => $loyalty->id,
            'points' => $request->points,
            'type' => 'redeem',
        ]);

        return response()->json([
            'message' => 'Points redeemed successfully!',
            'new_balance' => $loyalty->loyalty_points
        ]);
    }
}
