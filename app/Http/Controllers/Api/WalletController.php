<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WalletTransferRequest;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{

    public function show()
    {
        $wallet = Wallet::firstOrCreate(
            ['user_id' => auth()->id()],
            ['balance' => 0]
        );

        return response()->json([
            'user_id' => $wallet->user_id,
            'balance' => $wallet->balance,
        ], 200);
    }

    public function transfer(WalletTransferRequest $request)
    {
        $senderWallet = Wallet::where('user_id', auth()->id())->firstOrFail();
        
        $receiverWallet = Wallet::firstOrCreate(['user_id' => $request->receiver_id], ['balance' => 0]);

        if ($senderWallet->balance < $request->amount) {
            return response()->json(['message' => 'Solde insuffisant'], 400);
        }

        DB::transaction(function () use ($senderWallet, $receiverWallet, $request) {
            $senderWallet->decrement('balance', $request->amount);
            $receiverWallet->increment('balance', $request->amount);

            Transaction::create([
                'sender_id' => $senderWallet->user_id,
                'receiver_id' => $receiverWallet->user_id,
                'amount' => $request->amount,
                'status' => 'success',
            ]);
        });

        return response()->json([
            'transaction_id' => Transaction::latest()->first()->id,
            'sender_id' => $senderWallet->user_id,
            'receiver_id' => $receiverWallet->user_id,
            'amount' => $request->amount,
            'status' => 'success',
            'created_at' => now()->toISOString(),
        ], 201);
    }
    public function topup(WalletTopupRequest $request)
    {
        $wallet = Wallet::firstOrCreate(
            ['user_id' => auth()->id()],
            ['balance' => 0]
        );

        DB::transaction(function () use ($wallet, $request) {
            $wallet->increment('balance', $request->amount);

            Transaction::create([
                'sender_id' => $wallet->user_id,
                'receiver_id' => $wallet->user_id,
                'amount' => $request->amount,
                'status' => 'success',
            ]);
        });

        return response()->json([
            'user_id' => $wallet->user_id,
            'balance' => $wallet->balance,
            'topup_amount' => $request->amount,
            'created_at' => now()->toISOString(),
        ], 201);
    }

    public function transactions()
    {
        $transactions = Transaction::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return response()->json($transactions);
    }

}
