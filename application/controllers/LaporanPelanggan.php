<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaporanPelanggan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Other_model', 'other');
    }

    public function index()

    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Laporan Pelanggan';
        $data['setting'] = $this->other->getSetting();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar', $data);
        $this->load->view('laporan/pelanggan', $data);
        $this->load->view('template/footer');
    }
}
