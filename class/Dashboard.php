<?php

namespace Ataslangit\DB;

class Dashboard
{
    private $link;

    public function __construct()
    {
        $DB         = new DataBase();
        $this->link = $DB->sambungkan();
    }
    
    public function penjualan_hariini()
    {
        $hari = date('Y-m-d');
        $qry  = mysqli_query($this->link, "SELECT * FROM penjualan WHERE tgl_penjualan = '{$hari}'");

        return mysqli_num_rows($qry);
    }

    public function pembelian_hariini()
    {
        $hari = date('Y-m-d');
        $qry  = mysqli_query($this->link, "SELECT * FROM pembelian WHERE tgl_pembelian = '{$hari}'");

        return mysqli_num_rows($qry);
    }
}
