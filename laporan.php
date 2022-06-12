<?php
include "koneksi.php";
require_once("fpdf/fpdf.php");

class PDF extends FPDF
{

    function header()
    {
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(51, 122, 183);
        $this->Cell(30);
        $this->Cell(140, 9, 'MACAR AUTO', 0, 1, 'C');

        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0);
        $this->Cell(30);
        $this->Cell(140, 5, 'KANTOR PUSAT: JL RE MARTADINATA NO 272 A LANTAI 3', 0, 1, 'C');
        $this->Cell(30);
        $this->Cell(140, 5, 'TELP/FAX: (0265) 310830 - TASIKMALAYA - INDONESIA', 0, 1, 'C');

        // Menambahkan Gari Header
        $this->SetLineWidth(1);
        $this->Line(10, 36, 200, 36);
        $this->SetLineWidth(0);
        $this->Line(10, 37, 200, 37);
        $this->Ln();
    }

    function footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();

//tampilkan judul laporan
$pdf->Cell(0, 20, 'LAPORAN DATA MOBIL', '0', 1, 'C');
$pdf->SetFont('Arial', 'B', '11');

// Membuat kolom judul tabel
$pdf->SetFont('Arial', '', '11');
$pdf->SetFillColor(51, 122, 183);
$pdf->SetTextColor(255);
$pdf->Cell(30, 7, 'Plat Nomor', 0, '0', 'C', true);
$pdf->Cell(50, 7, 'Nama Mobil', 0, '0', 'C', true);
$pdf->Cell(20, 7, 'Jenis', 0, '0', 'C', true);
$pdf->Cell(20, 7, 'Tahun', 0, '0', 'C', true);
$pdf->Cell(20, 7, 'CC', 0, '0', 'C', true);
$pdf->Cell(20, 7, 'Warna', 0, '0', 'C', true);
$pdf->Cell(30, 7, 'Gambar', 0, '0', 'C', true);
$pdf->Ln();

$tampil = mysqli_query($conn, "SELECT * FROM t_mobil_rizkyardi as mobil INNER JOIN t_jenis_rizkyardi as jenis ON mobil.id_jenis_rizkyardi=jenis.id_jenis_rizkyardi ORDER BY nama_mobil_rizkyardi ASC");
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0);
while ($data = mysqli_fetch_array($tampil)) {
    $pdf->Cell(30, 30, $data['no_plat_rizkyardi'], 1, '0', 'C', true);
    $pdf->Cell(50, 30, $data['nama_mobil_rizkyardi'], 1, '0', 'C', true);
    $pdf->Cell(20, 30, $data['jenis_rizkyardi'], 1, '0', 'C', true);
    $pdf->Cell(20, 30, $data['tahun_rizkyardi'], 1, '0', 'C', true);
    $pdf->Cell(20, 30, $data['cc_rizkyardi'], 1, '0', 'C', true);
    $pdf->Cell(20, 30, $data['warna_rizkyardi'], 1, '0', 'C', true);
    $pdf->Cell(30, 30, $pdf->Image('assets/img/' . $data['foto_rizkyardi'], $pdf->GetX(), $pdf->GetY(), 30), 1, '0', 'C', false);

    $pdf->Ln();
}

// Menampilkan output file PDF
$pdf->Output('i', 'Laporan Data Mobil.pdf', 'false');
