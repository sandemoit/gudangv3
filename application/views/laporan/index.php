<!-- content @s -->
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg ">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title"><?= $title; ?></h3>
                                <div class="nk-block-des text-soft">
                                    <p>Data <?= $title; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= validation_errors(); ?>
                        </div>
                    <?php endif; ?>

                    <?= $this->session->flashdata('message'); ?>

                    <div class="card card-bordered card-preview col-12 ">
                        <div class="card-inner">
                            <div class="row form-group">
                                <label class="form-label">Filter Tanggal</label>
                                <form action="<?= site_url('laporan') ?>" method="post" class="form-inline" id="filterForm">
                                    <div class="form-group mb-0">
                                        <div class="form-control-wrap focused">
                                            <div class="form-icon form-icon-left"><em class="icon ni ni-calendar"></em></div>
                                            <input type="text" name="start_date" class="form-control date-picker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Awal" value="<?= set_value('start_date', isset($start_date) ? $start_date : ''); ?>">
                                        </div>
                                        <?= form_error('start_date', '<span class="text-danger small">', '</span>'); ?>
                                    </div>
                                    <div class="form-group mx-sm-3 mb-0">
                                        <div class="form-control-wrap focused">
                                            <div class="form-icon form-icon-left"><em class="icon ni ni-calendar"></em></div>
                                            <input type="text" name="end_date" id="end_date" class="form-control date-picker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Keluar" value="<?= set_value('end_date', isset($end_date) ? $end_date : ''); ?>">
                                        </div>
                                        <?= form_error('end_date', '<span class="text-danger small">', '</span>'); ?>
                                    </div>
                                    <div class="col-3">
                                        <div class="nk-block-head-content">
                                            <ul class="nk-block-tools g-3">
                                                <li>
                                                    <button type="submit" class="btn btn-icon btn-secondary"><em class="icon ni ni-filter"></em> Filter</button>
                                                </li>
                                                <li>
                                                    <button type="button" class="btn btn-icon btn-warning" onclick="resetDates()"><em class="icon ni ni-reload-alt"></em> Reset </button>
                                                </li>
                                                <li>
                                                    <a onclick="generateCetak()" class="btn btn-icon btn-light"><em class="icon ni ni-printer"></em> Print</a>
                                                </li>
                                                <li>
                                                    <butto onclick="generatePDF()" class="btn btn-icon btn-danger"><em class="icon ni ni-file-pdf"></em> PDF</butto>
                                                </li>
                                                <li>
                                                    <a onclick="downloadExcel()" class="btn btn-icon btn-success"><em class="icon ni ni-file-xls"></em> Excel</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-inner">
                            <table class="datatable-init nowrap table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Stok Awal</th>
                                        <th>Jumlah Masuk</th>
                                        <th>Jumlah Keluar</th>
                                        <th>Total Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($laporan as $item) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $item['id_barang']; ?></td>
                                            <td><?= $item['nama_barang']; ?></td>
                                            <td><?= $item['stok_awal']; ?></td>
                                            <td><?= (!empty($item['jumlah_masuk'])) ? $item['jumlah_masuk'] : 0; ?></td>
                                            <td><?= (!empty($item['jumlah_keluar'])) ? $item['jumlah_keluar'] : 0; ?></td>
                                            <td>
                                                <?php
                                                $totalStok = $item['stok_awal'] + ((!empty($item['jumlah_masuk'])) ? $item['jumlah_masuk'] : 0) - ((!empty($item['jumlah_keluar'])) ? $item['jumlah_keluar'] : 0);
                                                echo $totalStok;
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>