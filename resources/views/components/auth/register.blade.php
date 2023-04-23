<div class="vg-page page-register">

    <div class="container">

        <div class="card card-container">

            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />

            <div class="loader-form hidden" id="loader-register">
                <img src="{{ URL::asset('img/loader-2.svg') }}" alt="">
            </div>

            <form id="form-register" class="form-signin" action="{{ route('store') }}" method="post">

                <input type="hidden" name="token" value="{{ csrf_token() }}" />

                <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Prénom"
                    autofocus>

                <span class="error-text text-danger lastname_error"></span>

                <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Nom" autofocus>

                <span class="error-text text-danger firstname_error"></span>

                <input type="text" id="email" name="email" class="form-control" placeholder="Adresse email"
                    autofocus>

                <span class="error-text text-danger email_error"></span>

                <input type="password" id="password" name="password" class="form-control" placeholder="Mot de passe">

                <span class="error-text text-danger password_error"></span>

                <input type="password" id="passwordconfirmation" name="passwordconfirmation" class="form-control" placeholder="Confirmation du mot de passe">

                <span class="error-text text-danger passwordconfirmation_error"></span>

                <button type="submit" class="btn btn-theme mt-4 mb-0 ml-0 mr-0">S'inscrire</button>

            </form>
            <!-- /form -->

        </div>
        <!-- /card-container -->

    </div>

</div>
