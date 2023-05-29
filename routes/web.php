<?php

use App\Models\Projets;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\YoutubeController;
use App\Http\Controllers\UpdateMyBakeryController;
use App\Http\Controllers\FacebookGetBakerysController;
use App\Http\Controllers\TwitterGetBakerysController;
use App\Http\Controllers\GetCoordinateGpsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\Auth\LogsController;
use App\Http\Controllers\Auth\UsersController;
use App\Http\Controllers\GithubAuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\WhoisDomainController;
use App\Http\Controllers\NewsScrappingController;
use App\Http\Controllers\FullCalendarController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ApplicationsController;
use App\Http\Controllers\Auth\LoginRegisterController;

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

    $projets = Projets::orderBy('created_at', 'DESC')
        ->get();

    return view('home', compact('projets'));
})->name('home');

Route::get('/home', function () {

    $projets = Projets::orderBy('created_at', 'DESC')
        ->get();

    return view('home', compact('projets'));
})->name('home');

// Home (Projets) + (Artcile -> 6)

Route::get('/newsAll', [
    \App\Http\Controllers\NewsController::class, 'getNewsSmall',
])->name('news');

Route::get('/cgu', function () {
    return view('cgu');
})->name('cgu');

Route::get('/politique-confidentialite', function () {
    return view('politiques');
})->name('politique-confidentialite');

// Blog + article

Route::get('/blog/{slug}', [NewsController::class, 'getNewsAll'])->name('blog');
Route::post('/search-blog', [NewsController::class, 'getNewsSerch'])->name('search');
Route::get('/article/{slug}', [NewsController::class, 'getNewsOne'])->name('article');
Route::get('/news-scrapping', [NewsScrappingController::class, 'getNewsAll'])->name('article');


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
    $sitemap->add(URL::to('/offers'), date('Y-m-d') . 'T' . date('H:i:s') . '-02:00', '1.0', 'daily');

    // Article du blog
    $articles = DB::table('news')->orderBy('created_at', 'desc')->get();

    $maxPage = ceil((count($articles) / 9));

    for ($i = 1; $i <= $maxPage; $i++) {
        # code...
        $sitemap->add(URL::to('/blog') . '/' . $i, date('Y-m-d') . 'T' . date('H:i:s') . '-02:00', '1.0', 'daily');
    }

    foreach ($articles as $post) {
        $sitemap->add(URL::to('/article') . '/' . $post->url, date('Y-m-d') . 'T' . date('H:i:s') . '-02:00', '1.0', 'daily');
    }

    // Forums
    $forums = DB::table('forums')->orderBy('created_at', 'desc')->get();

    foreach ($forums as $post) {
        $sitemap->add(URL::to('/forums') . '/' . $post->url, date('Y-m-d') . 'T' . date('H:i:s') . '-02:00', '1.0', 'daily');
    }

    // Forums topics
    $forums_topics = DB::table('topics_forums')->orderBy('created_at', 'desc')->get();

    foreach ($forums_topics as $post) {
        $sitemap->add(URL::to('/forums/forum/topic') . '/' . $post->url, date('Y-m-d') . 'T' . date('H:i:s') . '-02:00', '1.0', 'daily');
    }

    // Forums topics
    $users = DB::table('users')->orderBy('created_at', 'desc')->get();

    foreach ($users as $post) {
        $sitemap->add(URL::to('/forums/users') . '/' . $post->pseudo, date('Y-m-d') . 'T' . date('H:i:s') . '-02:00', '1.0', 'daily');
    }

    $projets = Projets::where('categorie', 'android')
        ->where('active', 1)
        ->orderBy('created_at')
        ->get();

    foreach ($projets as $post) {
        $sitemap->add(URL::to('/applications') . '/' . $post->url, date('Y-m-d') . 'T' . date('H:i:s') . '-02:00', '1.0', 'daily');
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

//Youtube

Route::get('/google-api/{chanelId}', [GoogleController::class, 'showGoogleProjets']);
Route::get('/google-api-info/{videoId}', [GoogleController::class, 'YoutubeVideoInfo']);
Route::get('/google-xml', [GoogleController::class, 'saveXml']);

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

    Route::get('/dashboard/{year?}', 'dashboard')->name('dashboard');

    Route::get('/forgot-password/{token}', 'forgot_password')->name('forgot-password');
    Route::post('/forgot-password', 'forgot_password_change')->name('forgot_password_change');
    Route::get('/forgot-new-password', 'forgot_password_new')->name('forgot_not_user');
    Route::post('/forgot-new-password', 'forgot_password_new')->name('forgot_not_user');
    Route::get('/show-article', 'dashboard')->name('show-article');
    Route::get('/add-article', 'dashboard')->name('add-article');
});

