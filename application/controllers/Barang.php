<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Data Barang";
        $data['barang'] = $this->Admin_model->getBarang();
        $data['jenis'] = $this->Admin_model->get('jenis');
        $data['satuan'] = $this->Admin_model->get('satuan');

        // Mengenerate ID Barang
        $kode_terakhir = $this->Admin_model->getMax('barang', 'id_barang');
        $kode_tambah = substr($kode_terakhir, -6, 6);
        $kode_tambah++;
        $number = str_pad($kode_tambah, 6, '0', STR_PAD_LEFT);
        $data['id_barang'] = 'B' . $number;

        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('id_jenis', 'Jenis Barang', 'required');
        $this->form_validation->set_rules('id_satuan', 'Satuan Barang', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('master/barang', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'id_barang' => $this->input->post('id_barang'),
                'nama_barang' => $this->input->post('nama_barang'),
                'id_jenis' => $this->input->post('id_jenis'),
                'id_satuan' => $this->input->post('id_satuan')
            ];
            $this->Admin_model->insert('barang', $data);
            set_pesan('data berhasil ditambah!');
            redirect('barang');
        }
    }

    public function edit()
    {
        $id = $this->input->post('id_barang');
        $data['barang'] = $this->Admin_model->get('barang', ['id_barang' => $id]);
        $data['jenis'] = $this->Admin_model->get('jenis');
        $data['satuan'] = $this->Admin_model->get('satuan');

        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('id_jenis', 'Jenis Barang', 'required');
        $this->form_validation->set_rules('id_satuan', 'Satuan Barang', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('master/barang', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'nama_barang' => $this->input->post('nama_barang'),
                'id_jenis' => $this->input->post('id_jenis'),
                'id_satuan' => $this->input->post('id_satuan')
            ];

            $this->Admin_model->update('barang', 'id_barang', $id, $data);
            set_pesan('Data berhasil diubah!');
            redirect('barang');
        }
    }

    public function delete($id)
    {
        $id = encode_php_tags($id);
        $this->Admin_model->delete('barang', 'id_barang', $id);
        set_pesan('Data berhasil dihapus!');
        redirect('barang');
    }

    public function getstok($getId)
    {
        $id = encode_php_tags($getId);
        $query = $this->admin->cekStok($id);
        output_json($query);
    }
}
