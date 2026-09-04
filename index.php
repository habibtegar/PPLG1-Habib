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
    $jumlah_jurusan = $row ? (int)$row[0] : 0;
}

// Hitung data statistik banyaknya siswa untuk grafik
$jml_laki = 0;
$jml_perempuan = 0;

$q_jk = mysqli_query($koneksi, "SELECT jk, COUNT(*) as total FROM siswa GROUP BY jk");
if ($q_jk) {
    while ($row_jk = mysqli_fetch_assoc($q_jk)) {
        $jk_lower = strtolower(trim($row_jk['jk']));
        if ($jk_lower == 'laki-laki' || $jk_lower == 'l') {
            $jml_laki += (int)$row_jk['total'];
        } else if ($jk_lower == 'perempuan' || $jk_lower == 'p') {
            $jml_perempuan += (int)$row_jk['total'];
        }
    }
}

// Persentase jenis kelamin
$persen_laki = $jumlah_siswa > 0 ? round(($jml_laki / $jumlah_siswa) * 100, 1) : 0;
$persen_perempuan = $jumlah_siswa > 0 ? round(($jml_perempuan / $jumlah_siswa) * 100, 1) : 0;
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

                    <!-- Row Grafik Banyaknya Siswa -->
                    <div class="row">

                        <!-- Bar Chart Banyaknya Siswa -->
                        <div class="col-xl-8 col-lg-7 mb-4">
                            <div class="card shadow mb-4 h-100">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-chart-bar mr-2"></i>Grafik Banyaknya Siswa Berdasarkan Kategori
                                    </h6>
                                    <div class="badge badge-primary px-3 py-2" style="border-radius: 8px; font-weight: 700; font-size: 0.85rem;">
                                        Total: <?= $jumlah_siswa ?> Siswa
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-bar" style="position: relative; height: 310px;">
                                        <canvas id="siswaBarChart"></canvas>
                                    </div>
                                    <hr>
                                    <div class="row text-center pt-2">
                                        <div class="col-4 border-right">
                                            <small class="text-muted d-block font-weight-bold">Siswa Laki-laki</small>
                                            <span class="font-weight-bold text-primary h5"><?= $jml_laki ?></span>
                                            <span class="text-muted small"> (<?= $persen_laki ?>%)</span>
                                        </div>
                                        <div class="col-4 border-right">
                                            <small class="text-muted d-block font-weight-bold">Siswa Perempuan</small>
                                            <span class="font-weight-bold text-danger h5"><?= $jml_perempuan ?></span>
                                            <span class="text-muted small"> (<?= $persen_perempuan ?>%)</span>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted d-block font-weight-bold">Total Terdaftar</small>
                                            <span class="font-weight-bold text-success h5"><?= $jumlah_siswa ?></span>
                                            <span class="text-muted small"> Siswa</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Donut Chart Proporsi Siswa -->
                        <div class="col-xl-4 col-lg-5 mb-4">
                            <div class="card shadow mb-4 h-100">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-chart-pie mr-2"></i>Komposisi Gender Siswa
                                    </h6>
                                    <a href="siswa/siswa.php" class="btn btn-sm btn-primary" style="padding: 4px 10px; font-size: 0.8rem;">
                                        Kelola Siswa &rarr;
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-2 pb-2" style="position: relative; height: 240px;">
                                        <canvas id="siswaPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small font-weight-bold">
                                        <span class="mr-3 d-inline-block mb-2">
                                            <i class="fas fa-circle mr-1" style="color: #4f46e5;"></i> Laki-laki: <strong><?= $jml_laki ?></strong> (<?= $persen_laki ?>%)
                                        </span>
                                        <span class="d-inline-block mb-2">
                                            <i class="fas fa-circle mr-1" style="color: #f43f5e;"></i> Perempuan: <strong><?= $jml_perempuan ?></strong> (<?= $persen_perempuan ?>%)
                                        </span>
                                    </div>
                                    <div class="alert alert-light border mt-3 mb-0 text-center py-2" style="border-radius: 10px; font-size: 0.85rem;">
                                        <i class="fas fa-users text-primary mr-1"></i> Rasio gender: <strong><?= $jml_perempuan > 0 ? round(($jml_laki / max(1, $jml_perempuan)), 1) . ' : 1' : ($jml_laki > 0 ? '100% L' : '0') ?></strong>
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
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Inisialisasi Grafik Banyaknya Siswa -->
    <script>
        // Set font default
        Chart.defaults.global.defaultFontFamily = "'Plus Jakarta Sans', -apple-system, system-ui, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif";
        Chart.defaults.global.defaultFontColor = '#64748b';

        // 1. Bar Chart: Banyaknya Siswa
        var ctxBar = document.getElementById("siswaBarChart");
        if (ctxBar) {
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ["Laki-laki", "Perempuan", "Total Siswa"],
                    datasets: [{
                        label: "Banyaknya Siswa",
                        backgroundColor: ['#4f46e5', '#f43f5e', '#10b981'],
                        hoverBackgroundColor: ['#4338ca', '#e11d48', '#059669'],
                        borderColor: ['#4f46e5', '#f43f5e', '#10b981'],
                        borderWidth: 1,
                        data: [<?= $jml_laki ?>, <?= $jml_perempuan ?>, <?= $jumlah_siswa ?>],
                        maxBarThickness: 60
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    layout: {
                        padding: { left: 10, right: 20, top: 20, bottom: 0 }
                    },
                    scales: {
                        xAxes: [{
                            gridLines: { display: false, drawBorder: false },
                            ticks: { fontStyle: '600', fontColor: '#475569' }
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                suggestedMax: <?= max(5, $jumlah_siswa + 2) ?>,
                                padding: 10,
                                precision: 0,
                                callback: function(value) { return value + ' org'; }
                            },
                            gridLines: {
                                color: "rgba(226, 232, 240, 0.7)",
                                zeroLineColor: "rgba(226, 232, 240, 0.7)",
                                drawBorder: false,
                                borderDash: [3, 3],
                                zeroLineBorderDash: [3, 3]
                            }
                        }]
                    },
                    legend: { display: false },
                    tooltips: {
                        backgroundColor: "#ffffff",
                        titleFontColor: "#1e293b",
                        bodyFontColor: "#475569",
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        xPadding: 14,
                        yPadding: 12,
                        displayColors: true,
                        caretPadding: 8,
                        callbacks: {
                            label: function(tooltipItem, chart) {
                                return ' ' + tooltipItem.yLabel + ' Siswa';
                            }
                        }
                    }
                }
            });
        }

        // 2. Donut Chart: Komposisi Jenis Kelamin Siswa
        var ctxPie = document.getElementById("siswaPieChart");
        if (ctxPie) {
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: ["Laki-laki", "Perempuan"],
                    datasets: [{
                        data: [<?= $jml_laki ?>, <?= $jml_perempuan ?>],
                        backgroundColor: ['#4f46e5', '#f43f5e'],
                        hoverBackgroundColor: ['#4338ca', '#e11d48'],
                        hoverBorderColor: "#ffffff",
                        borderWidth: 3
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    tooltips: {
                        backgroundColor: "#ffffff",
                        titleFontColor: "#1e293b",
                        bodyFontColor: "#475569",
                        borderColor: '#e2e8f0',
                        borderWidth: 1,
                        xPadding: 14,
                        yPadding: 12,
                        caretPadding: 8,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var dataset = data.datasets[tooltipItem.datasetIndex];
                                var total = dataset.data.reduce(function(prev, curr) { return prev + curr; }, 0);
                                var value = dataset.data[tooltipItem.index];
                                var percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return ' ' + data.labels[tooltipItem.index] + ': ' + value + ' Siswa (' + percentage + '%)';
                            }
                        }
                    },
                    legend: { display: false },
                    cutoutPercentage: 72
                }
            });
        }
    </script>

</body>

</html>