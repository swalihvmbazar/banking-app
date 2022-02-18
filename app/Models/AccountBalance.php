<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class AccountBalance extends Model
{
    protected $fillable = ['amount'];

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
}
