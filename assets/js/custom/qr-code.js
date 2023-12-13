$(document).ready(function () {

    var barangId = document.getElementById('barang_id');

    function onScanSuccess(decodedText) {
        // Jika QR code cocok, cari elemen option dengan nilai sesuai dengan hasil pemindaian
        var option = $('#barang_id option[value="' + decodedText + '"]');

        // Periksa apakah option ditemukan
        if (option.length > 0) {
            // Pilih option yang sesuai
            option.prop('selected', true);
        } else {
            // Tampilkan pesan jika ID Barang tidak ditemukan
            console.warn('ID Barang ' + decodedText + ' Tidak Ditemukan');
        }
    }

    function onScanFailure(error) {
        console.warn(`ID Barang ${error} Tidak Ditemukan`);
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: 300 }
    );

    // Modifikasi untuk menggunakan kamera belakang
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
});