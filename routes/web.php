<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProjetsController;
use App\Http\Controllers\ContactsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/home', function () {
    return view('home');
})->name('home');

// Contact + Projets + News
// Insert App.js

Route::get('/projetsAll', [
    ProjetsController::class, 'getProjetsAll',
])->name('projets');

Route::get('/newsAll', [
    NewsController::class, 'getNewsSmall',
])->name('news');

Route::get('/blog/{slug}', [NewsController::class, 'getNewsAll'])->name('blog');
Route::post('/search-blog', [NewsController::class, 'getNewsSerch'])->name('search');

Route::get('/article/{slug}', [NewsController::class, 'getNewsOne'])->name('article');

Route::get('/', [ContactsController::class, 'create'])->name('contact.create');

Route::post('/', [ContactsController::class, 'store'])->name('contact.store');

Route::get('/sitemap', function () {
    $sitemap = resolve("sitemap");

    $sitemap->add(URL::to('/'), date('Y-m-d') . 'T' . date('H:i:s') . '-02:00', '1.0', 'daily');

    // Article du blog
    $articles = DB::table('news')->orderBy('created_at', 'desc')->get();

    $maxPage = ceil((count($articles) / 9) + 1);

    for ($i = 1; $i <= $maxPage; $i++) {
        # code...
        $sitemap->add(URL::to('/blog') . '/' . $i, date('Y-m-d') . 'T' . date('H:i:s') . '-02:00', '1.0', 'daily');
    }


    foreach ($articles as $post) {
        $sitemap->add(URL::to('/article') . '/' . $post->url, date('Y-m-d') . 'T' . date('H:i:s') . '-02:00', '1.0', 'daily');
    }

    // generate (format, filename)
    // sitemap.xml is stored within the public folder
    $sitemap->store('xml', 'sitemap');
});

// Projets
