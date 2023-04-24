<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">

        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-brands fa-redhat"></i>
        </div>

        <div class="sidebar-brand-text mx-3">Portfolio</div>

    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if (Route::current()->getName() == 'dashboard') active @endif">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    @if ($user->admin == 1)
        <!-- Heading -->
        <div class="sidebar-heading">
            Administration
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">

            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>

            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">

                <div class="bg-white py-2 collapse-inner rounded">

                    <h6 class="collapse-header">Blog :</h6>
                    <a class="collapse-item @if (Route::current()->getName() == 'show-article') active @endif"
                        href="/show-article">Mes
                        articles</a>
                    <a class="collapse-item @if (Route::current()->getName() == 'add-article') active @endif"
                        href="/add-article">Crée un
                        article</a>
                    <div class="collapse-divider"></div>

                    <h6 class="collapse-header">Utilisateurs :</h6>
                    <a class="collapse-item @if (Route::current()->getName() == 'show-users') active @endif"
                        href="/show-users">Voir les
                        utilisateurs</a>
                    <a class="collapse-item @if (Route::current()->getName() == 'show-users') active @endif"
                        href="/show-users">Crée un
                        utilisateur</a>

                    <h6 class="collapse-header">Projets :</h6>
                    <a class="collapse-item @if (Route::current()->getName() == 'show-projets') active @endif"
                        href="/show-projets">Voir les
                        projets</a>
                    <a class="collapse-item @if (Route::current()->getName() == 'show-projets') active @endif"
                        href="/show-projets">Crée un
                        projet</a>

                </div>

            </div>

        </li>
    @endif

</ul>
<!-- End of Sidebar -->
