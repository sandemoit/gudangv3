$(document).ready(function () {
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
        console.warn(`Gagal membuka kamera: ${error}`);
        alert(`Gagal membuka kamera: ${error}`);
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: 300 },
        // Tambahkan konfigurasi untuk menggunakan kamera belakang
        { facingMode: "environment" }
    );

    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
});
