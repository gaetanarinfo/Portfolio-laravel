<div class="vg-page page-login">

    <div class="container">

        <div class="card card-container">

            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />

            <div class="loader-form hidden" id="loader-login">
                <img src="{{ URL::asset('img/loader-2.svg') }}" alt="">
            </div>

            <form id="form-login" class="form-signin" action="{{ route('authenticate') }}" method="post">

                <input type="hidden" name="token" value="{{ csrf_token() }}" />

                <input type="text" id="email" name="email" class="form-control" placeholder="Adresse email" autofocus>

                <span class="error-text text-danger email_error"></span>

                <input type="password" id="password" name="password" class="form-control" placeholder="Mot de passe">

                <span class="error-text text-danger password_error"></span>

                <div id="remember" class="checkbox mt-3">

                    <label>
                        <input type="checkbox" id="connect_login" name="connect_login" class="mr-2">Se souvenir de moi
                    </label>

                </div>

                <button type="submit" class="btn btn-theme mt-3 mb-3 ml-0 mr-0">Se connecter</button>

            </form>
            <!-- /form -->

            <a href="#" class="forgot-password mt-2">
                Mot de passe oublié ?
            </a>

        </div>
        <!-- /card-container -->

    </div>

</div>
