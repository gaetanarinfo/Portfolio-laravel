<div class="apps" style="background-color: #{{ $projet->color }}">

    <div class="apps-container">

        <div class="row"
            style="background: url('{{ URL::asset('img/projets/background/' . $projet->background) }}');background-position: right;background-size: contain;background-repeat: no-repeat;">

            <div class="col-lg-12 h-s contain">

                <h1>{{ $projet->title }}</h1>

                <p class="product">{{ $projet->author }}</p>

                <small>
                    @if ($projet->prix >= 1)
                        Appli payante
                    @else
                        Gratuit
                    @endif
                </small>

                <div class="col-lg-6 grid">

                    <div class="row">

                        <div class="col">
                            <img src="{{ URL::asset('img/projets/icons/' . $projet->icone) }}" class=""
                                alt="Image de l'icône">
                        </div>

                        <div class="col">

                            <p>{{ number_format($projet->note, 2, ',', '') }} <i class="fa-solid fa-star"></i></p>
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

                <div class="text-end contain-btn">

                    <a href="" class="btn btn-theme ml-0">Acheter l'application</a>

                </div>

            </div>

            <div
                style="background: linear-gradient(to right,rgb(32,33,36) 0,rgba(0,0,0,0) 56%),linear-gradient(to top,rgb(32,33,36) 0,rgba(0,0,0,0) 56%),linear-gradient(to left,rgb(32,33,36) 0,rgba(0,0,0,0) 56%);bottom: 0;left: 30%;right: 0;top: 0;position: absolute;">
            </div>

        </div>

    </div>

</div>

<div class="apps-container apps-content">

    <div class="row">

        <div class="col-lg-7 mr-5">

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

                </div>

                <div>
                    <a href="" class="btn btn-avis">Rédiger un avis</a>
                </div>

            </div>

            <div class="note-by-avis">

                <h3>Notes et avis</h3>

                <span>
                    <div>Les notes et les avis sont vérifiés <i class="ml-2 fa-solid fa-exclamation"></i></div>
                </span>

            </div>

        </div>

        <div class="col-lg-4">

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

                                    <div class="in-note">
                                        <span class="note">{{ number_format($projet->note, 2, ',', '') }}</span>
                                        <span class="sp-p"><i class="fa-solid fa-star"></i></span>
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
