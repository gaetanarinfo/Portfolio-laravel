<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h2 mb-2 text-gray-900 font-weight-bold">Liste des projets</h1>
        <a href="#" data-toggle="modal" data-target="#addProjetModal"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm font-weight-bold"><i
                class="fa-solid fa-plus fa-sm text-white mr-1"></i> Créer un projets</a>
    </div>

    <p class="mb-4">Projets actif ou non actif sur mon blog, les projets inactifs sont aussi
        présents
        sur cette page on peut aussi modifier, supprimer un projets.</p>

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Projets actifs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($projets_active) }}</div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-user fa-2x text-gray-300"></i>

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

                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Projets inactifs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($projets_inactive) }}</div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-user-xmark fa-2x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Projets actifs / Non actifs</h6>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>

                        <tr>
                            <th data-sortable="false"></th>
                            <th>Titre</th>
                            <th>Catégorie</th>
                            <th>Url</th>
                            <th class="text-center">Statut du projet</th>
                            <th>Prix</th>
                            <th>Date de création</th>
                            <th>Date de modification</th>
                            <th data-sortable="false">Action</th>
                        </tr>

                    </thead>

                    <tfoot>

                        <tr>
                            <th></th>
                            <th>Titre</th>
                            <th>Catégorie</th>
                            <th>Url</th>
                            <th class="text-center">Statut du projet</th>
                            <th>Prix</th>
                            <th>Date de création</th>
                            <th>Date de modification</th>
                            <th>Action</th>
                        </tr>

                    </tfoot>

                    <tbody>

                        @foreach ($projets as $data)
                            <tr id="td_projet_{{ $data->id }}">

                                <td class="text-center">
                                    <img src="{{ URL::asset('img/projets/' . $data->image) }}" class="img-fluid"
                                        style="max-width: 50px;width: 50px;">
                                </td>

                                <td>{{ $data->title }}</td>

                                <td>{{ $data->categorie }}</td>

                                <td>
                                    <a href="{{ $data->url }}" target="_blank"
                                        class="btn btn-secondary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-arrow-right"></i>
                                        </span>
                                        <span class="text font-weight-bold">Voir</span>
                                    </a>
                                </td>

                                <td class="text-center">
                                    @if ($data->active >= 1)
                                        <a class="btn btn-success btn-circle btn-sm">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    @else
                                        <a class="btn btn-danger btn-circle btn-sm">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </td>

                                <td><b>{{ number_format($data->prix, 2, ',', '.') }}</b><i
                                        class="ml-1 fa-solid fa-euro-sign"></i></td>

                                <td>{{ date('d/m/Y à H:i', strtotime($data->created_at)) }}</td>

                                <td>
                                    @if ($data->updated_at != null)
                                        {{ date('d/m/Y à H:i', strtotime($data->updated_at)) }}
                                    @else
                                        /
                                    @endif
                                </td>

                                <td>

                                    <a href="#" data-toggle="modal" data-target="#editProjetModal"
                                        data-projet="{{ $data->id }}" data-active="{{ $data->active }}"
                                        data-image="{{ $data->image }}" data-title="{{ $data->title }}"
                                        data-categorie="{{ $data->categorie }}" data-url="{{ $data->url }}"
                                        data-prix="{{ number_format($data->prix, 2, ',', '.') }}" data-edit="1"
                                        class="btn modal-projet-btn btn-warning btn-icon-split mr-2">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span>
                                        <span class="text font-weight-bold">Éditer</span>
                                    </a>

                                    <a href="#" data-toggle="modal" data-target="#deleteProjetModal"
                                        data-projet="{{ $data->id }}" data-edit="0"
                                        class="btn modal-projet-btn btn-danger btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text font-weight-bold">Supprimer</span>
                                    </a>

                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
<!-- /.container-fluid -->
