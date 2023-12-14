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

    public function getLaporanData($start_date = null, $end_date = null)
    {
        $this->db->select('barang.id_barang, nama_barang, stok_awal');
        $this->db->select('IFNULL(SUM(jumlah_masuk), 0) AS jumlah_masuk', FALSE);
        $this->db->select('IFNULL(SUM(jumlah_keluar), 0) AS jumlah_keluar', FALSE);

        $this->db->from('barang');
        $this->db->join('barang_masuk', 'barang.id_barang = barang_masuk.barang_id', 'left');
        $this->db->join('barang_keluar', 'barang.id_barang = barang_keluar.barang_id', 'left');

        if ($start_date && $end_date) {
            $this->db->group_start();
            $this->db->where('tanggal_masuk >=', $start_date);
            $this->db->where('tanggal_masuk <=', $end_date);
            $this->db->or_where('tanggal_keluar >=', $start_date);
            $this->db->where('tanggal_keluar <=', $end_date);
            $this->db->group_end();
        }

        $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");

        $this->db->group_by('barang.id_barang, nama_barang, stok_awal');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAllLaporanData()
    {
        $this->db->select('*');
        $this->db->from('barang');
        $this->db->join('barang_masuk', 'barang.id_barang = barang_masuk.barang_id', 'left');
        $this->db->join('barang_keluar', 'barang.id_barang = barang_keluar.barang_id', 'left');
        $this->db->group_by('barang.id_barang');  // Menghindari duplikasi data

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDataBarang()
    {

        $this->db->select('*');
        $this->db->from('barang');
        $this->db->join('jenis', 'barang.id_jenis = jenis.id', 'left');
        $this->db->join('satuan', 'barang.id_satuan = satuan.id', 'left');
        $this->db->group_by('barang.id_barang');  // Menghindari duplikasi data

        $query = $this->db->get();
        return $query->result_array();
    }
}
