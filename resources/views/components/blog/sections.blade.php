<div class="vg-page page-blog">

    <div class="container">

        <div class="row widget-grid">

            <div class="col-lg-8">

                <div class="input-group py-2">
                    <input id="search-blog" name="search-blog" type="text" class="form-control" placeholder="Rechercher...">
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

        <div class="row post-grid" id="blog-news-search">

            @foreach ($news as $data)
                <div class="col-md-6 col-lg-4 wow news">

                    <div class="card">

                        <div class="img-place">
                            <img src="@if (empty($data->image)) {{ URL::asset('img/news') }}/picture-empty.jpg @else{{ URL::asset('img/news') }}/{{ $data->image }} @endif"
                                alt="{{ $data->title }}">
                        </div>

                        <div class="caption">

                            <div class="mb-2">
                                <a href="/blog/categorie/{{ Str::slug($data->categorie) }}"
                                    class="post-category">{{ $data->categorie }}</a>
                            </div>

                            <a href="/article/{{ Str::slug($data->title) }}" class="post-title">{{ $data->title }}</a>

                            <div class="mt-2">
                                <p class="small_content">{{ $data->small_content }}</p>
                            </div>

                            <div class="post-author mb-2 mt-2">
                                <i class="fa-solid fa-book-open mr-2 text-success"></i><span>{{ $data->author }}</span>
                            </div>

                            <div class="post-date"><i class="fa-regular fa-clock mr-1 text-info"></i><span
                                    class="sr-only">Publié
                                    le</span>
                                {{ date('d/m/Y à H:i', strtotime($data->created_at)) }}</div>

                        </div>

                    </div>

                </div>
            @endforeach

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
                            @foreach ($elements as $element)
                                {{-- "Three Dots" Separator --}}
                                @if (is_string($element))
                                    <li class="page-item disabled" aria-disabled="true"><span
                                            class="page-link">{{ $element }}</span>
                                    </li>
                                @endif

                                {{-- Array Of Links --}}
                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $slug)
                                            <li class="page-item active" aria-current="page"><span
                                                    class="page-link">{{ $page }}</span></li>
                                        @else
                                            <li class="page-item"><a class="page-link"
                                                    href="/{{ $urls }}/{{ $page }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($slug != $maxPage)
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
