$(document).ready(function () {
    const barangIdSelect = document.getElementById('barang_id');

    function onScanSuccess(decodedText) {
        const option = Array.from(barangIdSelect.options).find(option => option.value === decodedText);

        if (option) {
            option.selected = true;
        } else {
            console.warn('ID Barang ' + decodedText + ' Tidak Ditemukan');
        }
    }

    function onScanFailure(error) {
        console.warn(`${error}`);
    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: 300 },
        { facingMode: "environment" }
    );

    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
});
