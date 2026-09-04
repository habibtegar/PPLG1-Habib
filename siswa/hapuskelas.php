<?php
/** @var mysqli $koneksi */
require_once '../db.php';

$id_param = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, trim($_GET['id'])) : '';

if (!empty($id_param)) {
    // Deteksi kolom kunci pada tabel kelas
    $col_check = mysqli_query($koneksi, "SHOW COLUMNS FROM kelas");
    $columns = [];
    if ($col_check) {
        while ($c = mysqli_fetch_assoc($col_check)) {
            $columns[] = $c['Field'];
        }
    }

    $pk_col = 'id';
    if (in_array('id', $columns)) {
        $pk_col = 'id';
    } elseif (in_array('id_kelas', $columns)) {
        $pk_col = 'id_kelas';
    } elseif (in_array('nama', $columns)) {
        $pk_col = 'nama';
    } elseif (!empty($columns)) {
        $pk_col = $columns[0];
    }

    $where_clause = "$pk_col = '$id_param'";
    $check = mysqli_query($koneksi, "SELECT * FROM kelas WHERE $where_clause");
    
    if ($check && mysqli_num_rows($check) > 0) {
        $kelas = mysqli_fetch_assoc($check);
        $nama = urlencode($kelas['nama']);
        
        $delete = mysqli_query($koneksi, "DELETE FROM kelas WHERE $where_clause");
        if ($delete) {
            header("Location: kelas.php?status=deleted&nama=$nama");
            exit;
        } else {
            header("Location: kelas.php?status=error&msg=" . urlencode(mysqli_error($koneksi)));
            exit;
        }
    }
}

header("Location: kelas.php");
exit;
?>
