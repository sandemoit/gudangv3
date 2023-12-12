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
            <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>

            <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
            <script>
                let scanner;

                // Fungsi untuk membuka modalL
                function openModal() {
                    scanner = new Instascan.Scanner({
                        video: document.getElementById('preview')
                    });

                    Instascan.Camera.getCameras().then(function(cameras) {
                        if (cameras.length > 0) {
                            scanner.start(cameras[0]);
                        } else {
                            alert('Camera tidak di temukan');
                        }
                    }).catch(function(e) {
                        console.error(e);
                    });

                    scanner.addListener('scan', function(content) {
                        // Set nilai input ID Barang dengan hasil pemindaian QR code
                        document.getElementById('barang_id').value = content;

                        // Cari elemen option dengan nilai sesuai dengan hasil pemindaian
                        let option = $('#barang_id option[value="' + content + '"]');

                        // Periksa apakah option ditemukan
                        if (option.length > 0) {
                            // Pilih option yang sesuai
                            option.prop('selected', true);
                        } else {
                            // Tampilkan pesan jika ID Barang tidak ditemukan
                            alert('ID Barang tidak ditemukan: ' + content);
                        }

                        // Sembunyikan modal QR Code Scanner (ganti dengan id modal yang benar)
                        $('#modal').modal('hide');
                    });
                }

                // Fungsi untuk menutup modal
                function closeModal() {
                    // Hentikan pemindaian kamera
                    if (scanner) {
                        scanner.stop();
                    }
                }

                // Fungsi untuk mengatasi perubahan halaman atau penutupan modal
                window.addEventListener('beforeunload', function() {
                    // Hentikan pemindaian kamera saat meninggalkan halaman
                    if (scanner) {
                        scanner.stop();
                    }
                });
            </script>

            <script>
                function resetDates() {
                    document.getElementsByName('start_date')[0].value = '';
                    document.getElementsByName('end_date')[0].value = '';
                    document.getElementById('filterForm').submit();
                }

                function printData() {
                    window.print();
                }

                function generatePDF() {
                    // Dapatkan nilai start_date dan end_date dari formulir
                    var startDate = document.getElementsByName("start_date")[0].value;
                    var endDate = document.getElementsByName("end_date")[0].value;

                    // Jika tanggal tidak diisi, setel nilai default ke kosong atau nilai yang sesuai
                    startDate = startDate.trim() !== '' ? startDate : '';
                    endDate = endDate.trim() !== '' ? endDate : '';

                    // Buat URL dengan parameter GET
                    var pdfURL = '<?= site_url('laporan/pdf') ?>?start_date=' + startDate + '&end_date=' + endDate;

                    // Arahkan pengguna ke URL
                    window.location.href = pdfURL;
                }

                function generateCetak() {
                    // Dapatkan nilai start_date dan end_date dari formulir
                    var startDate = document.getElementsByName("start_date")[0].value;
                    var endDate = document.getElementsByName("end_date")[0].value;

                    // Jika tanggal tidak diisi, setel nilai default ke kosong atau nilai yang sesuai
                    startDate = startDate.trim() !== '' ? startDate : '';
                    endDate = endDate.trim() !== '' ? endDate : '';

                    // Buat URL dengan parameter GET
                    var pdfURL = '<?= site_url('laporan/cetak') ?>?start_date=' + startDate + '&end_date=' + endDate;

                    // Arahkan pengguna ke URL
                    window.location.href = pdfURL;
                }

                function downloadExcel() {
                    // Dapatkan nilai start_date dan end_date dari formulir atau tempat lain yang sesuai
                    var startDate = document.getElementsByName("start_date")[0].value;
                    var endDate = document.getElementsByName("end_date")[0].value;

                    // Jika tanggal tidak diisi, setel nilai default ke kosong atau nilai yang sesuai
                    startDate = startDate.trim() !== '' ? startDate : '';
                    endDate = endDate.trim() !== '' ? endDate : '';

                    // Buat URL dengan parameter GET
                    var excelURL = '<?= site_url('laporan/excel') ?>?start_date=' + startDate + '&end_date=' + endDate;

                    // Arahkan pengguna ke URL untuk mengunduh file Excel
                    window.location.href = excelURL;
                }

                function handleClick(event) {
                    event.preventDefault(); // menghentikan proses default
                    // Tambahkan logika tambahan di sini jika diperlukan
                }

                document.querySelectorAll('a[href="#"]').forEach(function(link) {
                    link.addEventListener('click', handleClick);
                });
            </script>
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
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 5000);
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
            </body>

            </html>