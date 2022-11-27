<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangkeluar extends CI_Controller
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
        $data['barangkeluar'] = $this->Admin_model->getBarangKeluar();

        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required|trim');
        $this->form_validation->set_rules('supplier', 'Supplier', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required|trim');
        $this->form_validation->set_rules('jumlah_masuk', 'Barang', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('transaksi/barang_keluar/keluar', $data);
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
