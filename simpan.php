<?php
include "koneksi.php";

$no_plat = htmlspecialchars($_POST["no_plat"]);
$nama_mobil = htmlspecialchars($_POST["nama_mobil"]);
$jenis_mobil = htmlspecialchars($_POST["jenis_mobil"]);
$cc = htmlspecialchars($_POST["cc"]);
$warna = htmlspecialchars($_POST["warna"]);
$tahun = htmlspecialchars($_POST["tahun"]);
$pesan = "";
$foto = upload();
$data = array();

if ($foto) {
    $query = mysqli_query($conn, "SELECT no_plat_rizkyardi FROM t_mobil_rizkyardi WHERE no_plat_rizkyardi='$no_plat'");
    if (mysqli_fetch_row($query) > 0) :
        $temp = array(
            "id_pesan" => 0,
            "pesan" => "Plat nomor sudah digunakan."
        );
        array_push($data, $temp);
    else :
        $simpan = mysqli_query($conn, "INSERT INTO t_mobil_rizkyardi VALUES('$no_plat', '$nama_mobil', '$jenis_mobil', '$tahun','$cc', '$warna','$foto')");
        if ($simpan > 0) {
            $temp = array(
                "id_pesan" => 1,
                "pesan" => "Data berhasil ditambahkan."
            );
            array_push($data, $temp);
        } else {
            $temp = array(
                "id_pesan" => 0,
                "pesan" => "Data gagal ditambahkan."
            );
            array_push($data, $temp);
        }
    endif;
} else {
    $temp = array(
        "id_pesan" => 0,
        "pesan" => $pesan
    );
    array_push($data, $temp);
}

function upload()
{
    global $pesan;
    $fileName = $_FILES["foto"]["name"];
    $fileSize = $_FILES["foto"]["size"];
    $error = $_FILES["foto"]["error"];
    $tmpName = $_FILES["foto"]["tmp_name"];

    if ($error === 4) {
        $pesan = "Pilih foto terlebih dahulu.";
        return false;
    }

    $validExtension = ["jpg", "jpeg", "png"];
    $fileExtension = explode(".", $fileName);
    $fileExtension = strtolower(end($fileExtension));
    if (!in_array($fileExtension, $validExtension)) {
        $pesan = "Ekstensi file tidak didukung.";
        return false;
    }

    if ($fileSize > 5000000) {
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
