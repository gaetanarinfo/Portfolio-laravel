@php
    use App\Models\ProjetsAvis;
    $counter = $sum_avis + $projet->counter_avis;
@endphp
<div class="apps" style="background-color: #{{ $projet->color }}">
    <div class="apps-container wow fadeIn">

        <div class="row"
            style="background: url('{{ URL::asset('img/projets/background/' . $projet->background) }}');background-position: right;background-size: contain;background-repeat: no-repeat;">

            <div class="col-lg-12 h-s contain">

                <h1>{{ $projet->title }}</h1>

                <p class="product">{{ $projet->author }} @if ($projet->prix >= 1)
                        - {{ number_format($projet->prix, 2, ',', '') }} €
                    @endif - Version {{ $projet->version }}
                </p>

                <small>
                    @if ($projet->prix >= 1)
                        Appli payante
                    @else
                        Gratuite
                    @endif
                </small>

                <div class="col-lg-6 grid">

                    <div class="row">

                        <div class="col">
                            <img src="{{ URL::asset('img/projets/icons/' . $projet->icone) }}" class=""
                                alt="Image de l'icône">
                        </div>

                        <div class="col">

                            <p>
                                @if ($projet->counter_avis !== 0)
                                    {{ number_format($counter / $projet->counter_avis, 2, ',', '') }}
                                @else
                                    0
                                @endif
                                <i class="fa-solid fa-star"></i>
                            </p>
                            <small>{{ $projet->counter_avis }} avis</small>

                        </div>

                        <div class="col">

                            <p>{{ $projet->acquisition }}</p>
                            <small>Téléchargements</small>

                        </div>

                        <div class="col">

                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" xml:space="preserve">
                                    <rect fill="none" width="20" height="20"></rect>
                                    <path
                                        d="M10.54,11.09L8.66,9.22l-1.02,1.02l2.9,2.9l5.8-5.8l-1.02-1.01L10.54,11.09z M15.8,16.24H8.2L4.41,9.66L8.2,3h7.6l3.79,6.66 L15.8,16.24z M17,1H7L2,9.66l5,8.64V23l5-2l5,2v-4.69l5-8.64L17,1z">
                                    </path>
                                </svg>
                            </span>
                            <small>Choix de l'équipe</small>

                        </div>

                        <div class="col">

                            <div>
                                <i class="fa-solid fa-flag-checkered"></i>
                            </div>
                            <small>{{ $projet->age }}</small>

                        </div>

                    </div>

                </div>

                <p class="desc-smart"><i class="fa-solid fa-mobile-screen mr-2"></i>Cette application est disponible
                    pour certains de vos appareils</p>

                <div class="contain-btn">

                    @if ($projet->prix >= 1 && count($orders_apps) <= 0)
                        @if (Auth::check())
                            <a data-toggle="modal" data-target="#modal-paiement" class="btn btn-theme ml-0">Acheter
                                l'application</a>
                        @else
                            <a href="/login" class="btn btn-theme ml-0">Acheter
                                l'application</a>
                        @endif
                    @elseif(count($orders_apps) >= 1)
                        <a href="/show-apps" class="btn btn-theme ml-0">Télécharger l'application</a>
                    @else
                        @if (Auth::check())
                            <a href="{{ Route('free.apps', $projet_id->id) }}" class="btn btn-theme ml-0">Télécharger
                                l'application</a>
                        @else
                            <a href="{{ Route('free.apps', $projet_id->id) }}" class="btn btn-theme ml-0">Télécharger
                                l'application</a>
                        @endif
                    @endif

                </div>

            </div>

            <div
                style="background: linear-gradient(to right,rgb(32,33,36) 0,rgba(0,0,0,0) 56%),linear-gradient(to top,rgb(32,33,36) 0,rgba(0,0,0,0) 56%),linear-gradient(to left,rgb(32,33,36) 0,rgba(0,0,0,0) 56%);bottom: 0;left: 30%;right: 0;top: 0;position: absolute;">
            </div>

        </div>

    </div>

</div>

