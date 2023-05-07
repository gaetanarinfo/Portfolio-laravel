@php
    use Carbon\Carbon;
    use App\Models\TopicsReplies;

    $dateNaissance = date('d-m-Y', strtotime($user->naissance));
    $aujourdhui = date('Y-m-d');
    $diff = date_diff(date_create($dateNaissance), date_create($aujourdhui));
    $post_date = $user->created_at;
@endphp

<div class="disputo-page-title">
    <div class="container">
        <h1 class="text-center">{{ $user->pseudo }}</h1>
        <p>{{ $user->signature }}</p>
    </div>
</div>

<div class="vg-page page-blog disputo-main-container">

    <div class="container">

        <div id="disputo-main-inner" class="">

            <div id="bbpress-forums">

                <div class="disputo-user-wrapper">

                    <div id="bbp-user-wrapper" class="disputo-user-left">

                        <div id="bbp-single-user-details">

                            <div id="bbp-user-avatar" class="" title="{{ $user->pseudo }}">
                                <a href="{{ route('forums.users') . '/' . $user->pseudo }}" title="{{ $user->pseudo }}">
                                    <img alt="" src="{{ URL::asset('img/profil/' . $user->avatar) }}"
                                        class="avatar avatar-150 photo" height="150" width="150" loading="lazy"
                                        decoding="async"> </a>
                            </div>

                            <div id="bbp-user-navigation" class="bbp-user-navigation-hide">

                                <ul class="list-group">

                                    <li class="list-group-item bg-primary">
                                        <span class="bbp-user-profile-link">
                                            <a class="text-white"
                                                href="https://themes.thememasters.club/disputo/forums/users/egemen/"
                                                title="{{ $user->pseudo }} Profile" rel="me">Profile</a>
                                        </span>
                                    </li>

                                    <li class="list-group-item ">
                                        <span class="bbp-user-topics-created-link">
                                            <a href="https://themes.thememasters.club/disputo/forums/users/egemen/topics/"
                                                title="{{ $user->pseudo }} Sujets commencés">Sujets commencés</a>
                                        </span>

                                    </li>

                                    <li class="list-group-item ">
                                        <span class="bbp-user-replies-created-link">
                                            <a href="https://themes.thememasters.club/disputo/forums/users/egemen/replies/"
                                                title="{{ $user->pseudo }} Replies Created">Réponses créées</a>
                                        </span>
                                    </li>

                                    <li class="list-group-item ">
                                        <span class="bbp-user-favorites-link">
                                            <a href="https://themes.thememasters.club/disputo/forums/users/egemen/favorites/"
                                                title="{{ $user->pseudo }} Favorites">Favoris</a>
                                        </span>
                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                    <div id="bbp-user-body" class="disputo-user-right">

                        <div class="disputo-before-user-profile">
                        </div>

                        <div id="bbp-user-profile" class="bbp-user-profile">

                            <div class="disputo-user-boxes">

                                <div class="disputo-user-box bbp-user-forum-role">

                                    <div class="disputo-user-box-icon">

                                        <div class="disputo-user-box-icon-inner">
                                            <i class="fa fa-user"></i>
                                        </div>

                                    </div>

                                    <div class="disputo-user-box-info disputo-user-bbp_keymaster">
                                        <h5>Rôle du forum</h5>
                                        <p><span class="badge badge-info">
                                                @if ($user->user_role == 1)
                                                    Administrateur
                                                @elseif($user->user_role == 2)
                                                    Modérateur
                                                @else
                                                    Utilisateur
                                                @endif
                                            </span></p>
                                    </div>

                                </div>

                                <div class="disputo-user-box center-box bbp-user-topic-count">

                                    <div class="disputo-user-box-icon">
                                        <div class="disputo-user-box-icon-inner">
                                            <i class="fa fa-comment"></i>
                                        </div>
                                    </div>

                                    <div class="disputo-user-box-info">
                                        <h5>Sujets commencés</h5>
                                        <p><span class="badge badge-primary">{{ count($topics) }}</span></p>
                                    </div>

                                </div>

                                <div class="disputo-user-box">

                                    <div class="disputo-user-box-icon">
                                        <div class="disputo-user-box-icon-inner">
                                            <i class="fa fa-comments"></i>
                                        </div>
                                    </div>

                                    <div class="disputo-user-box-info">
                                        <h5>Réponses créées</h5>
                                        <p><span class="badge badge-primary">{{ count($replies) }}</span></p>
                                    </div>
                                </div>

                            </div>

                            <ul class="disputo-user-list-group list-group">

                                <li class="bbp-user-name list-group-item">
                                    <p><strong class="text-primary">Prénom / Nom :</strong>
                                        {{ $user->firstname . ' ' . $user->lastname }}</p>
                                </li>

                                <li class="bbp-user-age list-group-item">
                                    <p><strong class="text-primary">Age :</strong> {{ $diff->format('%y') }}</p>
                                </li>

                                <li class="bbp-user-gender list-group-item">
                                    <p><strong class="text-primary">Civilité :</strong>
                                        @if ($user->civilite == 1)
                                            Femme
                                        @else
                                            Homme
                                        @endif
                                    </p>
                                </li>

                                <li class="bbp-user-location list-group-item">
                                    <p><strong class="text-primary">Location : </strong>
                                        <img src="{{ URL::asset('img/forums/blank.gif') }}"
                                            class="flag flag-{{ strtolower($user->pays) }}"
                                            alt="{{ strtolower($user->pays) }}"><span>{{ $pays->nom_fr_fr }}</span>
                                    </p>
                                </li>

                                <li class="bbp-user-description list-group-item">
                                    <p><strong class="text-primary">Information biographique :</strong> </p>
                                    <p class="mt-3 font-italic">{{ $user->biographie }}
                                    </p>
                                </li>

                                <li class="bbp-user-website list-group-item">
                                    <p><strong class="text-primary">Site internet :</strong> <a
                                            href="{{ $user->website }}" rel="nofollow"
                                            target="_blank">{{ $user->website }}</a></p>
                                </li>

                                <li class="bbp-user-registered list-group-item">
                                    <p><strong class="text-primary">Inscrit(e) depuis :</strong>
                                        {{ ucfirst($post_date->dayName) }} {{ $post_date->isoFormat('LL') }} -
                                        {{ $user->created_at->diffForHumans() }}</p>
                                </li>


                                <li class="bbp-user-socialmedia list-group-item">

                                    <ul class="disputo-social-icons">

                                        @if (!empty($user->fb_page))
                                            <li><a class="bg-info text-white" href="{{ $user->fb_page }}"
                                                    target="_blank" rel="nofollow"><i
                                                        class="fa fa-facebook-f"></i></a></li>
                                        @endif

                                        @if (!empty($user->twitter_page))
                                            <li><a class="bg-info text-white" href="{{ $user->twitter_page }}"
                                                    target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a>
                                            </li>
                                        @endif

                                        @if (!empty($user->insta_page))
                                            <li><a class="bg-info text-white" href="{{ $user->insta_page }}"
                                                    target="_blank" rel="nofollow"><i
                                                        class="fa fa-instagram"></i></a></li>
                                        @endif

                                        @if (!empty($user->linkedin_page))
                                            <li><a class="bg-info text-white" href="{{ $user->linkedin_page }}"
                                                    target="_blank" rel="nofollow"><i class="fa fa-linkedin"></i></a>
                                            </li>
                                        @endif

                                        @if (!empty($user->youtube_page))
                                            <li><a class="bg-info text-white" href="{{ $user->youtube_page }}"
                                                    target="_blank" rel="nofollow"><i class="fa fa-youtube"></i></a>
                                            </li>
                                        @endif
                                    </ul>

                                    <div class="clearfix"></div>

                                </li>

                            </ul>
                        </div>

                        <div class="disputo-after-user-profile">
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
