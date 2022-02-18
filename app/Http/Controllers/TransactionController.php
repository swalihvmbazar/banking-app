<?php

namespace App\Http\Controllers;

use App\Models\AccountTransfer;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\HaveBalance;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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
            'amount' => ['required', 'numeric', 'gt:0', new HaveBalance(auth()->user())]
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

    public function showTransferForm()
    {
        return view('transfer');
    }

    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'email' => [
                'required', 'email',
                Rule::exists('users')->where(function ($query) {
                    return $query->where('email', '<>', auth()->user()->email);
                })
            ],
            'amount' => ['required', 'numeric', 'gt:0', new HaveBalance(auth()->user())]
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $transfer_from = auth()->user();
                $transfer_to = User::where('email', $validated['email'])->first();
                $transfer = AccountTransfer::create([
                    'from_user_id' => $transfer_from->id,
                    'to_user_id' => $transfer_to->id,
                ]);

                $transfer_from->transactions()->create([
                    'amount' => $validated['amount'],
                    'type' => Transaction::DEBIT,
                    'balance' => $transfer_from->balance->getAttributes()['amount'] - $validated['amount'],
                    'transfer_id' => $transfer->id,
                ]);

                $transfer_to->transactions()->create([
                    'amount' => $validated['amount'],
                    'type' => Transaction::CREDIT,
                    'balance' => $transfer_to->balance->getAttributes()['amount'] + $validated['amount'],
                    'transfer_id' => $transfer->id,
                ]);
            });
        } catch (Exception $e) {
            Log::info($e);
            return redirect()->back()->withErrors("Something went wrong!");
        }

        return redirect()->back()->with([
            'success' => true
        ]);
    }

    protected function addTransaction($validated, $type)
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
