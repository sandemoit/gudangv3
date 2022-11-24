<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
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

    // barang
    public function getBarang()
    {
        $this->db->join('jenis', 'barang.id_jenis = jenis.id');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id');
        $this->db->order_by('id_barang');
        return $this->db->get('barang')->result_array();
    }

    public function getMax($table, $field, $kode = null)
    {
        $this->db->select_max($field);
        if ($kode != null) {
            $this->db->like($field, $kode, 'after');
        }
        return $this->db->get($table)->row_array()[$field];
    }




    public function cekStok($id)
    {
        $this->db->join('satuan s', 'b.id_satuan=s.id');
        return $this->db->get_where('barang b', ['id' => $id])->row_array();
    }
}
