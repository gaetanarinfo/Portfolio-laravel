<div class="vg-page page-register">

    <div class="container">

        <h1 class="mb-5">S'inscrire sur mon portfolio</h1>

        <div class="card card-container">

            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />

            <div class="loader-form hidden" id="loader-register">
                <img src="{{ URL::asset('img/loader-2.svg') }}" alt="">
            </div>

            <form id="form-register" class="form-signin" action="{{ route('store') }}" method="post">

                <input type="hidden" name="token" value="{{ md5(rand(1, 10) . microtime()) }}" />

                <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Prénom"
                    autofocus>

                <span class="error-text text-danger lastname_error"></span>

                <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Nom" autofocus>

                <span class="error-text text-danger firstname_error"></span>

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

                <div class="input-group">

                    <input type="password" id="passwordconfirmation" name="passwordconfirmation" class="form-control"
                        placeholder="Confirmation du mot de passe">

                    <div class="input-group-prepend">
                        <span class="input-group-text" id="show-password-2"><i class="fa-solid fa-eye"></i></span>
                    </div>

                    <span class="error-text text-danger password_error"></span>

                </div>

                <span class="error-text text-danger passwordconfirmation_error"></span>

                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" id="checkProtection">
                    <label class="form-check-label" for="checkProtection"><b>Protection des données
                            personnelles</b></label>
                    <p class="mt-3">
                        En soumettant ce formulaire, j'accepte que les données saisies soient utilisées dans le cadre de
                        ma demande d'informations.
                        Les données personnelles que vous nous confiez ne sont pas transmises, louées, ou
                        commercialisées à des tiers.
                    </p>
                </div>

                <button type="submit" class="btn btn-theme mt-4 mb-0 ml-0 mr-0 disabled">S'inscrire</button>

            </form>
            <!-- /form -->

        </div>
        <!-- /card-container -->

    </div>

</div>
