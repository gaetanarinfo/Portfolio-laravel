@php
    use Carbon\Carbon;

    $post_date = $article->created_at;

@endphp

<div class="vg-page page-blog">

    <div class="container">

        <div class="blog-badge">
            <h5><span class="badge badge-theme">{{ $article->categorie }}</span></h5>
        </div>

        <div class="blog-title mt-4 mb-4">
            <h1>{{ $article->title }}</h1>
        </div>

        <div class="blog-header">
            <i class="fa-solid fa-clock"></i>
            <span><span class="day">{{ $post_date->dayName }}</span> - {{ $post_date->isoFormat('LL') }} -
                {{ $article->created_at->diffForHumans() }}</span>
        </div>

        <div class="d-flex mt-4 bloc-header-blog">

            <div class="col-md-8 pl-0">

                <img src="{{ $article->image_bandeau }}" class="img-fluid"
                    alt="{{ $article->title }}">

            </div>

            <div class="col-md-4">

                <div class="bk-author-box clearfix">

                    <div class="bk-author-avatar">

                        <a target="_blank" href="{{ $article->author_link }}">
                            <img alt="{{ $article->author }}"
                                src="{{ $article->avatar }}"
                                class="avatar avatar-75 photo" height="100" width="100" />
                        </a>

                    </div>

                    <div class="author-info" itemprop="author">

                        <h3 class="bk-author-name"><a href="{{ $article->author_link }}"
                                target="_blank">{{ $article->author }}</a></h3>

                        <p class="bk-author-bio">{{ $article->author_content }}</p>

                        <div class="bk-author-page-contact">

                            @if (!empty($article->email))
                                <a class="bk-tipper-bottom tipper-attached" data-title="Email"
                                    href="mailto:{{ $article->email }}"><i class="fa fa-envelope"
                                        title="Email"></i></a>
                            @endif

                            @if (!empty($article->url_linkedin))
                                <a class="bk-tipper-bottom tipper-attached" data-title="Linkedin"
                                    href="{{ $article->url_linkedin }}" target="_blank"><i class="fa fa-linkedin "
                                        title="Linkedin"></i></a>
                            @endif

                            @if (!empty($article->url_twitter))
                                <a class="bk-tipper-bottom tipper-attached" data-title="Twitter"
                                    href="{{ $article->url_twitter }}" target="_blank"><i class="fa fa-twitter "
                                        title="Twitter"></i></a>
                            @endif

                            @if (!empty($article->url_fb))
                                <a class="bk-tipper-bottom tipper-attached" data-title="Facebook"
                                    href="{{ $article->url_fb }}" target="_blank"><i class="fa fa-facebook "
                                        title="Facebook"></i></a>
                            @endif

                        </div>

                    </div>

                </div>

                <div class="source">
                    <p><i class="fa-solid fa-wand-sparkles mr-1 text-success"></i> <a href="{{ $article->source }}"
                            target="_blank">Voir la source</a></p>
                </div>

            </div>

        </div>

        <hr class="mt-4">

        <div class="col-md-12 mt-4 pl-0 bloc-content-blog">

            <div class="entry-content">
                {!! $article->large_content !!}
            </div>

        </div>

        <hr>

        <div class="col-md-12 mt-4 pl-0 share-article">

            <h5>Partager sur les réseaux sociaux</h5>

            <div class="partage">

                <ul class="list-unstyled d-flex">

                    <li class="mr-3">
                        <a target="_blank" class="link-white"
                            href="https://www.facebook.com/sharer/sharer.php?u={{ url()->full() }}">
                            <img src="{{ URL::asset('img/socials') }}/facebook.svg" alt="Facebook" width="24"
                                height="24">
                        </a>
                    </li>

                    <li class="mr-3">
                        <a class="link-white"
                            href="https://twitter.com/share?url={{ url()->full() }}&amp;text={{ $article->title }}&amp;via=OverGames19"
                            onclick="window.open(this.href);return false;">
                            <img src="{{ URL::asset('img/socials') }}/twitter.svg" alt="Twitter" width="24"
                                height="24">
                        </a>
                    </li>

                    <li class="mr-3">
                        <a class="link-white" target="_blank"
                            href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{ url()->full() }}&amp;text={{ $article->title }}">
                            <img src="{{ URL::asset('img/socials') }}/linkedin.svg" alt="Linkedin" width="24"
                                height="24">
                        </a>
                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>
