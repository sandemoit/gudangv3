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
                        </div><!-- .nk-block-between -->
                        <div class="nk-block-head-content">
                            <ul class="nk-block-tools g-3">
                                <li>
                                    <div class="drodown">
                                        <a href="<?= site_url('pelanggan') ?>" class="btn btn-icon btn-info"><em class="icon ni ni-plus"></em>Add Pelanggan</a>
                                        <a href="#add" class="btn btn-icon btn-primary" data-bs-toggle="modal"><em class="icon ni ni-plus"></em>Add <?= $title; ?></a>
                                    </div>
                                </li>
                            </ul>
                        </div><!-- .nk-block-head-content -->
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
                                                    <th>Tanggal Keluar</th>
                                                    <th>Nama Barang</th>
                                                    <th>Jumlah</th>
                                                    <th>Pelanggan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                <?php foreach ($transaksi as $bk) : ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $bk['id_bkeluar'] ?></td>
                                                        <td><?= tanggal($bk['tanggal_keluar'])  ?></td>
                                                        <td><?= $bk['nama_barang'] ?></td>
                                                        <td><?= $bk['jumlah_keluar'] ?></td>
                                                        <td><?= $bk['nama'] ?></td>
                                                        <td>
                                                            <div class="tb-odr-btns d-none d-md-inline">
                                                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('pelanggan/delete/') . $bk['id_bkeluar'] ?>" class="btn btn-sm btn-danger"><em class="icon ni ni-trash"></em>Delete</a>
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
<!-- Modal Content Code -->
<form role="form" id="myform" method="post" action="<?= site_url('pelanggan/trx') ?>">
    <?php if (isset($user)) : ?>
        <input type="hidden" id="id_user" value="<?= $user['id']; ?>">
    <?php endif ?>
    <div class="modal fade" tabindex="-1" id="add">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">Add <?= $title; ?></h5>
                </div>
                <div class="modal-body">
                    <p>No. Surat Jalan: <?= $no_surat; ?></p>
                    <input type="hidden" id="no_surat" value="<?= $no_surat; ?>">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="room-no-add">Pelanggan</label>
                                <select name="pelanggan_id" id="pelanggan_id" data-search="on" class="js-select2">
                                    <option selected disabled>Pilih Pelanggan</option>
                                    <?php foreach ($pelanggan as $value) : ?>
                                        <option value="<?= $value['id_pelanggan']; ?>"><?= $value['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="room-no-add">Tanggal keluar</label>
                                <input type="date" value="<?= set_value('tanggal_keluar', date('Y-m-d')); ?>" class="form-control" name="tanggal_keluar" id="tanggal_keluar" placeholder="Nama barang">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="room-no-add">Barang</label>
                                <select name="barang_id" id="barang_id" data-search="on" class="js-select2">
                                    <option selected disabled>Pilih Barang</option>
                                    <?php foreach ($barang as $b) : ?>
                                        <option data-stok="<?= $b['stok']; ?>" value="<?= $b['kode_barang']; ?>"><?= $b['kode_barang'] . ' | ' . $b['nama_barang']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <p><a href=" <?= site_url('barang') ?>">+ Add Barang</a></p>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-control-wrap">
                                        <label class="form-label" for="stok">Stok</label>
                                        <div class="input-group">
                                            <input readonly type="number" id="stok" class="form-control">
                                        </div>
                                    </div>
                                    <p id="stokWarning" class="text-warning"><i>Stok Hampir Habis!</i></p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label" for="jumlah_keluar">Jumlah Keluar</label>
                                        <div class="form-control-wrap">
                                            <div class="input-group">
                                                <input type="number" class="form-control" for="jumlah_keluar" name="jumlah_keluar" id="jumlah_keluar" value="1" min="1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="satuan">pcs</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-control-wrap">
                                        <label class="form-label" for="total_stok">Sisa Stok</label>
                                        <div class="input-group">
                                            <input readonly type="number" id="total_stok" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="addtoList" class="btn btn-sm btn-primary mt-4 mb-4"><em class="icon ni ni-plus-sm"></em> Tambah ke List</button>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <h6>List Barang Keluar</h6>
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <td>Barang</td>
                                        <td>Jumlah</td>
                                        <td>Aksi</td>
                                    </tr>
                                </thead>
                                <tbody id="list"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="scanner-container" class="d-none"><video id="scanner" class="scann__qr"></video></div>
                <div class="modal-footer bg-light">
                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                        <li>
                            <button class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                        </li>
                        <li>
                            <a href="#" class="link" data-bs-dismiss="modal">Cancel</a>
                        </li>
                        <!-- <li>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="cameraScanner">
                                <label class="custom-control-label" for="cameraScanner">Camera Scanner</label>
                            </div>
                        </li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    var n = 1;
    var ls = [];

    $('#addtoList').click(function() {
        var plg = $("#pelanggan_id").val();
        var brg = $("#barang_id").val();
        var sel = $("#barang_id").select2('data')[0]['text'];
        var jum = $("#jumlah_keluar").val();
        var iduser = $("#id_user").val();
        var tgl = $("#tanggal_keluar").val();
        var nosurat = $('#no_surat').val();

        if (plg == '' || plg == undefined || jum == '' || jum == undefined || brg == '' || brg == undefined) {
            alert('Isikan Barang dan Jumlah dengan benar.');
            return false;
        } else {
            var ch = ls.includes(brg);

            console.log(ch, ls);

            $.post(baseurl + 'pelanggan/getstok/' + brg, function(res, status) {
                var stok = parseInt(res.stok);

                if (stok < 0 || stok == null) {
                    stok = 0;
                }

                if (ch) {
                    var newJum = eval($('#jls-' + brg).val()) + eval(jum);

                    if (newJum > stok) {
                        alert('Maaf sisa stok tidak cukup : ' + stok);
                        return false;
                    } else {
                        $('#jls-' + brg).val(newJum);
                        $('#jtextls-' + brg).text(newJum);
                    }
                } else {
                    if (jum > stok) {
                        alert('Maaf sisa stok tidak cukup : ' + stok);
                        return false;
                    } else {
                        ls.push(brg);

                        var nr = `<tr id="trlist-${brg}">
                            <td>
                            <input type="date" hidden name="tanggal_keluar[${n}]" id="tls-${tgl}" value="${tgl}">
                            <input type="hidden" name="id_user[${n}]" id="ils-${iduser}" value="${iduser}">
                            <input type="hidden" name="no_surat[${n}]" id="nls-${nosurat}" value="${nosurat}">
                            <input type="hidden" name="pelanggan_id[${n}]" id="pls-${plg}" value="${plg}">
                            <input type="hidden" name="barang_id[${n}]" id="bls-${brg}" value="${brg}">
                            <input type="hidden" name="jumlah_keluar[${n}]" id="jls-${brg}" value="${jum}">
                            ${sel}
                            </td>
                            <td><span id="jtextls-${brg}">${jum}</span></td>
                            <td align="center"><button type="button" onclick="removeList('${brg}')" class="btn btn-sm btn-danger"><em class="icon ni ni-trash-alt"></em></button></td>
                            </tr>`;

                        $('#list').append(nr);
                        n++;
                    }
                }
                $('#jumlah').val('1');
                $('#barang').val(null).trigger('change');
            });
        }
    });

    function removeList(brg) {
        var brg = brg.toString();
        var posDel = $.inArray(brg, ls);

        ls.splice(posDel, 1);

        $(`#trlist-${brg}`).remove();
    };
</script>
<script src="<?= base_url('assets') ?>/js/custom/barang-keluar.js"></script>
<script src="<?= base_url('assets') ?>/js/custom/count-stok.js"></script>
<!-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script src="<?= base_url('assets') ?>/js/custom/scanqr.js"></script> -->