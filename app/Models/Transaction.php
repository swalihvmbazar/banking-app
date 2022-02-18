<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Transaction extends Model
{
    protected $fillable = ['amount','type','balance'];

    const CREDIT = 'credit';
    const DEBIT = 'debit';
    
    protected function amount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => number_format(($value/100), 2),
            set: fn ($value) => $value * 100,
        );
    }

    protected function balance(): Attribute
    {
        return new Attribute(
            get: fn ($value) => number_format(($value/100), 2),
            set: fn ($value) => $value * 100,
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function($transaction) {
            if($transaction->type === self::CREDIT){
                $transaction->user->balance()->increment('amount', $transaction->getAttributes()['amount']);
            }else if($transaction->type === self::DEBIT){
                $transaction->user->balance()->decrement('amount', $transaction->getAttributes()['amount']);
            }
        });
    }
}
