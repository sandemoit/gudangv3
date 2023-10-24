<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Other_model');
        $this->load->model('Laporan_model');
        $this->load->library('Dompdf_gen');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Laporan Barang Masuk';
        $data['setting'] = $this->Other_model->getSetting();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('template/footer');
    }

    public function generate()
    {
        // Ambil nilai dari form
        $jenis_laporan = $this->input->post('jenis_laporan');
        $tanggal_awal = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');

        // Query database sesuai dengan jenis laporan
        if ($jenis_laporan == 'Barang Masuk') {
            $query = $this->db->query("SELECT bm.*, b.* FROM barang_masuk bm
                            JOIN barang b ON bm.barang_id = b.id_barang
                            WHERE bm.tanggal_masuk BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
        } elseif ($jenis_laporan == 'Barang Keluar') {
            $query = $this->db->query("SELECT bk.*, b.* FROM barang_keluar bk
                            JOIN barang b ON bk.barang_id = b.id_barang
                            WHERE bk.tanggal_keluar BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
        } else {
            // Jenis laporan tidak valid, redirect atau berikan pesan error sesuai kebutuhan
            redirect('laporan/index');
            return;
        }

        // Memanggil model untuk mendapatkan data laporan
        // $data['query'] = $this->Laporan_model->getLaporan($jenis_laporan, $tanggal_awal, $tanggal_akhir);

        // Load view untuk generate HTML
        $data['jenis_laporan'] = $jenis_laporan;
        $data['query'] = $query;
        $html = $this->load->view('laporan/laporan', $data, true);

        // Buat instance Dompdf
        $dompdf = new Dompdf();

        // Load HTML ke Dompdf
        $dompdf->loadHtml($html);

        // Render HTML ke PDF
        $dompdf->render();

        // Set nama file PDF yang akan di-download
        $filename = 'laporan_' . $jenis_laporan . '.pdf';

        // Outputkan file PDF ke browser untuk di-download
        $dompdf->stream($filename, array('Attachment' => 0));
    }
}
