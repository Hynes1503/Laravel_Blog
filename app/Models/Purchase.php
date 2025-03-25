<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['user_id', 'blog_id', 'payment_method', 'transaction_id', 'is_paid'];
}
