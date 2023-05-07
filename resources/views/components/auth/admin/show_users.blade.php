<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h2 mb-2 text-gray-900 font-weight-bold">Liste des utilisateurs</h1>
        <a href="#" data-toggle="modal" data-target="#addUserModal"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm font-weight-bold"><i
                class="fa-solid fa-user-plus fa-sm text-white mr-1"></i> Créer un utilisateur</a>
    </div>

    <p class="mb-4">Utilisateurs inscrits ou non inscrits sur mon blog, les utilisateurs inactifs sont aussi
        présents
        sur cette page on peut aussi modifier, supprimer un utilisateur.</p>

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Utilisateurs actifs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($users_active) }}</div>

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

                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Utilisateurs bannis
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($users_banned) }}</div>

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
            <h6 class="m-0 font-weight-bold text-primary">Utilisateurs actifs / Non actifs</h6>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"
                    data-click-to-select="true" data-custom-sort="customSort" data-checkbox-header="false"
                    data-page-size="25" data-locale="fr-FR" data-show-fullscreen="true" data-show-export="true"
                    data-show-refresh="true" data-click-to-select="true" data-detail-formatter="detailFormatter"
                    data-pagination="true" data-search="true" data-sortable="true" data-toggle="table"
                    data-show-columns="true">

                    <thead>

                        <tr>
                            <th data-field="state" data-checkbox="true"></th>
                            <th></th>
                            <th data-sortable="true">Nom</th>
                            <th data-sortable="true">Prénom</th>
                            <th data-sortable="true">Adresse email</th>
                            <th data-sortable="false" class="text-center">Statut du compte</th>
                            <th data-sortable="true">Date de création</th>
                            <th data-sortable="true">Date de modification</th>
                            <th data-sortable="false">Action</th>
                        </tr>

                    </thead>

                    <tfoot>

                        <tr>
                            <th></th>
                            <th></th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Adresse email</th>
                            <th class="text-center">Statut du compte</th>
                            <th>Date de création</th>
                            <th>Date de modification</th>
                            <th>Action</th>
                        </tr>

                    </tfoot>

                    <tbody>

                        @foreach ($users as $data)
                            <tr id="td_user_{{ $data->id }}">

                                <td></td>

                                <td class="text-center">
                                    <img src="{{ URL::asset('img/profil/' . $data->avatar) }}" class="img-fluid"
                                        style="border-radius: 50%;max-width: 50px;width: 50px;">
                                </td>

                                <td>{{ $data->lastname }}</td>

                                <td>{{ $data->firstname }}</td>

                                <td>{{ $data->email }}</td>

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

                                <td>{{ date('d/m/Y à H:i', strtotime($data->created_at)) }}</td>

                                <td>
                                    @if ($data->updated_at != null)
                                        {{ date('d/m/Y à H:i', strtotime($data->updated_at)) }}
                                    @else
                                        /
                                    @endif
                                </td>

                                <td>

                                    <a href="#" data-toggle="modal" data-target="#editUserModal"
                                        data-user="{{ $data->id }}" data-lastname="{{ $data->lastname }}"
                                        data-firstname="{{ $data->firstname }}" data-email="{{ $data->email }}"
                                        data-avatar="{{ $data->avatar }}" data-pays="{{ $data->pays }}"
                                        data-active="{{ $data->active }}" data-edit="1"
                                        data-naissance="{{ $data->naissance }}" data-civilite="{{ $data->civilite }}"
                                        data-pseudo="{{ $data->pseudo }}" data-website="{{ $data->website }}"
                                        data-biographie="{{ $data->biographie }}"
                                        data-signature="{{ $data->signature }}" data-facebook="{{ $data->fb_page }}"
                                        data-twitter="{{ $data->twitter_page }}"
                                        data-instagram="{{ $data->insta_page }}"
                                        data-linkedin="{{ $data->linkedin_page }}"
                                        data-youtube="{{ $data->youtube_page }}"
                                        class="btn modal-btn btn-warning btn-icon-split mr-2">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span>
                                        <span class="text font-weight-bold">Éditer</span>
                                    </a>

                                    <a href="#" data-toggle="modal" data-target="#deleteUserModal"
                                        data-user="{{ $data->id }}" data-edit="0"
                                        class="btn modal-btn btn-danger btn-icon-split">
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

<script>
    $(function() {
        $('#dataTable').bootstrapTable()
    })

    function customSort(sortName, sortOrder, data) {
        var order = sortOrder === 'desc' ? -1 : 1
        data.sort(function(a, b) {
            var aa = +((a[sortName] + '').replace(/[^\d]/g, ''))
            var bb = +((b[sortName] + '').replace(/[^\d]/g, ''))
            if (aa < bb) {
                return order * -1
            }
            if (aa > bb) {
                return order
            }
            return 0
        })
    }
</script>
