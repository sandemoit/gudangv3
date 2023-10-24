<!DOCTYPE html>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Laporan Barang</title>
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

    .total {
        background-color: #ddd;
        align-items: center;
        text-align: center;
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

    p {
        text-align: center;
        font-size: 16px;
    }

    .tanda-tangan h3 {
        font-size: 20px;
    }
</style>

<body>
    <h1>Laporan Data Barang</h1>
    <hr>
    <p>Tanggal di Cetak: <?= date('d-M-Y') ?></p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Barang</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Satuan</th>
                <th>Jenis Barang</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1 ?>
            <?php $total = 0; ?> <!-- Deklarasikan variabel $total di sini -->
            <?php foreach ($barang as $row) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['id_barang'] ?></td>
                    <td><?= $row['nama_barang'] ?></td>
                    <td><?= $row['stok'] ?></td>
                    <td><?= $row['nama_satuan'] ?></td>
                    <td><?= $row['nama_jenis'] ?></td>
                    <td>
                        <?php $angka = $row['harga'];
                        $rupiah = "Rp " . number_format($angka, 2, ',', '.');
                        echo $rupiah;
                        ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>