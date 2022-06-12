<?php
include "koneksi.php";

$no_plat = $_GET['no_plat'];
$query = mysqli_query($conn, "SELECT foto_rizkyardi FROM t_mobil_rizkyardi WHERE no_plat_rizkyardi='$no_plat'");
$row = mysqli_fetch_array($query);

$hapus = mysqli_query($conn, "DELETE FROM t_mobil_rizkyardi WHERE no_plat_rizkyardi='$no_plat'");

$data = array();

if ($hapus > 0) {
    if ($row["foto_rizkyardi"] != 'icons8_camera_60px.png') unlink("assets/img/" . $row["foto_rizkyardi"]);
    $temp = array(
        "id_pesan" => 1,
        "pesan" => "Data berhasil dihapus."
    );
    array_push($data, $temp);
} else {
    $temp = array(
        "id_pesan" => 0,
        "pesan" => "Data gagal dihapus."
    );
    array_push($data, $temp);
}

$data = json_encode($data);

echo $data;
