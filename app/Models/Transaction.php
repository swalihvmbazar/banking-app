<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Transaction extends Model
{
    protected $fillable = ['amount', 'type', 'balance', 'transfer_id'];

    const CREDIT = 'credit';
    const DEBIT = 'debit';

    /* the amount stored in database as integers. So here defined
     the accessor and mutator to convert amount data accordingly
    */
    protected function amount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => number_format(($value / 100), 2),
            set: fn ($value) => $value * 100,
        );
    }

    /* the amount stored in database as integers. So here defined
     the accessor and mutator to convert amount data accordingly
    */
    protected function balance(): Attribute
    {
        return new Attribute(
            get: fn ($value) => number_format(($value / 100), 2),
        );
    }

    // Here defined a accessor for getting details (transaction type)
    public function getDetailsAttribute()
    {
        if ($this->transfer_id != null) {
            if ($this->type == self::CREDIT) {
                return 'Transfer from ' . $this->transfer->from_user->email;
            }
            return 'Transfer to ' . $this->transfer->to_user->email;
        } else if ($this->type == self::CREDIT) {
            return 'Deposit';
        } else {
            return 'Withdraw';
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transfer()
    {
        return $this->belongsTo(AccountTransfer::class, 'transfer_id', 'id');
    }


    protected static function boot()
    {
        parent::boot();

        // Model observer created to calculate user balance for each transactions while creating the transaction
        static::creating(function ($transaction) {
            if ($transaction->type === self::CREDIT) {
                $transaction->balance = $transaction->user->balance->attributes['amount'] +  $transaction->attributes['amount'];
            } else if ($transaction->type === self::DEBIT) {
                $transaction->balance = $transaction->user->balance->attributes['amount'] -  $transaction->attributes['amount'];
            }
        });

        // Model observer created to update user balance on account balance table after created the transaction
        static::created(function ($transaction) {
            if ($transaction->type === self::CREDIT) {
                $transaction->user->balance()->increment('amount', $transaction->attributes['amount']);
            } else if ($transaction->type === self::DEBIT) {
                $transaction->user->balance()->decrement('amount', $transaction->attributes['amount']);
            }
        });
    }
}
