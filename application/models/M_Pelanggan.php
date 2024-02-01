<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Pelanggan extends CI_Model
{
    public function getPelanggan()
    {
        return $this->db->get('pelanggan')->result_array();
    }

    public function insert($table, $data, $batch = false)
    {
        return $batch ? $this->db->insert_batch($table, $data) : $this->db->insert($table, $data);
    }
}
