<!DOCTYPE html>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>LAPORAN DATA BARANG</title>
</head>
<style>
    h1 {
        text-align: center;
    }

    hr {
        border: none;
        height: 2px;
        border-bottom: 2px solid black;
        margin: 20px 0;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #ddd;
    }

    tfoot td {
        font-weight: bold;
    }

    tfoot td:first-child {
        text-align: right;
    }

    .tanda-tangan {
        margin-top: 60px;
        margin-left: 70%;
        position: absolute;
        margin-bottom: 20px;
        text-align: center;
    }

    .tanda-tangan p {
        margin-bottom: 70px;
        font-size: 20px;
    }

    .tanda-tangan h3 {
        font-size: 20px;
    }
</style>

<body>
    <h1>Laporan Data Barang</h1>
    <hr>
    <table>
        <thead>
            <tr>
                <th>ID Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>001</td>
                <td>Barang 1</td>
                <td>10</td>
                <td>10000</td>
                <td>100000</td>
            </tr>
            <tr>
                <td>002</td>
                <td>Barang 2</td>
                <td>5</td>
                <td>15000</td>
                <td>75000</td>
            </tr>
            <tr>
                <td>003</td>
                <td>Barang 3</td>
                <td>8</td>
                <td>20000</td>
                <td>160000</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Total Harga</td>
                <td>335000</td>
            </tr>
        </tfoot>
    </table>
    <div class="tanda-tangan">
        <p>Palembang, <?= date('d M Y') ?></p>
        <h3><b><u>Sandi Maulidika</u></b></h3>
    </div>
    <script>
        window.print();
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>