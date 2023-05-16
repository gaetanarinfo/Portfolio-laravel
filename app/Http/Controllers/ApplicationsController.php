<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Projets;
use Illuminate\View\View;
use App\Models\ProjetsAvis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PaypalClient;

class ApplicationsController extends Controller
{

    public function getAllApps()
    {
        $projets = Projets::orderByDesc('created_at');

        return view('applications', compact('projets'));
    }

    public function getSingleApps($url = null)
    {

        if ($url !== null) {

            $projet = Projets::where('projets.url', $url)
                ->where('projets.categorie', 'android')
                ->leftJoin('projets_avis', 'projets_avis.projets_id', '=', 'projets.id')
                ->select('projets.*', DB::raw("COUNT(projets_avis.id) as counter_avis"))
                ->groupBy('projets.id')
                ->first();

            $projets = Projets::where('url', '!=', $url)
                ->where('projets.categorie', 'android')
                ->where('active', '1')
                ->orderByDesc('id')
                ->limit(6)
                ->get();

            if ($projet) {
                return view('application', compact('projet', 'projets'));
            } else {
                // return redirect()->route('applications');
            }
        } else {
            return redirect()->route('/applications');
        }
    }
}
