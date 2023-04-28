@php
    use Carbon\Carbon;
@endphp

<div class="fl-rich-text wow news">

    <aside class="widget widget-news-smart-box widget-3 widget-latest-home">

        <div class="news-smart-box__listing row allposts">

            <div id="news-smart-box-5f2c793730c94" class="news-smart-box__instance layout_type_2">

                <div class="news-smart-box__wrapper">

                    <div class="news-smart-box__listing row allposts">

                        @foreach ($news as $data)
                            @php
                                $post_date = $data->created_at;
                            @endphp

                            <article class="news-smart-box__item col-sm-12 col-lg-4 full-type">

                                <div class="news-smart-box__item-inner">

                                    <div class="news-smart-box__item-header">

                                        <div class="post__cats category">

                                            <a>{{ $data->categorie }}</a>
                                        </div>

                                        <a href="/article/{{ Str::slug($data->title) }}" title="{{ $data->title }}"
                                            class="news-smart-box__item-thumb-link"><img
                                                class="news-smart-box__item-thumb-img lazy entered lazyloaded"
                                                src="@if (empty($data->image)) {{ URL::asset('img/news') }}/picture-empty.jpg @else {{ $data->image }} @endif"
                                                alt="{{ $data->title }}"></a>
                                    </div>

                                    <div class="news-smart-box__item-content">

                                        <div class="entry-meta">

                                            <span class="news-smart-box__item-author  posted-by">par
                                                <a href="{{ $data->author_link }}" class="post-author"
                                                    rel="author">{{ $data->author }}</a>
                                            </span>

                                            <span class="post__date">{{ $post_date->dayName }}
                                                {{ $post_date->isoFormat('LL') }}</span>
                                        </div>

                                        <h3 class="news-smart-box__item-title">
                                            <a href="/article/{{ Str::slug($data->title) }}" class="post-title"
                                                title="{{ $data->title }}">{{ $data->title }}</a>
                                        </h3>

                                        <p class="news-smart-box__item-excerpt">{{ $data->small_content }}</p>

                                    </div>

                                </div>

                            </article>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </aside>

</div>
