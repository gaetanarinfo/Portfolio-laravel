@foreach ($news as $data)
    <div class="col-md-7 col-lg-4 wow fadeInUp news">

        <div class="card">

            <div class="img-place">
                <img src="@if (empty($data->image)) {{ URL::asset('img/news') }}/picture-empty.jpg @else{{ URL::asset('img/news') }}/{{ $data->image }} @endif"
                    alt="{{ $data->title }}">
            </div>

            <div class="caption">

                <div class="mb-2">
                    <a href="/blog/categorie/{{ Str::slug($data->categorie) }}" class="post-category">{{ $data->categorie }}</a>
                </div>

                <a href="/article/{{ Str::slug($data->title) }}" class="post-title">{{ $data->title }}</a>

                <div class="mt-2">
                    <p class="small_content">{{ $data->small_content }}</p>
                </div>

                <div class="post-author mb-2 mt-2">
                    <i class="fa-solid fa-book-open mr-2 text-success"></i><span>{{ $data->author }}</span>
                </div>

                <div class="post-date"><i class="fa-regular fa-clock mr-1 text-info"></i><span class="sr-only">Publié
                        le</span>
                    {{ date('d/m/Y à H:i', strtotime($data->created_at)) }}</div>

            </div>

        </div>

    </div>
@endforeach

<div class="col-12 text-center py-3 wow fadeInUp">
    <a href="/blog/1" class="btn btn-theme">Tout afficher</a>
</div>
