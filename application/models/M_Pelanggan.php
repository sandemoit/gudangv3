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

    public function getTrx($limit = null, $id_barang = null)
    {
        $this->db->select('*');
        $this->db->join('barang', 'barang_keluar.barang_id = barang.id_barang');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = barang_keluar.pelanggan_id');
        $this->db->where('barang_keluar.pelanggan_id IS NOT NULL');

        if ($id_barang) {
            $this->db->where('barang_keluar.id_barang', $id_barang);
        }

        $this->db->order_by('barang_keluar.tanggal_keluar', 'desc');
        $query = $this->db->get('barang_keluar', $limit);
        return $query->result_array();
    }
}
