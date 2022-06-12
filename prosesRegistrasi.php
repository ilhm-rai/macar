<?php
//aktifkan session
session_start();

//Include koneksi ke database
include "koneksi.php";

$data = array();

// Cek apakah data session Captha sesuai dengan kode yang diinputkan
if ($_SESSION["Captcha"] != $_POST["captcha"]) {
    $temp = array(
        "id_pesan" => 0,
        "pesan" => "Kode salah!"
    );
    array_push($data, $temp);
} else {
    $fullname = htmlspecialchars($_POST["fullname"]);
    $username = str_replace(' ', '', htmlspecialchars($_POST["username"]));
    $password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT);
    $sql = "INSERT INTO t_user_martin(fullname, username, password) VALUES('$fullname', '$username', '$password')";

    $result = mysqli_query($conn, $sql);

    if ($result > 0) {
        $temp = array(
            "id_pesan" => 1,
            "pesan" => "Registrasi berhasil!"
        );
        array_push($data, $temp);
    } else {
        $temp = array(
            "id_pesan" => 0,
            "pesan" => "Registrasi gagal!"
        );
        array_push($data, $temp);
    }
}

$data = json_encode($data);

echo $data;
