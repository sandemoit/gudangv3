// Button laporan
document.querySelectorAll('a[href="#"]').forEach(function(link) {
    link.addEventListener('click', handleClick);
});
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
    var pdfURL = 'laporan/pdf?start_date=' + startDate + '&end_date=' + endDate;

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
    var pdfURL = 'laporan/cetak?start_date=' + startDate + '&end_date=' + endDate;

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
    var excelURL = 'laporan/excel?start_date=' + startDate + '&end_date=' + endDate;

    // Arahkan pengguna ke URL untuk mengunduh file Excel
    window.location.href = excelURL;
}

function handleClick(event) {
    event.preventDefault(); // menghentikan proses default
    // Tambahkan logika tambahan di sini jika diperlukan
}