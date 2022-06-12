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
    $username =  htmlspecialchars($_POST["username"]);
    $password =  htmlspecialchars($_POST["password"]);

    $result = mysqli_query($conn, "SELECT * FROM t_user_rizkyardi WHERE username='$username'");
    $user = mysqli_fetch_array($result);

    if (password_verify($password, $user['password'])) {
        $_SESSION['id_user'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['fullname'] = $user['fullname'];
        $temp = array(
            "id_pesan" => 1,
            "pesan" =>  'Login berhasil!'
        );
    } else {
        $temp = array(
            "id_pesan" => 0,
            "pesan" =>  'Login gagal! Username atau password tidak ditemukan.'
        );
    }
    array_push($data, $temp);
}

$data = json_encode($data);

echo $data;
