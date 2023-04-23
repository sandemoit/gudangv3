<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Dashboard <?= $setting['nama_aplikasi'] ?></h3>
                            <div class="nk-block-des text-soft">
                                <p>Welcome to <?= $setting['nama_perusahaan'] ?></p>
                            </div>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <!-- <ul class="nk-block-tools g-3">
                                        <li>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-calender-date"></em><span><span class="d-none d-md-inline">Last</span> 30 Days</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#"><span>Last 30 Days</span></a></li>
                                                        <li><a href="#"><span>Last 6 Months</span></a></li>
                                                        <li><a href="#"><span>Last 1 Years</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nk-block-tools-opt"><a href="#" class="btn btn-primary"><em class="icon ni ni-reports"></em><span>Reports</span></a></li>
                                    </ul> -->
                                </div>
                            </div>
                        </div>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-md-3">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <h6 class="title">Total Data Barang</h6>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Total Booking"></em>
                                        </div>
                                    </div>
                                    <div class="card-amount">
                                        <span class="amount mt-3"> <?= $total_barang; ?> </span>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-3">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <h6 class="title">Total Transaksi Barang Masuk</h6>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Total Booking"></em>
                                        </div>
                                    </div>
                                    <div class="card-amount">
                                        <span class="amount mt-3"> <?= $total_barang_masuk; ?> </span>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-3">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <h6 class="title">Total Transaksi Barang Keluar</h6>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Total Booking"></em>
                                        </div>
                                    </div>
                                    <div class="card-amount">
                                        <span class="amount mt-3"> <?= $total_barang_keluar; ?> </span>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-3">
                            <div class="card card-bordered card-full">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title">
                                            <h6 class="title">Total Users</h6>
                                        </div>
                                        <div class="card-tools">
                                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Total Booking"></em>
                                        </div>
                                    </div>
                                    <div class="card-amount">
                                        <span class="amount mt-3"> <?= $total_users; ?> </span>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-xxl-4">
                            <div class="card card-bordered card-full">
                                <div class="nk-block">
                                    <div class="card card-bordered card-stretch">
                                        <div class="card-inner-group">
                                            <div class="card card-bordered card-preview">
                                                <div class="card-inner">
                                                    <h4><em class="icon ni ni-info"></em> Pemberitahuan Stok Hampir Habis</h4>
                                                    <table class="datatable-init nowrap table">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>ID Barang</th>
                                                                <th>Nama Barang</th>
                                                                <th>Stok</th>
                                                                <th>Satuan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $no = 1; ?>
                                                            <?php foreach ($products as $s) : ?>
                                                                <tr>
                                                                    <td><?= $no++; ?></td>
                                                                    <td><?= $s['id_barang'] ?></td>
                                                                    <td><?= $s['nama_barang'] . ' / ' . $s['nama_jenis'] ?></td>
                                                                    <td><?= $s['stok'] ?></td>
                                                                    <td><?= $s['nama_satuan'] ?></td>

                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div><!-- .card-preview -->
                                        </div> <!-- nk-block -->
                                    </div><!-- .card-inner-group -->
                                </div><!-- .card -->
                            </div>
                        </div><!-- .col -->

                    </div><!-- .row -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
<!-- content @e -->