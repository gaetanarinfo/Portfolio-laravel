@foreach ($projets as $data)
    <div class="grid-item {{ $data->categorie }} wow zoomIn">

        <div class="img-place"
            @if ($data->categorie == 'template') data-src="{{ URL::asset('img/projets') }}/lg-{{ $data->image }}"
                        data-fancybox
                        data-caption="<h5 class='fg-theme'>{{ $data->title }}</h5> <p class='text-capitalize'>{{ $data->categorie }}</p>" @endif>

            <img src="{{ URL::asset('img/projets') }}/{{ $data->image }}" alt="">

            <div class="img-caption">

                <h5 class="fg-theme text-capitalize">{{ $data->categorie }}</h5>

                <p class="font-weight-bold"">{{ $data->title }}</p>

                <div class="mt-2">
                    <a @if ($data->active == 1) href="{{ $data->url }}" target="_blank" @endif
                        class="btn btn-success btn-small font-weight-bold @if ($data->active != 1) disabled @endif">Voir
                        le projet</a>
                </div>

                @if ($data->prix != 0)
                    <div class="price">
                        <span class="badge badge-info">{{ str_replace('.', ',', $data->prix) }} €</span>
                    </div>
                @endif

            </div>

        </div>

    </div>
@endforeach
