<?php
include 'db.php';

$jumlah_siswa   = 0;
$jumlah_kelas   = 0;
$jumlah_jurusan = 0;

$q_siswa = mysqli_query($koneksi, "SELECT COUNT(*) FROM siswa");
if ($q_siswa) {
    $row = mysqli_fetch_row($q_siswa);
    $jumlah_siswa = $row ? $row[0] : 0;
}

$q_kelas = mysqli_query($koneksi, "SELECT COUNT(*) FROM kelas");
if ($q_kelas) {
    $row = mysqli_fetch_row($q_kelas);
    $jumlah_kelas = $row ? $row[0] : 0;
}

$q_jurusan = mysqli_query($koneksi, "SELECT COUNT(*) FROM jurusan");
if ($q_jurusan) {
    $row = mysqli_fetch_row($q_jurusan);
    $jumlah_jurusan = $row ? $row[0] : 0;
}

// Ambil beberapa data siswa untuk preview (tanpa hardcode kolom id)
$siswa_terbaru = mysqli_query($koneksi, "SELECT * FROM siswa LIMIT 5");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard - Sistem Akademik PPLG 1</title>

    <!-- Custom fonts -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-graduation-cap fa-lg"></i>
                </div>
                <div class="sidebar-brand-text mx-3">AKADEMIK <sup>PPLG 1</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <div class="sidebar-heading text-light font-weight-bold" style="font-size: 0.7rem; opacity: 0.8;">
                MANAJEMEN DATA
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-database"></i>
                    <span>Bank Data</span>
                </a>
                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="siswa/siswa.php"><i class="fas fa-user-graduate mr-2 text-primary"></i>Data Siswa</a>
                        <a class="collapse-item" href="siswa/kelas.php"><i class="fas fa-chalkboard-teacher mr-2 text-success"></i>Data Kelas</a>
                        <a class="collapse-item" href="siswa/jurusan.php"><i class="fas fa-school mr-2 text-info"></i>Data Jurusan</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
                        <span class="text-gray-700 font-weight-bold">
                            <i class="fas fa-calendar-alt text-primary mr-2"></i><?= date('l, d F Y') ?>
                        </span>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-3 d-none d-lg-inline text-gray-700 font-weight-bold small">Administrator PPLG</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg" width="36" height="36">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="siswa/siswa.php">
                                    <i class="fas fa-user-graduate fa-sm fa-fw mr-2 text-primary"></i>
                                    Kelola Siswa
                                </a>
                                <a class="dropdown-item" href="siswa/kelas.php">
                                    <i class="fas fa-chalkboard-teacher fa-sm fa-fw mr-2 text-success"></i>
                                    Kelola Kelas
                                </a>
                                <a class="dropdown-item" href="siswa/jurusan.php">
                                    <i class="fas fa-school fa-sm fa-fw mr-2 text-info"></i>
                                    Kelola Jurusan
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h1 class="h3 mb-0 text-gray-800">Dashboard Akademik</h1>
                            <p class="page-subtitle">Selamat datang di Panel Manajemen CRUD PHP Native SMKN 1 Ciomas</p>
                        </div>
                    </div>

                    <!-- Stat Cards Row -->
                    <div class="row">

                        <!-- Card Siswa -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <a href="siswa/siswa.php" class="text-decoration-none">
                                <div class="card stat-card border-primary h-100 py-3">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="letter-spacing: 0.08em;">
                                                    Total Siswa
                                                </div>
                                                <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $jumlah_siswa ?> <span class="text-muted" style="font-size: 1rem; font-weight: 500;">Siswa</span></div>
                                                <small class="text-primary font-weight-bold mt-2 d-inline-block">
                                                    Kelola Data &rarr;
                                                </small>
                                            </div>
                                            <div class="col-auto">
                                                <div style="width: 56px; height: 56px; background: #e0e7ff; border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-user-graduate fa-2x text-primary stat-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Card Kelas -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <a href="siswa/kelas.php" class="text-decoration-none">
                                <div class="card stat-card border-success h-100 py-3">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="letter-spacing: 0.08em;">
                                                    Total Kelas
                                                </div>
                                                <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $jumlah_kelas ?> <span class="text-muted" style="font-size: 1rem; font-weight: 500;">Kelas</span></div>
                                                <small class="text-success font-weight-bold mt-2 d-inline-block">
                                                    Kelola Data &rarr;
                                                </small>
                                            </div>
                                            <div class="col-auto">
                                                <div style="width: 56px; height: 56px; background: #d1fae5; border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-chalkboard-teacher fa-2x text-success stat-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Card Jurusan -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <a href="siswa/jurusan.php" class="text-decoration-none">
                                <div class="card stat-card border-info h-100 py-3">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="letter-spacing: 0.08em;">
                                                    Total Jurusan
                                                </div>
                                                <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $jumlah_jurusan ?> <span class="text-muted" style="font-size: 1rem; font-weight: 500;">Jurusan</span></div>
                                                <small class="text-info font-weight-bold mt-2 d-inline-block">
                                                    Kelola Data &rarr;
                                                </small>
                                            </div>
                                            <div class="col-auto">
                                                <div style="width: 56px; height: 56px; background: #e0f2fe; border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-school fa-2x text-info stat-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>

                    <!-- Quick Actions Row -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <span class="font-weight-bold text-gray-800">
                                        <i class="fas fa-bolt text-warning mr-2"></i>Aksi Cepat Tambah Data
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <a href="siswa/tambahsiswa.php" class="quick-action-card">
                                                <div class="quick-action-icon qa-blue">
                                                    <i class="fas fa-user-plus"></i>
                                                </div>
                                                <div>
                                                    <strong class="d-block text-gray-900" style="font-size: 1rem;">Tambah Siswa</strong>
                                                    <span class="text-muted small">Input data siswa baru</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <a href="siswa/tambahkelas.php" class="quick-action-card">
                                                <div class="quick-action-icon qa-green">
                                                    <i class="fas fa-plus-circle"></i>
                                                </div>
                                                <div>
                                                    <strong class="d-block text-gray-900" style="font-size: 1rem;">Tambah Kelas</strong>
                                                    <span class="text-muted small">Input kelas & wali kelas</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="siswa/tambahjurusan.php" class="quick-action-card">
                                                <div class="quick-action-icon qa-cyan">
                                                    <i class="fas fa-folder-plus"></i>
                                                </div>
                                                <div>
                                                    <strong class="d-block text-gray-900" style="font-size: 1rem;">Tambah Jurusan</strong>
                                                    <span class="text-muted small">Input program keahlian baru</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Students Table Preview -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-list mr-2"></i>Daftar Siswa Terbaru
                                    </h6>
                                    <a href="siswa/siswa.php" class="btn btn-sm btn-primary">
                                        Lihat Semua Data Siswa &rarr;
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Siswa</th>
                                                    <th>NISN</th>
                                                    <th>Email</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th class="text-center" width="130">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($siswa_terbaru && mysqli_num_rows($siswa_terbaru) > 0) {
                                                    $no = 1;
                                                    while ($s = mysqli_fetch_array($siswa_terbaru)) {
                                                        $id_val = isset($s['id']) ? $s['id'] : (isset($s['id_siswa']) ? $s['id_siswa'] : (isset($s['nisn']) ? $s['nisn'] : ''));
                                                ?>
                                                <tr>
                                                    <td class="text-center font-weight-bold text-muted"><?= $no++ ?></td>
                                                    <td class="font-weight-bold text-gray-900"><?= htmlspecialchars($s['nama']) ?></td>
                                                    <td><code><?= htmlspecialchars($s['nisn']) ?></code></td>
                                                    <td><?= htmlspecialchars($s['email']) ?></td>
                                                    <td>
                                                        <?php if (isset($s['jk']) && ($s['jk'] == 'Laki-laki' || $s['jk'] == 'L')): ?>
                                                            <span class="badge-custom badge-laki"><i class="fas fa-mars"></i> Laki-laki</span>
                                                        <?php else: ?>
                                                            <span class="badge-custom badge-perempuan"><i class="fas fa-venus"></i> Perempuan</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="siswa/editsiswa.php?id=<?= urlencode($id_val) ?>" class="btn-action btn-edit" title="Edit Siswa">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="siswa/siswa.php" class="btn-action btn-delete" title="Kelola di Halaman Siswa">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                    }
                                                } else {
                                                ?>
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-4">
                                                        <i class="fas fa-info-circle mr-1"></i> Belum ada data siswa.
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white mt-4 border-top">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto font-weight-bold text-gray-600">
                        <span>Copyright &copy; <?= date('Y') ?> - PPLG 1 SMKN 1 CIOMAS</span>
                    </div>
                </div>
            </footer>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>