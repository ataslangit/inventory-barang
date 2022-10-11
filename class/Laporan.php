<?php

namespace Ataslangit\DB;

class Laporan
{
    private $link;

    public function __construct()
    {
        $DB         = new DataBase();
        $this->link = $DB->sambungkan();
    }
    
    public function tampil_penjualan_bulan($bln1, $bln2)
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

    public function cek_penjualan_bulan($bln1, $bln2)
    {
        $qry = mysqli_query($this->link, "SELECT * FROM penjualan pen
				JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
				JOIN barang bar ON dpen.kd_barang = bar.kd_barang
				WHERE pen.tgl_penjualan BETWEEN '{$bln1}' AND '{$bln2}'");
        $hitung = mysqli_num_rows($qry);

        return (bool) ($hitung >= 1);
    }

    public function hitung_total_penjualan()
    {
        $qry = mysqli_query($this->link, 'SELECT sum(dpen.subtotal) as jumlah FROM penjualan pen
				JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
				JOIN barang bar ON dpen.kd_barang = bar.kd_barang');
        $pecah = mysqli_fetch_array($qry);

        return $pecah['jumlah'];
    }

    public function tampil_penjualan()
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

    public function cek_penjualan()
    {
        $qry = mysqli_query($this->link, 'SELECT * FROM penjualan pen
				JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
				JOIN barang bar ON dpen.kd_barang = bar.kd_barang');
        $hitung = mysqli_num_rows($qry);

        return (bool) ($hitung >= 1);
    }

    public function hitung_total_penjualan_bulan($bln1, $bln2)
    {
        $qry = mysqli_query($this->link, "SELECT sum(dpen.subtotal) as jumlah FROM penjualan pen
				JOIN d_penjualan dpen ON pen.kd_penjualan = dpen.kd_penjualan
				JOIN barang bar ON dpen.kd_barang = bar.kd_barang
				WHERE pen.tgl_penjualan BETWEEN '{$bln1}' AND '{$bln2}'");
        $pecah = mysqli_fetch_array($qry);

        return $pecah['jumlah'];
    }
    // end penjualan

    public function tampil_pembelian_bulan($bln1, $bln2)
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

    public function cek_pembelian_bulan($bln1, $bln2)
    {
        $qry = mysqli_query($this->link, "SELECT * FROM supplier sup
				JOIN pembelian pem ON sup.kd_supplier = pem.kd_supplier
				JOIN d_pembelian dpem ON pem.kd_pembelian = dpem.kd_pembelian
				JOIN barang_pembelian barpem ON dpem.kd_barang_beli = barpem.kd_barang_beli
				WHERE pem.tgl_pembelian BETWEEN '{$bln1}' AND '{$bln2}'");
        $hitung = mysqli_num_rows($qry);

        return (bool) ($hitung >= 1);
    }

    public function hitung_total_pembelian_bulan($bln1, $bln2)
    {
        $qry = mysqli_query($this->link, "SELECT sum(dpem.subtotal) as jumlah FROM supplier sup
				JOIN pembelian pem ON sup.kd_supplier = pem.kd_supplier
				JOIN d_pembelian dpem ON pem.kd_pembelian = dpem.kd_pembelian
				JOIN barang_pembelian barpem ON dpem.kd_barang_beli = barpem.kd_barang_beli
				WHERE pem.tgl_pembelian BETWEEN '{$bln1}' AND '{$bln2}'");
        $pecah = mysqli_fetch_array($qry);

        return $pecah['jumlah'];
    }

    public function hitung_total_pembelian()
    {
        $qry = mysqli_query($this->link, 'SELECT sum(dpem.subtotal) as jumlah FROM supplier sup
				JOIN pembelian pem ON sup.kd_supplier = pem.kd_supplier
				JOIN d_pembelian dpem ON pem.kd_pembelian = dpem.kd_pembelian
				JOIN barang_pembelian barpem ON dpem.kd_barang_beli = barpem.kd_barang_beli');
        $pecah = mysqli_fetch_array($qry);

        return $pecah['jumlah'];
    }

    public function tampil_pembelian()
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

    public function cek_pembelian()
    {
        $qry = mysqli_query($this->link, 'SELECT * FROM supplier sup
				JOIN pembelian pem ON sup.kd_supplier = pem.kd_supplier
				JOIN d_pembelian dpem ON pem.kd_pembelian = dpem.kd_pembelian
				JOIN barang_pembelian barpem ON dpem.kd_barang_beli = barpem.kd_barang_beli');
        $hitung = mysqli_num_rows($qry);

        return (bool) ($hitung >= 1);
    }

    // end pembelian
    public function hitung_profit_bulan()
    {
    }

    public function hitung_profit_semua()
    {
    }
}
