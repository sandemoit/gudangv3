<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        <!-- sidebar @s -->
        <div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
            <div class="nk-sidebar-element nk-sidebar-head">
                <div class="nk-menu-trigger">
                    <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                    <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                </div>
                <div class="nk-sidebar-brand">
                    <a href="html/index.html" class="logo-link nk-sidebar-logo">
                        <img class="logo-light logo-img" src="<?= base_url('assets') ?>/images/logo.png" srcset="<?= base_url('assets') ?>/images/logo2x.png 2x" alt="logo">
                        <img class="logo-dark logo-img" src="<?= base_url('assets') ?>/images/logo-dark.png" srcset="<?= base_url('assets') ?>/images/logo-dark2x.png 2x" alt="logo-dark">
                    </a>
                </div>
            </div><!-- .nk-sidebar-element -->
            <div class="nk-sidebar-element nk-sidebar-body">
                <div class="nk-sidebar-content">
                    <div class="nk-sidebar-menu" data-simplebar>
                        <ul class="nk-menu">
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Dashboards</h6>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= site_url('dashboard') ?>" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-tile-thumb"></em></span>
                                    <span class="nk-menu-text">Dashboard</span><!-- <span class="nk-menu-badge">HOT</span> -->
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Data Master</h6>
                            </li><!-- .nk-menu-heading -->
                            <li class="nk-menu-item">
                                <a href="<?= site_url('supplier') ?>" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                    <span class="nk-menu-text">Supplier</span><!-- <span class="nk-menu-badge">HOT</span> -->
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item has-sub">
                                <a href="#" class="nk-menu-link nk-menu-toggle">
                                    <span class="nk-menu-icon"><em class="icon ni ni-folders"></em></em></span>
                                    <span class="nk-menu-text">Master Barang</span>
                                </a>
                                <ul class="nk-menu-sub">
                                    <li class="nk-menu-item">
                                        <a href="<?= site_url('satuan') ?>" class="nk-menu-link"><span class="nk-menu-text">Satuan Barang</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="<?= site_url('jenis') ?>" class="nk-menu-link"><span class="nk-menu-text">Jenis Barang</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="<?= site_url('barang') ?>" class="nk-menu-link"><span class="nk-menu-text">Data Barang</span></a>
                                    </li>
                                </ul><!-- .nk-menu-sub -->
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-heading">
                                <h6 class="overline-title text-primary-alt">Transaksi</h6>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= site_url('masuk') ?>" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-inbox-in-fill"></em></span>
                                    <span class="nk-menu-text">Barang Masuk</span><!-- <span class="nk-menu-badge">HOT</span> -->
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="<?= site_url('keluar') ?>" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-inbox-out-fill"></em></span>
                                    <span class="nk-menu-text">Barang Keluar</span><!-- <span class="nk-menu-badge">HOT</span> -->
                                </a>
                            </li><!-- .nk-menu-item -->
                        </ul><!-- .nk-menu -->
                    </div><!-- .nk-sidebar-menu -->
                </div><!-- .nk-sidebar-content -->
            </div><!-- .nk-sidebar-element -->
        </div>
        <!-- sidebar @e -->