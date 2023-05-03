<div class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container">

        <img src="{{ URL::asset('img/logo.png') }}" class="img-fuild logo">

        <a href="/" class="navbar-brand">{{ config('app.name_short') }}</a>

        <button class="navbar-toggler" data-toggle="collapse" data-target="#main-navbar" aria-expanded="true">
            <span class="ti-menu"></span>
        </button>

        <div class="collapse navbar-collapse" id="main-navbar">

            <ul class="navbar-nav ml-auto">

                <li class="nav-item @if (Route::current()->getName() == 'home') active @endif">
                    <a href="/" class="nav-link font-weight-bold" data-animate="scrolling"><i
                            class="mr-2 fa-solid fa-home"></i>Accueil</a>
                </li>

                <li class="nav-item">
                    <a href="/#about" class="nav-link font-weight-bold" data-animate="scrolling"><i
                            class="mr-2 fa-solid fa-adress-card"></i>À propos</a>
                </li>

                <li class="nav-item">
                    <a href="/blog/1" class="nav-link font-weight-bold" data-animate="scrolling"><i
                            class="mr-2 fa-solid fa-blog"></i>Blog</a>
                </li>

                <li class="nav-item">
                    <a href="/#github" class="nav-link font-weight-bold" data-animate="scrolling"><i
                            class="mr-2 fa-brands fa-github"></i>Github</a>
                </li>

                <li class="nav-item">
                    <a href="/#youtube" class="nav-link font-weight-bold" data-animate="scrolling"><i
                            class="mr-2 fa-solid fa-heart text-danger"></i>Youtube</a>
                </li>

                @if (Auth::check())
                    <li class="nav-item @if (Route::current()->getName() == 'dashboard') active @endif">
                        <a href="/dashboard" class="nav-link font-weight-bold" data-animate="scrolling"><i
                                class="mr-2 fa-solid fa-dashboard"></i>Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <a href="/logout" class="nav-link font-weight-bold" data-animate="scrolling"><i
                                class="mr-2 fa-solid fa-arrow-right-from-bracket"></i>Déconnexion</a>
                    </li>
                @else
                    <li class="nav-item @if (Route::current()->getName() == 'register') active @endif">
                        <a href="/register" class="nav-link font-weight-bold" data-animate="scrolling"><i
                                class="mr-2 fa-solid fa-user-plus"></i>S'inscrire</a>
                    </li>

                    <li class="nav-item @if (Route::current()->getName() == 'login') active @endif">
                        <a href="/login" class="nav-link font-weight-bold" data-animate="scrolling"><i
                                class="mr-2 fa-solid fa-user"></i>Se connecter</a>
                    </li>
                @endif

                <li class="nav-item @if (Route::current()->getName() == 'cart') active @endif">
                    <a @if (!empty($_COOKIE['product_formule'])) href="/cart" @endif
                        class="nav-link font-weight-bold @if (empty($_COOKIE['product_formule'])) disabled @endif"><i
                            class="fa-solid fa-cart-shopping"></i>
                    </a>
                </li>

            </ul>

            <ul class="nav ml-auto">
                <li class="nav-item">
                    <button
                        class="btn btn-fab btn-theme no-shadow text-uppercase font-weight-bold">{{ str_replace('_', '-', app()->getLocale()) }}</button>
                </li>
            </ul>

        </div>

    </div>

</div>
