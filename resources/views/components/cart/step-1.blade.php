<div class="vg-page page-cart">

    <div class="loader-form hidden" id="loader-cart">

        <div>
            <img src="{{ URL::asset('img/loader-2.svg') }}">
        </div>

    </div>

    @if (!empty($_COOKIE['product_etape']) && $_COOKIE['product_etape'] == '1')

        <div class="container pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center wow fadeInUp bloc-formule">

            <h1 class="display-4">Choisissez votre formule</h1>

            <p class="lead">Plusieurs formules s'offrent à vous, vous pouvez la modifier à tout moment de la commande.
            </p>

        </div>

        <div class="container wow fadeInUp bloc-formule">

            <div class="card-deck mb-3 text-center">

                @foreach ($products as $data)
                    <div class="card mb-4 box-shadow">

                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">{{ $data->product_title }}</h4>
                        </div>

                        <div class="card-body">

                            <h1 class="card-title pricing-card-title">{{ $data->product_price }} € TTC</small></h1>

                            <div class="icons">
                                <i class="fa-solid fa-{{ $data->product_icon }}"></i>
                            </div>

                            <p class="font-weight-bold"><i class="fa-brands fa-buffer mr-1"></i>Description de l'offre
                            </p>

                            <ul class="list-unstyled mt-3 mb-0 pb-0">
                                {!! $data->product_content !!}
                            </ul>

                            <p class="font-weight-bold mt-3"><i class="fa-solid fa-server mr-1"></i> Type d'hébergement
                            </p>

                            <ul class="list-unstyled mt-3 mb-4">
                                {!! $data->product_hebergement !!}
                            </ul>

                            <button type="button" data-product="{{ $data->product_id }}"
                                class="btn btn-lg btn-block btn-theme btn-formule">Choisir cette formule</button>

                        </div>

                    </div>
                @endforeach

            </div>

            <p class="small mb-0 mt-0">* Les prix sont affichée en TTC.</p>
            <p class="small mb-0 mt-0">** Site internet sans base de données.</p>
            <p class="small mt-0">*** Site internet avec base de données.</p>

        </div>
    @endif

    <div
        class="container pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center wow fadeInUp bloc-domain @if (!empty($_COOKIE['product_etape']) && $_COOKIE['product_etape'] == 2) show @endif">

        <h1 class="display-4">Choisissez vos nom de domaine</h1>

        <p class="lead">Vérifier si votre nom de domaine n'est pas présent sur internet.</p>

    </div>

    <div class="container wow fadeInUp bloc-domain @if (!empty($_COOKIE['product_etape']) && $_COOKIE['product_etape'] == 2) show @endif">

        <div class="row d-flex justify-content-center">

            <div class="col-md-8">

                <div class="card">

                    <div class="mt-3 inputs">

                        <form id="searchDomainForm" action="{{ route('domain.search') }}" method="POST">

                            <i class="fa fa-search"></i>

                            <input type="hidden" name="max_domain" id="max_domain"
                                value="@if (!empty($max_domain['max_domain'])) {{ $max_domain['max_domain'] }}@else 0 @endif">

                            <input id="domain" name="domain" type="text" class="form-control"
                                placeholder="Ex: mon-site.fr">

                            <span class="domain-count">
                                0/@if (!empty($max_domain['max_domain']))
                                    {{ $max_domain['max_domain'] }}
                                @else
                                    0
                                @endif
                            </span>

                            <div class="mb-3 mt-3 bloc-btn contact-form">
                                <a id="contact-form" class="btn btn-sm btn-theme">Valider ma selection</a>
                            </div>

                            <div class="result-domain"></div>

                            <div class="loader-form hidden" id="loader-cart-form">

                                <div>
                                    <img src="{{ URL::asset('img/loader-2.svg') }}">
                                </div>

                            </div>

                            <div class="mt-3 bloc-btn">
                                <button type="submit" class="btn btn-sm btn-theme">Rechercher</button>
                            </div>

                        </form>

                    </div>

                </div>

            </div>


        </div>
    </div>

    <div
        class="container pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center wow fadeInUp bloc-contact @if (!empty($_COOKIE['product_etape']) && $_COOKIE['product_etape'] == 3) show @endif">

        <h1 class="display-4">Vos coordonées</h1>

        <p class="lead">Laissez-nous vos coordonnées et avec votre projet et nous allons l'étudier ensemble.</p>

    </div>

    <div class="container wow fadeInUp bloc-contact @if (!empty($_COOKIE['product_etape']) && $_COOKIE['product_etape'] == 3) show @endif">

        <div class="row d-flex justify-content-center">

            <div class="col-lg-12 mb-3">

                <form id="form-cart-contact" action="{{ route('cart.contact.create') }}" method="POST">

                    <input type="hidden" id="productId" name="productId" value="{{ $_COOKIE['product_formule'] }}">
                    <input type="hidden" id="domains" name="domains"
                        value="@if (!empty($_COOKIE['product_domain'])) {{ $_COOKIE['product_domain'] }}@else aucun @endif">

                    <div class="form-row">

                        <div class="col">

                            <div>
                                <label for="firstname">Prénom :</label>
                                <input autocomplete="false" type="text" name="firstname" id="firstname"
                                    class="form-control" placeholder="Prénom*">

                                <span class="error-text text-danger firstname_error"></span>

                            </div>

                            <div class="mt-3">
                                <label for="email">Adresse email :</label>
                                <input autocomplete="false" type="text" name="email" id="email"
                                    class="form-control" placeholder="Adresse email*">

                                <span class="error-text text-danger email_error"></span>
                            </div>

                            <div class="mt-3">
                                <label for="appointment">Mise en place du projet :</label>
                                <input autocomplete="false" type="text" name="appointment" id="appointment"
                                    class="form-control">

                                <span class="error-text text-danger appointment_error"></span>
                            </div>

                            <div class="mt-3">
                                <label for="maquette">Votre maquette (PDF) :</label>
                                <input autocomplete="false" type="file" name="maquette" id="maquette"
                                    class="form-control-file" accept=".pdf">
                                <span class="error-text text-danger maquette_error"></span>
                            </div>

                        </div>

                        <div class="col">

                            <div>

                                <label for="lastname">Nom :</label>
                                <input autocomplete="false" type="text" name="lastname" id="lastname"
                                    class="form-control" placeholder="Nom*">

                                <span class="error-text text-danger lastname_error"></span>

                            </div>

                            <div class="mt-3">

                                <label for="phone">Téléphone :</label>
                                <input autocomplete="false" type="text" name="phone" id="phone"
                                    class="form-control" placeholder="Téléphone*">

                                <span class="error-text text-danger phone_error"></span>

                            </div>

                            <div class="mt-3">
                                <label for="appointmentTel">Rendez-vous téléphonique :</label>
                                <input autocomplete="false" type="text" name="appointmentTel" id="appointmentTel"
                                    class="form-control">

                                <span class="error-text text-danger appointmentTel_error"></span>
                            </div>

                        </div>

                    </div>

                    <div class="mt-3">

                        <label for="content">Votre projet :</label>
                        <textarea autocomplete="false" class="form-control" name="content" id="content" cols="30" rows="10"
                            placeholder="Description de votre projet*"></textarea>

                        <span class="error-text text-danger content_error"></span>

                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-theme">Valider</button>
                    </div>

                </form>

            </div>

        </div>

    </div>

    @if (
        !empty($_COOKIE['product_etape']) && $_COOKIE['product_etape'] == 4 && empty($paiement_status) or
            $paiement_status == 2)

        @php
            $TAUX_TVA = 20;
            $HT = number_format(($product->product_price * 100) / (100 + $TAUX_TVA), 2, ',', '');
        @endphp

        <div
            class="container pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center wow fadeInUp bloc-cart @if (!empty($_COOKIE['product_etape']) && $_COOKIE['product_etape'] == 4) show @endif">

            <h1 class="display-4">Votre panier</h1>

            <p class="lead">Finalisez votre commande pour que nous puissions vous recontacter au plus vite, vous
                pouvez
                payer par la plateforme <strong>Paypal</strong> ou nous envoyer un <strong>virement bancaire</strong>
                dès
                réception du paiement nous allons vous recontacter.</p>

        </div>

        <div class="container wow bloc-cart @if (!empty($_COOKIE['product_etape']) && $_COOKIE['product_etape'] == 4) show @endif">

            <div class="row">

                <div class="col-xl-9 col-md-8 mb-3">

                    <h2 class="h6 d-flex flex-wrap justify-content-between align-items-center px-4 py-3 bg-secondary">

                        <span>Votre choix</span>

                    </h2>

                    <!-- Item-->
                    <div class="d-sm-flex justify-content-between my-4 pb-4 border-bottom">

                        <div class="media d-block d-sm-flex text-center text-sm-left">

                            <div class="cart-item-thumb mx-auto mr-sm-4 icons_cart" href="#">
                                <i class="fa-solid fa-{{ $product->product_icon }}"
                                    style="color: #{{ $product->product_color }}"></i>
                            </div>

                            <div class="media-body pt-3">

                                <h3 class="product-card-title font-weight-semibold border-0 pb-0"><a
                                        href="#">{{ $product->product_title }}</a></h3>

                                <div class="font-size-sm">

                                    <span class="text-muted mr-2">Description du produit :</span>

                                    <ul class="mt-1 list-product">
                                        {!! $product->product_content !!}
                                    </ul>

                                    <span class="text-muted mr-2">Hebergement :</span>

                                    <ul class="mt-1 list-product">
                                        {!! $product->product_hebergement !!}
                                    </ul>

                                    <span class="text-muted mr-2">Nom de domaine :</span>

                                    <ul class="mt-1 list-product">
                                        @php
                                            $arrays = explode(',', $_COOKIE['product_domain']);
                                        @endphp

                                        @foreach ($arrays as $value)
                                            <li>
                                                {{ $value }}
                                            </li>
                                        @endforeach

                                    </ul>

                                </div>

                                <div class="font-size-lg pt-2 font-weight-semibold text-right">Prix TTC <span
                                        class="text-success">{{ $product->product_price }} €</span></div>

                            </div>

                        </div>

                        <div class="pt-2 pt-sm-0 pl-sm-3 mx-auto mx-sm-0 text-center text-sm-left"
                            style="max-width: 10rem;">

                            <div class="form-group mb-2">

                                <label for="quantity1">Quantité</label>
                                <input class="form-control form-control-sm" disabled type="number" id="quantity1"
                                    value="1">

                            </div>

                            <button class="btn btn-outline-secondary btn-sm btn-block mb-2" type="button">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-refresh-cw mr-1">
                                    <polyline points="23 4 23 10 17 10"></polyline>
                                    <polyline points="1 20 1 14 7 14"></polyline>
                                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15">
                                    </path>
                                </svg><span class="ml-1">Rafraîchir</span></button>

                            <button class="btn btn-outline-danger btn-sm btn-block mb-2" type="button">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-trash-2 mr-1">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path
                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                    </path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg><span class="ml-1">Supprimer</span></button>

                        </div>

                    </div>

                </div>

                <!-- Sidebar-->
                <div class="col-xl-3 col-md-4 pt-3 pt-md-0 mb-3">

                    <h2 class="h6 px-4 py-3 bg-secondary text-center">Sous total</h2>

                    <div class="h5 font-weight-semibold text-center py-1">{{ $HT }}<span> € HT</span>
                    </div>

                    <div class="h5 font-weight-semibold text-center py-1">{{ $product->product_price }}<span> €
                            TTC</span>
                    </div>

                    <div class="h5 font-weight-semibold text-center py-1">TVA {{ $TAUX_TVA }}%<span></span>
                    </div>

                    <hr>

                    <h3 class="h6 pt-4 font-weight-semibold"><span class="badge badge-success mr-2">Note</span>
                        Commentaires</h3>

                    <textarea class="form-control mb-3" id="order-comments" rows="5"></textarea>

                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            <i class="fa-solid fa-xmark mr-1"></i> <span
                                class="message-error">{{ session()->get('error') }}</span>
                        </div>
                    @endif

                    <a class="btn btn-outline-success btn-block" href="{{ route('make.payment') }}">

                        <i class="fa-brands fa-paypal mr-1"></i>

                        <span class="btn-card">Payer avec Paypal</span>

                    </a>

                    <a class="btn btn-outline-warning btn-block" data-toggle="modal"
                        data-target="#showCoordoneesVirement">

                        <i class="fa-solid fa-money-check mr-1"></i>

                        <span class="btn-card">Payer par virement</span>

                    </a>

                    <div class="pt-4">

                        <div class="accordion" id="cart-accordion">

                            <div class="card">

                                <div class="card-header">

                                    <h3 class="accordion-heading font-weight-semibold">
                                        <a href="#promocode" role="button" data-toggle="collapse"
                                            aria-expanded="true" aria-controls="promocode">Appliquer un code</a>
                                    </h3>

                                </div>

                                <div class="collapse show" id="promocode" data-parent="#cart-accordion">

                                    <div class="card-body">

                                        <form class="needs-validation">

                                            <div class="form-group">

                                                <input class="form-control" type="text" id="cart-promocode"
                                                    placeholder="Code promo">

                                                <div class="invalid-feedback"></div>

                                            </div>

                                            <button class="btn btn-outline-primary btn-block"
                                                type="submit">Valider</button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    @else
        <div
            class="container pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center wow fadeInUp bloc-cart @if (!empty($_COOKIE['product_etape']) && $_COOKIE['product_etape'] == 4) show @endif">

            <img src="{{ URL::asset('img/check.svg') }}" class="img-fluid paiement-success" alt="">

            <h1 class="display-4 text-success paiement-h1">Paiement accepter</h1>

            <p class="lead">Un grand merci pour votre paiement, votre demande de rendez-vous a bien été planifié, je
                vous recontacterai dans les plus brefs délais.</p>

            <p class="lead paiement-lead">Merci et à très bientôt.</p>

        </div>
    @endif

    <div
        class="container pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center wow fadeInUp bloc-iban @if (!empty($_COOKIE['product_etape']) && $_COOKIE['product_etape'] == 5) show @endif">

        <img src="{{ URL::asset('img/check.svg') }}" class="img-fluid paiement-success" alt="">

        <h1 class="display-4 text-success paiement-h1">Paiement en attente</h1>

        <p class="lead">Un grand merci pour votre paiement, quand votre paiement sera reçu, votre demande de
            rendez-vous sera planifié, et après celà je
            vous recontacterai dans les plus brefs délais.</p>

        <a id="change-paiement-iban" class="btn btn-theme btn-lg mb-3">Changer le moyen de paiement</a>

        <p class="lead paiement-lead">Merci et à très bientôt.</p>

    </div>

</div>

<!-- Edit user Modal-->
<div class="modal fade" id="showCoordoneesVirement" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Coordonnée de virement bancaire</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>

            <div class="modal-body">

                <p class="font-weight-bold">Titulaire</p>

                <p>Gaëtan Seigneur</p>

                <p class="font-weight-bold">IBAN</p>

                <p>FR76 1695 8000 0196 4536 6874 537</p>

                <p class="font-weight-bold">BIC/SWIFT</p>

                <p>QNTOFRP1XXX</p>

                <p class="font-weight-bold">Adresse du titulaire</p>

                <p>EI-SEIGNEUR GAETAN/ loveandheart 125 avenue félix geneslay 72100, Le mans - FR</p>

            </div>

            <div class="modal-footer">
                <button class="btn btn-warning font-weight-bold" type="button" data-dismiss="modal">Fermer</button>
                <a id="valide-paiement-iban" class="btn btn-success font-weight-bold" href="#">Valider le
                    paiement</a>
            </div>

        </div>

    </div>

</div>
