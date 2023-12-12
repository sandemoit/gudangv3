$('#filter').click(function() {
    var tanggalAwal = $('#tanggal_awal').val();
    var tanggalAkhir = $('#tanggal_akhir').val();

    $.ajax({
        url: 'laporan/filter',
        method: 'GET',
        data: {
            tanggalAwal: tanggalAwal,
            tanggalAkhir: tanggalAkhir
        },
        success: function(response) {
            // Proses data yang diterima dari server
            console.log(response);
        },
        error: function(xhr, status, error) {
            // Tangani kesalahan jika terjadi
            console.error(xhr.responseText);
        }
    });
});