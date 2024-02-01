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
                                            <a href="#add" class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="modal"><em class="icon ni ni-plus"></em> Tambah Barang</a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="drodown">
                                            <a href="<?= base_url('barang/excel') ?>" class="btn btn-icon btn-success"><em class="icon ni ni-file-xls"></em> Unduh Excel </a>
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
                                                    <th>No</th>
                                                    <th>ID Barang</th>
                                                    <th>Nama Barang</th>
                                                    <th>Jenis Barang</th>
                                                    <th>Satuan</th>
                                                    <th>Stok Awal</th>
                                                    <th>Stok</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                <?php foreach ($barang as $s) : ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $s['id_barang'] ?></td>
                                                        <td><?= $s['nama_barang'] ?></td>
                                                        <td><?= $s['nama_jenis'] ?></td>
                                                        <td><?= $s['nama_satuan'] ?></td>
                                                        <td><?= $s['stok_awal'] ?? '0' ?></td>
                                                        <td><?= $s['stok'] ?? '0' ?></td>
                                                        <td>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li>
                                                                            <a data-bs-toggle="modal" href="#gambar<?= $s['id_barang'] ?>" class="text-success"><em class="icon ni ni-eye"></em><span>Lihat Gambar</span>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a data-bs-toggle="modal" href="#edit<?= $s['id_barang'] ?>" class="text-primary"><em class="icon ni ni-edit"></em><span>Edit</span>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barang/delete/') . $s['id_barang'] ?>" class="text-danger"><em class="icon ni ni-trash"></em><span>Delete</span>
                                                                            </a>
                                                                        </li>
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
                <?= form_open_multipart('', [], ['stok' => 0]); ?>
                <div class="row g-gs">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="room-no-add">ID Barang</label>
                            <input type="text" class="form-control" name="id_barang" id="id_barang" placeholder="Masukan ID barang">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="room-no-add">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama barang" value="<?= set_value('nama_barang') ?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="room-no-add">Satuan barang</label>
                            <select name="id_satuan" id="satuan" class="form-select js-select2 js-select2-sm">
                                <option selected disabled>Pilih Jenis Barang</option>
                                <?php foreach ($satuan as $s) : ?>
                                    <option <?= set_select('id_satuan', $s['id']) ?> value="<?= $s['id'] ?>"><?= $s['nama_satuan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p><a href="<?= site_url('satuan') ?>">+ Add Satuan Barang</a></p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="room-no-add">Jenis barang</label>
                            <select name="id_jenis" id="id_jenis" class="form-select js-select2 js-select2-sm">
                                <option selected disabled>Pilih Jenis Barang</option>
                                <?php foreach ($jenis as $key) : ?>
                                    <option <?= set_select('id_jenis', $key['id']) ?> value="<?= $key['id'] ?>"><?= $key['nama_jenis'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p><a href="<?= site_url('jenis') ?>">+ Add Jenis Barang</a></p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="stok_awal">Stok</label>
                            <input type="text" class="form-control" name="stok_awal" id="stok_awal" placeholder="Stok Awal" value="<?= set_value('stok_awal', 0) ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label">Upload Gambar</label>
                            <div class="form-control-wrap">
                                <div class="form-file">
                                    <input type="file" class="form-file-input" id="image" name="image">
                                    <label class="form-file-label" for="customFile">Choose foto</label>
                                    <p class="text-orange"><em>Maximal upload 2 MB & Format JPG, PNG.</em></p>
                                </div>
                            </div>
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
<?php foreach ($barang as $b) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="edit<?= $b['id_barang'] ?>">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-md">
                    <h5 class="modal-title">Edit barang</h5>
                    <?= form_open_multipart('barang/edit', [], ['stok' => 0, 'id_barang' => $b['id_barang']]); ?>
                    <div class="row g-gs">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="room-no-add">Nama Barang</label>
                                <input type="text" class="form-control" value="<?= $b['nama_barang'] ?>" name="nama_barang" id="nama_barang" placeholder="Nama barang">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="room-no-add">Satuan barang</label>
                                <select name="id_satuan" id="satuan" class="form-select js-select2 js-select2-sm">
                                    <option selected disabled>Pilih Satuan Barang</option>
                                    <?php foreach ($satuan as $s) : ?>
                                        <option <?= $b['id_satuan'] == $s['id'] ? 'selected' : '' ?> value="<?= $s['id']; ?>"><?= $s['nama_satuan']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <p><a href="<?= site_url('satuan') ?>">+ Add Jenis Barang</a></p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
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
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="room-no-add">Stok Awal</label>
                                <input type="text" class="form-control" value="<?= $b['stok_awal'] ?>" name="stok_awal" id="rupiah-edit" placeholder="123456789">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label">Upload Gambar</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" class="form-file-input" id="image" name="image">
                                        <label class="form-file-label" for="customFile">Choose foto</label>
                                        <p class="text-orange"><em>Maximal upload 2 MB & Format JPG, PNG.</em></p>
                                    </div>
                                </div>
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

<!-- Edit Room-->
<?php foreach ($barang as $b) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="gambar<?= $b['id_barang'] ?>">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-md">
                    <h5 class="modal-title">Gambar barang</h5>
                    <div class="row g-gs">
                        <div class="col">
                            <div class="form-group">
                                <img src="<?= base_url('assets/images/barang/') . $b['image'] ?>" style="width: auto; height: 100%">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <a href="#" class="link" data-bs-dismiss="modal">Cancel</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->
<?php endforeach; ?>