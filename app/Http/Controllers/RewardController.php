<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reward;

class RewardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('rewards.index', [
            'rewards' => $user->rewards,
            'coins' => $user->coins,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:1',
        ]);

        auth()->user()->rewards()->create($request->only('name', 'price'));

        return redirect()->route('rewards.index')->with('success', 'Reward added!');
    }

    public function destroy(Reward $reward)
    {
        if ($reward->user_id === auth()->id()) {
            $reward->delete();
        }

        return redirect()->route('rewards.index')->with('success', 'Reward deleted.');
    }

    public function redeem(Reward $reward)
    {
        $user = auth()->user();

        // Pastikan reward milik user
        if ($reward->user_id !== $user->id) {
            abort(403);
        }

        if ($user->coins < $reward->price) {
            return redirect()->route('rewards.index')
                ->with('error', 'You do not have enough coins to redeem this reward.');
        }

        // Kurangi koin & simpan
        $user->coins -= $reward->price;
        $user->save();

        // Hapus reward
        $reward->delete();

        return redirect()->route('rewards.index')->with('success', 'Reward redeemed!');
    }
}
