<?php

require __DIR__ . '../../vendor/autoload.php';

$db = new Ataslangit\DB\DataBase();

$kd = $_GET['kdbarang'];
// Checks if the username is available or not
$query  = "SELECT kd_barang FROM barang WHERE kd_barang='{$kd}'";
$result = mysqli_query($db->sambungkan, $query);
$jum    = mysqli_num_rows($result);
if ($jum >= 1) {
    echo "<span style='color:red; padding-left:4px;'><i class='fa fa-warning'></i> Kode Barang Sudah Tersedia</span>";
} else {
    echo '';
}
