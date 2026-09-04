<?php
include '../db.php';

// Ambil data kelas tanpa hardcode kolom order
$data = mysqli_query($koneksi, "SELECT * FROM kelas");
$total_kelas = $data ? mysqli_num_rows($data) : 0;

// Hitung jumlah siswa per kelas
$siswa_count_map = [];
$q_counts = mysqli_query($koneksi, "SELECT kelas, COUNT(*) as total FROM siswa GROUP BY kelas");
if ($q_counts) {
    while ($rc = mysqli_fetch_assoc($q_counts)) {
        $siswa_count_map[$rc['kelas']] = (int)$rc['total'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Kelas - Sistem Akademik PPLG 1</title>

    <!-- Fonts & Icons -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../css/custom.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Toast Notifications Container -->
    <div id="toast-container">
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'deleted'): ?>
                <div class="toast-box toast-danger">
                    <div class="toast-icon danger"><i class="fas fa-trash-alt"></i></div>
                    <div class="toast-content">
                        <strong>Data Kelas Dihapus!</strong>
                        <span>Data kelas <?= isset($_GET['nama']) ? htmlspecialchars($_GET['nama']) : '' ?> berhasil dihapus.</span>
                    </div>
                </div>
            <?php elseif ($_GET['status'] == 'updated'): ?>
                <div class="toast-box toast-primary">
                    <div class="toast-icon primary"><i class="fas fa-check"></i></div>
                    <div class="toast-content">
                        <strong>Perubahan Disimpan!</strong>
                        <span>Data kelas berhasil diperbarui.</span>
                    </div>
                </div>
            <?php elseif ($_GET['status'] == 'added'): ?>
                <div class="toast-box">
                    <div class="toast-icon success"><i class="fas fa-check-circle"></i></div>
                    <div class="toast-content">
                        <strong>Data Ditambahkan!</strong>
                        <span>Data kelas baru berhasil disimpan.</span>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-graduation-cap fa-lg"></i>
                </div>
                <div class="sidebar-brand-text mx-3">AKADEMIK <sup>PPLG 1</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <div class="sidebar-heading text-light font-weight-bold" style="font-size: 0.7rem; opacity: 0.8;">
                MANAJEMEN DATA
            </div>

            <!-- Nav Item - Bank Data Menu -->
            <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-database"></i>
                    <span>Bank Data</span>
                </a>
                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="siswa.php"><i class="fas fa-user-graduate mr-2 text-primary"></i>Data Siswa</a>
                        <a class="collapse-item active" href="kelas.php"><i class="fas fa-chalkboard-teacher mr-2 text-success"></i>Data Kelas</a>
                        <a class="collapse-item" href="jurusan.php"><i class="fas fa-school mr-2 text-info"></i>Data Jurusan</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler -->
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
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
                        <span class="text-gray-700 font-weight-bold">
                            <i class="fas fa-chalkboard-teacher text-success mr-2"></i>Kelola Data Kelas
                        </span>
                    </div>

                    <!-- Topbar Navbar -->
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
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Header -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h1 class="h3 mb-0 text-gray-800">
                                <i class="fas fa-chalkboard-teacher mr-2 text-success"></i>Manajemen Data Kelas
                            </h1>
                            <p class="page-subtitle">Daftar kelas rombel, jurusan terhubung, dan wali kelas</p>
                        </div>
                        <a href="tambahkelas.php" class="btn btn-success shadow-sm">
                            <i class="fas fa-plus mr-1"></i> Tambah Kelas Baru
                        </a>
                    </div>

                    <!-- Data Table Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <span class="font-weight-bold text-success">
                                <i class="fas fa-table mr-2"></i>Tabel Data Kelas
                                <span class="badge badge-success ml-2" style="font-size: 0.8rem; border-radius: 6px;"><?= $total_kelas ?> Kelas</span>
                            </span>
                            <div class="form-inline">
                                <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Cari nama kelas / wali..." style="width: 200px;">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="kelasTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="60">No</th>
                                            <th>Nama Kelas</th>
                                            <th>Jurusan</th>
                                            <th>Wali Kelas</th>
                                            <th class="text-center">Daftar Siswa</th>
                                            <th class="text-center" width="100">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        if ($data && mysqli_num_rows($data) > 0) {
                                            while ($k = mysqli_fetch_array($data)) {
                                                $id_val = isset($k['id']) ? $k['id'] : (isset($k['id_kelas']) ? $k['id_kelas'] : (isset($k['nama']) ? $k['nama'] : ''));
                                        ?>
                                        <?php
                                            $nama_kelas = $k['nama'];
                                            $jml_siswa  = isset($siswa_count_map[$nama_kelas]) ? $siswa_count_map[$nama_kelas] : 0;
                                        ?>
                                        <tr>
                                            <td class="text-center font-weight-bold text-muted"><?= $i++ ?></td>
                                            <td class="font-weight-bold text-gray-900">
                                                <i class="fas fa-door-open text-gray-400 mr-2"></i>
                                                <?= htmlspecialchars($k['nama']) ?>
                                            </td>
                                            <td>
                                                <span class="badge-custom badge-jurusan">
                                                    <i class="fas fa-graduation-cap"></i>
                                                    <?= htmlspecialchars($k['jurusan']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <i class="fas fa-user-tie text-muted mr-1"></i>
                                                <?= htmlspecialchars($k['wali_kelas']) ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="siswa.php?kelas=<?= urlencode($k['nama']) ?>" title="Lihat Daftar Siswa Kelas <?= htmlspecialchars($k['nama']) ?>" style="text-decoration: none;">
                                                    <?php if ($jml_siswa > 0): ?>
                                                        <span style="display: inline-flex; align-items: center; gap: 6px; background: #e0e7ff; color: #4338ca; font-weight: 700; font-size: 0.85rem; padding: 5px 14px; border-radius: 20px; border: 1.5px solid #c7d2fe; transition: all .2s;">
                                                            <i class="fas fa-users"></i>
                                                            <?= $jml_siswa ?> Siswa
                                                        </span>
                                                    <?php else: ?>
                                                        <span style="display: inline-flex; align-items: center; gap: 6px; background: #f1f5f9; color: #94a3b8; font-weight: 600; font-size: 0.82rem; padding: 5px 12px; border-radius: 20px; border: 1.5px solid #e2e8f0;">
                                                            <i class="fas fa-user-slash"></i>
                                                            Belum Ada
                                                        </span>
                                                    <?php endif; ?>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="editkelas.php?id=<?= urlencode($id_val) ?>" class="btn-action btn-edit" title="Edit Data Kelas">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn-action btn-delete" 
                                                        title="Hapus Kelas" 
                                                        onclick="confirmDeleteKelas('<?= htmlspecialchars(addslashes($id_val)) ?>', '<?= htmlspecialchars(addslashes($k['nama'])) ?>')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        } else {
                                        ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fas fa-chalkboard fa-3x mb-3 d-block text-gray-300"></i>
                                                Belum ada data kelas yang tersimpan.
                                                <br>
                                                <a href="tambahkelas.php" class="btn btn-sm btn-success mt-3">
                                                    <i class="fas fa-plus mr-1"></i> Tambah Kelas Sekarang
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white border-top">
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

    <!-- Modal Konfirmasi Hapus Kelas -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center p-4">
                <div class="modal-body">
                    <div class="modal-delete-icon-wrapper">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h4 class="font-weight-bold text-gray-900 mb-2">Hapus Data Kelas?</h4>
                    <p class="text-muted mb-4">
                        Apakah Anda yakin ingin menghapus rombel kelas <strong id="deleteNama" class="text-danger"></strong>?
                        <br><small class="text-muted">Data kelas yang dihapus tidak dapat dipulihkan kembali.</small>
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" class="btn btn-secondary px-4 mr-2" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Batal
                        </button>
                        <a id="btnConfirmDelete" href="#" class="btn btn-danger px-4">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>

    <script>
        function confirmDeleteKelas(id, nama) {
            document.getElementById('deleteNama').innerText = nama;
            document.getElementById('btnConfirmDelete').href = 'hapuskelas.php?id=' + encodeURIComponent(id);
            $('#deleteModal').modal('show');
        }

        // Live search filter
        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#kelasTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Auto dismiss toast after 4s
        setTimeout(function() {
            $('.toast-box').addClass('hiding');
            setTimeout(function() {
                $('.toast-box').remove();
            }, 400);
        }, 4000);
    </script>

</body>

</html>
