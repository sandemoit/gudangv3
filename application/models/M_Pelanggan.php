<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Pelanggan extends CI_Model
{
    public function get($table, $data = null, $where = null)
    {
        if ($data != null) {
            return $this->db->get_where($table, $data)->row_array();
        } else {
            return $this->db->get_where($table, $where)->result_array();
        }
    }

    public function insert($table, $data, $batch = false)
    {
        return $batch ? $this->db->insert_batch($table, $data) : $this->db->insert($table, $data);
    }

    public function update($table, $pk, $id, $data)
    {
        $this->db->where($pk, $id);
        return $this->db->update($table, $data);
    }

    public function delete($table, $pk, $id)
    {
        return $this->db->delete($table, [$pk => $id]);
    }

    public function get_by_id($table, $primary_key, $id)
    {
        $this->db->where($primary_key, $id);
        $query = $this->db->get($table);

        // Check if there is a matching record
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
}
