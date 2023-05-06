@php
    use Carbon\Carbon;
    use App\Models\TopicsForums;
    use App\Models\TopicsReplies;
    $post_date = $forum_topic->created_at;
    if (!empty($topic_replie_last->updated_at)) {
        $post_date_last_topic = $topic_replie_last->updated_at;
    }

@endphp

<div class="disputo-page-title">
    <div class="container">
        <h1 class="text-center">{{ $forum_topic->title }}</h1>
    </div>
</div>

<div class="vg-page page-blog disputo-main-container">

    <div class="container">

        <div id="disputo-main-inner" class="">

            <div class="disputo-page-left">

                <div id="bbpress-forums">

                    <div class="bbp-breadcrumb">

                        <p>
                            <a href="/" class="bbp-breadcrumb-home"><i class="fa-solid fa-home"></i></a>

                            <span class="bbp-breadcrumb-sep">›</span>

                            <a href="{{ route('forum') }}" class="bbp-breadcrumb-home">Forums</a>

                            <span class="bbp-breadcrumb-sep">›</span>

                            <a href="{{ route('forum') . '/forum/' . $forum_categorie->url }}"
                                class="bbp-breadcrumb-forum">{{ $forum_categorie->title }}</a>

                            <span class="bbp-breadcrumb-sep">›</span>

                            <span class="bbp-breadcrumb-current">{{ $forum_topic->title }}</span>

                        </p>

                    </div>

                    <div class="bbp-template-notice info">

                        <ul>

                            <li class="bbp-topic-description">
                                Ce sujet a {{ count($topics_replies) }}@if (count($topics_replies) >= 2)
                                    réponses.
                                @else
                                    @endif @if (!empty($topic_replie_last) && !empty($topic_replie_last->updated_at))
                                        , a été mis à jour pour la dernière fois par
                                        {{ $topic_replie_last->firstname . ' ' . $topic_replie_last->lastname }}
                                        le {{ ucfirst($post_date_last_topic->dayName) }}
                                        {{ $post_date_last_topic->isoFormat('LL') }}
                                        - {{ $topic_replie_last->updated_at->diffForHumans() }}.
                                    @else
                                        @if (count($topics_replies) >= 2)
                                        @else
                                            réponse.
                                        @endif
                                    @endif
                            </li>

                        </ul>

                    </div>

                    <ul class="disputo-replies-bar">

                        <li class="disputo-replies-title">
                            Post </li>

                        <li class="disputo-replies-links">
                            <span class="disputo-replies-subscription"></span>
                            <span class="disputo-replies-favorites"></span>
                        </li>

                    </ul>

                    <ul id="topic-{{ $forum_topic->id }}-lead" class="forums bbp-lead">

                        <li>

                            <div id="post-{{ $forum_topic->id }}"
                                class="loop-item--1 user-id-1 bbp-parent-forum-90 even  sticky post-{{ $forum_topic->id }} topic type-topic status-publish hentry topic-tag-announcement topic-tag-maintenance topic-tag-sticky">

                                <div class="disputo-replies-content-bar">

                                    <ul class="disputo-replies-content-bar-left">

                                        <li>
                                            <span class="bbp-topic-post-date"><i class="fa fa-clock-o mr-1"></i>
                                                {{ ucfirst($post_date->dayName) }} {{ $post_date->isoFormat('LL') }} -
                                                {{ $forum_topic->created_at->diffForHumans() }}</span>
                                        </li>

                                    </ul>

                                    <ul class="disputo-replies-content-bar-right">

                                        @if (Auth::check() && $user->admin >= 1 && $forum_topic->status !== 0 && $forum_categorie->status !== 0)
                                            <li>
                                                <a id="close-topic" data-action="{{ route('close.topic') }}"
                                                    data-method="POST" data-id="{{ $forum_topic->id }}"
                                                    class="btn btn-sm btn-danger text-white font-weight-bold">Fermer</a>
                                            </li>
                                        @endif

                                        @if (Auth::check() && $user->admin >= 1 && $forum_topic->sticky !== 1)
                                            <li>
                                                <a id="top-topic" data-action="{{ route('top.topic') }}"
                                                    data-method="POST" data-id="{{ $forum_topic->id }}"
                                                    class="btn btn-sm btn-info text-white font-weight-bold">Top</a>
                                            </li>
                                        @endif

                                        @if (Auth::check() &&
                                                $user->admin <= 0 &&
                                                $forum_topic->user_id == Auth::id() &&
                                                $forum_topic->status !== 0 &&
                                                $forum_categorie->status !== 0)
                                            <li>
                                                <a id="close-topic-user" data-action="{{ route('close.topic.user') }}"
                                                    data-method="POST" data-id="{{ $forum_topic->id }}"
                                                    class="btn btn-sm btn-danger text-white font-weight-bold">Fermer</a>
                                            </li>
                                        @endif

                                    </ul>

                                </div>

                                <div class="disputo-replies-wrapper">

                                    <div class="disputo-replies-author disputo-user-bbp_keymaster">

                                        <div class="disputo-replies-author-img " title="">

                                            <a href="""
                                                title="Voir le profil de {{ $forum_topic->firstname . ' ' . $forum_topic->lastname }}"
                                                class="bbp-author-link">

                                                <span class="bbp-author-avatar">

                                                    <img alt="{{ $forum_topic->firstname . ' ' . $forum_topic->lastname }}"
                                                        src="{{ URL::asset('img/profil/' . $forum_topic->avatar) }}"
                                                        class="avatar avatar-80 photo" height="80" width="80"
                                                        loading="lazy" decoding="async">

                                                </span>

                                            </a>

                                        </div>

                                        <div class="disputo-replies-author-info">

                                            <a href=""
                                                title="Voir le profil de {{ $forum_topic->firstname . ' ' . $forum_topic->lastname }}"
                                                class="bbp-author-link">

                                                <span class="bbp-author-name">
                                                    {{ $forum_topic->firstname . ' ' . $forum_topic->lastname }}
                                                </span>

                                            </a>

                                            <div class="bbp-author-role">

                                                @if ($forum_topic->user_role == 1)
                                                    Administrateur
                                                @elseif($forum_topic->user_role == 2)
                                                    Modérateur
                                                @else
                                                    Utilisateur
                                                @endif

                                            </div>

                                            <div class="disputo-user-location">
                                                <img src="{{ URL::asset('img/forums/blank.gif') }}"
                                                    class="flag flag-{{ strtolower($forum_topic->pays) }}"
                                                    alt="{{ strtolower($forum_topic->pays) }}">
                                            </div>

                                            @php
                                                $topic_per_user = TopicsForums::where('topics_forums.user_id', $forum_topic->user_id)
                                                    ->join('users', 'users.id', '=', 'topics_forums.user_id')
                                                    ->select('topics_forums.id')
                                                    ->get();

                                                $replies_per_user = TopicsReplies::where('topics_replies.user_id', $forum_topic->user_id)
                                                    ->join('users', 'users.id', '=', 'topics_replies.user_id')
                                                    ->where('topics_replies.status', 1)
                                                    ->select('topics_replies.id')
                                                    ->get();
                                            @endphp

                                            <a tabindex="0" class="disputo-popover" data-container="body"
                                                data-trigger="focus" data-toggle="popover" data-placement="bottom"
                                                data-html="true"
                                                data-content="Sujets commencés : <b>{{ count($topic_per_user) }}</b><br>Réponses créées : <b>{{ count($replies_per_user) }}</b>"
                                                data-original-title="Statistiques"><i
                                                    class="fa-solid fa-chart-simple"></i></a>

                                        </div>

                                    </div>

                                    <div class="disputo-replies-content">

                                        <div class="disputo-reply-wrapper">

                                            <div class="solved-topic-bar">

                                                @if ($forum_topic->resolved == 1)
                                                    <span class="badge badge-success">
                                                        <i class="fa-solid fa-check"></i>
                                                        Résolue</span>
                                                @endif

                                            </div>

                                            <div id="disputo-quote-{{ $forum_topic->id }}"
                                                class="disputo-quote-wrapper">
                                                {!! $forum_topic->content !!}
                                            </div>

                                            <div class="disputo-forum-signature">{{ $forum_topic->signature }}</div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </li>

                    </ul>

                    @if (count($topics_replies) >= 1)
                        <div class="bbp-pagination">
                            <div class="bbp-pagination-count">Affichage de {{ count($topics_replies) }}@if (count($topics_replies) <= 1)
                                    réponse (sur
                                    {{ count($topics_replies) }} total)
                                @else
                                    réponses (sur
                                    {{ count($topics_replies) }} totals)
                                @endif
                            </div>
                            <div class="bbp-pagination-links"></div>
                        </div>
                    @endif

                    <ul id="topic-{{ $forum_topic->id }}-replies" class="forums bbp-replies">

                        @foreach ($topics_replies as $data)
                            @php
                                $post_date_topic = $data->created_at;
                                $topic_per_user = TopicsForums::where('topics_forums.user_id', $data->user_id)
                                    ->join('users', 'users.id', '=', 'topics_forums.user_id')
                                    ->select('topics_forums.id')
                                    ->get();

                                $replies_per_user = TopicsReplies::where('topics_replies.user_id', $data->user_id)
                                    ->join('users', 'users.id', '=', 'topics_replies.user_id')
                                    ->where('topics_replies.status', 1)
                                    ->select('topics_replies.id')
                                    ->get();
                            @endphp
                            <li>

                                <div id="post-{{ $data->id }}"
                                    class="loop-item-0 user-id-1 bbp-parent-forum-90 bbp-parent-topic-1 bbp-reply-position-1 odd topic-author  post-333 reply type-reply status-publish hentry">

                                    <div id="" class="disputo-replies-content-bar">

                                        <ul class="disputo-replies-content-bar-left">

                                            <li>
                                                <span class="bbp-reply-post-date">
                                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                    {{ ucfirst($post_date_topic->dayName) }}
                                                    {{ $post_date_topic->isoFormat('LL') }}
                                                    - {{ $data->created_at->diffForHumans() }}</span>
                                            </li>

                                        </ul>

                                    </div>

                                    <div class="disputo-replies-wrapper">

                                        <div class="disputo-replies-author disputo-user-bbp_keymaster">

                                            <div class="disputo-replies-author-img " title="">

                                                <a href=""
                                                    title="Voir le profil de {{ $data->firstname . ' ' . $data->lastname }}"
                                                    class="bbp-author-link">

                                                    <span class="bbp-author-avatar">
                                                        <img alt=""
                                                            src="{{ URL::asset('img/profil/' . $data->avatar) }}"
                                                            class="avatar avatar-80 photo" height="80"
                                                            width="80" loading="lazy" decoding="async">
                                                    </span>
                                                </a>

                                            </div>

                                            <div class="disputo-replies-author-info">

                                                <a href=""
                                                    title="Voir le profil de {{ $data->firstname . ' ' . $data->lastname }}"
                                                    class="bbp-author-link">

                                                    <span
                                                        class="bbp-author-name">{{ $data->firstname . ' ' . $data->lastname }}</span>

                                                </a>

                                                <div class="bbp-author-role">
                                                    @if ($data->user_role == 1)
                                                        Administrateur
                                                    @elseif($data->user_role == 2)
                                                        Modérateur
                                                    @else
                                                        Utilisateur
                                                    @endif
                                                </div>

                                                <div class="disputo-user-location">
                                                    <img src="{{ URL::asset('img/forums/blank.gif') }}"
                                                        class="flag flag-{{ strtolower($data->pays) }}"
                                                        alt="{{ strtolower($data->pays) }}">
                                                </div>

                                                <a tabindex="0" class="disputo-popover" data-container="body"
                                                    data-trigger="focus" data-toggle="popover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="Sujets commencés : <b>{{ count($topic_per_user) }}</b><br>Réponses créées : <b>{{ count($replies_per_user) }}</b>"
                                                    data-original-title="Statistiques"><i
                                                        class="fa-solid fa-chart-simple"></i></a>

                                            </div>
                                        </div>

                                        <div class="disputo-replies-content">

                                            <div class="disputo-reply-wrapper">

                                                <div id="disputo-quote-{{ $data->id }}"
                                                    class="disputo-quote-wrapper">
                                                    {!! $data->content !!}
                                                </div>

                                                <div class="disputo-forum-signature"> {!! $data->signature !!}</div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </li>
                        @endforeach

                    </ul>

                    @if ($forum_topic->status == 0)
                        <div id="no-reply-{{ $forum_topic->id }}" class="bbp-no-reply">
                            <div class="bbp-template-notice">
                                <ul>
                                    <li>Le sujet ‘{{ $forum_topic->title }}’ est fermé aux réponses.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if ($forum_categorie->status == 0)
                        <div id="no-reply-{{ $forum_topic->id }}" class="bbp-no-reply">
                            <div class="bbp-template-notice">
                                <ul>
                                    <li>Le forum ‘{{ $forum_topic->title }}’ est fermé aux nouveaux sujets et réponses.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if (count($topics_replies) >= 1)
                        <div class="bbp-pagination">
                            <div class="bbp-pagination-count">Affichage de {{ count($topics_replies) }}@if (count($topics_replies) <= 1)
                                    réponse (sur
                                    {{ count($topics_replies) }} total)
                                @else
                                    réponses (sur
                                    {{ count($topics_replies) }} totals)
                                @endif
                            </div>
                            <div class="bbp-pagination-links"></div>
                        </div>
                    @endif

                    @if ($forum_topic->admin == 1)
                        <div class="bbp-template-notice danger" style="margin-top: 1.5rem; margin-bottom: 0;">Vous
                            devez
                            être un utilisateur
                            vérifié pour répondre.</div>
                    @endif

                    @if (!Auth::check())
                        <div class="bbp-template-notice" style="margin-top: 1.5rem;">
                            <ul>
                                <li>Vous devez être connecté pour répondre à ce sujet.</li>
                            </ul>
                        </div>
                    @elseif($forum_topic->status == 1 && $forum_categorie->status == 1)
                        <div class="loader-form hidden" id="loader-reply">
                            <img src="{{ URL::asset('img/loader.svg') }}" alt="">
                        </div>

                        <form id="reply-topic" method="post" action="{{ route('topic.reply.message') }}"
                            class="bbp-login-form mt-3">

                            <input type="hidden" name="id" id="id" value="{{ $forum_topic->id }}">

                            <fieldset class="bbp-form">

                                <legend>Répondre à ce sujet</legend>

                                <div class="bbp-username">
                                    <label for="content">Votre message : </label>
                                    <textarea name="content" id="content" cols="30" rows="10"></textarea>
                                    <div style="width: 100%;margin-top: 0.25rem;">
                                        <span class="error-text text-danger content_error"></span>
                                    </div>
                                </div>

                                <div class="bbp-password mt-3">

                                    <label for="signature">Votre signature : </label>
                                    <input type="text" name="signature" size="20" id="signature">
                                    <div style="width: 100%;margin-top: 0.25rem;">
                                        <span class="error-text text-danger signature_error"></span>
                                    </div>

                                </div>

                                <div class="bbp-submit-wrapper mt-3">

                                    <button type="submit" class="button submit user-submit">Poster votre
                                        message</button>

                                </div>

                            </fieldset>

                        </form>
                    @endif

                </div>

            </div>

            <aside class="disputo-page-right">

                <div id="bbp_search_widget-2" class="widget_display_search disputo-sidebar-box">

                    <form role="search" method="get"
                        action="https://themes.thememasters.club/disputo/forums/search/">

                        <div class="input-group">

                            <input type="hidden" name="action" value="bbp-search-request">

                            <input tabindex="101" type="text" value="" name="bbp_search"
                                class="form-control" placeholder="Rechercher sur le forum">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary"><i
                                        class="fa-solid fa-search"></i></button>
                            </div>

                        </div>

                    </form>

                </div>

                @if (!Auth::check())
                    <div id="bbp_login_widget-2" class="bbp_widget_login disputo-sidebar-box">

                        <div class="loader-form hidden" id="loader-login">
                            <img src="{{ URL::asset('img/loader-2.svg') }}" alt="">
                        </div>

                        <form id="form-login" method="post" action="{{ route('authenticate') }}"
                            class="bbp-login-form">

                            <input type="hidden" name="token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="redirect" value="{{ url()->full() }}" />

                            <fieldset class="bbp-form">

                                <legend>Connexion</legend>

                                <div class="bbp-username">

                                    <label for="email">Adresse email : </label>
                                    <input type="text" name="email" size="20" id="email"
                                        name="email" autocomplete="off">

                                    <span class="error-text text-danger email_error"></span>

                                </div>

                                <div class="bbp-password mb-4">

                                    <label for="user_pass">Mot de passe : </label>
                                    <input type="password" name="password" size="20" id="password"
                                        autocomplete="off">

                                    <span class="error-text text-danger password_error"></span>

                                </div>

                                <div class="bbp-submit-wrapper">

                                    <button type="submit" class="button submit user-submit">Se connecter</button>

                                </div>

                            </fieldset>

                        </form>

                    </div>
                @endif

                <div id="disputo-list-4" class="widget_disputo-list disputo-sidebar-box">

                    <div class="so-widget-disputo-list so-widget-disputo-list-base">

                        <div class="disputo-widget-title">
                            <h5><span>Forums</span></h5>
                        </div>

                        <div class="disputo-post-list-wrapper">

                            @foreach ($forums as $data)
                                @php
                                    $topics_all = TopicsForums::where('forum_id', $data->id)->get();
                                    $topic_replies = TopicsReplies::where('forum_id', $data->id)
                                        ->where('topics_replies.status', 1)
                                        ->get();
                                @endphp
                                <div class="disputo-post-list">

                                    <div class="disputo-post-list-left">

                                        <a href="{{ route('forum') . '/forum/' . $data->url }}">
                                            <img src="{{ URL::asset('img/forums/' . $data->image) }}"
                                                alt="{{ $data->title }}">
                                        </a>

                                    </div>

                                    <div class="disputo-post-list-right">

                                        <p>
                                            <a
                                                href="{{ route('forum') . '/forum/' . $data->url }}">{{ $data->title }}</a>
                                        </p>

                                        <div class="disputo-post-list-meta">

                                            <span>
                                                Sujets : <strong>{{ count($topics_all) }}</strong>
                                            </span>

                                            <span>
                                                Réponses : <strong>{{ count($topic_replies) }}</strong>
                                            </span>

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>

                    </div>

                </div>

                <div id="bbp_topics_widget-2" class="widget_display_topics disputo-sidebar-box">

                    <h5 class="disputo-widget-title">
                        <span>Sujets récents</span>
                    </h5>

                    <ul class="bbp-topics-widget newness">

                        @foreach ($topics_recent as $data)
                            @php
                                $post_date_topic = $data->created_at;
                            @endphp

                            <li>

                                <a class="bbp-forum-title"
                                    href="{{ route('forum') . '/forum/topic/' . $data->url }}">{{ $data->title }}</a>

                                <div>
                                    {{ ucfirst($post_date_topic->dayName) }} {{ $post_date_topic->isoFormat('LL') }} -
                                    {{ $data->created_at->diffForHumans() }}
                                </div>

                            </li>
                        @endforeach

                    </ul>

                </div>

            </aside>

        </div>

    </div>

</div>
