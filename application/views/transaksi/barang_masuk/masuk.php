<!-- content @s -->
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title"><?= $title; ?></h3>
                                <div class="nk-block-des text-soft">
                                    <p>Data <?= $title; ?></p>
                                </div>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <ul class="nk-block-tools g-3">
                                    <li>
                                        <div class="drodown">
                                            <a href="#add" class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="modal"><em class="icon ni ni-plus"></em>Add <?= $title; ?></a>
                                        </div>
                                    </li>
                                </ul>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->

                    <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= validation_errors(); ?>
                        </div>
                    <?php endif; ?>

                    <?= $this->session->flashdata('message'); ?>
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card card-bordered card-preview">
                                    <div class="card-inner">
                                        <table class="datatable-init nowrap table">
                                            <thead>
                                                <tr>
                                                    <th>No. </th>
                                                    <th>No Transaksi</th>
                                                    <th>Tanggal Masuk</th>
                                                    <th>Nama Barang</th>
                                                    <th>Jumlah Masuk</th>
                                                    <th>Supplier</th>
                                                    <th>Petugas</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                <?php foreach ($barangmasuk as $bm) : ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $bm['id_bmasuk'] ?></td>
                                                        <td><?= $bm['tanggal_masuk']  ?></td>
                                                        <td><?= $bm['nama_barang'] ?></td>
                                                        <td><?= $bm['jumlah_masuk'] ?></td>
                                                        <td><?= $bm['nama_supplier'] ?></td>
                                                        <td><?= $bm['id_user'] ?></td>
                                                        <td>
                                                            <div class="tb-odr-btns d-none d-md-inline">
                                                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('masuk/delete/') . $bm['id_bmasuk'] ?>" class="btn btn-sm btn-danger"><em class="icon ni ni-trash"></em>Delete</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- .card-preview -->
                            </div> <!-- nk-block -->
                        </div><!-- .card-inner-group -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
<!-- content @e -->


<!-- Add Room-->
<div class="modal fade" tabindex="-1" role="dialog" id="add">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="modal-title">Add <?= $title; ?></h5>
                <form action="<?= base_url('masuk') ?>" method="post">
                    <input type="hidden" value="<?= $user['id']; ?>" class="form-control" name="id_user">
                    <div class="row g-gs">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 mt-2">
                                    <div class="form-group">
                                        <label class="form-label">ID Barang</label>
                                        <input readonly type="text" value="<?= $id_bmasuk; ?>" class="form-control" name="id_bmasuk">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 mt-2">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Masuk</label>
                                        <input type="date" value="<?= set_value('tanggal_masuk', date('Y-m-d')); ?>" class="form-control" name="tanggal_masuk" id="tanggal_masuk" placeholder="Nama barang">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 mt-2">
                                    <div class="form-group">
                                        <label class="form-label">Supplier</label>
                                        <select name="id_supplier" id="id_supplier" class="form-select js-select2 js-select2-sm">
                                            <option selected disabled>Pilih Supplier</option>
                                            <?php foreach ($supplier as $s) : ?>
                                                <option value="<?= $s['id']; ?>"><?= $s['nama_supplier']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p><a href="<?= site_url('supplier') ?>">+ Add Supplier</a></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 mt-2">
                                    <div class="form-group">
                                        <label class="form-label">Barang</label>
                                        <select name="barang_id" id="barang_id" class="form-select js-select2 js-select2-sm">
                                            <option selected disabled>Pilih Barang</option>
                                            <?php foreach ($barang as $key) : ?>
                                                <option <?= set_select('barang_id', $key['id_barang']) ?> data-stok="<?= $key['stok']; ?>" value="<?= $key['id_barang'] ?>"><?= $key['id_barang'] . ' | ' . $key['nama_barang'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <p><a href=" <?= site_url('barang') ?>">+ Add Barang</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12 mt-2">
                                    <div class="form-control-wrap">
                                        <label class="form-label" for="stok">Stok</label>
                                        <div class="input-group">
                                            <input readonly type="number" id="stok" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mt-2">
                                    <div class="form-group">
                                        <label class="form-label" for="jumlah_masuk">Jumlah Masuk</label>
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="jumlah_masuk" id="jumlah_masuk" placeholder="Jumlah Masuk">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="satuan">Satuan</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 mt-2">
                                    <div class="form-control-wrap">
                                        <label class="form-label" for="basic-total_stok">Total Stok</label>
                                        <div class="input-group">
                                            <input readonly type="number" id="total_stok" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <!-- disini camera reader qr code -->
                            <video id="scanner" class="scann__qr"></video>
                            <br>
                            <div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
                                <label class="btn btn-primary">
                                    <input type="radio" name="options" value="1" autocomplete="off" checked> Camera Depan
                                </label>
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="options" value="2" autocomplete="off"> Camera Belakang
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <button class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                                </li>
                                <li>
                                    <a href="#" class="link" data-bs-dismiss="modal">Cancel</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->
<!-- <script src="<?= base_url('assets') ?>/js/custom/instascan.min.js"></script> -->
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script src="<?= base_url('assets') ?>/js/custom/scanqr.js"></script>

<!-- <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script src="<?= base_url('assets') ?>/js/custom/qr-code.js"></script> -->