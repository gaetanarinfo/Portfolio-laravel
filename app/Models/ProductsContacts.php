<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsContacts extends Model
{

    use HasFactory;

    protected $fillable = ['product_id', 'lastname', 'firstname', 'email', 'appointment', 'appointmentTel', 'phone', 'content', 'maquette', 'domains'];
}
