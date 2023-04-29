<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h2 mb-2 text-gray-900 font-weight-bold">Activité de votre compte</h1>
    </div>

    <p class="mb-4">Retrouvezz ici l'activité de votre compte vous concernant.</p>

    <div class="card shadow mb-4">

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
                            <th data-sortable="true">Titre</th>
                            <th data-sortable="true">Description</th>
                            <th data-sortable="true">Page du site</th>
                            <th data-sortable="true">Adresse ip</th>
                            <th data-sortable="true">Date de création</th>
                        </tr>

                    </thead>

                    <tfoot>

                        <tr>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Page du site</th>
                            <th>Adresse ip</th>
                            <th>Date de création</th>
                        </tr>

                    </tfoot>

                    <tbody>

                        @foreach ($logs as $data)
                            <tr id="td_logs_{{ $data->id }}">

                                <td>
                                    {{ $data->title }}
                                </td>

                                <td>
                                    {{ $data->content }}
                                </td>

                                <td>
                                    {{ $data->page }}
                                </td>

                                <td>
                                    {{ $data->ip }}
                                </td>

                                <td>
                                    {{ date('d/m/Y à H:i', strtotime($data->created_at)) }}
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
