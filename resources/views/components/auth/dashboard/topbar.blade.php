@php
    use Carbon\Carbon;
@endphp

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light text-white bg-info topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">

            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <i class="fas fa-envelope fa-fw"></i>

                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">{{ count($contacts) }}</span>

            </a>

            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">

                <h6 class="dropdown-header bg-success">
                    Boite de réception
                </h6>

                @if (count($contacts) >= 1)

                    @foreach ($contacts as $data)
                        @php
                            $post_date = $data->created_at;
                        @endphp

                        <a class="dropdown-item d-flex align-items-center btn-modal-mail" href="#"
                            id="mail_{{ $data->id }}" data-toggle="modal" data-target="#mailModal"
                            data-name="{{ $data->name }}" data-date="{{ $data->created_at->diffForHumans() }}"
                            data-sujet="{{ $data->sujet }}" data-email="{{ $data->email }}"
                            data-message="{{ $data->message }}" data-avatar="{{ $data->avatar }}"
                            data-id="{{ $data->id }}">

                            <div class="dropdown-list-image mr-3">
                                <img class="rounded-circle"
                                    src="@if (!empty($data->avatar)) {{ URL::asset('/img/profil/' . $data->avatar) }} @else {{ URL::asset('/img/profil/default.svg') }} @endif" />
                                <div class="status-indicator bg-success"></div>
                            </div>

                            <div class="font-weight-bold">
                                <div class="text-truncate">{{ $data->sujet }}</div>
                                <div class="small text-dark-500 font-weight-bold">{{ $data->name }} ·
                                    {{ $data->created_at->diffForHumans() }}
                                </div>
                            </div>

                        </a>
                    @endforeach
                @else

                    <div class="text-warning message-mail">Vous n'avez aucun message</div>

                @endif

                @if (count($contacts) >= 7)
                    <a class="dropdown-item text-center small text-dark-500 font-weight-bold" href="#">Voir les
                        autres messages</a>
                @endif
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
                    class="mr-2 d-none d-lg-inline text-light font-weight-bold">@if(!empty($user->firstname) && !empty($user->lastname)) {{ $user->firstname . ' ' . $user->lastname }} @else {{ $user->name }} @endif</span>

                <img class="img-profile rounded-circle"
                    src="@if (!empty($user->avatar)) {{ '/img/profil/' . $user->avatar }} @else {{ URL::asset('img/profil/default.svg') }} @endif">

            </a>

            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                <a class="dropdown-item btn-modal-user" href="#" data-toggle="modal" data-target="#editUserLoggedModal" data-lastname="{{ $user->lastname }}"
                    data-firstname="{{ $user->firstname }}" data-email="{{ $user->email }}"
                    data-avatar="{{ $user->avatar }}"
                    data-edit="1">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-light"></i>
                    Mon profil
                </a>

                <a class="dropdown-item" href="/logs">
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
