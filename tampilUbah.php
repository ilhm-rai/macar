<?php
include "koneksi.php";

$no_plat = $_GET['no_plat'];

$sql = "SELECT * FROM t_mobil_rizkyardi as mobil INNER JOIN t_jenis_rizkyardi as jenis ON mobil.id_jenis_rizkyardi=jenis.id_jenis_rizkyardi WHERE no_plat_rizkyardi='$no_plat'";

$result = mysqli_query($conn, $sql);
$data = array();
$car = mysqli_fetch_array($result);
$temp = array(
    "no_plat" => $car["no_plat_rizkyardi"],
    "nama_mobil" => $car["nama_mobil_rizkyardi"],
    "jenis" => $car["jenis_rizkyardi"],
    "id_jenis" => $car["id_jenis_rizkyardi"],
    "tahun" => $car["tahun_rizkyardi"],
    "cc" => $car["cc_rizkyardi"],
    "warna" => $car["warna_rizkyardi"],
    "foto" => $car["foto_rizkyardi"]
);

array_push($data, $temp);

$data = json_encode($data);

echo $data;
