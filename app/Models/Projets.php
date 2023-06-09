<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projets extends Model
{
    use HasFactory;

    protected $fillable = ['categorie', 'title', 'description', 'image', 'icone', 'url', 'prix', 'app', 'audience', 'acquisition', 'revenu_brut', 'author', 'background', 'color', 'age', 'nouveautes', 'website', 'email', 'location', 'regles_url', 'active', 'version'];

}
