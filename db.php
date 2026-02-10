<?php
//mengkoneksikan aplikasi dengan database
$koneksi = mysqli_connect("localhost", "root", "", "web_akademik");

//cek koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
}
?>