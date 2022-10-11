<?php

namespace Ataslangit\DB;

class Nota
{
    private $link;

    public function __construct()
    {
        $DB         = new DataBase();
        $this->link = $DB->sambungkan();
    }

    public function tampil_nota_pembelian($kd)
    {
        $qry = mysqli_query($this->link, "SELECT * FROM supplier sup
				JOIN pembelian pem ON pem.kd_supplier = sup.kd_supplier
				JOIN admin adm ON adm.kd_admin = pem.kd_admin
				JOIN d_pembelian dpem ON pem.kd_pembelian = dpem.kd_pembelian
				JOIN barang_pembelian bpem ON dpem.kd_barang_beli = bpem.kd_barang_beli
				WHERE pem.kd_pembelian = '{$kd}'");

        while ($pecah = mysqli_fetch_array($qry)) {
            $data[] = $pecah;
        }
        $hitung = mysqli_num_rows($qry);
        if ($hitung > 0) {
            return $data;
        }

        error_reporting(0);
    }

    public function ambil_nota_pembelian($kd)
    {
        $qry = mysqli_query($this->link, "SELECT * FROM supplier sup
				JOIN pembelian pem ON pem.kd_supplier = sup.kd_supplier
				JOIN admin adm ON adm.kd_admin = pem.kd_admin
				JOIN d_pembelian dpem ON pem.kd_pembelian = dpem.kd_pembelian
				JOIN barang_pembelian bpem ON dpem.kd_pembelian = bpem.kd_pembelian
				WHERE pem.kd_pembelian = '{$kd}'");

        return mysqli_fetch_assoc($qry);
    }

    public function tampil_nota_penjualan($kd)
    {
        $qry = mysqli_query($this->link, "SELECT * FROM penjualan pen
				JOIN admin adm ON adm.kd_admin = pen.kd_admin
				JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
				JOIN barang bar ON dpen.kd_barang = bar.kd_barang
				WHERE pen.kd_penjualan = '{$kd}'");

        while ($pecah = mysqli_fetch_array($qry)) {
            $data[] = $pecah;
        }
        $hitung = mysqli_num_rows($qry);
        if ($hitung > 0) {
            return $data;
        }

        error_reporting(0);
    }

    public function ambil_nota_penjualan($kd)
    {
        $qry = mysqli_query($this->link, "SELECT * FROM penjualan pen
				JOIN admin adm ON adm.kd_admin = pen.kd_admin
				JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
				JOIN barang bar ON dpen.kd_barang = bar.kd_barang
				WHERE pen.kd_penjualan = '{$kd}'");

        return mysqli_fetch_assoc($qry);
    }
}
