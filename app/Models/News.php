<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'url', 'small_content', 'large_content', 'image', 'image_bandeau', 'categorie', 'author', 'author_content', 'author_link', 'avatar', 'views', 'active', 'url_fb', 'url_linkedin', 'url_twitter', 'email'];

}
