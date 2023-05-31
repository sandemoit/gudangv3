<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Other_model');
        $this->load->library('CustomPDF');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Laporan Barang Masuk';
        $data['setting'] = $this->Other_model->getSetting();

        $this->form_validation->set_rules('transaksi', 'Transaksi', 'required|in_list[barang_masuk,barang_keluar]');
        $this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('laporan/index', $data);
            $this->load->view('template/footer');
        } else {
            $input = $this->input->post(null, true);
            $table = $input['transaksi'];
            $tanggal = $input['tanggal'];
            $pecah = explode(' - ', $tanggal);
            $mulai = date('Y-m-d', strtotime($pecah[0]));
            $akhir = date('Y-m-d', strtotime(end($pecah)));

            $query = '';
            if ($table == 'barang_masuk') {
                $query = $this->Admin_model->getBarangMasuk(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            } else {
                $query = $this->Admin_model->getBarangKeluar(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            }

            $this->_cetak($query, $table, $tanggal);
        }
    }

    private function _cetak($data, $table_, $tanggal)
    {
        $table = $table_ == 'barang_masuk' ? 'Barang Masuk' : 'Barang Keluar';

        $pdf = new FPDF();
        $pdf->AddPage('P', 'Letter');
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(190, 7, 'Laporan ' . $table, 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(190, 4, 'Tanggal : ' . $tanggal, 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);

        if ($table_ == 'barang_masuk') :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(25, 7, 'Tgl Masuk', 1, 0, 'C');
            $pdf->Cell(35, 7, 'ID Transaksi', 1, 0, 'C');
            $pdf->Cell(55, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(40, 7, 'Supplier', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Jumlah Masuk', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(25, 7, $d['tanggal_masuk'], 1, 0, 'C');
                $pdf->Cell(35, 7, $d['id_bmasuk'], 1, 0, 'C');
                $pdf->Cell(55, 7, $d['nama_barang'], 1, 0, 'L');
                $pdf->Cell(40, 7, $d['nama_supplier'], 1, 0, 'L');
                $pdf->Cell(30, 7, $d['jumlah_masuk'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
                $pdf->Ln();
            }
        else :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(25, 7, 'Tgl Keluar', 1, 0, 'C');
            $pdf->Cell(35, 7, 'ID Transaksi', 1, 0, 'C');
            $pdf->Cell(95, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Jumlah Keluar', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(25, 7, $d['tanggal_keluar'], 1, 0, 'C');
                $pdf->Cell(35, 7, $d['id_bkeluar'], 1, 0, 'C');
                $pdf->Cell(95, 7, $d['nama_barang'], 1, 0, 'L');
                $pdf->Cell(30, 7, $d['jumlah_keluar'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
                $pdf->Ln();
            }
        endif;

        $file_name = $table . ' ' . $tanggal;
        $pdf->Output('I', $file_name);
    }

    public function cetak_data_barang()
    {
        $this->load->model('Admin_model');
        $barang = $this->Admin_model->getBarang();

        if (!$barang) {
            set_pesan('Gagal mengambil data dari database.', FALSE);
            redirect('laporan');
        }

        if (!$this->load->library('Dompdf_gen')) {
            set_pesan('Pustaka Dompdf tidak diinstal atau dimuat dengan benar.', FALSE);
            redirect('laporan');
        }

        $pdf = new Dompdf\Dompdf();
        $this->$pdf->setPaper('A4', 'portrait');
        $this->$pdf->filename = "laporan-petanikode.pdf";
        $this->$pdf->load_view('laporan/cetak_databarang', ['barang' => $barang]);

        $this->$pdf->stream();
    }
}
