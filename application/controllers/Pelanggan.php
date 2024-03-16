<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;

class Pelanggan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('M_Pelanggan', 'pelanggan');
        $this->load->model('Admin_model', 'admin');
        $this->load->model('Other_model');
    }

    public function index()
    {
        $data['title'] = 'Data Pelanggan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['pelanggan'] = $this->pelanggan->get('pelanggan');

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', ['required' => 'Nama tidak boleh kosong']);
        $this->form_validation->set_rules('kode_toko', 'Kode Toko', 'required|trim', ['required' => 'Kode Toko tidak boleh kosong']);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim', ['required' => 'Alamat tidak boleh kosong']);

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar');
            $this->load->view('master/pelanggan/data');
            $this->load->view('template/footer');
        } else {
            $save = [
                'nama' => $this->input->post('nama', true),
                'kode_toko' => $this->input->post('kode_toko', true),
                'alamat' => $this->input->post('alamat', true),
            ];

            $this->pelanggan->insert('pelanggan', $save);
            set_pesan('Data Pelanggan Berhasil ditambah.');

            redirect('pelanggan');
        }
    }

    public function edit($id)
    {
        $nama = $this->input->post('nama', true);
        $kode_toko = $this->input->post('kode_toko', true);
        $alamat = $this->input->post('alamat', true);

        if (empty($nama) || empty($kode_toko) || empty($alamat)) {
            set_pesan('Semua kolom harus diisi.', false);
        } else {
            $save = [
                'nama' => $nama,
                'kode_toko' => $kode_toko,
                'alamat' => $alamat,
            ];

            $this->pelanggan->update('pelanggan', 'id_pelanggan', $id, $save);
            set_pesan('Data Pelanggan Berhasil diedit.');
        }

        redirect('pelanggan');
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        $existing_data = $this->pelanggan->delete('barang_keluar', 'id_bkeluar', $id);

        $keluar = $this->pelanggan->getKeluar($id);
        $path = FCPATH . 'assets/documents/no_surat/';
        $file = $keluar['no_surat'];
        $file_path = $path . $file;

        if (!$existing_data) {
            set_pesan('Nomor Transaksi tidak ditemukan.', false);
        } else {
            unlink($file_path);
            $this->pelanggan->delete('pelanggan', 'id_pelanggan', $id);
            set_pesan('Data Pelanggan Berhasil dihapus.');
        }

        redirect('pelanggan/trx');
    }

    public function trx()
    {
        $data['title'] = 'Transaksi Pelanggan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['transaksi'] = $this->pelanggan->getTrx();
        $data['pelanggan'] = $this->pelanggan->get('pelanggan');
        $data['barang'] = $this->db->get('barang')->result_array();

        $data['no_surat'] = 'SJ-' . random_string('numeric', 9);

        if ($this->input->post() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar');
            $this->load->view('transaksi/pelanggan/keluar');
            $this->load->view('template/footer');
        } else {
            $this->db->trans_begin();

            $barang_ids = $this->input->post('barang_id');
            $pelanggan_ids = $this->input->post('pelanggan_id');
            $jumlah_keluars = $this->input->post('jumlah_keluar');
            $id_users = $this->input->post('id_user');
            $no_surats = $this->input->post('no_surat');
            $tanggal_keluar = $this->input->post('tanggal_keluar');

            var_dump($barang_ids);
            var_dump($pelanggan_ids);
            var_dump($jumlah_keluars);
            var_dump($id_users);
            var_dump($no_surats);
            var_dump($tanggal_keluar);
            die;

            // no transaksi generate
            $kode = 'T-BK-' . date('dmY');
            $kode_terakhir = $this->admin->getMax('barang_keluar', 'id_bkeluar', $kode);
            if ($kode_terakhir) {
                $kode_tambah = substr($kode_terakhir, -4, 4);
                $kode_tambah++;
            } else {
                $kode_tambah = 1;
            }

            // Data transaksi yang akan dimasukkan
            $data = array();
            foreach ($barang_ids as $key => $barang_id) {
                $number = str_pad($kode_tambah, 4, '0', STR_PAD_LEFT);

                // Gunakan nomor yang telah dihasilkan untuk membuat ID unik
                $id_bkeluar = $kode . $number;

                $data[] = array(
                    'id_bkeluar' => $id_bkeluar[$key],
                    'id_user' => $id_users[$key],
                    'barang_id' => $barang_id,
                    'pelanggan_id' => $pelanggan_ids[$key],
                    'jumlah_keluar' => $jumlah_keluars[$key],
                    'no_surat' => $no_surats[$key],
                    'tanggal_keluar' => $tanggal_keluar[$key]
                );
            }

            // Masukkan data transaksi ke dalam tabel menggunakan insert_batch()
            $this->db->insert_batch('barang_keluar', $data);

            if ($this->db->trans_status() === false) {
                // Rollback transaksi jika terjadi kesalahan saat memasukkan data
                $this->db->trans_rollback();
                set_pesan('Gagal menyimpan data transaksi.', false);
            } else {
                // Commit transaksi jika semuanya berhasil
                $this->db->trans_commit();
                set_pesan('Data berhasil disimpan.');
            }
            redirect('pelanggan/trx');
        }
    }

    public function getstok($getKode)
    {
        $kode = encode_php_tags($getKode);
        $query = $this->admin->cekStok($kode);
        output_json($query);
    }

    public function sales($id)
    {
        $data['title'] = 'Sales Pelanggan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Periksa apakah ada input start_date dan end_date dari POST
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $data['pelanggan'] = $this->pelanggan->getDataPelanggan($id);
        $data['total_trx'] = $this->pelanggan->getTotalTrx($id, $start_date, $end_date);
        $data['sales'] = $this->pelanggan->getSales($start_date, $end_date, $id);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar');
        $this->load->view('master/pelanggan/sales');
        $this->load->view('template/footer');
    }

    public function salesChart($id)
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $data = $this->pelanggan->salesChart($id, $start_date, $end_date);

        output_json($data);
    }

    public function excel($id = null)
    {
        // Dapatkan nilai start_date dan end_date dari permintaan GET
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $start_date = isset($start_date) ? $start_date : null;
        $end_date = isset($end_date) ? $end_date : null;

        // Ambil data laporan dari model
        if ($start_date !== null && $end_date !== null) {
            $pelanggan = $this->pelanggan->getSales($start_date, $end_date, $id);
        } else {
            $pelanggan = $this->pelanggan->getAllLaporanData($id);
        }

        // Load library PHPSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Setel header kolom
        $headerColumns = ['No', 'ID Barang', 'Nama Barang', 'Jenis', 'Total', 'Tanggal Keluar'];
        foreach ($headerColumns as $key => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
            $sheet->setCellValue($column . '1', $header);

            // Terapkan gaya header
            $sheet->getStyle($column . '1')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'F0F0F0']
                ]
            ]);
        }

        // Isi data ke dalam Spreadsheet
        $row = 2;
        foreach ($pelanggan as $key => $item) {
            $sheet->setCellValue('A' . $row, $key + 1);
            $sheet->setCellValue('B' . $row, $item['kode_barang']);
            $sheet->setCellValue('C' . $row, $item['nama_barang']);
            $sheet->setCellValue('D' . $row, $item['nama_jenis']);
            $sheet->setCellValue('E' . $row, (!empty($item['jumlah_keluar'])) ? $item['jumlah_keluar'] : 0);
            $sheet->setCellValue('F' . $row, tanggal($item['tanggal_keluar']));

            // Terapkan gaya baris
            $style_row = [
                'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
                'borders' => [
                    'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
                ]
            ];
            $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($style_row);

            $row++;
        }

        // Set lebar kolom
        foreach (range('A', 'E') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Atur header untuk file Excel
        $filename = 'Laporan-pelanggan.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Simpan Spreadsheet ke file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');

        exit;
    }

    public function cetak($id)
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $start_date = isset($start_date) ? $start_date : null;
        $end_date = isset($end_date) ? $end_date : null;

        if ($start_date !== null && $end_date !== null) {
            $data['pelanggan'] = $this->pelanggan->getSales($start_date, $end_date, $id);
        } else {
            $data['pelanggan'] = $this->pelanggan->getAllLaporanData($id);
        }

        $data['title'] = 'Laporan Barang Keluar Pelanggan';
        $data['start_date'] = tanggal($start_date);
        $data['end_date'] = tanggal($end_date);

        $this->load->view('laporan/pelanggan/print', $data);
    }


    public function pdf($id)
    {
        // Ambil nilai dari form
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        // Setel ke null jika tidak terdefinisi
        $start_date = isset($start_date) ? $start_date : null;
        $end_date = isset($end_date) ? $end_date : null;

        // Ambil data berdasarkan rentang tanggal jika start_date dan end_date terdefinisi
        if ($start_date !== null && $end_date !== null) {
            $data['pelanggan'] = $this->pelanggan->getSales($start_date, $end_date, $id);
        } else {
            $data['pelanggan'] = $this->pelanggan->getAllLaporanData($id);
        }

        $data['title'] = 'Laporan Barang';
        $data['start_date'] = tanggal($start_date);
        $data['end_date'] = tanggal($end_date);

        // Load library DOMPDF
        $this->load->library('Dompdf_gen');

        // Set konten PDF
        $html = $this->load->view('laporan/pelanggan/pdf', $data, true);
        // Buat instance Dompdf
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        // (Optional) Atur konfigurasi PDF, misalnya ukuran kertas
        $dompdf->setPaper('A4', 'landscape');

        // Render PDF (output)
        $dompdf->render();

        // Stream PDF ke browser
        $dompdf->stream('laporan.pdf', array('Attachment' => 0));
    }
}