<div class="apps-container apps-content">

    @if (session()->has('error'))
        <div class="alert alert-danger mt-3">
            <i class="fa-solid fa-xmark mr-1"></i> <span class="message-error">{{ session()->get('error') }}</span>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-check mr-1"></i> <span class="message-success">{{ session()->get('success') }}</span>
        </div>
    @endif

    <div class="row">

        <div class="col-lg-7 mr-5 wow fadeIn">

            <h3 class="mb-3">Nouveautés</h3>

            <p class="mb-5 description">{{ $projet->nouveautes }}</p>

            <h3 class="mb-3">Sécurité des données</h3>

            <p class="description mb-5">La sécurité, c'est d'abord comprendre comment les développeurs collectent et
                partagent vos données. Les
                pratiques concernant leur confidentialité et leur protection peuvent varier selon votre utilisation,
                votre région et votre âge. Le développeur a fourni ces informations et peut les modifier ultérieurement.
            </p>

            <div class="security mb-5">

                <div class="item">
                    <img class="icone"
                        src="https://play-lh.googleusercontent.com/iFstqoxDElUVv4T3KxkxP3OTcuFvWF5ZQQjT7aIxy4n2uaVigCCykxeG6EZV9FQ10X1itPj1oORm=s20-rw"
                        alt="Image de l'icône">
                    <div>Cette appli ne collecte pas de données</div>
                </div>

                <div class="item">
                    <img class="icone"
                        src="https://play-lh.googleusercontent.com/12USW7aflgz466ifDehKTnMoAep_VHxDmKJ6jEBoDZWCSefOC-ThRX14Mqe0r8KF9XCzrpMqJts=s20-rw"
                        alt="Image de l'icône">
                    <div>Cette appli ne recueillis pas types de données</div>
                </div>

                <div class="item">
                    <img class="icone"
                        src="https://play-lh.googleusercontent.com/W5DPtvB8Fhmkn5LbFZki_OHL3ZI1Rdc-AFul19UK4f7np2NMjLE5QquD6H0HAeEJ977u3WH4yaQ=s20-rw"
                        alt="Image de l'icône">
                    Les données sont chiffrées lors de leur transfert
                </div>

                <div class="item">
                    <img class="icone"
                        src="https://play-lh.googleusercontent.com/ohRyQRA9rNfhp7xLW0MtW1soD8SEX45Oec7MyH3FaxtukWUG_6GKVpvh3JiugzryLi7Bia02HPw=s20-rw"
                        alt="Image de l'icône">
                    Vous pouvez demander la suppression des données
                </div>

                <div class="item">
                    <img class="icone"
                        src="https://play-lh.googleusercontent.com/ZvOdCQjZm7PU-1Qrdn_m9ksg7RAAbXL4iW6QSCoYmkHcl4lopAjeOMYiESyXCQFfRjN5f1mRb1un=s20-rw"
                        alt="Image de l'icône">
                    Examen de sécurité indépendant
                </div>

            </div>

            <h3 class="mb-0">Noter mon application</h3>

            <p class="mb-0">Donnez votre avis aux utilisateurs.</p>

            <div class="grid-note-avis">

                <div
                    class="note @if (!Auth::check()) reverse @endif @if (Auth::check() && $user_verif_projet != null) reverse @endif @if (Auth::check() && $user_verif_projet == null) reverse @endif mb-5">

                    @if (Auth::check() && $user_verif_projet == null)
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($projet->counter_avis !== 0)
                                @if ($projet->counter_avis !== 0 && $i >= $counter / $projet->counter_avis)
                                    <div class="s-note " data-note="{{ $i }}" data-toggle="modal"
                                        data-target="#modal-avis">
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                @else
                                    <div class="s-note active" data-note="{{ $i }}" data-toggle="modal"
                                        data-target="#modal-avis">
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                @endif
                            @else
                                <div class="s-note" data-note="{{ $i }}" data-toggle="modal"
                                    data-target="#modal-avis">
                                    <i class="fa-solid fa-star"></i>
                                </div>
                            @endif
                        @endfor
                    @elseif($user_verif_projet != null)
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($projet->counter_avis !== 0)
                                @if ($i >= $counter / $projet->counter_avis)
                                    <div class="s-note  disabled">
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                @else
                                    <div class="s-note active disabled">
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                @endif
                            @else
                                <div class="s-note disabled">
                                    <i class="fa-solid fa-star"></i>
                                </div>
                            @endif
                        @endfor
                    @else
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($projet->counter_avis !== 0)
                                @if ($i >= $counter / $projet->counter_avis)
                                    <div class="s-note ">
                                        <a href="/login">
                                            <i class="fa-solid fa-star"></i>
                                        </a>
                                    </div>
                                @else
                                    <div class="s-note active">
                                        <a href="/login">
                                            <i class="fa-solid fa-star"></i>
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="s-note ">
                                    <a href="/login">
                                        <i class="fa-solid fa-star"></i>
                                    </a>
                                </div>
                            @endif
                        @endfor
                    @endif
                </div>

                <div>
                    @if (Auth::check() && $user_verif_projet == null)
                        <a class="btn btn-avis" data-toggle="modal" data-target="#modal-avis">Rédiger un avis</a>
                    @elseif($user_verif_projet != null)
                        <a class="btn btn-avis disabled">Rédiger un avis</a>
                    @else
                        <a href="/login" class="btn btn-avis">Rédiger un avis</a>
                    @endif
                </div>

            </div>

            <div class="note-by-avis">

                <h3>Notes et avis</h3>

                <span>
                    <div>Les notes et les avis sont vérifiés <i class="ml-2 fa-solid fa-exclamation"></i></div>
                </span>

            </div>

            <div class="mt-3">

                <div>

                    <div class="grid-comments-avis">

                        <div>

                            <div class="comment-note">
                                @if ($projet->counter_avis !== 0)
                                    @if ($counter / $projet->counter_avis >= 5)
                                        5
                                    @else
                                        {{ number_format($counter / $projet->counter_avis, 2, ',', '') }}
                                    @endif
                                @else
                                    0
                                @endif
                            </div>

                            <div>

                                <div class="note reverse mb-5">

                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($projet->counter_avis !== 0)
                                            @if ($i >= $counter / $projet->counter_avis)
                                                <div class="s-note disabled">
                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            @else
                                                <div class="s-note active disabled">
                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            @endif
                                        @else
                                            <div class="s-note disabled">
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                        @endif
                                    @endfor

                                </div>

                            </div>

                            <div class="counter-avis">
                                {{ $projet->counter_avis }} avis
                            </div>

                        </div>

                        <div>

                            <div class="grid-progress">

                                @for ($i = 5; $i >= 1; $i--)
                                    <div class="note-t">
                                        {{ $i }}
                                    </div>

                                    <div>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="@if ($projet->counter_avis == 0) width: 0% @elseif($i <= $sum_avis) width: {{ round(($sum_avis * $i) / $projet->counter_avis) }}% @else width: 0% @endif"
                                                aria-valuenow="{{ $i }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                @endfor

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="mt-5">

                @foreach ($avis as $value)
                    <div class="grid-comments-all-avis">

                        <div class="grid-comment">

                            <div class="grid-img-text">

                                <img src="{{ URL::asset('img/profil/' . $value->avatar) }}" class="T75of abYEib"
                                    aria-hidden="true" loading="lazy">

                                <div class="X5PpBb">
                                    {{ $value->pseudo }}
                                </div>

                            </div>

                        </div>

                        <div class="grid-note">

                            <div class="grid-note-in">

                                <div class="note reverse">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($value->note !== 0)
                                            @if ($i <= $value->note)
                                                <div class="s-note active disabled">
                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            @else
                                                <div class="s-note  disabled">
                                                    <i class="fa-solid fa-star"></i>
                                                </div>
                                            @endif
                                        @else
                                            <div class="s-note disabled">
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                        @endif
                                    @endfor
                                </div>

                                <div class="grid-note-date">{{ date('d m Y', strtotime($value->created_at)) }}</div>

                            </div>

                        </div>

                        <div class="grid-desc">
                            {{ $value->comment }}
                        </div>

                    </div>
                @endforeach


            </div>

        </div>

        <div class="col-lg-4 wow fadeIn">

            <h4 class="mb-3">Coordonnées du développeur</h4>

            <div class="grid-coord-dev mb-4">

                <div class="item">

                    <div>
                        <i class="fa-solid fa-globe"></i>
                    </div>

                    <div class="content">

                        <div>Site Web</div>
                        <div>{{ $projet->website }}</div>

                    </div>

                </div>

                <div class="item">

                    <div>
                        <i class="fa-solid fa-envelope"></i>
                    </div>

                    <div class="content">

                        <div>E-mail</div>
                        <div>{{ $projet->email }}</div>

                    </div>

                </div>

                <div class="item">

                    <div>
                        <i class="fa-solid fa-map-pin"></i>
                    </div>

                    <div class="content">

                        <div>Adresse</div>
                        <div>{{ $projet->location }}</div>

                    </div>


                </div>

                <div class="item">

                    <div>
                        <i class="fa-solid fa-shield"></i>
                    </div>

                    <div class="content">

                        <div>Règles de confidentialité</div>
                        <div>{{ $projet->regles_url }}</div>

                    </div>

                </div>

            </div>

            <h4 class="mb-4">Mes autres applis à essayer</h4>

            <div class="grid-apps">

                @foreach ($projets as $projet)
                    <div class="before-item">

                        <a target="_blank" href="{{ route('application') . '/' . $projet->url }}">

                            <div class="item">

                                <img src="{{ URL::asset('img/projets/icons/' . $projet->icone) }}" alt="">

                                <div class="content">

                                    <div>
                                        <span class="title">{{ $projet->title }}</span>
                                    </div>

                                    <div>
                                        <span class="author">{{ $projet->author }}</span>
                                    </div>

                                </div>

                            </div>

                        </a>

                    </div>
                @endforeach

            </div>

        </div>

    </div>

