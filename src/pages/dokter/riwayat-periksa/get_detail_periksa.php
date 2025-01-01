<!-- get_detail_periksa.php -->
<?php
include_once("koneksi.php");

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan");
}

$id = $_GET['id'];
$query = "SELECT 
    p.id,
    ps.nama AS nama_pasien,
    p.tgl_periksa,
    dp.keluhan,
    p.catatan,
    GROUP_CONCAT(o.nama_obat) AS obat_list,
    GROUP_CONCAT(o.kemasan) AS kemasan_list,
    p.biaya_periksa,
    d.nama AS nama_dokter,
    pol.nama_poli
FROM 
    periksa p
    JOIN daftar_poli dp ON p.id_daftar_poli = dp.id
    JOIN pasien ps ON dp.id_pasien = ps.id
    JOIN jadwal_periksa jp ON dp.id_jadwal = jp.id
    JOIN dokter d ON jp.id_dokter = d.id
    JOIN poli pol ON d.id_poli = pol.id
    LEFT JOIN detail_periksa dpr ON p.id = dpr.id_periksa
    LEFT JOIN obat o ON dpr.id_obat = o.id
WHERE 
    p.id = ?
GROUP BY 
    p.id";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Nama Pasien</label>
                <p class="form-control-static"><?= htmlspecialchars($data['nama_pasien']) ?></p>
            </div>
            <div class="form-group">
                <label>Tanggal Periksa</label>
                <p class="form-control-static"><?= date('d/m/Y H:i', strtotime($data['tgl_periksa'])) ?></p>
            </div>
            <div class="form-group">
                <label>Dokter Pemeriksa</label>
                <p class="form-control-static"><?= htmlspecialchars($data['nama_dokter']) ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Poli</label>
                <p class="form-control-static"><?= htmlspecialchars($data['nama_poli']) ?></p>
            </div>
            <div class="form-group">
                <label>Keluhan</label>
                <p class="form-control-static"><?= htmlspecialchars($data['keluhan']) ?></p>
            </div>
            <div class="form-group">
                <label>Catatan</label>
                <p class="form-control-static"><?= htmlspecialchars($data['catatan']) ?></p>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <h5>Obat yang Diberikan</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Obat</th>
                        <th>Kemasan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $obat_list = explode(',', $data['obat_list']);
                    $kemasan_list = explode(',', $data['kemasan_list']);
                    for ($i = 0; $i < count($obat_list); $i++) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($obat_list[$i]) . "</td>";
                        echo "<td>" . htmlspecialchars($kemasan_list[$i]) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="form-group">
                <label>Total Biaya</label>
                <p class="form-control-static">Rp <?= number_format($data['biaya_periksa'], 0, ',', '.') ?></p>
            </div>
        </div>
    </div>
</div>