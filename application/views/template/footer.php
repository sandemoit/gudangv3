            <!-- footer @s -->
            <div class="nk-footer">
                <div class="container-fluid">
                    <div class="nk-footer-wrap">
                        <div class="nk-footer-copyright"> &copy; <?= date('Y') ?> <a href="<?= site_url('/') ?>" target="_blank"><?= $setting['nama_aplikasi'] ?></a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
            </div>
            <script src="<?= base_url('assets') ?>/js/bundle.js?ver=3.0.3"></script>
            <script src="<?= base_url('assets') ?>/js/scripts.js?ver=3.0.3"></script>
            <script src="<?= base_url('assets') ?>/js/charts/gd-default.js?ver=3.0.3"></script>
            <!-- Menggunakan versi di-host (CDN) -->
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
            <script>
                const baseurl = '<?= base_url() ?>';
                const segment = '<?= $this->uri->segment(1); ?>';
            </script>
            <script type="text/javascript">
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 5000);
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/2.0.0-rc.4/instascan.min.js"></script>
            <script src="<?= base_url('assets') ?>/js/custom/scanqr.js"></script>
            <!-- <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
            <script src="<?= base_url('assets') ?>/js/custom/qr-code.js"></script> -->
            <script src="<?= base_url('assets') ?>/js/custom/laporan.js"></script>
            <script src="<?= base_url('assets') ?>/js/custom/count-stok.js"></script>

            </body>

            </html>