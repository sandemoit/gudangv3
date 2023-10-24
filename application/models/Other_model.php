<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Other_model extends CI_Model
{
    public function getSetting()
    {
        return $this->db->get('setting')->row_array();
    }

    public function updateSetting($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    public function getSettingById($where)
    {
        $this->db->where('id', $where);
        $query = $this->db->get('setting');
        return $query->row_array();
    }
}
