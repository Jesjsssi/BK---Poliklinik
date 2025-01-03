<?php
session_start();
include_once("../../../config/koneksi.php");

function getQueQue($mysqli, $id_jadwal)
{
    $getQueQue = mysqli_query($mysqli, "SELECT MAX(no_antrian) as max_queue FROM daftar_poli WHERE id_jadwal = $id_jadwal");
    $result = mysqli_fetch_assoc($getQueQue);
    $get = $result['max_queue'];
    return $get;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pasien = $_SESSION["id"];
    $id_jadwal = $_POST["jadwal"];
    $keluhan = $_POST["keluhan"];
    $no_antrian = getQueQue($mysqli, $id_jadwal) + 1;

    $sql = "INSERT INTO daftar_poli (id_pasien, id_jadwal, keluhan, no_antrian) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "iisi", $id_pasien, $id_jadwal, $keluhan, $no_antrian);

    if (mysqli_stmt_execute($stmt)) {
        $id_daftar_poli = mysqli_insert_id($mysqli);
        $queryPeriksa = "INSERT INTO periksa (id_daftar_poli) VALUES (?)";
        $stmtPeriksa = mysqli_prepare($mysqli, $queryPeriksa);
        mysqli_stmt_bind_param($stmtPeriksa, "i", $id_daftar_poli);
        if (mysqli_stmt_execute($stmtPeriksa)) {
?>
            <script>
                alert(`Berhasil Daftar Poli`)
            </script>
            <meta http-equiv='refresh' content='0; url=../index.php'>
<?php
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
        }
        mysqli_stmt_close($stmtPeriksa);
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($mysqli);
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($mysqli);
?>