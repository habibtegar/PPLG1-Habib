<?php
// Mengkoneksikan aplikasi dengan database
$koneksi = mysqli_connect("localhost", "root", "", "akademik");

// Cek koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
} else {
    // Pastikan kolom 'kelas' otomatis tersedia di tabel siswa
    $cek_kolom_kelas = @mysqli_query($koneksi, "SHOW COLUMNS FROM siswa LIKE 'kelas'");
    if ($cek_kolom_kelas && mysqli_num_rows($cek_kolom_kelas) == 0) {
        @mysqli_query($koneksi, "ALTER TABLE siswa ADD COLUMN kelas VARCHAR(100) NOT NULL DEFAULT '' AFTER jk");
    }
}
?>