<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Export extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
    }

    public function export_data_barang()
    {

        // get data from model
        $data = $this->Admin_model->getBarang();

        // export data to Excel
        $filename = 'data-barang.xlsx';
        export_excel($filename, $data);

        // force download the file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        readfile($filename);
        exit;
    }
}
