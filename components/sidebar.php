<?php
/**
 * Komponen Sidebar Sistem Akademik PPLG 1
 * Dilengkapi Navigasi Lengkap, Kategori Sistem, Profil Pengguna, dan Badge Counter.
 */

// 1. Deteksi path dasar (root vs subdirektori siswa/) secara otomatis & akurat
$in_siswa_folder = (basename(dirname($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? '')) === 'siswa') || !file_exists('db.php');
$base_url        = $in_siswa_folder ? '../' : '';
$siswa_url       = $in_siswa_folder ? '' : 'siswa/';

// 2. Deteksi file halaman yang sedang diakses
$current_page = basename($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? 'index.php');

// 3. Pastikan koneksi DB tersedia untuk query counter badge
if (!isset($koneksi) || !($koneksi instanceof mysqli)) {
    $db_file = $in_siswa_folder ? __DIR__ . '/../db.php' : __DIR__ . '/../db.php';
    if (file_exists($db_file)) {
        @include_once $db_file;
    }
}

// 4. Hitung jumlah data (badge counter) jika belum diset dari file utama
$count_siswa   = $count_siswa ?? null;
$count_kelas   = $count_kelas ?? null;
$count_jurusan = $count_jurusan ?? null;

if ($count_siswa === null || $count_kelas === null || $count_jurusan === null) {
    if (isset($koneksi) && $koneksi instanceof mysqli) {
        if ($count_siswa === null) {
            $q_siswa = @mysqli_query($koneksi, "SELECT COUNT(*) as total FROM siswa");
            $count_siswa = ($q_siswa && $r_s = mysqli_fetch_assoc($q_siswa)) ? (int)$r_s['total'] : 0;
        }
        if ($count_kelas === null) {
            $q_kelas = @mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kelas");
            $count_kelas = ($q_kelas && $r_k = mysqli_fetch_assoc($q_kelas)) ? (int)$r_k['total'] : 0;
        }
        if ($count_jurusan === null) {
            $q_jurusan = @mysqli_query($koneksi, "SELECT COUNT(*) as total FROM jurusan");
            $count_jurusan = ($q_jurusan && $r_j = mysqli_fetch_assoc($q_jurusan)) ? (int)$r_j['total'] : 0;
        }
    } else {
        $count_siswa   = $count_siswa ?? 0;
        $count_kelas   = $count_kelas ?? 0;
        $count_jurusan = $count_jurusan ?? 0;
    }
}

