<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Other_model');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Data Barang";
        $data['barang'] = $this->Admin_model->getBarang();
        $data['setting'] = $this->Other_model->getSetting();
        $data['jenis'] = $this->Admin_model->get('jenis');
        $data['satuan'] = $this->Admin_model->get('satuan');

        // Mengenerate ID Barang
        // $kode_terakhir = $this->Admin_model->getMax('barang', 'id_barang');
        // $kode_tambah = substr($kode_terakhir, -6, 6);
        // $kode_tambah++;
        // $number = str_pad($kode_tambah, 6, '0', STR_PAD_LEFT);
        // $data['id_barang'] = 'B' . $number;

        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('id_jenis', 'Jenis Barang', 'required');
        $this->form_validation->set_rules('id_satuan', 'Satuan Barang', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('template/topbar', $data);
            $this->load->view('master/barang', $data);
            $this->load->view('template/footer', $data);
        } else {
            $data = [
                'id_barang' => $this->input->post('id_barang', true),
                'nama_barang' => $this->input->post('nama_barang', true),
                'stok_awal' => $this->input->post('stok_awal', true),
                'stok' => $this->input->post('stok_awal', true),
                'id_jenis' => $this->input->post('id_jenis', true),
                'id_satuan' => $this->input->post('id_satuan', true)
            ];
            $insert = $this->Admin_model->insert('barang', $data);
            if ($insert) {
                set_pesan('data berhasil ditambah!');
            } else {
                set_pesan('data gagal ditambah!', false);
            }
            redirect('barang');
        }
    }

    public function edit()
    {
        $id = $this->input->post('id_barang');

        $data = [
            'nama_barang' => $this->input->post('nama_barang'),
            'id_jenis' => $this->input->post('id_jenis'),
            'stok_awal' => $this->input->post('stok_awal'),
            'id_satuan' => $this->input->post('id_satuan')
        ];

        $this->Admin_model->update('barang', 'id_barang', $id, $data);
        set_pesan('Data berhasil diubah!');
        redirect('barang');
    }

    public function delete($id)
    {
        $id = encode_php_tags($id);
        $this->Admin_model->delete('barang', 'id_barang', $id);
        set_pesan('Data berhasil dihapus!');
        redirect('barang');
    }

    public function getstok($getId)
    {
        $id = encode_php_tags($getId);
        $query = $this->admin->cekStok($id);
        output_json($query);
    }

    public function excel()
    {
        $dataBarang = $this->Other_model->getDataBarang();

        // Load library PHPSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Setel header kolom
        $headerColumns = ['No', 'ID Barang', 'Nama Barang', 'Jenis Barang', 'Satuan', 'Stok Awal', 'Stok'];
        foreach ($headerColumns as $key => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
            $sheet->setCellValue($column . '1', $header);

            // Terapkan gaya header
            $sheet->getStyle($column . '1')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'F0F0F0']
                ]
            ]);
        }

        // Isi data ke dalam Spreadsheet
        $row = 2;
        foreach ($dataBarang as $key => $item) {
            $sheet->setCellValue('A' . $row, $key + 1);
            $sheet->setCellValue('B' . $row, $item['id_barang']);
            $sheet->setCellValue('C' . $row, $item['nama_barang']);
            $sheet->setCellValue('D' . $row, $item['nama_jenis']);
            $sheet->setCellValue('E' . $row, $item['nama_satuan']);
            $sheet->setCellValue('F' . $row, $item['stok_awal']);
            $sheet->setCellValue('G' . $row, $item['stok']);

            // Terapkan gaya baris
            $style_row = [
                'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
                'borders' => [
                    'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
                ]
            ];
            $sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray($style_row);

            $row++;
        }

        // Tambahkan kolom total di bawah setiap kolom
        foreach (range('F', 'G') as $column) {
            $sheet->setCellValue($column . $row, "=SUM($column:$column$row)");
            $sheet->getStyle($column . $row)->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'F0F0F0']
                ]
            ]);

            // Tambahkan teks "TOTAL:" di samping kolom jumlah (G)
            if ($column == 'G') {
                $mergeRange = 'A' . $row . ':E' . $row;
                // Menggabungkan kolom
                $sheet->mergeCells($mergeRange);
                $sheet->setCellValue('A' . $row, 'TOTAL:');
                $sheet->getStyle('A' . $row)->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                    ],
                    'borders' => [
                        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['argb' => 'F0F0F0']
                    ]
                ]);
            }
        }

        // Terapkan gaya baris untuk kolom total
        $style_row = [
            'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];
        $sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray($style_row);

        // Set lebar kolom
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Atur header untuk file Excel
        $filename = 'data-barang.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Simpan Spreadsheet ke file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');

        exit;
    }


    // public function pdf()
    // {
    //     // Memanggil model untuk mendapatkan data laporan
    //     // $data['query'] = $this->Laporan_model->getLaporan($jenis_laporan, $tanggal_awal, $tanggal_akhir);

    //     // Load view untuk generate HTML
    //     $data['barang'] = $this->Admin_model->cetak();
    //     $html = $this->load->view('master/cetak', $data, true);

    //     // Buat instance Dompdf
    //     $dompdf = new Dompdf();

    //     // Load HTML ke Dompdf
    //     $dompdf->loadHtml($html);

    //     // Render HTML ke PDF
    //     $dompdf->render();

    //     // Set nama file PDF yang akan di-download
    //     $filename = 'laporan_data_barang.pdf';

    //     // Outputkan file PDF ke browser untuk di-download
    //     $dompdf->stream($filename, array('Attachment' => 0));
    // }
}
