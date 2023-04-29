<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h2 mb-0 text-gray-900 font-weight-bold">Tableau de bord</h1>

        @if ($user->admin == 1)
            <form>

                <div class="form-group">

                    <select name="year" id="year" class="form-control">
                        @for ($i = date('Y', strtotime('-2 years')); $i <= 2026; $i++)
                            <option value="{{ $i }}" @if (!empty($year) && $i == $year) selected @endif
                                @if (empty($year) && $i == date('Y')) selected @endif>
                                {{ $i }}</option>
                        @endfor
                    </select>

                </div>

            </form>
        @endif
    </div>

    @if ($user->admin == 1)

        <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">

                <div class="card border-left-success shadow h-100 py-2">

                    <div class="card-body">

                        <div class="row no-gutters align-items-center">

                            <div class="col mr-2">

                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total des
                                    commandes
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

                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Montant des
                                    commandes
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

                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Montant des
                                    commandes
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
    @endif

    @if ($user->admin == 1)
        <input type="hidden" id="commandes_graph" data-target="{{ $commandes_graph }}" />
        <input type="hidden" id="commandes_graph_refund" data-target="{{ $commandes_graph_refund }}" />

        <script>
            $(document).ready(function() {

                var commandes = $('#commandes_graph').data("target");
                commandes = commandes.split(',');
                myBarChart.data.datasets[0].data = commandes;
                myBarChart.update();

                var commandes_refund = $('#commandes_graph_refund').data("target");
                commandes_refund = commandes_refund.split(',');
                myBarChart2.data.datasets[0].data = commandes_refund;
                myBarChart2.update();

            });
        </script>

        <!-- Content Row -->
        <div class="row">

            <div class="col-xl-6 col-lg-6 mt-4">

                <div class="card shadow mb-4 bloc-stats-1">

                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-success">Commande Google Play sur l'année
                            @if (empty($year))
                                {{ date('Y') }}
                            @else
                                {{ $year }}
                            @endif
                        </h6>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">

                        <div class="chart-area">

                            <div class="chartjs-size-monitor">

                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>

                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>

                            </div>

                            <canvas id="myBarChart" style="display: block; height: 320px; width: 781px;" width="976"
                                height="400" class="chartjs-render-monitor"></canvas>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-xl-6 col-lg-6 mt-4">

                <div class="card shadow mb-4 bloc-stats-1">

                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-danger">Commande Google Play rembourser sur l'année
                            @if (empty($year))
                                {{ date('Y') }}
                            @else
                                {{ $year }}
                            @endif
                        </h6>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">

                        <div class="chart-area">

                            <div class="chartjs-size-monitor">

                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>

                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>

                            </div>

                            <canvas id="myBarChart2" style="display: block; height: 320px; width: 781px;" width="976"
                                height="400" class="chartjs-render-monitor"></canvas>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    @else
        <div class="row">
        </div>
    @endif

</div>
<!-- /.container-fluid -->
