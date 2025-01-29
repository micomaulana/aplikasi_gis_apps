<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex flex-column align-items-center justify-content-between text-center">
            <h4 class="display-6 mb-1"><b>GIS DBD</b></h4>
            <p class="mb-0">PUSKESMAS KARYA MAJU</p>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>

        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                    <span class="hide-menu">MENU</span>
                </li>
                @can('desa-list')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('desas.index') }}" aria-expanded="false">
                            <span>
                                <iconify-icon icon="mdi:map-outline" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">Desa</span>
                        </a>
                    </li>
                @endcan
                @can('pasien-list')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('pasiens.index') }}" aria-expanded="false">
                            <span>
                                <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">Pasien</span>
                        </a>
                    </li>
                @endcan
                @can('dokter-list')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('dokters.index') }}" aria-expanded="false">
                            <span>
                                <iconify-icon icon="solar:user-id-bold-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">Dokter</span>
                        </a>
                    </li>
                @endcan

                @can('maps')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('maps') }}" aria-expanded="false">
                            <span>
                                <iconify-icon icon="solar:map-point-bold-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">Peta</span>
                        </a>
                    </li>
                @endcan

                @can('informasi-create')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('data_informasi_view') }}" aria-expanded="false">
                            <span>
                                <iconify-icon icon="solar:clipboard-list-bold-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">Informasi</span>
                        </a>
                    </li>
                @endcan

                @can('informasi-list')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('data_informasi_views') }}" aria-expanded="false">
                            <span>
                                <iconify-icon icon="solar:documents-bold-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">lihat data dan informasi</span>
                        </a>
                    </li>
                @endcan

                @can('validasi-kepala_puskesmas')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('validasi_kapus') }}" aria-expanded="false">
                            <span>
                                <iconify-icon icon="solar:checklist-bold-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">validasi kapus</span>
                        </a>
                    </li>
                @endcan

                @can('validasi-admin')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('validasi_admin') }}" aria-expanded="false">
                            <span>
                                <iconify-icon icon="solar:user-check-bold-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">validasi pasien</span>
                        </a>
                    </li>
                @endcan

                @can('laporankondisi_masyarakat')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('laporan_masyarakat') }}" aria-expanded="false">
                            <span>
                                <iconify-icon icon="solar:notebook-bold-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">laporan masyarakat</span>
                        </a>
                    </li>
                @endcan

                @can('laporandbd_admin')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('laporan_view') }}" aria-expanded="false">
                            <span>
                                <iconify-icon icon="solar:document-bold-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">Laporan</span>
                        </a>
                    </li>
                @endcan

                @can('landingpage')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('landing_page_views') }}" aria-expanded="false">
                            <span>
                                <iconify-icon icon="solar:virus-bold-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">Detail DBD</span>
                        </a>
                    </li>
                @endcan

                @can('dashboard_masyarakat')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('dashboard_masyarakat') }}" aria-expanded="false">
                            <span>
                                <iconify-icon icon="solar:hospital-bold-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">Profil puskesmas Karya Maju</span>
                        </a>
                    </li>
                @endcan

                @can('faq_masyarakat')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('faq_masyarakat') }}" aria-expanded="false">
                            <span>
                                <iconify-icon icon="solar:chat-round-dots-bold-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">FAQ</span>
                        </a>
                    </li>
                @endcan
                @can('user-list')

                    <li class="nav-small-cap">
                        <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-6"
                            class="fs-6"></iconify-icon>
                        <span class="hide-menu">AUTH</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="#" aria-expanded="false" data-bs-toggle="collapse"
                            data-bs-target="#manageUsers">
                            <span>
                                <iconify-icon icon="solar:users-group-two-bold-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu">Manage Users</span>
                        </a>
                        <ul id="manageUsers" class="collapse">
                            <li class="sidebar-item ps-4">
                                <a class="sidebar-link" href="{{ route('users.index') }}">
                                    <span>
                                        <iconify-icon icon="solar:users-group-rounded-bold-duotone"
                                            class="fs-6"></iconify-icon>
                                    </span>
                                    <span class="hide-menu">List Users</span>
                                </a>
                            </li>
                            @can('role-list')
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="{{ route('roles.index') }}" aria-expanded="false">
                                        <span>
                                            <iconify-icon icon="solar:shield-user-bold-duotone" class="fs-6"></iconify-icon>
                                        </span>
                                        <span class="hide-menu">Manage roles</span>
                                    </a>
                                </li>
                            @endcan
                        @endcan

                    </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
