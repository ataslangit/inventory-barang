<?php

namespace Ataslangit\DB;

class Pembelian
{
    private $link;

    public function __construct()
    {
        $DB         = new DataBase();
        $this->link = $DB->sambungkan();
    }

    public function kode_otomatis()
    {
        $qry   = mysqli_query($this->link, 'SELECT MAX(kd_pembelian) AS kode FROM pembelian');
        $pecah = mysqli_fetch_array($qry);
        $kode  = substr($pecah['kode'], 3, 5);
        $jum   = $kode + 1;
        if ($jum < 10) {
            $id = 'PEM0000' . $jum;
        } elseif ($jum >= 10 && $jum < 100) {
            $id = 'PEM000' . $jum;
        } elseif ($jum >= 100 && $jum < 1000) {
            $id = 'PEM00' . $jum;
        } else {
            $id = 'PEM0' . $jum;
        }

        return $id;
    }

    public function tampil_pembelian()
    {
        $qry = mysqli_query($this->link, 'SELECT * FROM pembelian p JOIN supplier s ON p.kd_supplier=s.kd_supplier ORDER BY kd_pembelian DESC');

        while ($pecah = mysqli_fetch_array($qry)) {
            $data[] = $pecah;
        }
        $cek = mysqli_num_rows($qry);
        if ($cek > 0) {
            return $data;
        }
        error_reporting(0);
    }

    public function hitung_item_pembelian($kdpembelian)
    {
        $qry = mysqli_query($this->link, "SELECT count(*) as jumlah FROM d_pembelian WHERE kd_pembelian = '{$kdpembelian}'");

        return mysqli_fetch_array($qry);
    }

    // sementara
    public function tambah_barang_sementara($kode, $nama, $satuan, $hargab, $item)
    {
        $tot = $item * $hargab;
        mysqli_query($this->link, "INSERT INTO barangp_sementara(kd_pembelian,nama_barangp, satuan,harga_barangp,item,total)
				VALUES('{$kode}','{$nama}','{$satuan}','{$hargab}','{$item}','{$tot}')");
    }

    public function tampil_barang_sementara($kode)
    {
        $qry = mysqli_query($this->link, "SELECT * FROM barangp_sementara WHERE kd_pembelian = '{$kode}'");

        while ($pecah = mysqli_fetch_array($qry)) {
            $data[] = $pecah;
        }
        $hitung = mysqli_num_rows($qry);
        if ($hitung > 0) {
            return $data;
        }

        error_reporting(0);
    }

    public function hitung_total_sementara($kode)
    {
        $qry   = mysqli_query($this->link, "SELECT sum(total) as jumlah FROM barangp_sementara WHERE kd_pembelian = '{$kode}'");
        $pecah = mysqli_fetch_array($qry);
        $cek   = $this->cek_data_barangp($kode);
        if ($cek === true) {
            $subtotal = $pecah['jumlah'];
        } else {
            $subtotal = 0;
        }

        return $subtotal;
    }

    public function hapus_barang_sementara($hapus)
    {
        mysqli_query($this->link, "DELETE FROM barangp_sementara WHERE id_barangp ='{$hapus}'");
    }

    public function cek_data_barangp($kode)
    {
        $qry    = mysqli_query($this->link, "SELECT * FROM barangp_sementara WHERE kd_pembelian = '{$kode}'");
        $hitung = mysqli_num_rows($qry);

        return (bool) ($hitung >= 1);
    }

    // end sementara
    public function simpan_pembelian($kdpembelian, $tglpembelian, $supplier, $totalpem)
    {
        // insert pembelian
        $kdadmin = $_SESSION['login_admin']['id'];
        mysqli_query($this->link, "INSERT INTO pembelian(kd_pembelian,tgl_pembelian,kd_admin,kd_supplier,total_pembelian)
				VALUES('{$kdpembelian}','{$tglpembelian}','{$kdadmin}','{$supplier}','{$totalpem}')");

        // insert data barang
        mysqli_query($this->link, 'INSERT INTO barang_pembelian(kd_pembelian,nama_barang_beli,satuan,harga_beli,item,total)
				SELECT kd_pembelian,nama_barangp,satuan,harga_barangp,item,total FROM barangp_sementara');
        // insert detail pembelian
        mysqli_query($this->link, "INSERT INTO d_pembelian(kd_pembelian,kd_barang_beli,jumlah,subtotal)
				SELECT kd_pembelian, kd_barang_beli,item,total FROM barang_pembelian WHERE kd_pembelian='{$kdpembelian}'");
        // hapus data barang pembelian sementara
        mysqli_query($this->link, "DELETE FROM barangp_sementara WHERE kd_pembelian='{$kdpembelian}'");
    }

    public function tampil_barang_pembelian()
    {
        $qry = mysqli_query($this->link, "SELECT * FROM barang_pembelian WHERE status = '0'");

        while ($pecah = mysqli_fetch_array($qry)) {
            $data[] = $pecah;
        }
        $hitung = mysqli_num_rows($qry);
        if ($hitung > 0) {
            return $data;
        }

        error_reporting(0);
    }

    public function ambil_kdpem()
    {
        $qry = mysqli_query($this->link, 'SELECT * FROM pembelian ORDER BY kd_pembelian DESC LIMIT 1');

        return mysqli_fetch_assoc($qry);
    }

    public function cek_hapuspembelian($kd)
    {
        $qry    = mysqli_query($this->link, "SELECT * FROM barang_pembelian WHERE kd_pembelian = '{$kd}' AND status ='0'");
        $hitung = mysqli_num_rows($qry);

        return ! ($hitung > 0);
    }

    public function hitung_jumlah_pembelian($kd)
    {
        $qry   = mysqli_query($this->link, "SELECT SUM(subtotal) as total FROM d_pembelian WHERE kd_pembelian = '{$kd}'");
        $pecah = mysqli_fetch_assoc($qry);

        return $pecah['total'];
    }

    public function hapus_pembelian($kdpembelian)
    {
        mysqli_query($this->link, "DELETE FROM pembelian WHERE kd_pembelian='{$kdpembelian}'");
        mysqli_query($this->link, "DELETE FROM barang_pembelian WHERE kd_pembelian = '{$kdpembelian}' AND status='1'");
    }
}
