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
                    <?= form_open(); ?>
                    <div class="card card-bordered card-preview col-md-6 ">
                        <div class="card-inner">
                            <div class="row form-group">
                                <label class="col-md-5 text-md-right form-label" for="transaksi">Laporan Transaksi</label>
                                <div class="col-md">
                                    <div class="custom-control custom-radio">
                                        <input value="barang_masuk" type="radio" id="barang_masuk" name="transaksi" class="custom-control-input">
                                        <label class="custom-control-label" for="barang_masuk">Barang Masuk</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input value="barang_keluar" type="radio" id="barang_keluar" name="transaksi" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio1">Barang Keluar</label>
                                    </div>
                                </div>
                                <?= form_error('transaksi', '<span class="text-danger small">', '</span>'); ?>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-5 text-md-right form-label" for="transaksi">Tanggal</label>
                                <div class="col-md">
                                    <div class="form-group">
                                        <div class="form-icon form-icon-right"><em class="icon ni ni-calendar-booking-fill"></em></div>
                                        <input value="<?= set_value('tanggal'); ?>" name="tanggal" id="tanggal" type="text" class="form-control" />
                                    </div>
                                </div>
                                <?= form_error('transaksi', '<span class="text-danger small">', '</span>'); ?>
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