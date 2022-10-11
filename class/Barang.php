<?php

namespace Ataslangit\DB;

class Barang
{
    private $link;

    public function __construct()
    {
        $DB         = new DataBase();
        $this->link = $DB->sambungkan();
    }

    public function tampil_barang()
    {
        $qry = mysqli_query($this->link, 'SELECT * FROM barang ORDER BY nama_barang ASC');

        while ($pecah = mysqli_fetch_array($qry)) {
            $data[] = $pecah;
        }

        return $data;
    }

    public function simpan_barang($kdbarang, $nama, $satuan, $hargaj, $hargab, $stok)
    {
        mysqli_query($this->link, "INSERT INTO barang(kd_barang,nama_barang,satuan,harga_jual,harga_beli,stok)
				VALUES('{$kdbarang}','{$nama}','{$satuan}','{$hargaj}','{$hargab}','{$stok}')");
    }

    public function ubah_barang($nama, $satuan, $hargaj, $hargab, $stok, $kd)
    {
        mysqli_query($this->link, "UPDATE barang SET nama_barang='{$nama}', satuan='{$satuan}', harga_jual='{$hargaj}',harga_beli='{$hargab}',stok='{$stok}' WHERE kd_barang = '{$kd}' ");
    }

    public function ambil_barang($id)
    {
        $qry = mysqli_query($this->link, "SELECT * FROM barang WHERE kd_barang = '{$id}'");

        return mysqli_fetch_assoc($qry);
    }

    public function hapus_barang($kd)
    {
        mysqli_query($this->link, "DELETE FROM barang WHERE kd_barang = '{$kd}'");
    }

    public function simpan_barang_gudang($kdbarang, $hargaj, $kdbl)
    {
        $dat    = $this->ambil_barangpem($kdbl);
        $nama   = $dat['nama_barang_beli'];
        $satuan = $dat['satuan'];
        $hargab = $dat['harga_beli'];
        $stok   = $dat['item'];
        mysqli_query($this->link, "INSERT INTO barang(kd_barang,nama_barang,satuan,harga_jual,harga_beli,stok)
				VALUES('{$kdbarang}','{$nama}','{$satuan}','{$hargaj}','{$hargab}','{$stok}')");
        // update data barang pembelian dengan setatus 1
        mysqli_query($this->link, "UPDATE barang_pembelian SET status='1' WHERE kd_barang_beli ='{$kdbl}'");
    }

    public function ambil_barangpem($kd)
    {
        $qry = mysqli_query($this->link, "SELECT * FROM barang_pembelian WHERE kd_barang_beli = '{$kd}'");

        return mysqli_fetch_assoc($qry);
    }
}
