<?php
$barang = new \Ataslangit\DB\Barang();

if (isset($_GET['hapus'])) {
    $barang->hapus_barang($_GET['hapus']);
    echo "<script>location='index.php?page=barang';</script>";
}
?>
<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Barang
            </div>
            <div class="panel-body">
                <div class="table">
                    <table class="table table-striped table-bordered table-hover" id="tabelku">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama</th>
                                <th>Satuan</th>
                                <th>Harga Jual</th>
                                <th>Harga Beli</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $brg = $barang->tampil_barang();

                            foreach ($brg as $index => $data) {
                            ?>
                                <tr class="odd gradeX">
                                    <td><?= $index + 1; ?></td>
                                    <td><?= $data['kd_barang']; ?></td>
                                    <td><?= $data['nama_barang']; ?></td>
                                    <td><?= $data['satuan']; ?></td>
                                    <td><?= number_format($data['harga_jual']); ?></td>
                                    <td><?= number_format($data['harga_beli']); ?></td>
                                    <td><?= $data['stok']; ?></td>
                                    <td>
                                        <a href="index.php?page=ubahbarang&id=<?= $data['kd_barang']; ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                        <a href="index.php?page=barang&hapus=<?= $data['kd_barang']; ?>" class="btn btn-danger btn-xs" id="alertHapus"><i class="fa fa-trash"></i> Hapus</a>
                                    </td>
                                </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <a href="index.php?page=tambahbarang" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Barang</a>
            </div>
        </div>
        <!--End Advanced Tables -->
    </div>
</div>