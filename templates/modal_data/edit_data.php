<?php
$edit_error = '';
$edit_success = '';
$edit_form = [
    'id' => '',
    'nama' => '',
    'npm' => '',
    'prodi' => '',
    'angkatan' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['modal_action'] ?? '') === 'edit_data') {
    $edit_form['id'] = (int) ($_POST['id'] ?? 0);
    $edit_form['nama'] = trim($_POST['nama'] ?? '');
    $edit_form['npm'] = trim($_POST['npm'] ?? '');
    $edit_form['prodi'] = trim($_POST['prodi'] ?? '');
    $edit_form['angkatan'] = trim($_POST['angkatan'] ?? '');

    if ($edit_form['id'] <= 0) {
        $edit_error = 'Data mahasiswa tidak ditemukan.';
    } elseif ($edit_form['nama'] === '' || $edit_form['npm'] === '' || $edit_form['prodi'] === '' || $edit_form['angkatan'] === '') {
        $edit_error = 'Semua field harus diisi!';
    } elseif (strlen($edit_form['npm']) < 10 || !is_numeric($edit_form['npm'])) {
        $edit_error = 'NPM harus berupa angka minimal 10 digit!';
    } else {
        $npm_safe = mysqli_real_escape_string($koneksi, $edit_form['npm']);
        $check_sql = "SELECT id FROM student WHERE npm = '" . $npm_safe . "' AND id != " . $edit_form['id'];
        $check_res = mysqli_query($koneksi, $check_sql);

        if (mysqli_num_rows($check_res) > 0) {
            $edit_error = 'NPM sudah terdaftar untuk mahasiswa lain!';
        } else {
            $update_sql = "UPDATE student SET " .
                "nama = '" . mysqli_real_escape_string($koneksi, $edit_form['nama']) . "', " .
                "npm = '" . $npm_safe . "', " .
                "prodi = '" . mysqli_real_escape_string($koneksi, $edit_form['prodi']) . "', " .
                "angkatan = '" . mysqli_real_escape_string($koneksi, $edit_form['angkatan']) . "' " .
                "WHERE id = " . $edit_form['id'];

            if (mysqli_query($koneksi, $update_sql)) {
                $edit_success = 'Data berhasil diperbarui!';
                $edit_form = [
                    'id' => '',
                    'nama' => '',
                    'npm' => '',
                    'prodi' => '',
                    'angkatan' => ''
                ];
            } else {
                $edit_error = 'Terjadi kesalahan: ' . mysqli_error($koneksi);
            }
        }
    }
}
