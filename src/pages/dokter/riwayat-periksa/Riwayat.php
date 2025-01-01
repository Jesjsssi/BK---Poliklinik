<!-- Table Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 ">
            <div class="col-sm-6">
                <h1 class="m-0">Manajemen Periksa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
                    <li class="breadcrumb-item active">Periksa</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end Table Header -->

<!-- Riwayat Pasien Section -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title text-dark">Riwayat Pasien</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Alamat Pasien</th>
                    <th>No HP</th>
                    <th>No KTP</th>
                    <th>No RM</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Modified SQL query to include examination details
                $sqlRiwayat = "SELECT PASIEN.id, PASIEN.nama_pasien, PASIEN.alamat_pasien, PASIEN.no_hp, PASIEN.no_ktp, PASIEN.no_rm,
                      PERIKSA.tgl_periksa, PERIKSA.catatan, DAFTAR_POLI.keluhan, PERIKSA.biaya_periksa,
                      GROUP_CONCAT(OBAT.nama_obat SEPARATOR ', ') as nama_obat
               FROM pasien AS PASIEN
               JOIN daftar_poli AS DAFTAR_POLI ON PASIEN.id = DAFTAR_POLI.id_pasien
               JOIN periksa AS PERIKSA ON DAFTAR_POLI.id = PERIKSA.id_daftar_poli
               LEFT JOIN detail_periksa AS DETAIL ON PERIKSA.id = DETAIL.id_periksa
               LEFT JOIN obat AS OBAT ON DETAIL.id_obat = OBAT.id
               WHERE PERIKSA.tgl_periksa IS NOT NULL
               GROUP BY PERIKSA.id
               ORDER BY PERIKSA.tgl_periksa DESC";

                $resultRiwayat = mysqli_query($mysqli, $sqlRiwayat);
                $no = 1;

                while ($rowRiwayat = mysqli_fetch_assoc($resultRiwayat)) {
                    ?>
                    <tr class="text-center">
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $rowRiwayat['nama_pasien']; ?></td>
                        <td><?php echo $rowRiwayat['alamat_pasien']; ?></td>
                        <td><?php echo $rowRiwayat['no_hp']; ?></td>
                        <td><?php echo $rowRiwayat['no_ktp']; ?></td>
                        <td><?php echo $rowRiwayat['no_rm']; ?></td>
                        <td>
                            <button type='button' class='btn btn-sm btn-info' data-toggle='modal'
                                data-target='#historyModal<?php echo $rowRiwayat['id']; ?>'>
                                Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Detail Riwayat -->
                    <div class="modal fade" id="historyModal<?php echo $rowRiwayat['id']; ?>" tabindex="-1" role="dialog"
                        aria-labelledby="historyModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="historyModalLabel">Detail Riwayat Pemeriksaan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group text-left">
                                        <label>Nama Pasien</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo $rowRiwayat['nama_pasien']; ?>" readonly>
                                    </div>
                                    <div class="form-group text-left">
                                        <label>Tanggal Periksa</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo date('d/m/Y H:i', strtotime($rowRiwayat['tgl_periksa'])); ?>"
                                            readonly>
                                    </div>
                                    <div class="form-group text-left">
                                        <label>Keluhan</label>
                                        <textarea class="form-control"
                                            readonly><?php echo $rowRiwayat['keluhan']; ?></textarea>
                                    </div>
                                    <div class="form-group text-left">
                                        <label>Catatan Dokter</label>
                                        <textarea class="form-control"
                                            readonly><?php echo $rowRiwayat['catatan']; ?></textarea>
                                    </div>
                                    <div class="form-group text-left">
                                        <label>Obat</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo $rowRiwayat['nama_obat'] ?? '-'; ?>" readonly>
                                    </div>
                                    <div class="form-group text-left">
                                        <label>Total Biaya</label>
                                        <input type="text" class="form-control"
                                            value="Rp. <?php echo number_format($rowRiwayat['biaya_periksa'], 0, ',', '.'); ?>"
                                            readonly>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>