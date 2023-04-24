<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Auth\Users;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\YoutubeController;
use App\Http\Controllers\ProjetsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\NewsletterController;

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

// Home (Projets) + (Artcile -> 6)

Route::get('/projetsAll', [
    ProjetsController::class, 'getProjetsAll',
])->name('projets');

Route::get('/newsAll', [
    NewsController::class, 'getNewsSmall',
])->name('news');

// Blog + article

Route::get('/blog/{slug}', [NewsController::class, 'getNewsAll'])->name('blog');
Route::post('/search-blog', [NewsController::class, 'getNewsSerch'])->name('search');
Route::get('/article/{slug}', [NewsController::class, 'getNewsOne'])->name('article');

// Contact + Projets + News
// Insert App.js

Route::get('/contact', [ContactsController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactsController::class, 'store'])->name('contact.store');

// Sitemap

Route::get('/sitemap', function () {
    $sitemap = resolve("sitemap");

    $sitemap->add(URL::to('/'), date('Y-m-d') . 'T' . date('H:i:s') . '-02:00', '1.0', 'daily');
    $sitemap->add(URL::to('/login'), date('Y-m-d') . 'T' . date('H:i:s') . '-02:00', '1.0', 'daily');
    $sitemap->add(URL::to('/register'), date('Y-m-d') . 'T' . date('H:i:s') . '-02:00', '1.0', 'daily');

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

// Newsletter

Route::get('/newsletter', [NewsletterController::class, 'create'])->name('newsletter.create');
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

// Github

Route::get('/github-api', [GithubController::class, 'showGitProjets']);
Route::post('/github-api', [GithubController::class, 'showGitProjets']);

// User

Route::get('/login', [LoginController::class, 'index'])->name('user.login');
Route::post('/login', [LoginController::class, 'index'])->name('user.login');

Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/forgot-password/{token}', 'forgot_password')->name('forgot-password');
    Route::post('/forgot-password', 'forgot_password_change')->name('forgot_password_change');
    Route::get('/forgot-new-password', 'forgot_password_new')->name('forgot_not_user');
    Route::post('/forgot-new-password', 'forgot_password_new')->name('forgot_not_user');
    Route::get('/show-article', 'dashboard')->name('show-article');
    Route::get('/add-article', 'dashboard')->name('add-article');
});

Route::controller(Users::class)->group(function () {
    // Utilisateurs
    Route::get('/show-users', 'show_users')->name('show-users');
    Route::post('/show-users/delete', 'delete_user')->name('delete-user');
    Route::post('/show-users/edit', 'edit_user')->name('edit-user');
    Route::post('/show-users/add', 'add_user')->name('add-user');

    // Projets
    Route::get('/show-projets', 'show_projets')->name('show-projets');
    Route::post('/show-projets/delete', 'delete_projet')->name('delete-projet');
    Route::post('/show-projets/edit', 'edit_projet')->name('edit-projet');
    Route::post('/show-projets/add', 'add_projet')->name('add-projet');
});

// Github

Route::get('/youtube-api', [YoutubeController::class, 'showYoutubeProfil']);
