<?php
include '../db.php';

// Ambil daftar kelas untuk dropdown
$daftar_kelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nama ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama  = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
    $nisn  = mysqli_real_escape_string($koneksi, trim($_POST['nisn']));
    $email = mysqli_real_escape_string($koneksi, trim($_POST['email']));
    $jk    = mysqli_real_escape_string($koneksi, trim($_POST['jk']));
    $kelas = mysqli_real_escape_string($koneksi, trim($_POST['kelas']));

    $query  = "INSERT INTO siswa (nama, nisn, email, jk, kelas) VALUES ('$nama', '$nisn', '$email', '$jk', '$kelas')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: siswa.php?status=added&nama=" . urlencode($nama));
        exit;
    } else {
        $error_message = "Gagal menambahkan data: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Siswa Baru - PPLG 1</title>

    <!-- Fonts & Icons -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../css/custom.css" rel="stylesheet">
</head>

<body id="page-top">
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index.php">
            <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-graduation-cap fa-lg"></i></div>
            <div class="sidebar-brand-text mx-3">AKADEMIK <sup>PPLG 1</sup></div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item">
            <a class="nav-link" href="../index.php">
                <i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span>
            </a>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading text-light font-weight-bold" style="font-size: 0.7rem; opacity: 0.8;">
            MANAJEMEN DATA
        </div>
        <li class="nav-item active">
            <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-database"></i><span>Bank Data</span>
            </a>
            <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item active" href="siswa.php"><i class="fas fa-user-graduate mr-2 text-primary"></i>Data Siswa</a>
                    <a class="collapse-item" href="kelas.php"><i class="fas fa-chalkboard-teacher mr-2 text-success"></i>Data Kelas</a>
                    <a class="collapse-item" href="jurusan.php"><i class="fas fa-school mr-2 text-info"></i>Data Jurusan</a>
                </div>
            </div>
        </li>
        <hr class="sidebar-divider d-none d-md-block">
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <!-- End Sidebar -->

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
                    <span class="text-gray-700 font-weight-bold">
                        <i class="fas fa-user-plus text-primary mr-2"></i>Registrasi Siswa Baru
                    </span>
                </div>
                <ul class="navbar-nav ml-auto">
                    <div class="topbar-divider d-none d-sm-block"></div>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button">
                            <span class="mr-3 d-none d-lg-inline text-gray-700 font-weight-bold small">Administrator PPLG</span>
                            <img class="img-profile rounded-circle" src="../img/undraw_profile.svg" width="36" height="36">
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- End Topbar -->

            <div class="container-fluid">
                
                <div class="mb-4">
                    <a href="siswa.php" class="btn btn-sm btn-secondary mb-3">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Siswa
                    </a>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-user-plus mr-2 text-primary"></i>Tambah Siswa Baru
                    </h1>
                    <p class="page-subtitle">Daftarkan data peserta didik baru ke dalam database</p>
                </div>

                <?php if (isset($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i> <?= htmlspecialchars($error_message) ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php endif; ?>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <span class="font-weight-bold text-primary">
                                    <i class="fas fa-user-plus mr-2"></i>Formulir Data Siswa Baru
                                </span>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" action="">
                                    <div class="form-group mb-3">
                                        <label for="nama">
                                            <i class="fas fa-user text-primary mr-1"></i> Nama Lengkap Siswa <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Contoh: Muhammad Farhan" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="nisn">
                                                <i class="fas fa-id-card text-primary mr-1"></i> Nomor Induk Siswa Nasional (NISN) <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="nisn" name="nisn" class="form-control" placeholder="Contoh: 0054321890" required>
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="email">
                                                <i class="fas fa-envelope text-primary mr-1"></i> Alamat Email <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" id="email" name="email" class="form-control" placeholder="farhan@example.com" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-4">
                                            <label for="jk">
                                                <i class="fas fa-venus-mars text-primary mr-1"></i> Jenis Kelamin <span class="text-danger">*</span>
                                            </label>
                                            <select id="jk" name="jk" class="form-control" required>
                                                <option value="">-- Pilih Jenis Kelamin --</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 form-group mb-4">
                                            <label for="kelas">
                                                <i class="fas fa-chalkboard-teacher text-primary mr-1"></i> Pilihan Kelas <span class="text-danger">*</span>
                                            </label>
                                            <select id="kelas" name="kelas" class="form-control" required>
                                                <option value="">-- Pilih Kelas --</option>
                                                <?php
                                                if ($daftar_kelas && mysqli_num_rows($daftar_kelas) > 0) {
                                                    while ($k = mysqli_fetch_array($daftar_kelas)) {
                                                        echo '<option value="' . htmlspecialchars($k['nama']) . '">' . htmlspecialchars($k['nama']) . ' (' . htmlspecialchars($k['jurusan']) . ')</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        <a href="siswa.php" class="btn btn-secondary mr-2">
                                            <i class="fas fa-times mr-1"></i> Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="fas fa-check mr-1"></i> Simpan Data Siswa
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white border-top">
            <div class="container my-auto">
                <div class="copyright text-center my-auto font-weight-bold text-gray-600">
                    <span>Copyright &copy; <?= date('Y') ?> - PPLG 1 SMKN 1 CIOMAS</span>
                </div>
            </div>
        </footer>
    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../js/sb-admin-2.min.js"></script>
</body>
</html>