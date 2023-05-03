<!-- Toast -->
<div class="toast toast-form-contact" style="position: fixed;bottom: 1rem;right: 1rem;z-index: 99999999;">

    <div class="toast-header">

        <div class="svg"></div>

        <strong class="title mr-auto"></strong>

        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>

    <div class="toast-body">

    </div>
</div>

<!-- Code Modal -->
<div class="modal fade" id="codeModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Local - <span class="title"></span></h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>

            <div class="modal-body">

                <div class="modal-info mb-3">

                    <div class="modal-title font-weight-bold"><i class="fa-solid fa-terminal mr-2"></i> Clone</div>

                    <div class="modal-help"><a target="_blank"
                            href="https://docs.github.com/articles/which-remote-url-should-i-use"
                            class="text-success"><i class="fa-regular fa-circle-question"></i></a></div>

                </div>

                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" style="color: black;font-size: 14px;" id="https-tab"
                            data-toggle="tab" href="#https" role="tab" aria-controls="https"
                            aria-selected="true">HTTPS</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" style="color: black;font-size: 14px;" id="cli-tab"
                            data-toggle="tab" href="#cli" role="tab" aria-controls="cli"
                            aria-selected="false">GitHub CLI</a>
                    </li>

                </ul>

                <div class="tab-content" id="tabContentGitHub">

                    <div class="tab-pane fade show active" style="padding: 1rem;" id="https" role="tabpanel"
                        aria-labelledby="https-tab">

                        <div class="input-group input-group-sm mb-2 mr-sm-2">

                            <div class="input-group-prepend">
                                <span id="httpsSpan"></span>
                                <div class="input-group-text input-group-text-https"
                                    onclick="copyToClipboard('httpsSpan')"><i class="fa-regular fa-clipboard"></i></div>
                            </div>

                            <input type="text" class="form-control" id="inputHttps" name="https">

                        </div>

                        <span class="font-weight-bold text-gray-600" style="font-size: 13px">Use Git or checkout with
                            SVN using the web URL.</span>

                    </div>

                    <div class="tab-pane fade" style="padding: 1rem;" id="cli" role="tabpanel"
                        aria-labelledby="cli-tab">

                        <div class="input-group input-group-sm mb-2 mr-sm-2">

                            <div class="input-group-prepend">
                                <span id="cliSpan"></span>
                                <div class="input-group-text input-group-text-cli" onclick="copyToClipboard('cliSpan')">
                                    <i class="fa-regular fa-clipboard"></i>
                                </div>
                            </div>

                            <input type="text" class="form-control" id="inputCli" name="cli">

                        </div>

                        <span class="font-weight-bold text-gray-600" style="font-size: 13px">Work fast with our official
                            CLI. <a href="https://cli.github.com/" target="_blank">Learn more</a>.</span>

                    </div>

                </div>

            </div>

            <div class="footer-content">

                <span class="mr-2">
                    <i class="fa-regular fa-file-zipper"></i>
                </span>

                <span>
                    Download ZIP
                </span>

            </div>

        </div>

    </div>

</div>

<!-- Footer -->
<div class="vg-footer">

    <h2 class="text-center">{{ config('app.name_short') }} </h2>

    <div class="container">

        <div class="row">

            <div class="col-lg-4 py-3">

                <div class="footer-info">

                    <p>Où me trouver</p>

                    <hr class="divider">

                    <p class="fs-large fg-white">{{ config('app.complete_adress') }}</p>

                </div>

            </div>

            <div class="col-md-6 col-lg-3 py-3">

                <div class="float-lg-center">

                    <p>Suivez-moi</p>

                    <hr class="divider">

                    <ul class="list-unstyled">
                        <li><a href="https://www.facebook.com/profile.php?id=100073260022541">Facebook</a></li>
                        <li><a href="https://twitter.com/OverGames19">Twitter</a></li>
                        <li><a href="https://www.linkedin.com/in/ga%C3%ABtan-seigneur-2b3357200/">Linkedin</a></li>
                        <li><a href="https://github.com/gaetanarinfo">Github</a></li>
                    </ul>

                </div>

            </div>

            <div class="col-md-6 col-lg-4 py-3">

                <div class="float-lg-left">

                    <p>Contactez moi</p>

                    <hr class="divider">

                    <ul class="list-unstyled">
                        <li><a href="/cgu">Cgu</a></li>
                        <li><a href="/politique-confidentialite">Politique de confidentialité</a></li>
                        <li><a href="mailto:contact@portfolio-gaetan.fr">contact@portfolio-gaetan.fr</a></li>
                    </ul>

                </div>

            </div>

        </div>

        <div class="row justify-content-center mt-3">

            <div class="col-12 mb-3">
                <h3 class="fw-normal text-center">S'abonner</h3>
            </div>

            <div class="col-lg-6 form-min-h">

                <div class="loader-form hidden">
                    <img width="70" height="70" src="{{ URL::asset('img/loader-2.svg') }}" alt="">
                </div>

                <form id="newsletter-form" class="mb-3" method="POST" action="{{ route('newsletter.create') }}">

                    <input type="hidden" name="token" value="{{ csrf_token() }}" />

                    <div class="input-group">

                        <input type="text" class="form-control" name="email" id="email"
                            placeholder="Adresse email">

                        <input type="submit" class="btn btn-theme no-shadow" value="S'abonner">

                    </div>

                    <div><span class="error-text text-danger email_error_newsletter"></span></div>

                </form>

            </div>

            <div class="col-12">
                <p class="text-center mb-0 mt-4">Copyright &copy; {{ date('Y') }}. Tous droits réservés | Ce
                    modèle est fait
                    avec <span class="ti-heart fg-theme-red"></span> par <a href="https://www.macodeid.com/">MACode
                        ID</a></p>
            </div>

        </div>

    </div>

</div>
<!-- End footer -->
