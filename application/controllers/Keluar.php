<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keluar extends CI_Controller
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
        $data['title'] = 'Barang Keluar';
        $data['setting'] = $this->Other_model->getSetting();
        $data['barangkeluar'] = $this->Admin_model->getBarangKeluar();
        $data['barang'] = $this->db->get('barang')->result_array();

        $this->form_validation->set_rules('tanggal_keluar', 'Tanggal keluar', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required|trim');
        $this->form_validation->set_rules('jumlah_keluar', 'Barang', 'required|trim');

        if ($this->form_validation->run() == false) {

            $kode = 'T-BK-' . date('dmY');
            $kode_terakhir = $this->Admin_model->getMax('barang_keluar', 'id_bkeluar', $kode);

            if ($kode_terakhir) {
                $kode_tambah = substr($kode_terakhir, -4, 4);
                $kode_tambah++;
            } else {
                $kode_tambah = 1;
            }

            $number = str_pad($kode_tambah, 4, '0', STR_PAD_LEFT);
            $data['id_bkeluar'] = $kode . $number;


            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('transaksi/barang_keluar/keluar', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'id_bkeluar' => $this->input->post('id_bkeluar'),
                'id_user' => $this->input->post('id_user'),
                'barang_id' => $this->input->post('barang_id'),
                'jumlah_keluar' => $this->input->post('jumlah_keluar'),
                'tanggal_keluar' => $this->input->post('tanggal_keluar')
            ];
            $this->db->insert('barang_keluar', $data);
            set_pesan('data berhasil disimpan.');
            redirect('keluar');
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        $this->Admin_model->delete('barang_keluar', 'id_bkeluar', $id);
        set_pesan('Data berhasil dihapus!');
        redirect('keluar');
    }
}
