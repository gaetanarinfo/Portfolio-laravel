<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetsAvis extends Model
{
    use HasFactory;

    protected $fillable = ['projets_id', 'note', 'comment'];

}
