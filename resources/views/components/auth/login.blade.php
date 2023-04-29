@php
    $token = md5(rand(1, 10) . microtime());
@endphp

<div class="vg-page page-login">

    <div class="container">

        <h1 class="mb-5">Connexion utilisateur</h1>

        <div class="card card-container">

            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />

            <div class="loader-form hidden" id="loader-login">
                <img src="{{ URL::asset('img/loader-2.svg') }}" alt="">
            </div>

            <form id="form-login" class="form-signin" action="{{ route('authenticate') }}" method="post">

                <input type="hidden" name="token" value="{{ csrf_token() }}" />

                <input type="text" id="email" name="email" class="form-control" placeholder="Adresse email"
                    autofocus>

                <span class="error-text text-danger email_error"></span>

                <div class="input-group">

                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Mot de passe">

                    <div class="input-group-prepend">
                        <span class="input-group-text" id="show-password"><i class="fa-solid fa-eye"></i></span>
                    </div>

                    <span class="error-text text-danger password_error"></span>

                </div>

                <div id="remember" class="checkbox mt-3">

                    <label>
                        <input type="checkbox" id="connect_login" name="connect_login" class="mr-2">Se souvenir de moi
                    </label>

                </div>

                <button type="submit" class="btn btn-theme mt-3 mb-3 ml-0 mr-0">Se connecter</button>

            </form>

            <form id="form-forgot-new" class="form-signin mt-3" action="{{ route('forgot_not_user') }}" method="post">

                <input type="hidden" name="tokens" id="tokens" value="{{ $token }}">

                <input type="text" id="emailForgot" name="emailForgot" class="form-control"
                    placeholder="Adresse email" autofocus>

                <span class="error-text text-danger email_error"></span>

                <button type="submit" class="btn btn-theme mt-3 mb-3 ml-0 mr-0">Valider</button>

            </form>
            <!-- /form -->

            <div style="width: 100%;display: flex;justify-content: center;">

                <div style="max-width: 230px;display: flex;flex-direction: column;">

                    <div class="btn-group mt-3">
                        <a class='btn btn-danger disabled'><i class="fa fa-google-plus"
                                style="width:16px; height:20px"></i></a>
                        <a class='btn btn-danger' href="{{ route('auth.google') }}" style="width:12em;"> Google</a>
                    </div>

                    <div class="btn-group mt-3">
                        <a class='btn btn-info disabled'><i class="fa fa-facebook"
                                style="width:16px; height:20px"></i></a>
                        <a class='btn btn-info' href="{{ route('auth.facebook') }}" style="width:12em;"> Facebook</a>
                    </div>

                    <div class="btn-group mb-3 mt-3">
                        <a class='btn btn-secondary disabled'><i class="fa fa-github"
                                style="width:16px; height:20px"></i></a>
                        <a class='btn btn-secondary' href="{{ route('auth.github') }}" style="width:12em;"> Github</a>
                    </div>

                </div>

            </div>

            <a href="#" class="forgot-password mt-2">
                Mot de passe oublié ?
            </a>

        </div>
        <!-- /card-container -->

    </div>

</div>
