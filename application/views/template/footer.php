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
            <script>
                $(document).ready(function() {

                    let scanned = '';

                    setInterval(function() {
                        var date = new Date();
                        var h = date.getHours(),
                            m = date.getMinutes(),
                            s = date.getSeconds();
                        h = ("0" + h).slice(-2);
                        m = ("0" + m).slice(-2);
                        s = ("0" + s).slice(-2);

                        var time = h + ":" + m + ":" + s;
                        $('.live-clock').html(time);
                    }, 1000);

                    function onScanSuccess(decodedText) {
                        if (scanned !== decodedText) {
                            scanned = decodedText;
                            $.ajax({
                                type: 'post',
                                url: '/siswa/validate_qrcode',
                                data: {
                                    scanned
                                },
                                success: function(result) {
                                    // script here if success
                                    result = JSON.parse(result);

                                    let today = new Date();
                                    let dd = String(today.getDate()).padStart(2, '0');
                                    let mm = String(today.getMonth() + 1).padStart(2, '0');
                                    let yyyy = today.getFullYear();
                                    let hh = String(today.getHours()).padStart(2, '0');
                                    let ii = String(today.getMinutes()).padStart(2, '0');
                                    let ss = String(today.getSeconds()).padStart(2, '0');
                                    let waktu = `${dd}-${mm}-${yyyy} ${hh}:${ii}:${ss}`;

                                    if (result.result == 'ngawur') {
                                        $('#notif').show().removeClass('alert-success').addClass('alert-danger').html("Materi pembelajaran tidak diketahui.");
                                    } else if (result.result == true) {
                                        $('#notif').show().removeClass('alert-danger').addClass('alert-success').html("Terimakasih telah melakukan absen pada " + waktu);
                                    } else {
                                        $('#notif').show().removeClass('alert-success').addClass('alert-danger').html("Anda sudah melakukan absen.");
                                    }

                                    $('#mapel').html(result.data.mapel);
                                    $('#guru').html(result.data.guru);
                                }
                            });
                        }
                    }

                    var html5QrcodeScanner = new Html5QrcodeScanner(
                        "reader", {
                            fps: 10,
                            qrbox: 300
                        }
                    );
                    html5QrcodeScanner.render(onScanSuccess);
                });
            </script>
            <script src="<?= base_url('assets') ?>/js/custom/qr-code.js"></script>
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