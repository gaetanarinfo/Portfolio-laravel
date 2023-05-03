<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h2 mb-2 text-gray-900 font-weight-bold">Gestion des commandes clients</h1>
    </div>

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Paiement accepté
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($orders_success) }}</div>

                        </div>

                        <div class="col-auto">

                            <i class="fa-solid fa-money-check fa-2x text-gray-300"></i>

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

                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Paiement refusée
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($orders_canceled) }}</div>

                        </div>

                        <div class="col-auto">

                            <i class="fa-solid fa-money-check fa-2x text-gray-300"></i>

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

                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Paiement rembourser
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($orders_refund) }}</div>

                        </div>

                        <div class="col-auto">

                            <i class="fa-solid fa-money-check fa-2x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-success shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total des commandes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orders_total }} €</div>

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
            <h6 class="m-0 font-weight-bold text-primary">Projets actifs / Non actifs</h6>
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
                            <th data-sortable="false"></th>
                            <th data-sortable="true">Produit</th>
                            <th data-sortable="true">Client</th>
                            <th data-sortable="true">Adresse email</th>
                            <th data-sortable="true">Type de paiement</th>
                            <th data-sortable="true">Statut du paiement</th>
                            <th data-sortable="true">Transaction</th>
                            <th data-sortable="true">Total</th>
                            <th data-sortable="true">Date du paiement</th>
                            <th data-sortable="true">Date du remboursement</th>
                            <th data-sortable="false">Action</th>
                        </tr>

                    </thead>

                    <tfoot>

                        <tr>
                            <th></th>
                            <th></th>
                            <th>Produit</th>
                            <th>Client</th>
                            <th>Adresse email</th>
                            <th>Type de paiement</th>
                            <th>Statut du paiement</th>
                            <th>Transaction</th>
                            <th>Total</th>
                            <th>Date du paiement</th>
                            <th>Date du remboursement</th>
                            <th>Action</th>
                        </tr>

                    </tfoot>

                    <tbody>

                        @foreach ($orders as $data)
                            <tr>
                                <td></td>
                                <td>
                                    <div class="text-center">
                                        <i class="fa-solid fa-{{ $data->product_icon }}"
                                            style="color: #{{ $data->product_color }}"></i>
                                    </div>
                                </td>
                                <td>{{ $data->product_title }}</td>
                                <td>{{ $data->firstname . ' ' . $data->lastname }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->order_method }}</td>
                                <td>
                                    @if ($data->status == 'COMPLETED')
                                        <span class="text-success font-weight-bold"><i
                                                class="fa-solid fa-check mr-2"></i>Paiement accepté</span>
                                    @elseif ($data->status == 'CANCELED')
                                        <span class="text-danger font-weight-bold"><i
                                                class="fa-solid fa-xmark mr-2"></i>Paiement refusé</span>
                                    @elseif ($data->status == 'PAYMENT_DECLINED')
                                        <span class="text-danger font-weight-bold"><i
                                                class="fa-solid fa-xmark mr-2"></i>Paiement refusé</span>
                                    @elseif ($data->status == 'REFUND')
                                        <span class="text-danger font-weight-bold"><i
                                                class="fa-solid fa-xmark mr-2"></i>Paiement rembourser</span>
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($data->transaction_id))
                                        {{ $data->transaction_id }}
                                    @else
                                        /
                                    @endif
                                </td>
                                <td>
                                    {{ $data->price }} €
                                </td>
                                <td>{{ date('d/m/Y à H:i', strtotime($data->order_at)) }}</td>
                                <td>
                                    @if (!empty($data->refund_at))
                                        {{ date('d/m/Y à H:i', strtotime($data->refund_at)) }}
                                    @else
                                        /
                                    @endif
                                </td>
                                <td>
                                    @if ($data->status == 'COMPLETED')
                                        <a class="refund-paiement btn btn-outline-danger btm-sm font-weight-bold"
                                            data-id="{{ $data->id }}"
                                            data-transaction="{{ $data->transaction_id }}">Rembourser</a>
                                    @else
                                        /
                                    @endif
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
