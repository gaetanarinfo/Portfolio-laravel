<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light text-white bg-info topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">

            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>

                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">0</span>

            </a>

            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">

                <h6 class="dropdown-header">
                    Notifications
                </h6>

            </div>

        </li>

        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">

            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <i class="fas fa-envelope fa-fw"></i>

                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">0</span>

            </a>

            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">

                <h6 class="dropdown-header">
                    Boite de réception
                </h6>

            </div>

        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">

            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">

                @if ($user->admin == 1)
                    <span><i class="fa-solid fa-crown mr-2 text-warning"></i></span>
                @endif
                <span
                    class="mr-2 d-none d-lg-inline text-light font-weight-bold">{{ $user->firstname . ' ' . $user->lastname }}</span>

                <img class="img-profile rounded-circle"
                    src="@if (!empty($user->avatar)) {{ 'img/profil/' . $user->avatar }} @else {{ URL::asset('img/profil/default.svg') }} @endif">

            </a>

            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-light"></i>
                    Mon profil
                </a>

                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-light"></i>
                    Paramètres
                </a>

                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-light"></i>
                    Mon activité
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-light"></i>
                    Déconnexion
                </a>

            </div>

        </li>

    </ul>

</nav>
<!-- End of Topbar -->
