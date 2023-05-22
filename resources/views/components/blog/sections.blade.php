<div class="vg-page page-blog">

    <div class="container">

        <h1 class="mb-4 text-center">Mon blog</h1>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="fg-theme">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Blog</li>
            </ol>
        </nav>

        <div class="row widget-grid mb-4">

            <div class="col-lg-8">

                <div class="input-group py-2">
                    <input id="search-blog" name="search-blog" type="text" class="form-control"
                        placeholder="Rechercher...">
                </div>

            </div>

            <div class="col-lg-4">

                <div class="d-flex py-2 mx-n2">

                    <div class="input-group px-2">

                        <select id="select-categorie" class="vg-select">
                            <option value="">Tous</option>
                            <option value="Technologie">Technologie</option>
                            <option value="Cybersécurité">Cybersécurité</option>
                            <option value="Graphique">Graphique</option>
                            <option value="UI/UX">UI/UX</option>
                            <option value="Culture">Culture</option>
                            <option value="Financement">Financement</option>
                            <option value="Ethique">Ethique</option>
                            <option value="Sante">Sante</option>
                            <option value="Éducation">Éducation</option>
                            <option value="Défense">Défense</option>
                            <option value="International">International</option>
                        </select>

                    </div>

                    <div class="input-group px-2">

                        <select id="select-trie" class="vg-select">
                            <option value="">Trier par</option>
                            <option value="Les plus récent">Les plus récent</option>
                            <option value="Populaire">Populaire</option>
                            <option value="Les plus ancien">Les plus ancien</option>
                        </select>

                    </div>

                </div>

            </div>

        </div>

        <div class="row" id="blog-news-search">

            <div class="fl-rich-text wow news">

                <aside class="widget widget-news-smart-box widget-3 widget-latest-home">


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

                                                <a href="/article/{{ Str::slug($data->title) }}"
                                                    title="{{ $data->title }}"
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

                                                <p class="news-smart-box__item-excerpt">{{ $data->small_content }}
                                                </p>

                                            </div>

                                        </div>

                                    </article>
                                @endforeach

                            </div>

                        </div>

                    </div>


                </aside>

            </div>

            <div class="col-12 py-3">

                <ul class="pagination justify-content-center">

                    @if (!empty(Request::route('slug')))
                        @php
                            $slug = Request::route('slug');
                            $urls = Request::segment(1);
                        @endphp
                    @else
                        @php
                            $slug = '1';
                            $urls = Request::segment(1);
                        @endphp
                    @endif

                    <nav>
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($slug == 1)
                                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="/{{ $urls }}/{{ $slug - 1 }}"
                                        rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @for ($i = 1; $i <= $pages; $i++)
                                <li class="page-item @if ($i == $slug) active @endif"><a
                                        class="page-link"
                                        @if ($i != $slug) href="/{{ $urls }}/{{ $i }}" @endif>{{ $i }}</a>
                                </li>
                            @endfor

                            {{-- Next Page Link --}}
                            @if ($slug != $pages)
                                <li class="page-item">
                                    <a class="page-link" href="/{{ $urls }}/{{ $slug + 1 }}"
                                        rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                                </li>
                            @endif

                        </ul>

                    </nav>


                </ul>

            </div>

        </div>

    </div>

</div>
