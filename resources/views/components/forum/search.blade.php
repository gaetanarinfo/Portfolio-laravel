@php
    use Carbon\Carbon;
    use App\Models\TopicsForums;
    use App\Models\Forums;
    use App\Models\TopicsReplies;
@endphp

<div class="disputo-page-title">

    <div class="container">

        <h1 class="text-center">RÉSULTATS DE LA RECHERCHE POUR '{{ $terms }}'</h1>

        <div id="disputo-header-search">

            <form method="get" id="bbp-header-search-form" action="{{ route('forums.search') }}">

                <div class="input-group">

                    <input tabindex="101" type="text" name="bbp_search" class="form-control ui-autocomplete-input"
                        value="{{ $terms }}" placeholder="Entrez un mot-clé..." autocomplete="off">

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

        <div id="disputo-main-inner" class="">

            <div class="disputo-page-left">

                <div id="bbpress-forums">

                    @if (empty($forums) && empty($topics_replies))
                        <div class="disputo-no-feedback">

                            <div class="bbp-template-notice">

                                <ul>

                                    <li>Oh ! Aucun résultat de recherche n'a été trouvé ici.</li>
                                </ul>

                            </div>

                        </div>
                    @else
                        <div class="bbp-pagination">
                            <div class="bbp-pagination-count">Affichage de {{ count($forums) + count($topics_replies) }}
                                résultats -
                                {{ count($forums) + count($topics_replies) }} à
                                {{ count($forums) + count($topics_replies) }} (sur
                                {{ count($forums) + count($topics_replies) }} au total)</div>
                            <div class="bbp-pagination-links"></div>
                        </div>

                        <div id="bbp-search-results" class="forums bbp-search-results">

                            @if (!empty($forums))
                                @foreach ($forums as $data)
                                    @php
                                        $post_date = $data->created_at;
                                    @endphp
                                    <div class="disputo-forum-search-result">

                                        <div class="disputo-forum-search-badge">
                                            <span class="badge badge-primary">Forum</span>
                                        </div>

                                        <div class="disputo-forum-search-result-left">

                                            <a href="{{ route('forums.categorie') . '/' . $data->url }}"
                                                title="{{ $data->title }}" class="bbp-author-link"><span
                                                    class="bbp-author-avatar"><img alt="{{ $data->title }}"
                                                        src="{{ URL::asset('img/forums/' . $data->image) }}"
                                                        class="avatar avatar-80 photo" height="80" width="80"
                                                        loading="lazy" decoding="async"></span></a>

                                        </div>

                                        <div class="disputo-forum-search-result-right">

                                            <div class="disputo-forum-search-result-meta">
                                                <span class="bbp-reply-post-date">{{ ucfirst($post_date->dayName) }}
                                                    {{ $post_date->isoFormat('LL') }} -
                                                    {{ $data->created_at->diffForHumans() }}</span>
                                            </div>

                                            <div class="disputo-forum-search-result-title">
                                                <h5><a class="bbp-topic-permalink"
                                                        href="{{ route('forums.categorie') . '/' . $data->url }}">{{ $data->title }}</a>
                                                </h5>
                                            </div>

                                        </div>

                                    </div>
                                @endforeach
                            @endif

                            @if (!empty($topics_replies))
                                @foreach ($topics_replies as $data)
                                    @php
                                        $post_date = $data->created_at;

                                        // Topic
                                        $topic = TopicsForums::where('forum_id', $data->forum_id)->first();

                                        // Forum
                                        $forum = Forums::where('id', $data->forum_id)->first();
                                    @endphp
                                    <div class="disputo-forum-search-result">

                                        <div class="disputo-forum-search-badge">
                                            <span class="badge badge-success">Réponse</span>
                                        </div>

                                        <div class="disputo-forum-search-result-left">

                                            <a href="{{ route('forums.users') . '/' . $data->pseudo }}"
                                                title="Voir le profil de {{ $data->pseudo }}"
                                                class="bbp-author-link"><span class="bbp-author-avatar"><img
                                                        alt="Voir le profil de {{ $data->pseudo }}"
                                                        src="{{ URL::asset('img/profil/' . $data->avatar) }}"
                                                        class="avatar avatar-80 photo" height="80" width="80"
                                                        loading="lazy" decoding="async"></span></a>

                                        </div>

                                        <div class="disputo-forum-search-result-right">

                                            <div class="disputo-forum-search-result-meta">
                                                <span class="bbp-reply-post-date">{{ ucfirst($post_date->dayName) }}
                                                    {{ $post_date->isoFormat('LL') }} -
                                                    {{ $data->created_at->diffForHumans() }}</span> <a
                                                    href="{{ route('forums.topic') . '/' . $topic->url . '#post-' . $data->id }}"
                                                    class="bbp-reply-permalink">#{{ $data->id }}</a>
                                            </div>

                                            <div class="disputo-forum-search-result-title">
                                                <h5>En réponse à : <a class="bbp-topic-permalink"
                                                        href="{{ route('forums.categorie') . '/' . $forum->url }}">{{ $topic->title }}</a>
                                                </h5>
                                            </div>

                                        </div>

                                    </div>
                                @endforeach
                            @endif

                        </div>

                        <div class="bbp-pagination">
                            <div class="bbp-pagination-count">Affichage de
                                {{ count($forums) + count($topics_replies) }} résultats -
                                {{ count($forums) + count($topics_replies) }} à
                                {{ count($forums) + count($topics_replies) }} (sur
                                {{ count($forums) + count($topics_replies) }} au total)</div>
                            <div class="bbp-pagination-links"></div>
                        </div>
                    @endif

                </div>

            </div>

            <aside class="disputo-page-right">

                <div id="disputo-list-5" class="widget_disputo-list disputo-sidebar-box">

                    <div class="so-widget-disputo-list so-widget-disputo-list-base">

                        <div class="disputo-widget-title">
                            <h5><span>Forums</span></h5>
                        </div>

                        <div class="disputo-post-list-wrapper">

                            @foreach ($forums_list as $data)
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

                <div id="bbp_topics_widget-3" class="widget_display_topics disputo-sidebar-box">

                    <h5 class="disputo-widget-title"><span>Sujets récent</span></h5>

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
