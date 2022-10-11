<?php

namespace Ataslangit\DB;

class Supplier
{
    private $link;

    public function __construct()
    {
        $DB         = new DataBase();
        $this->link = $DB->sambungkan();
    }

    public function tampil_supplier()
    {
        $qry = mysqli_query($this->link, 'SELECT * FROM supplier');

        while ($pecah = mysqli_fetch_array($qry)) {
            $data[] = $pecah;
        }

        return $data;
    }

    public function simpan_supplier($nama, $alamat)
    {
        mysqli_query($this->link, "INSERT INTO supplier(nama_supplier,alamat) VALUES('{$nama}','{$alamat}')");
    }

    public function ubah_supplier($nama, $alamat, $id)
    {
        mysqli_query($this->link, "UPDATE supplier SET nama_supplier='{$nama}', alamat='{$alamat}' WHERE kd_supplier = '{$id}'");
    }

    public function hapus_supplier($id)
    {
        mysqli_query($this->link, "DELETE FROM supplier WHERE kd_supplier= '{$id}'");
    }

    public function ambil_supplier($id)
    {
        $qry = mysqli_query($this->link, "SELECT * FROM supplier WHERE kd_supplier= '{$id}'");

        return mysqli_fetch_assoc($qry);
    }
}
