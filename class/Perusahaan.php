<?php

namespace Ataslangit\DB;

class Perusahaan
{
    private $link;

    public function __construct()
    {
        $DB         = new DataBase();
        $this->link = $DB->sambungkan();
    }
    
    public function tampil_perusahaan()
    {
        $qry = mysqli_query($this->link, "SELECT * FROM perusahaan WHERE kd_perusahaan = '1'");

        return mysqli_fetch_assoc($qry);
    }

    public function simpan_perusahaan($nama, $alamat, $pemilik, $kota)
    {
        mysqli_query($this->link, "UPDATE perusahaan SET nama_perusahaan='{$nama}',alamat='{$alamat}', pemilik='{$pemilik}', kota='{$kota}' WHERE kd_perusahaan ='1' ");
    }
}
