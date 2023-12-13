$(document).ready(function () {
    const barangIdSelect = document.getElementById('barang_id');

    function onScanSuccess(decodedText) {
        const option = Array.from(barangIdSelect.options).find(option => option.value === decodedText);

        if (option) {
            option.selected = true;
        } else {
            console.warn(`ID Barang ${decodedText} tidak ditemukan dalam pilihan.`);
        }
    }

    function onScanFailure(error) {
        console.warn(`Gagal membuka kamera: ${error}`);
        alert(`Gagal membuka kamera: ${error}`);
    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: 300 },
        { facingMode: "environment" }
    );

    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
});
