<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Other_model');
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Barang Masuk';
        $data['setting'] = $this->Other_model->getSetting();
        $data['barangmasuk'] = $this->Admin_model->getBarangMasuk();
        $data['supplier'] = $this->db->get('suplier')->result_array();
        $data['barang'] = $this->db->get('barang')->result_array();

        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required|trim');
        $this->form_validation->set_rules('id_supplier', 'Supplier', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required|trim');
        $this->form_validation->set_rules('jumlah_masuk', 'Barang', 'required|trim|numeric|greater_than[0]');

        if ($this->form_validation->run() == false) {
            // mendapatkan menggenerate otomatis kode transaksi
            // $kode = 'T-BM-' . date('dmY');
            // $kode_terakhir = $this->Admin_model->getMax('barang_masuk', 'id_bmasuk', $kode);
            // if ($kode_terakhir) {
            //     $kode_tambah = substr($kode_terakhir, -4, 4);
            //     $kode_tambah++;
            // } else {
            //     $kode_tambah = 1;
            // }
            // $number = str_pad($kode_tambah, 4, '0', STR_PAD_LEFT);
            // $data['id_bmasuk'] = $kode . $number;


            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('transaksi/barang_masuk/masuk', $data);
            $this->load->view('template/footer', $data);
        } else {
            $data = [
                'id_bmasuk' => $this->input->post('id_bmasuk'),
                'tanggal_masuk' => $this->input->post('tanggal_masuk'),
                'id_supplier' => $this->input->post('id_supplier'),
                'id_user' => $this->input->post('id_user'),
                'barang_id' => $this->input->post('barang_id'),
                'jumlah_masuk' => $this->input->post('jumlah_masuk')
            ];
            $this->db->insert('barang_masuk', $data);
            set_pesan('Data berhasil disimpan.');
            redirect('masuk');
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        $this->Admin_model->delete('barang_masuk', 'id_bmasuk', $id);
        set_pesan('Data berhasil dihapus!');
        redirect('masuk');
    }
}
