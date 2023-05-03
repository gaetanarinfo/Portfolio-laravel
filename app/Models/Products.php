<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{

    use HasFactory;

    protected $fillable = ['product_title', 'product_icon', 'product_price', 'product_per_month', 'product_content', 'product_color'];
}
