<?php

namespace Ataslangit\DB;

class DataBase
{
    private $host;
    private $user;
    private $pass;
    private $db;
    private $link;

    public function __construct()
    {
        $this->host = 'localhost';
        $this->user = 'root';
        $this->pass = 'root';
        $this->db   = 'db_ataslangit_inventory';
        $this->link = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
    }

    public function sambungkan()
    {
        return $this->link;
    }
}
