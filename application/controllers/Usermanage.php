<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usermanage extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
    }
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'User Management';
        $data['userm'] = $this->Admin_model->get('user');
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar', $data);
        $this->load->view('other/usermanage', $data);
        $this->load->view('template/footer');
    }
}
