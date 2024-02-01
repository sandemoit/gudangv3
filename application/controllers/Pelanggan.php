<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pelanggan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Other_model');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['setting'] = $this->Other_model->getSetting();
        $data['title'] = 'Data Pelanggan';

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar');
        $this->load->view('transaksi/pelanggan');
        $this->load->view('template/footer');
    }
}
