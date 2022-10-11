<?php

namespace Ataslangit\DB;

class Penjualan extends Barang
{
    private $link;

    public function __construct()
    {
        $DB         = new DataBase();
        $this->link = $DB->sambungkan();
    }
    
    public function kode_otomatis()
    {
        $qry   = mysqli_query($this->link, 'SELECT MAX(kd_penjualan) AS kode FROM penjualan');
        $pecah = mysqli_fetch_array($qry);
        $kode  = substr($pecah['kode'], 3, 5);
        $jum   = $kode + 1;
        if ($jum < 10) {
            $id = 'PEN0000' . $jum;
        } elseif ($jum >= 10 && $jum < 100) {
            $id = 'PEN000' . $jum;
        } elseif ($jum >= 100 && $jum < 1000) {
            $id = 'PEN00' . $jum;
        } else {
            $id = 'PEN0' . $jum;
        }

        return $id;
    }

    public function tampil_barang_penjualan()
    {
        $qry = mysqli_query($this->link, 'SELECT * FROM barang WHERE stok > 0 ORDER BY nama_barang ASC');

        while ($pecah = mysqli_fetch_array($qry)) {
            $data[] = $pecah;
        }

        return $data;
    }

    public function tampil_penjualan()
    {
        $qry = mysqli_query($this->link, 'SELECT * FROM penjualan ORDER BY kd_penjualan DESC');

        while ($pecah = mysqli_fetch_array($qry)) {
            $data[] = $pecah;
        }
        $hitung = mysqli_num_rows($qry);
        if ($hitung > 0) {
            return $data;
        }

        error_reporting(0);
    }

    public function cek_data_barangp($kode)
    {
        $qry    = mysqli_query($this->link, "SELECT * FROM penjualan_sementara WHERE kd_penjualan = '{$kode}'");
        $hitung = mysqli_num_rows($qry);

        return (bool) ($hitung >= 1);
    }

    public function tampil_barang_sementara($kode)
    {
        $qry = mysqli_query($this->link, "SELECT * FROM penjualan_sementara WHERE kd_penjualan = '{$kode}'");

        while ($pecah = mysqli_fetch_array($qry)) {
            $data[] = $pecah;
        }
        $hitung = mysqli_num_rows($qry);
        if ($hitung > 0) {
            return $data;
        }

        error_reporting(0);
    }

    public function tambah_penjualan_sementara($kdpen, $kdbarang, $item)
    {
        $bar    = $this->ambil_barang($kdbarang);
        $namabr = $bar['nama_barang'];
        $satuan = $bar['satuan'];
        $harga  = $bar['harga_jual'];
        $total  = $harga * $item;
        mysqli_query($this->link, "INSERT INTO penjualan_sementara(kd_penjualan, kd_barang, nama_barang, satuan, harga, item, total)
				VALUES('{$kdpen}', '{$kdbarang}','{$namabr}','{$satuan}','{$harga}','{$item}','{$total}')");
        // update barang
        $kurang = $bar['stok'] - $item;
        mysqli_query($this->link, "UPDATE barang SET stok = '{$kurang}' WHERE kd_barang = '{$kdbarang}'");
    }

    public function cek_item($kdbarang, $item)
    {
        $data    = $this->ambil_barang($kdbarang);
        $jumitem = $data['stok'];
        if ($item < $jumitem + 1) {
            return true;
        }

        echo "<script>bootbox.alert('Item tidak cukup, {$jumitem} tersisa di gudang!', function(){
					window.location='index.php?page=tambahpenjualan';
				});</script>";
    }

    public function hitung_total_sementara($kode)
    {
        $qry   = mysqli_query($this->link, "SELECT sum(total) as jumlah FROM penjualan_sementara WHERE kd_penjualan = '{$kode}'");
        $pecah = mysqli_fetch_array($qry);
        $cek   = $this->cek_data_barangp($kode);
        if ($cek === true) {
            $subtotal = $pecah['jumlah'];
        } else {
            $subtotal = 0;
        }

        return $subtotal;
    }

    public function hitung_item_penjualan($kdpenjualan)
    {
        $qry = mysqli_query($this->link, "SELECT count(*) as jumlah FROM d_penjualan WHERE kd_penjualan = '{$kdpenjualan}'");

        return mysqli_fetch_array($qry);
    }

    public function simpan_penjualan($kdpenjualan, $tglpen, $ttlbayar, $subtotal)
    {
        // insert penjualan
        $kdadmin = $_SESSION['login_admin']['id'];
        mysqli_query($this->link, "INSERT INTO penjualan(kd_penjualan,tgl_penjualan,kd_admin,dibayar,total_penjualan)
				VALUES('{$kdpenjualan}','{$tglpen}','{$kdadmin}','{$ttlbayar}','{$subtotal}')");

        // insert d penjualan
        mysqli_query($this->link, "INSERT INTO d_penjualan(kd_penjualan,kd_barang,jumlah,subtotal)
				SELECT kd_penjualan, kd_barang,item,total FROM penjualan_sementara WHERE kd_penjualan='{$kdpenjualan}'");
        // hapus semua penjualan sementera
        mysqli_query($this->link, "DELETE FROM penjualan_sementara WHERE kd_penjualan = '{$kdpenjualan}'");
    }

    public function ambil_kdpen()
    {
        $qry = mysqli_query($this->link, 'SELECT * FROM penjualan ORDER BY kd_penjualan DESC LIMIT 1');

        return mysqli_fetch_assoc($qry);
    }

    public function hapus_penjualan_sementara($kd)
    {
        // update barang, di kembalikan ke setok semula
        $datpen = $this->ambil_penjualan_sementara($kd);
        $datbar = $this->ambil_barang($datpen['kd_barang']);
        $stok   = $datbar['stok'] + $datpen['item'];
        $kdbar  = $datpen['kd_barang'];
        mysqli_query($this->link, "UPDATE barang SET stok ='{$stok}' WHERE kd_barang = '{$kdbar}'");
        // hapus
        mysqli_query($this->link, "DELETE FROM penjualan_sementara WHERE id_penjualan_sementara = '{$kd}'");
    }

    public function ambil_penjualan_sementara($kd)
    {
        $qry = mysqli_query($this->link, "SELECT * FROM penjualan_sementara WHERE id_penjualan_sementara = '{$kd}'");

        return mysqli_fetch_assoc($qry);
    }
}
