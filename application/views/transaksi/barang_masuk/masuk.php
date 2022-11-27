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
                                            <a href="#add" class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="modal"><em class="icon ni ni-plus"></em>Add Barang Masuk</a>
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
                                                    <th>Supplier</th>
                                                    <th>Nama Barang</th>
                                                    <th>Jumlah Masuk</th>
                                                    <th>Petugas</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($barangmasuk as $bm) : ?>
                                                    <?php $no = 1; ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $bm['id_bmasuk'] ?></td>
                                                        <td><?= $bm['tanggal_masuk']  ?></td>
                                                        <td><?= $bm['nama_supplier'] ?></td>
                                                        <td><?= $bm['nama_barang'] ?></td>
                                                        <td><?= $bm['jumlah_masuk'] ?></td>
                                                        <td><?= $bm['name'] ?></td>
                                                        <td>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a data-bs-toggle="modal" href="#edit<?= $bm['id_bmasuk'] ?>"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                                                        <li><a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barang/delete/') . $bm['id_bmasuk'] ?>"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
                                                                    </ul>
                                                                </div>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="modal-title">Add barang</h5>
                <?= form_open('', [], ['stok' => 0]); ?>
                <div class="row g-gs">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="room-no-add">ID Barang</label>
                            <input readonly type="text" value="<?= set_value('id_barang', $id_barang); ?>" class="form-control" name="id_barang" id="id_barang">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="room-no-add">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama barang">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="room-no-add">Satuan barang</label>
                            <select name="id_satuan" id="id_satuan" class="form-select js-select2 js-select2-sm">
                                <option selected disabled>Pilih Jenis Barang</option>
                                <?php foreach ($bmatuan as $bm) : ?>
                                    <option <?= set_select('id_satuan', $bm['id']) ?> value="<?= $bm['id'] ?>"><?= $bm['nama_satuan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p><a href="<?= site_url('satuan') ?>">+ Add Satuan Barang</a></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="room-no-add">Jenis barang</label>
                            <select name="id_jenis" id="id_jenis" class="form-select js-select2 js-select2-sm">
                                <option selected disabled>Pilih Jenis Barang</option>
                                <?php foreach ($jenis as $j) : ?>
                                    <option <?= set_select('id_jenis', $j['id']) ?> value="<?= $j['id'] ?>"><?= $j['nama_jenis'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p><a href="<?= site_url('jenis') ?>">+ Add Jenis Barang</a></p>
                        </div>
                    </div>
                    <!--col-->
                    <div class="col-12">
                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                            <li>
                                <button class="btn btn-primary" data-bs-dismiss="modal">Add barang</button>
                            </li>
                            <li>
                                <a href="#" class="link" data-bs-dismiss="modal">Cancel</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?= form_close(); ?>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

<!-- Edit Room-->
<?php foreach ($barangmasuk as $bm) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="edit<?= $bm['id_barang'] ?>">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-md">
                    <h5 class="modal-title">Edit barang</h5>
                    <?= form_open('barang/edit', [], ['stok' => 0, 'id_barang' => $bm['id_barang']]); ?>
                    <div class="row g-gs">
                        <div class="row mt-5">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label" for="room-no-add">Nama Barang</label>
                                    <input type="text" class="form-control" value="<?= $bm['nama_barang'] ?>" name="nama_barang" id="nama_barang" placeholder="Nama barang">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="room-no-add">Satuan barang</label>
                                <select name="id_satuan" id="id_satuan" class="form-select js-select2 js-select2-sm">
                                    <option selected disabled>Pilih Satuan Barang</option>
                                    <?php foreach ($bmatuan as $bm) : ?>
                                        <option <?= $b['id_satuan'] == $bm['id'] ? 'selected' : '' ?> value="<?= $bm['id']; ?>"><?= $bm['nama_satuan']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <p><a href="<?= site_url('satuan') ?>">+ Add Jenis Barang</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="room-no-add">Jenis barang</label>
                                <select name="id_jenis" id="id_jenis" class="form-select js-select2 js-select2-sm">
                                    <option selected disabled>Pilih Jenis Barang</option>
                                    <?php foreach ($jenis as $j) : ?>
                                        <option <?= $b['id_jenis'] == $j['id'] ? 'selected' : ''; ?> <?= set_select('id_jenis', $j['id']) ?> value="<?= $j['id'] ?>"><?= $j['nama_jenis'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <p><a href="<?= site_url('jenis') ?>">+ Add Jenis Barang</a></p>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <button class="btn btn-primary" data-bs-dismiss="modal">Add barang</button>
                                </li>
                                <li>
                                    <a href="#" class="link" data-bs-dismiss="modal">Cancel</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->
<?php endforeach; ?>