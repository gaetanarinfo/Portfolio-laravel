<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Projets;

class ProjetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getProjetsAll(): View
    {
        $projets = Projets::all();
        return view('components.home.projets', compact('projets'));
    }

}
