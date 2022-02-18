<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function showDepositForm()
    {
        return view('deposit');
    }

    public function depositMoney(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|gt:0'
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $user = auth()->user();
                $user->transactions()->create(
                    [
                        'amount' => $validated['amount'],
                        'type' => Transaction::CREDIT,
                        'balance' => $user->balance->getAttributes()['amount'] + $validated['amount'],
                    ]
                );
            });
        } catch (Exception $e) {
            Log::info($e);
            return redirect()->back()->withErrors("Something went wrong!");
        }

        return redirect()->back()->with([
            'success' => true
        ]);
    }
}
