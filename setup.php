<?php
$koneksi = mysqli_connect("localhost", "root", "", "web_akademik");

// Cek koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit;
}

// Buat tabel jurusan
$sql_jurusan = "CREATE TABLE IF NOT EXISTS jurusan (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nama VARCHAR(100) NOT NULL,
  kode VARCHAR(10) NOT NULL,
  ketua VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";

if (mysqli_query($koneksi, $sql_jurusan)) {
    echo "✓ Tabel jurusan berhasil dibuat<br>";
} else {
    echo "✗ Error membuat tabel jurusan: " . mysqli_error($koneksi) . "<br>";
}

// Buat tabel kelas
$sql_kelas = "CREATE TABLE IF NOT EXISTS kelas (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nama VARCHAR(100) NOT NULL,
  jurusan VARCHAR(50) NOT NULL,
  wali_kelas VARCHAR(100) NOT NULL,
  ruangan VARCHAR(50) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";

if (mysqli_query($koneksi, $sql_kelas)) {
    echo "✓ Tabel kelas berhasil dibuat<br>";
} else {
    echo "✗ Error membuat tabel kelas: " . mysqli_error($koneksi) . "<br>";
}

// Buat tabel siswa
$sql_siswa = "CREATE TABLE IF NOT EXISTS siswa (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nama VARCHAR(100) NOT NULL,
  nisn VARCHAR(20) NOT NULL,
  email VARCHAR(100) NOT NULL,
  jk VARCHAR(20) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";

if (mysqli_query($koneksi, $sql_siswa)) {
    echo "✓ Tabel siswa berhasil dibuat<br>";
} else {
    echo "✗ Error membuat tabel siswa: " . mysqli_error($koneksi) . "<br>";
}

// Insert data sampel jurusan
$check_jurusan = mysqli_query($koneksi, "SELECT COUNT(*) as count FROM jurusan");
$count = mysqli_fetch_array($check_jurusan)['count'];

if ($count == 0) {
    $sql_insert_jurusan = "INSERT INTO jurusan (nama, kode, ketua) VALUES
    ('Rekayasa Perangkat Lunak', 'RPL', 'Bapak Suryanto'),
    ('Teknik Komputer Jaringan', 'TKJ', 'Bapak Hendra')";
    
    if (mysqli_query($koneksi, $sql_insert_jurusan)) {
        echo "✓ Data jurusan sampel berhasil ditambahkan<br>";
    }
}

// Insert data sampel kelas
$check_kelas = mysqli_query($koneksi, "SELECT COUNT(*) as count FROM kelas");
$count = mysqli_fetch_array($check_kelas)['count'];

if ($count == 0) {
    $sql_insert_kelas = "INSERT INTO kelas (nama, jurusan, wali_kelas, ruangan) VALUES
    ('X RPL 1', 'RPL', 'Ibu Siti', 'Ruang 101'),
    ('X RPL 2', 'RPL', 'Bapak Andi', 'Ruang 102'),
    ('X TKJ 1', 'TKJ', 'Bapak Budi', 'Ruang 103'),
    ('X TKJ 2', 'TKJ', 'Ibu Maya', 'Ruang 104'),
    ('XI RPL 1', 'RPL', 'Bapak Arif', 'Ruang 105'),
    ('XI RPL 2', 'RPL', 'Ibu Dina', 'Ruang 106'),
    ('XI TKJ 1', 'TKJ', 'Bapak Fajar', 'Ruang 107'),
    ('XI TKJ 2', 'TKJ', 'Ibu Rani', 'Ruang 108'),
    ('XII RPL 1', 'RPL', 'Bapak Yudi', 'Ruang 109'),
    ('XII TKJ 1', 'TKJ', 'Ibu Lilis', 'Ruang 110')";
    
    if (mysqli_query($koneksi, $sql_insert_kelas)) {
        echo "✓ Data kelas sampel berhasil ditambahkan<br>";
    }
}

// Insert data sampel siswa
$check_siswa = mysqli_query($koneksi, "SELECT COUNT(*) as count FROM siswa");
$count = mysqli_fetch_array($check_siswa)['count'];

if ($count == 0) {
    $sql_insert_siswa = "INSERT INTO siswa (nama, nisn, email, jk) VALUES
    ('Ahmad Rifki', '1234567890', 'ahmad@example.com', 'Laki-laki'),
    ('Siti Nurhaliza', '1234567891', 'siti@example.com', 'Perempuan'),
    ('Budi Santoso', '1234567892', 'budi@example.com', 'Laki-laki'),
    ('Rina Wijaya', '1234567893', 'rina@example.com', 'Perempuan')";
    
    if (mysqli_query($koneksi, $sql_insert_siswa)) {
        echo "✓ Data siswa sampel berhasil ditambahkan<br>";
    }
}

mysqli_close($koneksi);
echo "<br><a href='kelas.php'>Buka Halaman Kelas →</a>";
?>
