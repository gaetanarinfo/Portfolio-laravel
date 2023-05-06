    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('vendor/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ URL::asset('vendor/perfect-scrollbar/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('vendor/nice-select/css/nice-select.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('vendor/fancybox/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/virtual.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/topbar.virtual.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/app.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />

    @if (Route::current()->getName() == 'forum' || Route::current()->getName() == 'forums.categorie' || Route::current()->getName() == 'forums.topic' || Route::current()->getName() == 'forums.search')
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/forumbb.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/forum.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/flags.css') }}">
    @endif

    @if (Route::current()->getName() == 'login')
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login.css') }}">
    @endif

    @if (Route::current()->getName() == 'register')
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/register.css') }}">
    @endif

    @if (Route::current()->getName() == 'forgot-password')
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/forgot-password.css') }}">
    @endif

    @if (Route::current()->getName() == 'cart')
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/cart.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery.datetimepicker.min.css') }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
