-- SQL Script untuk membuat tabel di database web_akademik
-- Jalankan script ini di phpMyAdmin atau MySQL command line

-- Tabel Jurusan
CREATE TABLE IF NOT EXISTS `jurusan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `ketua` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- Tabel Kelas
CREATE TABLE IF NOT EXISTS `kelas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `wali_kelas` varchar(100) NOT NULL,
  `ruangan` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- Tabel Siswa
CREATE TABLE IF NOT EXISTS `siswa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jk` varchar(20) NOT NULL,
  `kelas` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- Insert data sampel untuk Jurusan
INSERT INTO `jurusan` (`nama`, `kode`, `ketua`) VALUES
('Rekayasa Perangkat Lunak', 'RPL', 'Bapak Suryanto'),
('Teknik Komputer Jaringan', 'TKJ', 'Bapak Hendra');

-- Insert data sampel untuk Kelas
INSERT INTO `kelas` (`nama`, `jurusan`, `wali_kelas`, `ruangan`) VALUES
('X RPL 1', 'RPL', 'Ibu Siti', 'Ruang 101'),
('X RPL 2', 'RPL', 'Bapak Andi', 'Ruang 102'),
('X TKJ 1', 'TKJ', 'Bapak Budi', 'Ruang 103'),
('X TKJ 2', 'TKJ', 'Ibu Maya', 'Ruang 104'),
('XI RPL 1', 'RPL', 'Bapak Arif', 'Ruang 105'),
('XI RPL 2', 'RPL', 'Ibu Dina', 'Ruang 106'),
('XI TKJ 1', 'TKJ', 'Bapak Fajar', 'Ruang 107'),
('XI TKJ 2', 'TKJ', 'Ibu Rani', 'Ruang 108'),
('XII RPL 1', 'RPL', 'Bapak Yudi', 'Ruang 109'),
('XII TKJ 1', 'TKJ', 'Ibu Lilis', 'Ruang 110');

-- Insert data sampel untuk Siswa
INSERT INTO `siswa` (`nama`, `nisn`, `email`, `jk`, `kelas`) VALUES
('Ahmad Rifki', '1234567890', 'ahmad@example.com', 'Laki-laki', 'X RPL 1'),
('Siti Nurhaliza', '1234567891', 'siti@example.com', 'Perempuan', 'X RPL 1'),
('Budi Santoso', '1234567892', 'budi@example.com', 'Laki-laki', 'X TKJ 1'),
('Rina Wijaya', '1234567893', 'rina@example.com', 'Perempuan', 'X TKJ 1');
