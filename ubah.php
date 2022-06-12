<?php
include "koneksi.php";
$no_plat_lama = htmlspecialchars($_POST["no_plat_lama"]);
$no_plat_baru = htmlspecialchars($_POST["no_plat"]);
$nama_mobil = htmlspecialchars($_POST["nama_mobil"]);
$jenis_mobil = htmlspecialchars($_POST["jenis_mobil"]);
$cc = htmlspecialchars($_POST["cc"]);
$warna = htmlspecialchars($_POST["warna"]);
$tahun = htmlspecialchars($_POST["tahun"]);
$foto_lama = htmlspecialchars($_POST["foto_lama"]);
$pesan = "";
$data = array();

if ($_FILES['foto']['error'] == 4) {
    $foto = $foto_lama;
} else {
    $foto = upload();
    if ($foto) {
        unlink("assets/img/$foto_lama");
    } else {
        $temp = array(
            "id_pesan" => 0,
            "pesan" => $pesan
        );
        array_push($data, $temp);
    }
}

$ubah = mysqli_query($conn, "UPDATE t_mobil_rizkyardi SET no_plat_rizkyardi='$no_plat_baru', nama_mobil_rizkyardi='$nama_mobil', id_jenis_rizkyardi='$jenis_mobil', tahun_rizkyardi='$tahun', cc_rizkyardi='$cc', warna_rizkyardi='$warna', foto_rizkyardi='$foto' WHERE no_plat_rizkyardi='$no_plat_lama'");

if ($ubah > 0) {
    $temp = array(
        "id_pesan" => 1,
        "pesan" => "Data berhasil diubah."
    );
    array_push($data, $temp);
} else {
    $temp = array(
        "id_pesan" => 0,
        "pesan" => "Data gagal diubah."
    );
    array_push($data, $temp);
}

function upload()
{
    global $pesan;
    $fileName = $_FILES["foto"]["name"];
    $fileSize = $_FILES["foto"]["size"];
    $tmpName = $_FILES["foto"]["tmp_name"];

    $validExtension = ["jpg", "jpeg", "png"];
    $fileExtension = explode(".", $fileName);
    $fileExtension = strtolower(end($fileExtension));
    if (!in_array($fileExtension, $validExtension)) {
        $pesan = "Ekstensi file tidak didukung.";
        return false;
    }

    if ($fileSize > 1000000) {
        $pesan = "Ukuran Gambar terlalu besar.";
        return false;
    }

    $newFilename = uniqid();
    $newFilename .= '.';
    $newFilename .= $fileExtension;

    move_uploaded_file($tmpName, 'assets/img/' . $newFilename);

    return $newFilename;
}

$data = json_encode($data);
echo $data;
