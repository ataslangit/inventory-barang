<?php

namespace Ataslangit\DB;

class CetakLaporan
{
    private $link;

    public function __construct()
    {
        $DB         = new DataBase();
        $this->link = $DB->sambungkan();
    }

    public function laporan_penjualan_bulan($bln1, $bln2)
    {
        $qry = mysqli_query($this->link, "SELECT * FROM penjualan pen
				JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
				JOIN barang bar ON dpen.kd_barang = bar.kd_barang
				WHERE pen.tgl_penjualan BETWEEN '{$bln1}' AND '{$bln2}'");

        while ($pecah = mysqli_fetch_array($qry)) {
            $data[] = $pecah;
        }
        $hitung = mysqli_num_rows($qry);
        if ($hitung > 0) {
            return $data;
        }

        error_reporting(0);
    }

    public function laporan_semua_penjualan()
    {
        $qry = mysqli_query($this->link, 'SELECT * FROM penjualan pen
				JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
				JOIN barang bar ON dpen.kd_barang = bar.kd_barang ');

        while ($pecah = mysqli_fetch_array($qry)) {
            $data[] = $pecah;
        }
        $hitung = mysqli_num_rows($qry);
        if ($hitung > 0) {
            return $data;
        }

        error_reporting(0);
    }

    public function laporan_pembelian_bulan($bln1, $bln2)
    {
        $qry = mysqli_query($this->link, "SELECT * FROM supplier sup
				JOIN pembelian pem ON sup.kd_supplier = pem.kd_supplier
				JOIN d_pembelian dpem ON pem.kd_pembelian = dpem.kd_pembelian
				JOIN barang_pembelian barpem ON dpem.kd_barang_beli = barpem.kd_barang_beli
				WHERE pem.tgl_pembelian BETWEEN '{$bln1}' AND '{$bln2}'");

        while ($pecah = mysqli_fetch_array($qry)) {
            $data[] = $pecah;
        }
        $hitung = mysqli_num_rows($qry);
        if ($hitung > 0) {
            return $data;
        }

        error_reporting(0);
    }

    public function laporan_semua_pembelian()
    {
        $qry = mysqli_query($this->link, 'SELECT * FROM supplier sup
				JOIN pembelian pem ON sup.kd_supplier = pem.kd_supplier
				JOIN d_pembelian dpem ON pem.kd_pembelian = dpem.kd_pembelian
				JOIN barang_pembelian barpem ON dpem.kd_barang_beli = barpem.kd_barang_beli');

        while ($pecah = mysqli_fetch_array($qry)) {
            $data[] = $pecah;
        }
        $hitung = mysqli_num_rows($qry);
        if ($hitung > 0) {
            return $data;
        }

        error_reporting(0);
    }
}
