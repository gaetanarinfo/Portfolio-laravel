@php
    use Carbon\Carbon;
    use App\Models\TopicsForums;
    use App\Models\TopicsReplies;

@endphp

<div class="disputo-page-title">

    <div class="container">

        <h1 class="text-center">Forums portfolio Gaëtan Seigneur</h1>
        <p>Bienvenue sur mon forums !</p>

        <div id="disputo-header-search">

            <form method="get" id="bbp-header-search-form" action="{{ route('forums.search') }}">

                <div class="input-group">

                    <input tabindex="101" type="text" name="bbp_search" class="form-control ui-autocomplete-input"
                        placeholder="Entrez un mot-clé..." autocomplete="off">

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-info"><i class="fa-solid fa-search"></i></button>
                    </div>

                </div>

            </form>

        </div>

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

                                        <div class="bbp-breadcrumb">
                                            <p>
                                                <a href="/" class="bbp-breadcrumb-home">
                                                    <i class="fa-solid fa-home"></i>
                                                </a>

                                                <span class="bbp-breadcrumb-sep">›</span>

                                                <span class="bbp-breadcrumb-current">Forums</span>
                                            </p>
                                        </div>

                                        <div id="pg-268-1" class="panel-grid panel-has-style">

                                            <div class="panel-row-style panel-row-style-for-268-1">

                                                <div id="pgc-268-1-0" class="panel-grid-cell">

                                                    <div id="panel-268-1-0-0"
                                                        class="so-panel widget widget_disputo-statistic panel-first-child panel-last-child"
                                                        data-index="2">

                                                        <div
                                                            class="so-widget-disputo-statistic so-widget-disputo-statistic-base">

                                                            <div class="disputo-statistic"
                                                                style="font-size:2rem;color:#364253;">

                                                                <div class="disputo-statistic-icon" style="width:80px;">

                                                                    <div class="disputo-statistic-icon-inner"
                                                                        style="font-size:30px;color:#ffffff;background-color:#364253;height:80px;line-height:80px;">
                                                                        <span class="sow-icon-icomoon" data-sow-icon=""
                                                                            aria-hidden="true"></span>
                                                                    </div>

                                                                </div>

                                                                <div class="disputo-statistic-number">

                                                                    <div class="disputo-statistic-title">
                                                                        POSTS </div>
                                                                    {{ count($forums) }}

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div id="pgc-268-1-1" class="panel-grid-cell">

                                                    <div id="panel-268-1-1-0"
                                                        class="so-panel widget widget_disputo-statistic panel-first-child panel-last-child"
                                                        data-index="3">

                                                        <div
                                                            class="so-widget-disputo-statistic so-widget-disputo-statistic-base">

                                                            <div class="disputo-statistic"
                                                                style="font-size:2rem;color:#364253;">

                                                                <div class="disputo-statistic-icon" style="width:80px;">

                                                                    <div class="disputo-statistic-icon-inner"
                                                                        style="font-size:30px;color:#ffffff;background-color:#1d84b5;height:80px;line-height:80px;">
                                                                        <span class="sow-icon-icomoon" data-sow-icon=""
                                                                            aria-hidden="true"></span>
                                                                    </div>

                                                                </div>

                                                                <div class="disputo-statistic-number">

                                                                    <div class="disputo-statistic-title">
                                                                        SUJETS </div>
                                                                    {{ count($forums_topic) }}
                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div id="pgc-268-1-2" class="panel-grid-cell">

                                                    <div id="panel-268-1-2-0"
                                                        class="so-panel widget widget_disputo-statistic panel-first-child panel-last-child"
                                                        data-index="4">

                                                        <div
                                                            class="so-widget-disputo-statistic so-widget-disputo-statistic-base">

                                                            <div class="disputo-statistic"
                                                                style="font-size:2rem;color:#364253;">

                                                                <div class="disputo-statistic-icon" style="width:80px;">

                                                                    <div class="disputo-statistic-icon-inner"
                                                                        style="font-size:30px;color:#ffffff;background-color:#ff5a5f;height:80px;line-height:80px;">
                                                                        <span class="sow-icon-icomoon" data-sow-icon=""
                                                                            aria-hidden="true"></span>
                                                                    </div>

                                                                </div>

                                                                <div class="disputo-statistic-number">
                                                                    <div class="disputo-statistic-title">
                                                                        RÉPONSES </div>
                                                                    {{ count($forums_topic_replies) }}
                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        @if (Auth::check())
                                            @if ($user->admin >= 1)
                                                <div class="mb-3 text-right">
                                                    <a id="create-forum"
                                                        class="btn btn-sm btn-primary text-white font-weight-bold">Créer
                                                        un forum</a>
                                                </div>
                                            @endif
                                        @endif

                                        <ul id="forums-list-0" class="bbp-forums">

                                            <li class="bbp-header">

                                                <ul class="forum-titles">

                                                    <li class="bbp-forum-info">Forum</li>

                                                    <li class="bbp-forum-topic-count"><i class="fa fa-comment"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="LES SUJETS"></i></li>

                                                    <li class="bbp-forum-reply-count"><i class="fa fa-comments"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="RÉPONSES"></i></li>

                                                    <li class="bbp-forum-views-count"><i class="fa fa-eye"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="VUES"></i></li>

                                                    <li class="bbp-forum-freshness"><i class="fa fa-clock-o"
                                                            data-toggle="tooltip" data-placement="top" title=""
                                                            data-original-title="FRAÎCHEMENT POSTÉ"></i></li>
                                                </ul>

                                            </li>

                                            <li class="bbp-body">

                                                @foreach ($forums as $data)
                                                    @php
                                                        $post_date = $data->created_at;
                                                        $topics = TopicsForums::where('forum_id', $data->id)
                                                            ->select('id')
                                                            ->get();

                                                        // Replies par identifiant et par topic
                                                        $topics_replies = TopicsReplies::where('forum_id', $data->id)
                                                            ->where('status', 1)
                                                            ->select('id')
                                                            ->get();

                                                    @endphp

                                                    <ul id="bbp-forum-{{ $data->id }}"
                                                        class="loop-item-0 bbp-forum-status-closed bbp-forum-visibility-publish odd  post-90 forum type-forum status-publish has-post-thumbnail hentry">

                                                        <li class="bbp-forum-info">

                                                            <div class="disputo-forum-table-wrapper">

                                                                <div class="disputo-forum-left">

                                                                    <a
                                                                        href="{{ route('forum') . '/forum/' . $data->url }}">
                                                                        <img src="{{ URL::asset('img/forums/' . $data->image) }}"
                                                                            alt="{{ $data->title }}">
                                                                    </a>

                                                                </div>

                                                                <div class="disputo-forum-right">

                                                                    <a class="bbp-forum-title"
                                                                        href="{{ route('forum') . '/forum/' . $data->url }}">{{ $data->title }}</a>

                                                                    @if ($data->status == 0)
                                                                        <span class="badge badge-danger">
                                                                            Fermé
                                                                        </span>
                                                                    @endif

                                                                    <div class="bbp-forum-content">
                                                                        {!! $data->content !!}</div>

                                                                </div>

                                                            </div>

                                                        </li>

                                                        <li class="bbp-forum-topic-count">{{ count($topics) }}</li>

                                                        <li class="bbp-forum-reply-count">{{ count($topics_replies) }}
                                                        </li>

                                                        <li class="bbp-forum-reply-count">{{ $data->views }}
                                                        </li>

                                                        <li class="bbp-forum-freshness">

                                                            <div class="disputo-freshness-box">

                                                                <div class="disputo-freshness-left">

                                                                    <div class="disputo-freshness-name">
                                                                        <a href=""
                                                                            title="Voir le profil de {{ $data->pseudo }}"
                                                                            class="bbp-author-link"><span
                                                                                class="bbp-author-name">{{ $data->pseudo }}</span></a>
                                                                    </div>

                                                                    <div class="disputo-freshness-link">
                                                                        <a
                                                                            title="Reply To: Main Forum Rules &amp; Policies">
                                                                            {{ $data->created_at->diffForHumans() }}</a>
                                                                    </div>

                                                                </div>

                                                                <div class="disputo-freshness-right ">
                                                                    <a href="{{ route('forums.users') . '/' . $data->pseudo }}"
                                                                        title="Voir le profil de {{ $data->pseudo }}"
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

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            @if (Auth::check())

                @if ($user->admin >= 1)
                    <div class="panel-layout-create">

                        <form id="create_forum_form" action="{{ route('forum.create') }}" method="POST">

                            <div style="display: flex;justify-content: center;flex-direction: row;">

                                <div class="col-md-4" style="justify-content: center;">

                                    <div class="form-group col mr-3">

                                        <div style="width: 100%;margin-top: 0.25rem;">
                                            <label for="title">Titre du forum</label>
                                        </div>
                                        <input type="text" name="title" id="title" class="form-control"
                                            placeholder="Titre du forum">
                                        <div style="width: 100%;margin-top: 0.25rem;">
                                            <span class="error-text text-danger title_error"></span>
                                        </div>

                                    </div>

                                    <div class="form-group col mr-3"
                                        style="flex-direction: row;justify-content: space-evenly;">

                                        <div class="pr-0 pl-0">
                                            <label for="image">Image du forum</label>
                                            <input type="file" name="image" id="image"
                                                class="form-input-file" placeholder="Titre du forum">
                                            <div style="width: 100%;margin-top: 0.25rem;">
                                                <span class="error-text text-danger image_error"></span>
                                            </div>
                                        </div>

                                        <div class="pr-0">
                                            <img class="image-forum" style="max-width: 66px;" />
                                        </div>

                                    </div>

                                    <div class="form-group col mr-3">

                                        <div style="width: 100%;margin-top: 0.25rem;">
                                            <label for="status">Statut du forum</label>
                                        </div>
                                        <select name="status" id="status" class="custom-select">
                                            <option value="1" selected>Activé</option>
                                            <option value="0">Désactiver</option>
                                        </select>
                                        <div style="width: 100%;margin-top: 0.25rem;">
                                            <span class="error-text text-danger status_error"></span>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-5" style="justify-content: center;">

                                    <div class="form-group col-md-12">

                                        <div style="width: 100%;margin-top: 0.25rem;">
                                            <label for="title">Description du forum</label>
                                        </div>
                                        <textarea name="content" id="content" cols="30" rows="10" class="form-control"
                                            placeholder="Description du forum"></textarea>
                                        <div style="width: 100%;margin-top: 0.25rem;">
                                            <span class="error-text text-danger content_error"></span>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="form-row mt-4 form-submit">
                                <button class="btn btn-warning font-weight-bold btn-cancel mr-3"
                                    type="button">Annuler</button>
                                <button class="btn btn-primary font-weight-bold" type="submit">Valider</button>
                            </div>

                        </form>

                    </div>
                @endif

            @endif

        </div>

    </div>

</div>
