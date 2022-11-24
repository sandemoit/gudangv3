<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Supplier';
        $data['supplier'] = $this->Admin_model->get('suplier');

        $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required|trim');
        $this->form_validation->set_rules('nohp', 'No Telphone', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('supplier/index', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'nama_supplier' => $this->input->post('nama_supplier'),
                'nohp' => $this->input->post('nohp'),
                'alamat' => $this->input->post('alamat'),
            ];
            $save = $this->Admin_model->insert('suplier', $data);
            if ($save) {
                set_pesan('data berhasil disimpan.');
                redirect('supplier');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('supplier');
            }
        }
    }
    public function edit()
    {
        $id = $this->input->post('id');
        $data['supplier'] = $this->Admin_model->get('suplier');

        $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required|trim');
        $this->form_validation->set_rules('nohp', 'No Telphone', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');

        $data = [
            'nama_supplier' => $this->input->post('nama_supplier'),
            'nohp' => $this->input->post('nohp'),
            'alamat' => $this->input->post('alamat'),
        ];
        $this->Admin_model->update('suplier', 'id', $id, $data);
        set_pesan('data berhasil disimpan!');
        redirect('supplier');
    }

    public function delete($id)
    {
        $this->db->delete('suplier', ['id' => $id]);
        set_pesan('data berhasil dihapus!');
        redirect('supplier');
    }
}
