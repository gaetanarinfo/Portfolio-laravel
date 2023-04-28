<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between">

        <h1 class="h2 mb-2 text-gray-900 font-weight-bold">Commandes Google Play</h1>

        <div>
            <a href="https://www.convertcsv.com/csv-to-sql.htm" target="_blank"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm font-weight-bold mr-2"><i
                    class="fa-solid fa-file-csv fa-sm text-white mr-1"></i> Convertir Xml / Sql</a>

            <a href="https://console.cloud.google.com/storage/browser/pubsite_prod_7028272590560812880/sales?authuser=0&pageState=(%22StorageObjectListTable%22:(%22f%22:%22%255B%255D%22))&prefix=&forceOnObjectsSortingFiltering=false"
                target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm font-weight-bold"><i
                    class="fa-solid fa-box-archive fa-sm text-white mr-1"></i> Archives Google Play</a>
        </div>

    </div>

    <p class="mb-4">Commande passée par les clients sur Google Play, le tableau n'est pas dynamique à remplir chaque
        mois.</p>

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-success shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total des commandes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($totals_commandes) }}</div>

                        </div>

                        <div class="col-auto">

                            <i class="fa-brands fa-google-play fa-2x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Montant des commandes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($total_commandes, 2, ',', '') }} €</div>

                        </div>

                        <div class="col-auto">

                            <i class="fa-solid fa-euro-sign fa-2x text-gray-300"></i>

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

                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Montant des commandes
                                remboursé
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($total_commandes_refund, 2, ',', '') }} €</div>

                        </div>

                        <div class="col-auto">

                            <i class="fa-solid fa-euro-sign fa-2x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des commandes (Google Play)</h6>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered orders" data-click-to-select="true" data-custom-sort="customSort"
                    data-checkbox-header="false" data-page-size="25" data-locale="fr-FR" data-show-fullscreen="true"
                    data-show-export="true" data-show-refresh="true" data-click-to-select="true"
                    data-detail-formatter="detailFormatter" data-pagination="true" data-search="true"
                    data-sortable="true" data-toggle="table" data-show-columns="true" id="dataTable" width="100%"
                    cellspacing="0">

                    <thead>

                        <tr>
                            <th data-field="state" data-checkbox="true"></th>
                            <th data-searchable="false" data-switchable="false" data-sortable="false"></th>
                            <th data-sortable="true" data-field="title">Titre</th>
                            <th data-sortable="true">Commande n°</th>
                            <th data-sortable="true">Type</th>
                            <th data-sortable="true">Prix</th>
                            <th data-sortable="true">Taxes</th>
                            <th data-sortable="true">Pays</th>
                            <th data-sortable="false">Statut</th>
                            <th data-sortable="true" data-sort-order="desc">Date de commande</th>
                        </tr>

                    </thead>

                    <tfoot>

                        <tr>
                            <th></th>
                            <th></th>
                            <th>Titre</th>
                            <th>Commande n°</th>
                            <th>Type</th>
                            <th>Prix</th>
                            <th>Taxes</th>
                            <th>Pays</th>
                            <th>Statut</th>
                            <th>Date de commande</th>
                        </tr>

                    </tfoot>

                    <tbody>

                        @foreach ($orders_google as $data)
                            <tr id="">
                                <td></td>
                                <td style="text-align: center;"><img
                                        src="{{ URL::asset('/img/projets/icons/' . $data->icone) }}" class="img-fluid"
                                        width="50" style="border-radius: 50%"></td>
                                <td>{{ $data->Product_Title }}</td>
                                <td>{{ $data->Order_Number }}</td>
                                <td>
                                    @if ($data->Product_Type == 'paidapp')
                                        Application
                                    @elseif($data->Product_Type == 'inapp')
                                        Dans l'application
                                    @endif
                                </td>
                                <td>{{ $data->Item_Price }} €</td>
                                <td>{{ $data->Taxes_Collected }} €</td>
                                <td>{{ $data->Country_of_Buyer }}</td>
                                <td>
                                    @if ($data->Financial_Status == 'Refund')
                                        Rembourser
                                    @elseif($data->Financial_Status == 'Charged')
                                        Payé
                                    @endif
                                </td>
                                <td>{{ date('d/m/Y', strtotime($data->Order_Charged_Date)) }}</td>
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
