<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersApps extends Model
{

    use HasFactory;

    protected $fillable = ['projets_id', 'user_id', 'status', 'order_at', 'order_method', 'transaction_id', 'capture_id', 'price'];
}