// 5. Status aktif untuk navigasi
$is_dash_active    = ($current_page === 'index.php');
$is_siswa_active   = in_array($current_page, ['siswa.php', 'tambahsiswa.php', 'editsiswa.php']);
$is_kelas_active   = in_array($current_page, ['kelas.php', 'tambahkelas.php', 'editkelas.php']);
$is_jurusan_active = in_array($current_page, ['jurusan.php', 'tambahjurusan.php', 'editjurusan.php']);
$is_bank_active    = ($is_siswa_active || $is_kelas_active || $is_jurusan_active);
$is_user_active    = in_array($current_page, ['pengguna.php', 'user.php']);
$is_setting_active = in_array($current_page, ['pengaturan.php', 'setting.php']);
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $base_url ?>index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-graduation-cap fa-lg"></i>
        </div>
        <div class="sidebar-brand-text mx-3">AKADEMIK <sup>PPLG 1</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= $is_dash_active ? 'active' : '' ?>">
        <a class="nav-link" href="<?= $base_url ?>index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading MANAJEMEN DATA -->
    <div class="sidebar-heading text-light font-weight-bold" style="font-size: 0.7rem; opacity: 0.8;">
        MANAJEMEN DATA
    </div>

    <!-- Nav Item - Bank Data Menu -->
    <li class="nav-item <?= $is_bank_active ? 'active' : '' ?>">
        <a class="nav-link <?= $is_bank_active ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="<?= $is_bank_active ? 'true' : 'false' ?>" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-database"></i>
            <span>Bank Data</span>
        </a>
        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?= $is_siswa_active ? 'active' : '' ?>" href="<?= $siswa_url ?>siswa.php" style="display: flex; align-items: center; justify-content: space-between;">
                    <span class="collapse-text">
                        <i class="fas fa-user-graduate mr-2 text-primary"></i>Data Siswa
                    </span>
                    <span class="sidebar-badge-counter badge-counter-primary badge badge-pill badge-primary" style="font-size: 0.72rem; font-weight: 700; padding: 2px 7px; border-radius: 9999px; background-color: #e0e7ff; color: #4338ca; border: 1px solid #c7d2fe;" title="Jumlah Siswa"><?= $count_siswa ?></span>
                </a>
                <a class="collapse-item <?= $is_kelas_active ? 'active' : '' ?>" href="<?= $siswa_url ?>kelas.php" style="display: flex; align-items: center; justify-content: space-between;">
                    <span class="collapse-text">
                        <i class="fas fa-chalkboard-teacher mr-2 text-success"></i>Data Kelas
                    </span>
                    <span class="sidebar-badge-counter badge-counter-success badge badge-pill badge-success" style="font-size: 0.72rem; font-weight: 700; padding: 2px 7px; border-radius: 9999px; background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;" title="Jumlah Kelas"><?= $count_kelas ?></span>
                </a>
                <a class="collapse-item <?= $is_jurusan_active ? 'active' : '' ?>" href="<?= $siswa_url ?>jurusan.php" style="display: flex; align-items: center; justify-content: space-between;">
                    <span class="collapse-text">
                        <i class="fas fa-school mr-2 text-info"></i>Data Jurusan
                    </span>
                    <span class="sidebar-badge-counter badge-counter-info badge badge-pill badge-info" style="font-size: 0.72rem; font-weight: 700; padding: 2px 7px; border-radius: 9999px; background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;" title="Jumlah Jurusan"><?= $count_jurusan ?></span>
                </a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading PENGATURAN SISTEM -->
    <div class="sidebar-heading text-light font-weight-bold" style="font-size: 0.7rem; opacity: 0.8;">
        PENGATURAN SISTEM
    </div>

    <!-- Nav Item - Manajemen Pengguna -->
    <li class="nav-item <?= $is_user_active ? 'active' : '' ?>">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#infoFeatureModal" data-feature="Manajemen Pengguna" data-icon="fas fa-users-cog text-primary">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Manajemen Pengguna</span>
        </a>
    </li>

    <!-- Nav Item - Pengaturan -->
    <li class="nav-item <?= $is_setting_active ? 'active' : '' ?>">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#infoFeatureModal" data-feature="Pengaturan Sistem" data-icon="fas fa-cog text-warning">
            <i class="fas fa-fw fa-cog"></i>
            <span>Pengaturan</span>
        </a>
    </li>

    <!-- Divider Menuju Profil Pengguna di Bagian Bawah -->
    <hr class="sidebar-divider d-none d-md-block my-2">

    <!-- Profil Pengguna di Bawah Sidebar (Di atas tombol collapse) -->
    <div class="sidebar-user-panel" style="padding: 0.5rem 0.85rem; width: 100%;">
        <div class="sidebar-user-card shadow-sm" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.14); border-radius: 12px; padding: 8px 10px; display: flex; align-items: center; justify-content: space-between; gap: 8px;">
            <div class="sidebar-user-avatar-wrap position-relative flex-shrink-0" style="width: 36px; height: 36px;">
                <img class="sidebar-user-avatar" 
                     src="<?= $base_url ?>img/undraw_profile.svg" 
                     alt="Avatar Administrator"
                     width="36" 
                     height="36" 
                     style="width: 36px !important; height: 36px !important; max-width: 36px !important; max-height: 36px !important; border-radius: 50% !important; object-fit: cover !important; background: #ffffff; border: 2px solid rgba(255, 255, 255, 0.3); display: block;">
                <span class="sidebar-status-dot" 
                      title="Online" 
                      style="position: absolute; bottom: -1px; right: -1px; width: 10px; height: 10px; background-color: #10b981; border: 2px solid #1e1b4b; border-radius: 50%; box-shadow: 0 0 6px rgba(16, 185, 129, 0.8);"></span>
            </div>
            <div class="sidebar-user-details" style="flex: 1; min-width: 0; display: flex; flex-direction: column; overflow: hidden;">
                <span class="sidebar-user-name" title="Administrator" style="color: #ffffff; font-size: 0.82rem; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.25;">Administrator</span>
                <span class="sidebar-user-badge" style="color: rgba(255, 255, 255, 0.6); font-size: 0.68rem; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Super Admin</span>
            </div>
            <button type="button" 
                    class="btn-sidebar-logout" 
                    data-toggle="modal" 
                    data-target="#logoutModal" 
                    title="Keluar / Logout" 
                    aria-label="Logout"
                    style="flex-shrink: 0; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; border: 1px solid rgba(244, 63, 94, 0.3); background: rgba(244, 63, 94, 0.15); color: #fb7185; font-size: 0.88rem; cursor: pointer; outline: none; padding: 0;">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </div>
    </div>

    <!-- Sidebar Toggler (Sidebar Collapse Button) -->
    <div class="text-center d-none d-md-inline my-2">
        <button class="rounded-circle border-0" id="sidebarToggle" title="Toggle Sidebar"></button>
    </div>

