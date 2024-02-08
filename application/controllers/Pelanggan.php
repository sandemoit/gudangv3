<?php
defined('BASEPATH') or exit('No direct script access allowed');
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
        $path = FCPATH . 'assets/documents/surat_jalan/';
        $file = $keluar['surat_jalan'];
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

        $this->form_validation->set_rules('tanggal_keluar', 'Tanggal keluar', 'required|trim');
        $this->form_validation->set_rules('pelanggan_id', 'Pelanggan', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required|trim');
        $this->form_validation->set_rules('jumlah_keluar', 'Barang', 'required|trim');

        // no transaksi generate
        $kode = 'T-BK-' . date('dmY');
        $kode_terakhir = $this->admin->getMax('barang_keluar', 'id_bkeluar', $kode);
        if ($kode_terakhir) {
            $kode_tambah = substr($kode_terakhir, -4, 4);
            $kode_tambah++;
        } else {
            $kode_tambah = 1;
        }
        $number = str_pad($kode_tambah, 4, '0', STR_PAD_LEFT);
        $data['id_bkeluar'] = $kode . $number;

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar');
            $this->load->view('transaksi/pelanggan/keluar');
            $this->load->view('template/footer');
        } else {
            $barang_id = $this->input->post('barang_id');
            $noTransaksi = $this->input->post('id_bkeluar');
            $pelanggan_id = $this->input->post('pelanggan_id');
            $jumlah_keluar = $this->input->post('jumlah_keluar');

            // Cek stok barang sebelum memproses transaksi
            $stok_barang = $this->admin->getStokBarang($barang_id);
            if ($stok_barang >= $jumlah_keluar) {
                // Jika stok mencukupi, lanjutkan transaksi
                $data = [
                    'id_bkeluar' => $noTransaksi,
                    'id_user' => $this->input->post('id_user'),
                    'barang_id' => $barang_id,
                    'pelanggan_id' => $pelanggan_id,
                    'jumlah_keluar' => $jumlah_keluar,
                    'tanggal_keluar' => $this->input->post('tanggal_keluar')
                ];

                // surat jalan
                $config['upload_path'] = 'assets/documents/surat_jalan/';
                $config['allowed_types'] = 'pdf|xls|xlsx';
                $config['max_size'] = 2048;
                $config['file_name'] = $noTransaksi . '-' . date('Y-m-d');

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('surat_jalan')) {
                    $error = $this->upload->display_errors();
                    set_pesan($error, false);
                } else {
                    $file = $this->upload->data('file_name');
                    $this->db->set('surat_jalan', $file);
                }

                $this->db->insert('barang_keluar', $data);
                set_pesan('Data berhasil disimpan.');
            } else {
                // Jika stok tidak mencukupi, beri pesan kesalahan
                set_pesan('Stok barang tidak mencukupi.', false);
            }
            redirect('pelanggan/trx');
        }
    }

    public function sales($id)
    {
        $data['title'] = 'Sales Pelanggan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['pelanggan'] = $this->pelanggan->getDataPelanggan($id);
        $data['sales'] = $this->pelanggan->getSales($id);
        $data['total_trx'] = $this->pelanggan->getTotalTrx($id);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar');
        $this->load->view('master/pelanggan/sales');
        $this->load->view('template/footer');
    }

    public function salesChart($id)
    {
        $data = $this->pelanggan->salesChart($id);
        output_json($data);
    }

    public function filter()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Laporan Barang Masuk & Keluar';

        // Periksa apakah ada input start_date dan end_date dari POST
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $id = $this->input->post('id_pelanggan');

        // Panggil model untuk mendapatkan data laporan berdasarkan tanggal
        $data['total_trx'] = $this->pelanggan->getTotalTrx($id);
        $data['sales'] = $this->pelanggan->filterSalesPelanggan($start_date, $end_date, $id);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar');
        $this->load->view('master/pelanggan/sales');
        $this->load->view('template/footer');
    }
}
