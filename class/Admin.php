<?php

namespace Ataslangit\DB;

// session_start();
// // set jam
// date_default_timezone_set('Asia/Jakarta');
// membuat class admin
class Admin
{
    private $link;

    public function __construct()
    {
        $DB         = new DataBase();
        $this->link = $DB->sambungkan();
    }

    // method insert data admin
    public function simpan_admin($email, $pass, $nama, $gambar)
    {
        $namafile = $gambar['name'];
        // lokasi sementara
        $lokasifile = $gambar['tmp_name'];
        // upload
        move_uploaded_file($lokasifile, "gambar_admin/{$namafile}");
        // insert
        mysqli_query($this->link, "INSERT INTO admin(email,password,nama,gambar) VALUES('{$email}','{$pass}','{$nama}','{$namafile}')");
    }

    public function tampil_admin()
    {
        $qry = mysqli_query($this->link, 'SELECT * FROM admin');

        while ($pecah = mysqli_fetch_array($qry)) {
            // array
            $data[] = $pecah;
        }

        return $data;
    }

    public function ambil_admin($id)
    {
        $qry = mysqli_query($this->link, "SELECT * FROM admin WHERE kd_admin= '{$id}'");

        return mysqli_fetch_assoc($qry);
    }

    public function ubah_admin($email, $pass, $nama, $gambar, $id)
    {
        $namafile   = $gambar['name'];
        $lokasifile = $gambar['tmp_name'];
        // mengambil nama gambar sebelumnya untuk di hapus, akan di hapus
        // jika form gambar tidak kosong
        $ambil       = $this->ambil_admin($id);
        $gambarhapus = $ambil['gambar'];
        if (! empty($lokasifile)) {
            // hapus gambar sebelumnya
            unlink("gambar_admin/{$gambarhapus}");
            // upload gambar baru
            move_uploaded_file($lokasifile, "gambar_admin/{$namafile}");
            // update
            mysqli_query($this->link, "UPDATE admin
					SET email = '{$email}', password='{$pass}', nama='{$nama}', gambar='{$namafile}' WHERE kd_admin='{$id}'");
        } else {
            // update tanpa upload gambar
            mysqli_query($this->link, "UPDATE admin
					SET email = '{$email}', password='{$pass}', nama='{$nama}' WHERE kd_admin='{$id}'");
        }
    }

    public function hapus_admin($hapus)
    {
        // ambil nama gambar yang akan di hapus pada folder gambar
        $gbr     = $this->ambil_admin($hapus);
        $namagbr = $gbr['gambar'];
        // hapus
        unlink("gambar_admin/{$namagbr}");
        mysqli_query($this->link, "DELETE FROM admin WHERE kd_admin= '{$hapus}'");
    }

    public function login_admin($email, $pass): bool
    {
        // mencocokan data di db dengan username dan pass yang di inputkan
        $cek = mysqli_query($this->link, "SELECT * FROM admin WHERE email='{$email}' AND password='{$pass}'");
        // mengambil data orang yang login dan cocok
        $data = mysqli_fetch_assoc($cek);
        // hitung data yang cocok
        $cocokan = mysqli_num_rows($cek);
        // jika akun yang cocok lebih besar dari 0 maka bisa login
        if ($cocokan > 0) {
            // bisa login
            $_SESSION['login_admin']['id']     = $data['kd_admin'];
            $_SESSION['login_admin']['email']  = $data['email'];
            $_SESSION['login_admin']['nama']   = $data['nama'];
            $_SESSION['login_admin']['gambar'] = $data['gambar'];

            return true;
        }// selain itu (akun yang cocok tdk lebih dari 0) maka ggl

        return false;
    }
}

// $DataBase = new DataBase();
// $DataBase->sambungkan();
// $admin        = new Admin();
// $barang       = new Barang();
// $supplier     = new Supplier();
// $pembelian    = new Pembelian();
// $penjualan    = new Penjualan();
// $nota         = new Nota();
// $laporan      = new Laporan();
// $cetaklaporan = new Cetak_Laporan();
// $perusahaan   = new Perusahaan();
// $dashboard    = new Dashboard();