</ul>
<!-- End of Sidebar -->

<!-- Modal Konfirmasi Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg" style="border-radius: 16px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-weight-bold text-gray-800" id="logoutModalLabel">
                    <i class="fas fa-sign-out-alt text-danger mr-2"></i>Konfirmasi Logout
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-gray-600 py-3">
                Apakah Anda yakin ingin keluar dari sesi <strong>Administrator</strong> Sistem Akademik?
            </div>
            <div class="modal-footer border-0 pt-0">
                <button class="btn btn-secondary px-3" type="button" data-dismiss="modal" style="border-radius: 8px;">Batal</button>
                <a class="btn btn-danger px-4 font-weight-bold" href="<?= $base_url ?>index.php" style="border-radius: 8px; background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%); border: none;">Keluar</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Informasi Fitur Segera Hadir -->
<div class="modal fade" id="infoFeatureModal" tabindex="-1" role="dialog" aria-labelledby="infoFeatureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg" style="border-radius: 16px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-weight-bold text-gray-800" id="infoFeatureModalLabel">
                    <i class="fas fa-info-circle text-primary mr-2" id="infoFeatureIcon"></i><span id="infoFeatureTitle">Pemberitahuan</span>
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-gray-600 py-3">
                Fitur <strong id="infoFeatureName" class="text-primary">Fitur Terpilih</strong> saat ini sedang dalam proses pengembangan dan akan segera aktif pada rilis pembaruan berikutnya.
            </div>
            <div class="modal-footer border-0 pt-0">
                <button class="btn btn-primary px-4 font-weight-bold" type="button" data-dismiss="modal" style="border-radius: 8px; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); border: none;">Mengerti</button>
            </div>
        </div>
    </div>
</div>

<script>
// Script kecil untuk modal informasi fitur baru jika jQuery sudah ter-load
document.addEventListener('DOMContentLoaded', function() {
    if (window.jQuery) {
        $('#infoFeatureModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var feature = button.data('feature') || 'Fitur Sistem';
            var iconClass = button.data('icon') || 'fas fa-info-circle text-primary';
            var modal = $(this);
            modal.find('#infoFeatureTitle').text(feature);
            modal.find('#infoFeatureName').text(feature);
            modal.find('#infoFeatureIcon').attr('class', iconClass + ' mr-2');
        });
    }
});
</script>
