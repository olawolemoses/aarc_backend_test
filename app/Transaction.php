<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['reference', 'amount','status', 'product_id', 'user_id', 'email'];
}
