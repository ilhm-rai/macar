<?php
include "koneksi.php";

$batas = 4;
$halaman = isset($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

$sebelumnya = $halaman - 1;
$selanjutnya = $halaman + 1;

$sql = "SELECT * FROM t_mobil_rizkyardi as mobil INNER JOIN t_jenis_rizkyardi as jenis ON mobil.id_jenis_rizkyardi=jenis.id_jenis_rizkyardi ORDER BY nama_mobil_rizkyardi ASC";

$result = mysqli_query($conn, $sql);
$jumlah_data = mysqli_num_rows($result);
$total_halaman = ceil($jumlah_data / $batas);

$sql = $sql . " LIMIT $halaman_awal, $batas";

if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $sql = "SELECT * FROM t_mobil_rizkyardi as mobil INNER JOIN t_jenis_rizkyardi as jenis ON mobil.id_jenis_rizkyardi=jenis.id_jenis_rizkyardi WHERE CONCAT(no_plat_rizkyardi, nama_mobil_rizkyardi, jenis_rizkyardi, tahun_rizkyardi, cc_rizkyardi,warna_rizkyardi) LIKE '%$keyword%' ORDER BY nama_mobil_rizkyardi ASC LIMIT $halaman_awal, $batas";
}

$result = mysqli_query($conn, $sql);
$data = array();
while ($car = mysqli_fetch_array($result)) :
    $temp = array(
        "no_plat" => $car["no_plat_rizkyardi"],
        "nama_mobil" => $car["nama_mobil_rizkyardi"],
        "jenis" => $car["jenis_rizkyardi"],
        "tahun" => $car["tahun_rizkyardi"],
        "cc" => $car["cc_rizkyardi"],
        "warna" => $car["warna_rizkyardi"],
        "foto" => $car["foto_rizkyardi"],
        "aksi" => "<button data-plat='" . $car['no_plat_rizkyardi'] . "' class='btn btn-danger btn-hapus mr-1'>Hapus</button> <button data-plat='" . $car['no_plat_rizkyardi'] . "' class='btn btn-info btn-ubah'>Ubah</button>",
    );

    array_push($data, $temp);

endwhile;

$pageBack = ($halaman > 1) ? "<a data-halaman=$sebelumnya href=javascript(); id=pageBack> &larr; </a>" : '&larr;';

$page = '';

for ($i = 1; $i <= $total_halaman; $i++) :
    if ($halaman != $i) {
        $page .= "<a data-halaman=$i href=javascript(); class=page>$i</a>";
    } else {
        $page .= "<a class='page active'>$i</a>";
    }
endfor;


$pageNext = ($halaman < $total_halaman) ? "<a data-halaman=$selanjutnya href=javascript(); id=pageNext> &rarr; </a>" : '&rarr;';

$pagination = $pageBack . $page . $pageNext;

$response = array(
    'data' => $data,
    'pagination' => $pagination
);

$response = json_encode($response);

echo $response;