</div>

@if (Auth::check() && $user_verif_projet == null)
    <div class="modal fade" id="modal-avis" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <div class="grid-header-modal">

                        <div class="column-1">
                            <img src="{{ URL::asset('img/projets/icons/' . $projet->icone) }}"
                                alt="Image de l'icône">
                        </div>

                        <div>
                            <h5>{{ $projet->title }}</h5>
                            <div class="source">Noter cette application</div>
                        </div>


                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                </div>

                <form id="form-avis-apps" method="post"
                    action="{{ route('post.application.avis', $projet->url) }}">

                    <div class="modal-body">

                        <input type="hidden" name="noteComments" id="noteComments">
                        <input type="hidden" name="idProjets" id="idProjets" value="{{ $projet->id }}">

                        <div class="grid-prevent">

                            <div><img src="{{ URL::asset('img/profil/' . $user->avatar) }}" alt="Photo du profil">
                            </div>

                            <div class="content">

                                <div class="title">{{ $user->pseudo }}</div>

                                <div class="desc">Les avis sont publics et incluent des informations sur votre compte
                                    et
                                    votre appareil. Tout
                                    le monde peut voir le nom et la photo de votre compte Google ainsi que le type
                                    d'appareil
                                    associés à votre avis. Les développeurs peuvent aussi voir votre pays et des
                                    informations
                                    sur votre appareil (langue, modèle, version de l'OS, etc.), et utiliser ces données
                                    pour
                                    vous répondre. Les utilisateurs et le développeur de l'appli peuvent consulter les
                                    modifications antérieures, à moins que vous ne supprimiez votre avis.</div>

                            </div>

                        </div>

                        <div class="note mb-5">

                            <div class="s-note" data-note="5">
                                <i class="fa-solid fa-star"></i>
                            </div>

                            <div class="s-note" data-note="4">
                                <i class="fa-solid fa-star"></i>
                            </div>

                            <div class="s-note" data-note="3">
                                <i class="fa-solid fa-star"></i>
                            </div>

                            <div class="s-note" data-note="2">
                                <i class="fa-solid fa-star"></i>
                            </div>

                            <div class="s-note" data-note="1">
                                <i class="fa-solid fa-star"></i>
                            </div>

                            <div style="width: 100%;margin-top: 0.25rem;">
                                <span class="error-text text-danger noteComments_error"></span>
                            </div>

                        </div>

                        <div class="add-comment">

                            <textarea name="appsComment" maxlength="500" minlength="2" id="appsComment"
                                placeholder="Décrivez votre expérience (facultatif)" cols="" rows="1"></textarea>
                            <span class="text-end counterkey">0 / 500</span>

                            <div style="width: 100%;margin-top: 0.25rem;">
                                <span class="error-text text-danger appsComment_error"></span>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="submit" class="btn btn-avis disabled">Valider</button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endif

@if (Auth::check())
    <div class="modal fade" id="modal-paiement" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">Acheter cette application</h1>

                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                </div>

                <div class="modal-body text-center">

                    <div class="apps-paiements">

                        <p class="font-weight-bold">
                            En cliquant sur le bouton vous serez redirigée sur la plateforme Paypal
                            sécurisée, après votre achat vous pourrez télécharger l'application dans votre espace !</p>

                        <div>
                            <a class="btn btn-success btn-block font-weight-bold"
                                href="{{ route('make.payment.apps', $projet_id->id) }}">

                                <i class="fa-brands fa-paypal mr-1"></i>

                                <span class="btn-card">Payer avec Paypal</span>

                            </a>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-warning font-weight-bold" type="button"
                        data-dismiss="modal">Annuler</button>
                </div>

            </div>

        </div>

    </div>
@endif
