<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountTransfer extends Model
{
    protected $fillable = ['from_user_id', 'to_user_id'];

    public function from_user()
    {
        return $this->belongsTo(User::class,'from_user_id','id');
    }

    public function to_user()
    {
        return $this->belongsTo(User::class,'to_user_id','id');
    }

}
