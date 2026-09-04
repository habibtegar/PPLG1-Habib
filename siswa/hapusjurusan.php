<?php
/** @var mysqli $koneksi */
require_once '../db.php';

$id_param = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, trim($_GET['id'])) : '';

if (!empty($id_param)) {
    // Deteksi kolom kunci pada tabel jurusan
    $col_check = mysqli_query($koneksi, "SHOW COLUMNS FROM jurusan");
    $columns = [];
    if ($col_check) {
        while ($c = mysqli_fetch_assoc($col_check)) {
            $columns[] = $c['Field'];
        }
    }

    $pk_col = 'id';
    if (in_array('id', $columns)) {
        $pk_col = 'id';
    } elseif (in_array('id_jurusan', $columns)) {
        $pk_col = 'id_jurusan';
    } elseif (in_array('kode', $columns)) {
        $pk_col = 'kode';
    } elseif (!empty($columns)) {
        $pk_col = $columns[0];
    }

    $where_clause = "$pk_col = '$id_param'";
    $check = mysqli_query($koneksi, "SELECT * FROM jurusan WHERE $where_clause");
    
    if ($check && mysqli_num_rows($check) > 0) {
        $jurusan = mysqli_fetch_assoc($check);
        $nama = urlencode($jurusan['nama']);
        
        $delete = mysqli_query($koneksi, "DELETE FROM jurusan WHERE $where_clause");
        if ($delete) {
            header("Location: jurusan.php?status=deleted&nama=$nama");
            exit;
        } else {
            header("Location: jurusan.php?status=error&msg=" . urlencode(mysqli_error($koneksi)));
            exit;
        }
    }
}

header("Location: jurusan.php");
exit;
?>
