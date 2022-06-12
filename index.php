<?php
include "koneksi.php";
session_start();
if (empty($_SESSION['id_user'])) {
    echo '<script>alert(`Silakan login terlebih dahulu!`);window.location.href=`login.php`</script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Macar Auto</title>
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/js/jquery.js"></script>
</head>

<body>
    <main>
        <h1><?= $_SESSION['fullname']; ?></h1>
        <a href="logout.php" class="btn btn-danger">Logout</a>
        <a href="laporan.php" class="btn btn-success" target="_blank">Print</a>
        <table class="table-custom">
            <thead>
                <tr style="background-color: white; color: black;">
                    <td colspan="8">
                        Pencarian : <input type="search" placeholder="Masukan kata kunci" class="search-custom" name="keyword" id="keyword">
                </tr>
                <tr>
                    <th class="align-left">Plat Nomor</th>
                    <th class="align-left">Nama Mobil</th>
                    <th>Jenis</th>
                    <th>Tahun</th>
                    <th>Kapasitas Mesin</th>
                    <th>Warna</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="carData">
            </tbody>
        </table>
        <p align="center" id="pagination">

        </p>
        <div class="flex" style="margin-top: 10px;">
            <div class="flex-row justify-content-center">
                <div class="fb-50">
                    <form action="" method="post" enctype="multipart/form-data" id="addCarForm">
                        <input type="hidden" name="no_plat_lama" id="no_plat_lama">
                        <input type="hidden" name="foto_lama" id="foto_lama">
                        <div class="form-group">
                            <label for="no_plat">Plat Nomor</label>
                            <input type="text" name="no_plat" id="no_plat" class="form-custom" value="<?= (isset($_POST['no_plat'])) ? $_POST['no_plat'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_mobil">Nama Mobil</label>
                            <input type="text" name="nama_mobil" id="nama_mobil" class="form-custom" value="<?= (isset($_POST['nama_mobil'])) ? $_POST['nama_mobil'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="cc">Kapasitas Mesin</label>
                            <input type="text" placeholder="CC" name="cc" id="cc" class="form-custom" value="<?= (isset($_POST['cc'])) ? $_POST['cc'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="warna">Warna</label>
                            <input type="text" name="warna" id="warna" class="form-custom" value="<?= (isset($_POST['warna'])) ? $_POST['warna'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_mobil">Jenis Mobil</label>
                            <select name="jenis_mobil" id="jenis_mobil" class="form-custom" required>
                                <?php
                                include "koneksi.php";
                                $result = mysqli_query($conn, "SELECT * FROM t_jenis_rizkyardi");
                                while ($type = mysqli_fetch_array($result)) :
                                ?>
                                    <option value="<?= $type["id_jenis_rizkyardi"]; ?>" <?= ($type["id_jenis_rizkyardi"] == isset($_POST['warna']) ? 'selected' : ''); ?>><?= $type["jenis_rizkyardi"]; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <input type="text" placeholder="YYYY" name="tahun" id="tahun" class="form-custom" value="<?= (isset($_POST['tahun'])) ? $_POST['tahun'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="foto" style="display: block; margin-bottom:5px">Foto</label>
                            <img src="assets/img/icons8_camera_60px.png" class="img-preview">
                            <br>
                            <input type="file" name="foto" id="foto">
                        </div>
                        <input type="submit" name="submit" value="Simpan" class="btn btn-success" id="simpan">
                        <input type="reset" name="reset" value="Batal" class="btn btn-secondary">
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="assets/js/main.js"></script>
    <script>
        tampil()
    </script>
</body>

</html>