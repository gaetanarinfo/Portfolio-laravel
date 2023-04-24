<div class="vg-page page-forgot">

    <div class="container">

        <h1 class="mb-5">Modifier mon mot de passe</h1>

        <div class="card card-container">

            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />

            <div class="loader-form hidden" id="loader-forgot">
                <img src="{{ URL::asset('img/loader-2.svg') }}" alt="">
            </div>

            <form id="form-forgot" class="form-signin" action="{{ route('forgot_password_change') }}" method="post">

                <input type="hidden" name="token" id="token" value="{{ $token }}">

                <input type="password" id="password" name="password" class="form-control"
                    placeholder="Nouveau mot de passe">

                <span class="error-text text-danger password_error"></span>

                <input type="password" id="passwordconfirmation" name="passwordconfirmation" class="form-control"
                    placeholder="Confirmation du mot de passe">

                <span class="error-text text-danger passwordconfirmation_error"></span>

                <button type="submit" class="btn btn-theme mt-3 mb-3 ml-0 mr-0">Valider</button>

            </form>
            <!-- /form -->

        </div>
        <!-- /card-container -->

    </div>

</div>
