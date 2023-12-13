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
            <script src="https://unpkg.com/html5-qrcode"></script>
            <script src="<?= base_url('assets') ?>/js/custom/qr-code.js"></script>
            <script src="<?= base_url('assets') ?>/js/custom/laporan.js"></script>
            <script type="text/javascript">
                /* Rupiah Edit*/
                var tanpa_rupiah = document.getElementById('rupiah-edit');
                tanpa_rupiah.addEventListener('keyup', function(e) {
                    tanpa_rupiah.value = formatRupiah(this.value);
                });

                /* Rupiah */
                var dengan_rupiah = document.getElementById('rupiah');
                dengan_rupiah.addEventListener('keyup', function(e) {
                    dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
                });

                /* Fungsi */
                function formatRupiah(angka, prefix) {
                    var number_string = angka.replace(/[^,\d]/g, '').toString(),
                        split = number_string.split(','),
                        sisa = split[0].length % 3,
                        rupiah = split[0].substr(0, sisa),
                        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }

                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                }
            </script>
            <script type="text/javascript">
                // hitung stok
                let page = '<?= $this->uri->segment(1); ?>';

                let satuan = $('#satuan');
                let stok = $('#stok');
                let total = $('#total_stok');
                let jumlah = page == 'barangmasuk' ? $('#jumlah_masuk') : $('#jumlah_keluar');

                $(document).on('change', '#barang_id', function() {
                    let stok = $(this).find(':selected').data('stok');

                    $('#stok').val(stok);
                });

                $(document).on('keyup', '#jumlah_masuk', function() {
                    let totalStok = parseInt(stok.val()) + parseInt(this.value);
                    total.val(Number(totalStok));
                });

                $(document).on('keyup', '#jumlah_keluar', function() {
                    let totalStok = parseInt(stok.val()) - parseInt(this.value);
                    total.val(Number(totalStok));
                });
            </script>
            <script type="text/javascript">
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 5000);
            </script>
            </body>

            </html>