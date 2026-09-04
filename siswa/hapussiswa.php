<?php
include '../db.php';

$id_param = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, trim($_GET['id'])) : '';

if (!empty($id_param)) {
    // Deteksi kolom kunci pada tabel siswa
    $col_check = mysqli_query($koneksi, "SHOW COLUMNS FROM siswa");
    $columns = [];
    if ($col_check) {
        while ($c = mysqli_fetch_assoc($col_check)) {
            $columns[] = $c['Field'];
        }
    }

    $pk_col = 'id';
    if (in_array('id', $columns)) {
        $pk_col = 'id';
    } elseif (in_array('id_siswa', $columns)) {
        $pk_col = 'id_siswa';
    } elseif (in_array('nisn', $columns)) {
        $pk_col = 'nisn';
    } elseif (!empty($columns)) {
        $pk_col = $columns[0];
    }

    $where_clause = "$pk_col = '$id_param'";
    $check = mysqli_query($koneksi, "SELECT * FROM siswa WHERE $where_clause");
    
    if ($check && mysqli_num_rows($check) > 0) {
        $siswa = mysqli_fetch_assoc($check);
        $nama = urlencode($siswa['nama']);
        
        $delete = mysqli_query($koneksi, "DELETE FROM siswa WHERE $where_clause");
        if ($delete) {
            header("Location: siswa.php?status=deleted&nama=$nama");
            exit;
        } else {
            header("Location: siswa.php?status=error&msg=" . urlencode(mysqli_error($koneksi)));
            exit;
        }
    }
}

header("Location: siswa.php");
exit;
?>