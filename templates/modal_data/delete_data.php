<?php
$delete_error = '';
$delete_success = '';
$delete_form = [
    'id' => '',
    'nama' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['modal_action'] ?? '') === 'delete_data') {
    $delete_form['id'] = (int) ($_POST['id'] ?? 0);
    $delete_form['nama'] = trim($_POST['nama'] ?? '');

    if ($delete_form['id'] <= 0) {
        $delete_error = 'Data mahasiswa tidak ditemukan.';
    } else {
        $check_sql = "SELECT id FROM student WHERE id = " . $delete_form['id'];
        $check_res = mysqli_query($koneksi, $check_sql);

        if (mysqli_num_rows($check_res) === 0) {
            $delete_error = 'Data mahasiswa tidak ditemukan.';
        } else {
            $delete_sql = "DELETE FROM student WHERE id = " . $delete_form['id'];

            if (mysqli_query($koneksi, $delete_sql)) {
                $delete_success = 'Data berhasil dihapus!';
                $delete_form = [
                    'id' => '',
                    'nama' => ''
                ];
            } else {
                $delete_error = 'Terjadi kesalahan: ' . mysqli_error($koneksi);
            }
        }
    }
}
