<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pelanggan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('M_Pelanggan', 'pelanggan');
        $this->load->model('Admin_model');
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

    public function trx()
    {
        $data['title'] = 'Transaksi Pelanggan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['setting'] = $this->db->get('setting')->row_array();
        $data['transaksi'] = $this->pelanggan->getTrx();
        $data['pelanggan'] = $this->pelanggan->get('pelanggan');
        $data['barang'] = $this->db->get('barang')->result_array();

        $this->form_validation->set_rules('tanggal_keluar', 'Tanggal keluar', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required|trim');
        $this->form_validation->set_rules('jumlah_keluar', 'Barang', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar');
            $this->load->view('transaksi/pelanggan/keluar');
            $this->load->view('template/footer');
        } else {
            // Cek stok barang sebelum memproses transaksi
            $barang_id = $this->input->post('barang_id');
            $pelanggan_id = $this->input->post('pelanggan_id');
            $jumlah_keluar = $this->input->post('jumlah_keluar');

            $stok_barang = $this->Admin_model->getStokBarang($barang_id);
            if ($stok_barang >= $jumlah_keluar) {
                // Jika stok mencukupi, lanjutkan transaksi
                $data = [
                    'id_bkeluar' => $this->input->post('id_bkeluar'),
                    'id_user' => $this->input->post('id_user'),
                    'barang_id' => $barang_id,
                    'pelanggan_id' => $pelanggan_id,
                    'jumlah_keluar' => $jumlah_keluar,
                    'tanggal_keluar' => $this->input->post('tanggal_keluar')
                ];
                $this->db->insert('barang_keluar', $data);
                set_pesan('Data berhasil disimpan.');
                redirect('pelanggan/trx');
            } else {
                // Jika stok tidak mencukupi, beri pesan kesalahan
                set_pesan('Stok barang tidak mencukupi.', false);
                redirect('pelanggan/trx');
            }
        }
    }

    public function sales($id)
    {
        $data['title'] = 'Sales Pelanggan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['setting'] = $this->db->get('setting')->row_array();
        $data['pelanggan'] = $this->pelanggan->getDataPelanggan($id);
        $data['sales'] = $this->pelanggan->getSales($id);
        $data['total_trx'] = $this->pelanggan->getTotalTrx($id);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar');
        $this->load->view('master/pelanggan/sales');
        $this->load->view('template/footer');
    }
}
