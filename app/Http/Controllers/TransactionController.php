<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Rules\HaveBalance;
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
            $this->addTransaction($validated, Transaction::CREDIT);
        } catch (Exception $e) {
            Log::info($e);
            return redirect()->back()->withErrors("Something went wrong!");
        }

        return redirect()->back()->with([
            'success' => true
        ]);
    }

    public function showWithdrawForm()
    {
        return view('withdraw');
    }

    public function withDrawMoney(Request $request)
    {
        $validated = $request->validate([
            'amount' => ['required','numeric','gt:0', new HaveBalance(auth()->user())]
        ]);

        try {
            $this->addTransaction($validated, Transaction::DEBIT);
        } catch (Exception $e) {
            Log::info($e);
            return redirect()->back()->withErrors("Something went wrong!");
        }

        return redirect()->back()->with([
            'success' => true
        ]);
    }

    protected function addTransaction($validated,$type)
    {
        DB::transaction(function () use ($validated, $type) {
            $user = auth()->user();
            $user->transactions()->create(
                [
                    'amount' => $validated['amount'],
                    'type' => $type,
                    'balance' => $user->balance->getAttributes()['amount'] + $validated['amount'],
                ]
            );
        });
    }

}
