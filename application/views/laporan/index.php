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
                    <?php echo form_open('laporan/generate'); ?>
                    <div class="card card-bordered card-preview col-md-6 ">
                        <div class="card-inner">
                            <div class="row form-group">
                                <div class="col-md">
                                    <div class="form-group"><label class="form-label">Tanggal Awal</label>
                                        <div class="form-control-wrap focused">
                                            <div class="form-icon form-icon-left"><em class="icon ni ni-calendar"></em></div>
                                            <input type="text" name="tanggal_awal" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                                        </div>
                                    </div>
                                </div>
                                <?= form_error('transaksi', '<span class="text-danger small">', '</span>'); ?>
                                <div class="col-md">
                                    <div class="form-group"><label class="form-label">Tanggal Akhir</label>
                                        <div class="form-control-wrap focused">
                                            <div class="form-icon form-icon-left"><em class="icon ni ni-calendar"></em></div>
                                            <input type="text" name="tanggal_akhir" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                                        </div>
                                    </div>
                                </div>
                                <?= form_error('transaksi', '<span class="text-danger small">', '</span>'); ?>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="room-no-add">Jenis Laporan</label>
                                <select name="jenis_laporan" required class="form-select js-select2 js-select2-sm">
                                    <option selected disabled>-- Pilih Jenis Laporan --</option>
                                    <option value="Barang Masuk">Barang Masuk</option>
                                    <option value="Barang Keluar">Barang Keluar</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-icon btn-primary"><em class="icon ni ni-printer-fill"></em> Cetak</button>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>