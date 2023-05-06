@php
    use Carbon\Carbon;
    use App\Models\TopicsReplies;
@endphp

<div class="disputo-page-title">
    <div class="container">
        <h1 class="text-center">{{ $forum_categorie->title }}</h1>
        <p>{{ $forum_categorie->content }}</p>
    </div>
</div>

<div class="vg-page page-blog disputo-main-container">

    <div class="container">

        <div id="disputo-main-inner">

            <div class="panel-layout">

                <div id="pg-194-0" class="panel-grid panel-no-style">

                    <div id="pgc-194-0-0" class="panel-grid-cell">

                        <div id="panel-194-0-0-0"
                            class="so-panel widget widget_disputo-forums panel-first-child panel-last-child"
                            data-index="0">

                            <div class="so-widget-disputo-forums so-widget-disputo-forums-base">

                                <div class="disputo-forums-widget">

                                    <div id="bbpress-forums">

                                        <div class="bbp-search-form">

                                            <form role="search" method="get"
                                                action="https://themes.thememasters.club/disputo/forums/search/">
                                                <div class="input-group">
                                                    <input type="hidden" name="action" value="bbp-search-request">
                                                    <input tabindex="101" type="text" value=""
                                                        name="bbp_search" class="form-control"
                                                        placeholder="Rechercher sur le forum">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary"><i
                                                                class="fa-solid fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>

                                        <div class="bbp-breadcrumb">
                                            <p>
                                                <a href="/" class="bbp-breadcrumb-home"><i
                                                        class="fa-solid fa-home"></i></a>

                                                <span class="bbp-breadcrumb-sep">›</span>

                                                <a href="{{ route('forum') }}" class="bbp-breadcrumb-home">Forums</a>

                                                <span class="bbp-breadcrumb-sep">›</span>

                                                <span
                                                    class="bbp-breadcrumb-current">{{ $forum_categorie->title }}</span>
                                            </p>
                                        </div>

                                        <div class="bbp-template-notice info">
                                            <ul>
                                                <li class="bbp-forum-description">Ce forum comporte {{ count($topics) }}
                                                    @if (count($topics) >= 2)
                                                        sujets,
                                                    @else
                                                        sujet,
                                                        @endif {{ count($topics_replies_all) }} @if (count($topics_replies_all) >= 2)
                                                            réponses.
                                                        @else
                                                            réponse.
                                                        @endif
                                                </li>
                                            </ul>
                                        </div>

                                        @if (Auth::check())
                                            @if ($user->admin >= 1)
                                                <div class="mb-3 text-right">
                                                    <a id="create-topic"
                                                        class="btn btn-sm btn-primary text-white font-weight-bold">Créer
                                                        un sujet</a>
                                                </div>
                                            @endif

                                            @if ($user->admin == 0 && $forum_categorie->status >= 1)
                                                <div class="mb-3 text-right">
                                                    <a id="create-topic"
                                                        class="btn btn-sm btn-primary text-white font-weight-bold">Créer
                                                        un sujet</a>
                                                </div>
                                            @endif
                                        @endif

                                        @if (count($topics) >= 1)
                                            <div class="bbp-pagination">

                                                <div class="bbp-pagination-count">Affichage de {{ count($topics) }}
                                                    sujets -
                                                    1 à {{ count($topics) }} (sur {{ count($topics) }} au
                                                    total)</div>
                                                <div class="bbp-pagination-links"></div>

                                            </div>

                                            <ul id="bbp-list-{{ $forum_categorie->id }}" class="bbp-topics">

                                                <li class="bbp-header">

                                                    <ul class="forum-titles">

                                                        <li class="bbp-topic-title">SUJET</li>

                                                        <li class="bbp-topic-voice-count"><i class="fa fa-user"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="" data-original-title="DISCUSSION"></i>
                                                        </li>

                                                        <li class="bbp-topic-reply-count"><i class="fa fa-comments"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="" data-original-title="RÉPONSES"></i>
                                                        </li>

                                                        <li class="bbp-topic-views-count"><i class="fa fa-eye"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="" data-original-title="VUES"></i></li>

                                                        <li class="bbp-topic-freshness"><i class="fa fa-clock-o"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title=""
                                                                data-original-title="FRAÎCHEMENT POSTÉ"></i></li>

                                                    </ul>

                                                </li>

                                                <li class="bbp-body">
                                                    @foreach ($topics as $data)
                                                        @php
                                                            $post_date = $data->created_at;

                                                            // Replies par identifiant et par topic
                                                            $topics_replies = TopicsReplies::where('forum_id', $data->forum_id)
                                                                ->where('topic_id', $data->id)
                                                                ->where('status', 1)
                                                                ->select('id')
                                                                ->get();

                                                            $topics_replies_views = TopicsReplies::where('forum_id', $data->forum_id)
                                                                ->where('topic_id', $data->id)
                                                                ->where('status', 1)
                                                                ->select('views')
                                                                ->first();

                                                        @endphp

                                                        <ul id="bbp-forum-{{ $data->id }}"
                                                            class="loop-item-0 user-id-1 bbp-parent-forum-90 odd sticky post-187 topic type-topic status-publish hentry topic-tag-announcement topic-tag-maintenance topic-tag-sticky">

                                                            <li class="bbp-topic-title">

                                                                @if ($data->resolved == 1)
                                                                    <i class="fa fa-check-circle text-success"></i>
                                                                @endif

                                                                <a class="bbp-topic-permalink"
                                                                    href="{{ route('forum') . '/forum/topic/' . $data->url }}">{{ $data->title }}</a>

                                                                @if ($data->sticky == 1)
                                                                    <span class="badge badge-success">Top</span>
                                                                @endif

                                                                <p class="bbp-topic-meta">

                                                                    <span class="bbp-topic-started-by">
                                                                        Démarré par :
                                                                        <a href=""
                                                                            title="Voir le profil de {{ $data->firstname }} {{ $data->lastname }}"
                                                                            class="bbp-author-link"><span
                                                                                class="bbp-author-name">{{ $data->firstname }}
                                                                                {{ $data->lastname }}</span></a>
                                                                    </span>
                                                                </p>

                                                            </li>

                                                            <li class="bbp-forum-topic-count">0</li>

                                                            <li class="bbp-forum-reply-count">
                                                                {{ count($topics_replies) }}
                                                            </li>

                                                            <li class="bbp-forum-views-count">
                                                                {{ $data->views }}
                                                            </li>

                                                            <li class="bbp-forum-freshness">

                                                                <div class="disputo-freshness-box">

                                                                    <div class="disputo-freshness-left">

                                                                        <div class="disputo-freshness-name">
                                                                            <a href=""
                                                                                title="Voir le profil de {{ $data->firstname }} {{ $data->lastname }}"
                                                                                class="bbp-author-link"><span
                                                                                    class="bbp-author-name">{{ $data->firstname }}
                                                                                    {{ $data->lastname }}</span></a>
                                                                        </div>

                                                                        <div class="disputo-freshness-link">
                                                                            <a href="https://themes.thememasters.club/disputo/forums/topic/main-forum-rules-policies/#post-333"
                                                                                title="Reply To: Main Forum Rules &amp; Policies">{{ $data->created_at->diffForHumans() }}</a>
                                                                        </div>

                                                                    </div>

                                                                    <div class="disputo-freshness-right ">
                                                                        <a href=""
                                                                            title="Voir le profil de {{ $data->firstname }} {{ $data->lastname }}"
                                                                            class="bbp-author-link"><span
                                                                                class="bbp-author-avatar"><img
                                                                                    alt=""
                                                                                    src="{{ URL::asset('img/profil' . '/' . $data->avatar) }}"
                                                                                    class="avatar avatar-45 photo"
                                                                                    height="45" width="45"
                                                                                    loading="lazy"
                                                                                    decoding="async"></span></a>
                                                                    </div>

                                                                </div>

                                                            </li>

                                                        </ul>
                                                    @endforeach
                                                </li>

                                            </ul>

                                            <div class="bbp-pagination" style="padding: 0.25rem 0 1.5rem 0;">

                                                <div class="bbp-pagination-count">Affichage de {{ count($topics) }}
                                                    sujets
                                                    - 1 à {{ count($topics) }} (sur {{ count($topics) }} au
                                                    total)</div>
                                                <div class="bbp-pagination-links"></div>

                                            </div>
                                        @else
                                            <h2 class="empty-topic text-center">Aucun sujet pour le moment</h2>
                                        @endif

                                        <div id="forum-closed-{{ $forum_categorie->id }}" class="bbp-forum-closed">

                                            <div class="bbp-template-notice">
                                                <ul>
                                                    <li>Ce forum comporte {{ count($topics) }} sujets, 0 réponses</li>
                                                </ul>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            @if (Auth::check())
                <div class="panel-layout-create topic">

                    <form id="create_topic_form" action="{{ route('forum.create.topic') }}" method="POST">

                        <input type="hidden" name="url" id="url" value="{{ $forum_categorie->url }}">

                        <div style="display: flex;justify-content: center;flex-direction: row;">

                            <div class="col-md-4" style="justify-content: center;">

                                <div class="form-group col mr-3">

                                    <div style="width: 100%;margin-top: 0.25rem;">
                                        <label for="title">Titre du sujet</label>
                                    </div>
                                    <input type="text" name="title" id="title" class="form-control"
                                        placeholder="Titre du sujet">
                                    <div style="width: 100%;margin-top: 0.25rem;">
                                        <span class="error-text text-danger title_error"></span>
                                    </div>

                                </div>

                                <div class="form-group mr-3">

                                    <div style="width: 100%;margin-top: 0.25rem;">
                                        <label for="signature">Signature du sujet</label>
                                    </div>
                                    <input type="text" name="signature" id="signature" class="form-control"
                                        placeholder="Signature du sujet">
                                    <div style="width: 100%;margin-top: 0.25rem;">
                                        <span class="error-text text-danger signature_error"></span>
                                    </div>

                                </div>

                                <div class="form-group col">

                                    <div style="width: 100%;margin-top: 0.25rem;">
                                        <label for="title">Statut du sujet</label>
                                    </div>
                                    <select name="status" id="status" class="custom-select">
                                        <option value="1" selected="">Activé</option>
                                        <option value="0">Désactiver</option>
                                    </select>
                                    <div style="width: 100%;margin-top: 0.25rem;">
                                        <span class="error-text text-danger status_error"></span>
                                    </div>
                                </div>

                                @if ($user->admin == 1)
                                    <div class="form-group col mr-3">

                                        <div style="width: 100%;margin-top: 0.25rem;">
                                            <label for="admin">Sujet admin</label>
                                        </div>
                                        <select name="admin" id="admin" class="custom-select">
                                            <option value="1" selected>Admin</option>
                                            <option value="0">Utilisateur</option>
                                        </select>
                                        <div style="width: 100%;margin-top: 0.25rem;">
                                            <span class="error-text text-danger admin_error"></span>
                                        </div>
                                    </div>
                                @endif

                            </div>

                            <div class="col-md-5" style="justify-content: center;">

                                <div class="form-group col-md-12">

                                    <div style="width: 100%;margin-top: 0.25rem;">
                                        <label for="title">Description du sujet</label>
                                    </div>
                                    <textarea name="content" id="content" cols="30" rows="10" class="form-control"
                                        placeholder="Description du sujet"></textarea>
                                    <div style="width: 100%;margin-top: 0.25rem;">
                                        <span class="error-text text-danger content_error"></span>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="form-row mt-4 form-submit">
                            <button class="btn btn-warning font-weight-bold btn-cancel-topic mr-3"
                                type="button">Annuler</button>
                            <button class="btn btn-primary font-weight-bold" type="submit">Valider</button>
                        </div>

                    </form>

                </div>
            @endif

        </div>

    </div>

</div>
