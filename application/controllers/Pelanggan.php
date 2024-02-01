<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pelanggan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('M_Pelanggan', 'pelanggan');
    }

    public function index()
    {
        $data['title'] = 'Data Pelanggan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['setting'] = $this->db->get('setting')->row_array();
        $data['pelanggan'] = $this->pelanggan->get('pelanggan');

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', ['required' => 'Nama tidak boleh kosong']);
        $this->form_validation->set_rules('kode_toko', 'Kode Toko', 'required|trim', ['required' => 'Kode Toko tidak boleh kosong']);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim', ['required' => 'Alamat tidak boleh kosong']);

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('master/pelanggan/data', $data);
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

    public function delete($id)
    {
        $existing_data = $this->pelanggan->get_by_id('pelanggan', 'id_pelanggan', $id);

        if (!$existing_data) {
            set_pesan('Data Pelanggan tidak ditemukan.', false);
        } else {
            $this->pelanggan->delete('pelanggan', 'id_pelanggan', $id);
            set_pesan('Data Pelanggan Berhasil dihapus.');
        }

        redirect('pelanggan');
    }
}
