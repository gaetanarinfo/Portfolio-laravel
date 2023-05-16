<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h2 mb-2 text-gray-900 font-weight-bold">Liste des articles</h1>
        <a href="show-blog/add" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm font-weight-bold"><i
                class="fa-solid fa-paperclip fa-sm text-white mr-1"></i> Créer un article</a>
    </div>

    <p class="mb-4">Articles actif ou non actif sur mon blog, les articles inactifs sont aussi
        présents
        sur cette page on peut aussi modifier, supprimer un articles.</p>

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Articles actifs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($articles_active) }}</div>

                        </div>

                        <div class="col-auto">

                            <i class="fa-regular fa-file-lines fa-2x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-danger shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Articles inactifs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($articles_inactive) }}</div>

                        </div>

                        <div class="col-auto">

                            <i class="fa-regular fa-file-lines fa-2x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        @foreach ($blogs as $data)
            <div class="col-lg-4" id="article_{{ $data->id }}">

                <div class="card shadow mb-4">

                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                        <h6 class="m-0 font-weight-bold text-primary">{{ $data->title }}</h6>

                        <div class="dropdown no-arrow">

                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">

                                <div class="dropdown-header">Gérer l'article</div>

                                <a class="dropdown-item" href="/article/{{ Str::slug($data->title) }}"
                                    target="_blank">Voir l'article</a>

                                <a class="dropdown-item"
                                    href="/show-blog/update/{{ Str::slug($data->title) }}">Modifier</a>

                                <a class="dropdown-item modal-article-btn" data-toggle="modal"
                                    data-target="#deleteArticleModal" data-article="{{ $data->id }}" data-edit="0"
                                    href="#">Supprimer</a>

                            </div>

                        </div>

                    </div>

                    <!-- Card Body -->
                    <div class="card-body">

                        <div class="card-img">
                            <img src="{{ $data->image }}" class="img-fluid">
                        </div>

                        <p class="mt-3 mb-3 categorie">{{ $data->categorie }}</p>

                        <p>
                            {{ $data->small_content }}
                        </p>

                        <p class="post-author mb-2 mt-2">
                            <i class="fa-solid fa-book-open mr-2 text-success"></i><span>{{ $data->author }}</span>
                        </p>

                        <div class="post-date"><i class="fa-regular fa-clock mr-1 text-info"></i><span
                                class="sr-only">Publié
                                le</span>
                            {{ date('d/m/Y à H:i') }}</div>

                    </div>

                </div>

            </div>
        @endforeach

    </div>

</div>
<!-- /.container-fluid -->
