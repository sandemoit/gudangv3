<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{
    public function getLaporan($jenis_laporan, $tanggal_awal, $tanggal_akhir)
    {
        if ($jenis_laporan == 'Barang Masuk') {
            $this->db->select('barang_masuk.*, u.*, b.*');
            $this->db->join('user u', 'barang_masuk.id_user = u.id');
            $this->db->join('barang b', 'barang_masuk.barang_id = b.id_barang');
            $this->db->where('tanggal_masuk >=', $tanggal_awal);
            $this->db->where('tanggal_masuk <=', $tanggal_akhir);
            $this->db->order_by('tanggal_masuk', 'desc');
            $query = $this->db->get('barang_masuk');
            return $query->result();
        } elseif ($jenis_laporan == 'Barang Keluar') {
            $this->db->select('barang_keluar.*, u.*, b.*');
            $this->db->join('user u', 'barang_keluar.id_user = u.id');
            $this->db->join('barang b', 'barang_keluar.barang_id = b.id_barang');
            $this->db->where('tanggal_keluar >=', $tanggal_awal);
            $this->db->where('tanggal_keluar <=', $tanggal_akhir);
            $this->db->order_by('tanggal_keluar', 'desc');
            $query = $this->db->get('barang_keluar');
            return $query->result();
        } else {
            // Jenis laporan tidak valid, return null atau berikan pesan error sesuai kebutuhan
            return null;
        }
    }
}