Route::controller(UsersController::class)->group(function () {

    // Utilisateurs
    Route::get('/show-users', 'show_users')->name('show-users');
    Route::post('/show-users/delete', 'delete_user')->name('delete-user');
    Route::post('/show-users/edit', 'edit_user')->name('edit-user');
    Route::post('/show-users/add', 'add_user')->name('add-user');
    Route::post('/user/edit', 'edit_user_logged')->name('edit-user');

    // Projets
    Route::get('/show-projets', 'show_projets')->name('show-projets');
    Route::post('/show-projets/delete', 'delete_projet')->name('delete-projet');
    Route::post('/show-projets/edit', 'edit_projet')->name('edit-projet');
    Route::post('/show-projets/add', 'add_projet')->name('add-projet');

    // Blog
    Route::get('/show-blog', 'show_blog')->name('show-blog');
    Route::post('/show-blog/delete', 'delete_article')->name('delete-article');
    Route::get('/show-blog/update/{slug}', 'edit_article')->name('edit-article');
    Route::post('/show-blog/update/{slug}', 'edit_article_post')->name('edit-article-post');
    Route::get('/show-blog/add', 'add_article')->name('add-article');
    Route::post('/show-blog/add', 'add_article_post')->name('add-article-post');

    // Orders
    Route::get('/show-orders-google', 'show_orders_google')->name('show-orders-google');

    // Mail
    Route::post('/mail/archive', 'archive_mail')->name('archive-mail');

    // Agenda
    Route::get('/show-agenda', 'show_agenda')->name('show-agenda');

    // Commandes clients
    Route::get('/show-orders', 'show_orders')->name('show-orders');
    Route::get('/order/refund/{id}/{transaction}', 'order_refund')->name('order-refund');
    Route::get('/show-orders-client', 'show_orders_client')->name('show-orders-client');

    // Forums
    Route::get('/forums/check/reply/{type?}/{id}', 'check_reply')->name('check.reply');

    // Apps acheté
    Route::get('/show-apps', 'show_apps')->name('show-apps');

});

// Agenda
Route::controller(FullCalendarController::class)->group(function () {
    Route::get('fullcalender', 'index');
    Route::post('fullcalenderAjax', 'ajax');
});

// Logs
Route::controller(LogsController::class)->group(function () {
    Route::get('/logs', 'logs')->name('logs');
});

// Panier
Route::controller(CartController::class)->group(function () {
    Route::get('/offers', 'getOffers')->name('offers');
    Route::get('/cart', 'getCartSteps')->name('cart');
    Route::post('/cart', 'contactCreate')->name('cart.contact.create');
    Route::get('/handle-payment', 'handlePayment')->name('make.payment');
    Route::get('/cancel-payment', 'paymentCancel')->name('cancel.payment');
    Route::get('/payment-success', 'paymentSuccess')->name('success.payment');
});

// Youtube

Route::get('/youtube-api', [YoutubeController::class, 'showYoutubeProfil']);

// Auth Socials

Route::controller(GoogleAuthController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

Route::controller(FacebookController::class)->group(function () {
    Route::get('auth/facebook', 'redirectToFacebook')->name('auth.facebook');
    Route::get('auth/facebook/callback', 'handleFacebookCallback');
});

Route::controller(GithubAuthController::class)->group(function () {
    Route::get('auth/github', 'redirectToGithub')->name('auth.github');
    Route::get('auth/github/callback', 'handleGithubCallback');
});

// Whoise Domain

Route::post('/whois-domain', [WhoisDomainController::class, 'showDomain'])->name('domain.search');

// Forums

Route::controller(ForumController::class)->group(function () {
    Route::get('/forums', 'index')->name('forum');
    Route::get('/forums/forum/{url?}', 'getForum')->name('forums.categorie');
    Route::get('/forums/forum/topic/{title?}', 'getTopic')->name('forums.topic');
    Route::post('/forums', 'create_forum')->name('forum.create');
    Route::post('/forums/forum/{url?}', 'create_topic')->name('forum.create.topic');
    Route::post('/forums/reply', 'reply_topic')->name('topic.reply.message');
    Route::post('/forums/close', 'close_topic')->name('close.topic');
    Route::post('/forums/top', 'top_topic')->name('top.topic');
    Route::post('/forums/close/user', 'close_topic_user')->name('close.topic.user');
    Route::post('/forums/favorites/user', 'favorites_topic_user')->name('favorites.topic');
    Route::get('/forums/search/{terms?}', 'searchForum')->name('forums.search');
    Route::get('/forums/users/{pseudo?}', 'showUsersForum')->name('forums.users');
    Route::get('/forums/users/topics/{pseudo?}', 'showUsersTopicsForum')->name('forums.users.topics');
    Route::get('/forums/users/replies/{pseudo?}', 'showUsersRepliesForum')->name('forums.users.replies');
    Route::get('/forums/users/favorites/{pseudo?}', 'showUsersFavoritesForum')->name('forums.users.favorites');
});

// Applications

Route::controller(ApplicationsController::class)->group(function () {
    Route::get('/applications/{url?}', 'getSingleApps')->name('application');
    Route::post('/applications*/{url?}/avis', 'postCommentSingleApps')->name('post.application.avis');
});


// Panier Apps
Route::controller(ApplicationsController::class)->group(function () {
    Route::get('/handle-payment-apps/{projets_id}', 'handlePaymentApps')->name('make.payment.apps');
    Route::get('/cancel-payment-apps/{url?}', 'paymentCancelApps')->name('cancel.payment.apps');
    Route::get('/payment-success-apps/{url?}', 'paymentSuccessApps')->name('success.payment.apps');
});

// Apps

Route::get('/encrypt-apps', [UsersController::class, 'encrypt_app']);
Route::get('/download-apps/{projets_id}', [UsersController::class, 'decrypt_app'])->name('decrypt.apps');
Route::get('/download-apps-free/{projets_id}', [UsersController::class, 'apps_free'])->name('free.apps');

// My bakery

Route::get('/update-mybakery', [UpdateMyBakeryController::class, 'update']);
Route::get('/scrapping-mybakery', [UpdateMyBakeryController::class, 'getBakerys']);

// Gouvernement

Route::get('/apis/get-coordinate/{adresse}', [GetCoordinateGpsController::class, 'get']);

// Bakery post

Route::get('/apis/facebook', [FacebookGetBakerysController::class, 'get']);
Route::get('/apis/twitter', [TwitterGetBakerysController::class, 'get']);
