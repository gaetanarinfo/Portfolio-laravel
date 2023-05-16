@php
    use Carbon\Carbon;
    use App\Models\TopicsReplies;
    use App\Models\Forums;

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

                            @include('components/forum/navigation')

                        </div>

                    </div>

                    <div id="bbp-user-body" class="disputo-user-right">

                        <div id="bbp-user-topics-started" class="bbp-user-topics-started">

                            <h2 class="entry-title">Sujets du forum démarrés</h2>

                            <div class="bbp-user-section">

                                @if (count($topics) <= 0)

                                    <div class="disputo-no-feedback mt-3">

                                        <div class="bbp-template-notice">

                                            <ul>

                                                <li>Oh ! Aucun résultat n'a été trouvé ici.</li>
                                            </ul>

                                        </div>

                                    </div>
                                @else
                                    <div class="bbp-pagination">

                                        <div class="bbp-pagination-count">
                                            Affichage de {{ count($topics) }} sujets - 1 à {{ count($topics) }} (sur
                                            {{ count($topics) }} au total)
                                        </div>

                                    </div>

                                    <ul id="bbp-forum-0" class="bbp-topics">

                                        <li class="bbp-header">

                                            <ul class="forum-titles">

                                                <li class="bbp-topic-title">SUJET</li>

                                                <li class="bbp-forum-reply-count"><i class="fa fa-comments"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="RÉPONSES"></i></li>

                                                <li class="bbp-forum-views-count"><i class="fa fa-eye"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="VUES"></i>
                                                </li>

                                                <li class="bbp-forum-freshness"><i class="fa fa-clock-o"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="FRAÎCHEMENT POSTÉ"></i></li>

                                            </ul>

                                        </li>

                                        <li class="bbp-body">

                                            @foreach ($topics as $key => $data)
                                                @php
                                                    $post_date = $data->created_at;
                                                    $forum = Forums::where('id', $data->forum_id)->first();
                                                    $topics_replies = TopicsReplies::where('topic_id', $forum->id)
                                                        ->select('id')
                                                        ->get();
                                                @endphp
                                                <ul id="bbp-topic-{{ $data->id }}"
                                                    class="loop-item-{{ $key }} user-id-{{ $data->user_id }} bbp-parent-forum-73 odd post-{{ $data->id }} topic type-topic status-publish hentry topic-tag-food topic-tag-italian">

                                                    <li class="bbp-topic-title">

                                                        @if ($data->resolved == 1)
                                                            <i class="fa fa-check-circle text-success"></i>
                                                        @endif

                                                        <a class="bbp-topic-permalink"
                                                            href="{{ route('forums.topic') . '/' . $data->url }}">{{ $data->title }}</a>

                                                        @if ($data->sticky >= 1)
                                                            <span class="badge badge-success">Top</span>
                                                        @endif

                                                        <p class="bbp-topic-meta">

                                                            <span class="bbp-topic-started-by">
                                                                Commencé par : <a
                                                                    href="{{ route('forums.users') . '/' . $data->pseudo }}"
                                                                    title="Voir le profil de {{ $data->pseudo }}"
                                                                    class="bbp-author-link"><span
                                                                        class="bbp-author-name">{{ $data->pseudo }}</span></a></span>

                                                            <span class="bbp-topic-started-in"><a
                                                                    href="{{ route('forums.categorie') . '/' . $forum->url }}">{{ $forum->title }}</a></span>


                                                        </p>

                                                    </li>

                                                    <li class="bbp-topic-reply-count">{{ count($topics_replies) }}</li>

                                                    <li class="bbp-topic-reply-count">{{ $data->views }}</li>

                                                    <li class="bbp-topic-freshness">

                                                        <div class="disputo-freshness-box">

                                                            <div class="disputo-freshness-left">

                                                                <div class="disputo-freshness-name">
                                                                    <a href="{{ route('forums.users') . '/' . $data->pseudo }}"
                                                                        title="Voir le profil de {{ $data->pseudo }}"
                                                                        class="bbp-author-link"><span
                                                                            class="bbp-author-name">{{ $data->pseudo }}</span></a>
                                                                </div>

                                                                <div class="disputo-freshness-link">
                                                                    <a title="Reply To: Italian Cuisine">
                                                                        {{ ucfirst($post_date->dayName) }}
                                                                        {{ $post_date->isoFormat('LL') }} -
                                                                        {{ $data->created_at->diffForHumans() }}</a>
                                                                </div>

                                                            </div>

                                                            <div class="disputo-freshness-right ">

                                                                <a href="{{ route('forums.users') . '/' . $data->pseudo }}"
                                                                    title="Voir le profil de {{ $data->pseudo }}"
                                                                    class="bbp-author-link"><span
                                                                        class="bbp-author-avatar"><img alt=""
                                                                            src="{{ URL::asset('img/profil') . '/' . $data->avatar }}"
                                                                            class="avatar avatar-45 photo"
                                                                            height="45" width="45" loading="lazy"
                                                                            decoding="async"></span></a>


                                                            </div>

                                                        </div>

                                                    </li>

                                                </ul>
                                            @endforeach

                                        </li>

                                    </ul>

                                    <div class="bbp-pagination">

                                        <div class="bbp-pagination-count"> Affichage de {{ count($topics) }} sujets - 1
                                            à
                                            {{ count($topics) }} (sur {{ count($topics) }} au total)</div>

                                    </div>
                                @endif

                            </div>

                        </div><!-- #bbp-user-topics-started -->

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
