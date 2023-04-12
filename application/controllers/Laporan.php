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
    }

    public function databarang()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Laporan';
        $data['setting'] = $this->Other_model->getSetting();
        $data['barang'] = $this->Admin_model->getBarang();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar', $data);
        $this->load->view('laporan/databarang', $data);
        $this->load->view('template/footer');
    }

    public function cetak_data_barang()
    {
        $this->load->model('Admin_model');
        $barang = $this->Admin_model->getBarang();

        if (!$barang) {
            set_pesan('Gagal mengambil data dari database.', FALSE);
            redirect('laporan/databarang');
        }

        if (!$this->load->library('Dompdf_gen')) {
            set_pesan('Pustaka Dompdf tidak diinstal atau dimuat dengan benar.', FALSE);
            redirect('laporan/databarang');
        }

        $pdf = new Dompdf\Dompdf();
        $this->$pdf->setPaper('A4', 'portrait');
        $this->$pdf->filename = "laporan-petanikode.pdf";
        $this->$pdf->load_view('laporan/cetak_databarang', ['barang' => $barang]);

        $this->$pdf->stream();
    }

    public function trxbarangmasuk()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Laporan';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar', $data);
        $this->load->view('laporan/trxbarangmasuk', $data);
        $this->load->view('template/footer');
    }

    public function cetak_trxbarangmasuk()
    {
        // Load model untuk mengambil data

    }

    public function trxbarangkeluar()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Laporan';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar', $data);
        $this->load->view('laporan/trxbarangkeluar', $data);
        $this->load->view('template/footer');
    }

    public function cetak_trxbarangkeluar()
    {
        // Load model untuk mengambil data

    }
}
