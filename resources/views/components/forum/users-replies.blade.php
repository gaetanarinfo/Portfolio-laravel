@php
    use Carbon\Carbon;
    use App\Models\TopicsReplies;
    use App\Models\TopicsForums;
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

                            <h2 class="entry-title">Réponses du forum créées</h2>

                            <div class="bbp-user-section">

                                @if (count($replies) <= 0)

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
                                            Affichage de {{ count($replies) }} sujets - 1 à {{ count($replies) }} (sur
                                            {{ count($replies) }} au total)
                                        </div>

                                    </div>


                                    <ul class="disputo-replies-bar">
                                        <li class="disputo-replies-title">
                                            Réponses </li>
                                        <li class="disputo-replies-links">
                                            <span class="disputo-replies-subscription"></span>
                                            <span class="disputo-replies-favorites"></span>
                                        </li>
                                    </ul>

                                    <ul id="topic-0-replies" class="forums bbp-replies">

                                        @foreach ($replies as $data)
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

                                                                <a href="{{ route('forums.users') . '/' . $data->pseudo }}"
                                                                    title="Voir le profil de {{ $data->pseudo }}"
                                                                    class="bbp-author-link">

                                                                    <span class="bbp-author-avatar">
                                                                        <img alt=""
                                                                            src="{{ URL::asset('img/profil/' . $data->avatar) }}"
                                                                            class="avatar avatar-80 photo"
                                                                            height="80" width="80" loading="lazy"
                                                                            decoding="async">
                                                                    </span>
                                                                </a>

                                                            </div>

                                                            <div class="disputo-replies-author-info">

                                                                <a href="{{ route('forums.users') . '/' . $data->pseudo }}"
                                                                    title="Voir le profil de {{ $data->pseudo }}"
                                                                    class="bbp-author-link">

                                                                    <span
                                                                        class="bbp-author-name">{{ $data->pseudo }}</span>

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

                                                                <a tabindex="0" class="disputo-popover"
                                                                    data-container="body" data-trigger="focus"
                                                                    data-toggle="popover" data-placement="bottom"
                                                                    data-html="true"
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

                                                                <div class="disputo-forum-signature">
                                                                    {!! $data->signature !!}
                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </li>
                                        @endforeach

                                    </ul>

                                    <div class="bbp-pagination mt-4">

                                        <div class="bbp-pagination-count"> Affichage de {{ count($replies) }} sujets -
                                            1 à
                                            {{ count($replies) }} (sur {{ count($replies) }} au total)</div>

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
