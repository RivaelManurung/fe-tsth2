<!-- Sidebar content -->
<div class="sidebar-content">
    <!-- Sidebar header -->
    <div class="sidebar-section">
        <div class="sidebar-section-body d-flex justify-content-center">
            <h5 class="sidebar-resize-hide flex-grow-1 my-auto">Navigation</h5>

            <div>
                <button type="button"
                    class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                    <i class="ph-arrows-left-right"></i>
                </button>

                <button type="button"
                    class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                    <i class="ph-x"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- /sidebar header -->

    <!-- Main navigation -->
    <div class="sidebar-section">
        <ul class="nav nav-sidebar" data-nav-type="accordion">
            <!-- Main -->
            <li class="nav-item-header pt-0">
                <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">
                    Main
                </div>
                <i class="ph-dots-three sidebar-resize-show"></i>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link active">
                    <i class="ph-house"></i>
                    <span> Dashboard </span>
                </a>
            </li>
            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link">
                    <i class="ph-squares-four"></i>
                    <span>Master Data</span>
                </a>
                {{-- <ul class="nav-group-sub collapse">
                    <li class="nav-item">
                        <a href="{{ route('barangs.index') }}"
                            class="nav-link {{ request()->routeIs('barangs.*') ? 'active' : '' }}">
                            Barang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('satuans.index') }}"
                            class="nav-link {{ request()->routeIs('satuans.*') ? 'active' : '' }}">
                            Satuan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('jenis-barangs.index') }}"
                            class="nav-link {{ request()->routeIs('jenis-barangs.*') ? 'active' : '' }}">
                            Jenis Barang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('barang-categories.index') }}"
                            class="nav-link {{ request()->routeIs('barang-categories.*') ? 'active' : '' }}">
                            Kategori Barang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('gudangs.index') }}"
                            class="nav-link {{ request()->routeIs('gudangs.*') ? 'active' : '' }}">
                            Gudang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('transaction-types.index') }}"
                            class="nav-link {{ request()->routeIs('transaction-types.*') ? 'active' : '' }}">
                            Jenis Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../../layout_7/full/index.html"
                            class="nav-link {{ request()->is('status') ? 'active' : '' }}">
                            Status
                        </a>
                    </li>
                </ul> --}}
                <ul
                    class="nav-group-sub collapse {{ request()->routeIs(
                        'barangs.*',
                        'satuans.*',
                        'jenis-barangs.*',
                        'barang-categories.*',
                        'gudangs.*',
                        'transaction-types.*',
                    )
                        ? 'show'
                        : '' }}">

                    <x-nav-item route="barangs" label="Barang" />
                    <x-nav-item route="satuans" label="Satuan" />
                    <x-nav-item route="jenis-barangs" label="Jenis Barang" />
                    <x-nav-item route="barang-categories" label="Kategori Barang" />
                    <x-nav-item route="gudangs" label="Gudang" />
                    <x-nav-item route="transaction-types" label="Jenis Transaksi" />
                </ul>


            </li>
            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transaksi</span>
                </a>
            </li>
            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link">
                    <i class="ph-printer"></i>
                    <span>Laporan</span>
                </a>
            </li>

            <!-- Settings -->
            <li class="nav-item-header">
                <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">
                    Other
                </div>
                <i class="ph-dots-three sidebar-resize-show"></i>
            </li>
            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link">
                    <i class="mi-settings"></i>
                    <span>Settings</span>
                </a>
                <ul class="nav-group-sub collapse">
                    <li class="nav-item">
                        <a href="form_autocomplete.html" class="nav-link">User</a>
                    </li>
                    <li class="nav-item">
                        <a href="form_checkboxes_radios.html" class="nav-link">Role</a>
                    </li>
                    <li class="nav-item">
                        <a href="form_dual_listboxes.html" class="nav-link">Akses</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="ph-desktop"></i>
                    <span>Web</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="mi-power-settings-new"></i>
                    <span>Logout</span>
                </a>
            </li>
            <!-- /forms -->
        </ul>
    </div>
    <!-- /main navigation -->
</div>
<!-- /sidebar content -->
