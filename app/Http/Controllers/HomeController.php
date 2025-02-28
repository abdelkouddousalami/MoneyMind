<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get user's balance
        $balance = $user->balance ?? 0.00;

        // Get recent transactions
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('home', compact('balance', 'recentTransactions'));
    }

    public function quickTransfer(Request $request)
    {
        $request->validate([
            'recipient' => 'required|exists:users,account_number',
            'amount' => 'required|numeric|min:0.01|max:' . auth()->user()->balance
        ]);

        try {
            // Process transfer logic here
            // This is a simplified version - you should add more validation and security checks
            $sender = auth()->user();
            $recipient = User::where('account_number', $request->recipient)->first();

            DB::transaction(function () use ($sender, $recipient, $request) {
                // Deduct from sender
                $sender->balance -= $request->amount;
                $sender->save();

                // Add to recipient
                $recipient->balance += $request->amount;
                $recipient->save();

                // Create transaction records
                Transaction::create([
                    'user_id' => $sender->id,
                    'type' => 'debit',
                    'amount' => $request->amount,
                    'description' => 'Transfer to ' . $recipient->name,
                    'reference' => 'TRF' . time()
                ]);

                Transaction::create([
                    'user_id' => $recipient->id,
                    'type' => 'credit',
                    'amount' => $request->amount,
                    'description' => 'Transfer from ' . $sender->name,
                    'reference' => 'TRF' . time()
                ]);
            });

            return back()->with('success', 'Transfer completed successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Transfer failed. Please try again.');
        }
    }
}
