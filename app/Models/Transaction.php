<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Transaction extends Model
{
    protected $fillable = ['amount', 'type', 'balance', 'transfer_id'];

    const CREDIT = 'credit';
    const DEBIT = 'debit';

    protected function amount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => number_format(($value / 100), 2),
            set: fn ($value) => $value * 100,
        );
    }

    protected function balance(): Attribute
    {
        return new Attribute(
            get: fn ($value) => number_format(($value / 100), 2),
        );
    }

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

        static::creating(function ($transaction) {
            if ($transaction->type === self::CREDIT) {
                $transaction->balance = $transaction->user->balance->attributes['amount'] +  $transaction->attributes['amount'];
            } else if ($transaction->type === self::DEBIT) {
                $transaction->balance = $transaction->user->balance->attributes['amount'] -  $transaction->attributes['amount'];
            }
        });

        static::created(function ($transaction) {
            if ($transaction->type === self::CREDIT) {
                $transaction->user->balance()->increment('amount', $transaction->attributes['amount']);
            } else if ($transaction->type === self::DEBIT) {
                $transaction->user->balance()->decrement('amount', $transaction->attributes['amount']);
            }
        });
    }
}
