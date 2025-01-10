<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.html" class="text-nowrap logo-img">
                <img src="/Seodash-assets/images/logos/logo-light.svg" alt="" />
            </a>
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
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('desas.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Desa</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('pasiens.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:danger-circle-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Pasien</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dokters.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:danger-circle-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Dokter</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('maps') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:bookmark-square-minimalistic-bold-duotone"
                                class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Peta</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('data_informasi_view') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:file-text-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Informasi</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('data_informasi_views') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:file-text-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">lihat data dan informasi</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('validasi_kapus') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:file-text-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">validasi kapus</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('validasi_admin') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:file-text-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">validasi pasien</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('laporan_masyarakat') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:file-text-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">laporan masyarakat</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('laporan_view') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:text-field-focus-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Laporan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('landing_page_views') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:text-field-focus-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Landing Page</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dashboard_masyarakat') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:text-field-focus-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('faq_masyarakat') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:text-field-focus-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">FAQ</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-6"
                        class="fs-6"></iconify-icon>
                    <span class="hide-menu">AUTH</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('logout') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:login-3-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Logout</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"
                        class="fs-6"></iconify-icon>
                    <span class="hide-menu">EXTRA</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./icon-tabler.html" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:sticker-smile-circle-2-bold-duotone"
                                class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Icons</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./sample-page.html" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:planet-3-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Sample Page</span>
                    </a>
                </li>
            </ul>
            <div class="unlimited-access hide-menu bg-primary-subtle position-relative mb-7 mt-7 rounded-3">
                <div class="d-flex">
                    <div class="unlimited-access-title me-3">
                        <h6 class="fw-semibold fs-4 mb-6 text-dark w-75">Upgrade to pro</h6>
                        <a href="#" target="_blank" class="btn btn-primary fs-2 fw-semibold lh-sm">Buy
                            Pro</a>
                    </div>
                    <div class="unlimited-access-img">
                        <img src="/Seodash-assets/images/backgrounds/rocket.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
