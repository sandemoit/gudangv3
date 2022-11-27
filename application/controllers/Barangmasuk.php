<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangmasuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Barang Masuk';
        $data['barangmasuk'] = $this->Admin_model->getBarangMasuk();

        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required|trim');
        $this->form_validation->set_rules('supplier', 'Supplier', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required|trim');
        $this->form_validation->set_rules('jumlah_masuk', 'Barang', 'required|trim');

        if ($this->form_validation->run() == false) {
            // mendapatkan menggenerate otomatis kode transaksi
            $kode = 'T-BM-' . date('ymd');
            $kode_terakhir = $this->Admin_model->getMax('barang_masuk', 'id_bmasuk', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['id_bmasuk'] = $kode . $number;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('transaksi/barang_masuk/masuk', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'tanggal_masuk' => $this->input->post('tanggal_masuk'),
                'supplier' => $this->input->post('supplier'),
                'barang_id' => $this->input->post('barang_id'),
                'jumlah_masuk' => $this->input->post('jumlah_masuk')
            ];
            $this->db->insert('barang_masuk', $data);
            set_pesan('data berhasil disimpan.');
            redirect('barangmasuk');
        }
    }
}
