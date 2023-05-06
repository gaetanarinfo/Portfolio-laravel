<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicsForums extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    protected $fillable = [
        'user_id', 'forum_id', 'title', 'url', 'content', 'signature', 'status', 'sticky', 'admin', 'resolved'
    ];
}
