<?php
$add_error = '';
$add_success = '';
$add_form = [
    'nama' => '',
    'npm' => '',
    'prodi' => '',
    'angkatan' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['modal_action'] ?? '') === 'add_data') {
    $add_form['nama'] = trim($_POST['nama'] ?? '');
    $add_form['npm'] = trim($_POST['npm'] ?? '');
    $add_form['prodi'] = trim($_POST['prodi'] ?? '');
    $add_form['angkatan'] = trim($_POST['angkatan'] ?? '');

    if ($add_form['nama'] === '' || $add_form['npm'] === '' || $add_form['prodi'] === '' || $add_form['angkatan'] === '') {
        $add_error = 'Semua field harus diisi!';
    } elseif (strlen($add_form['npm']) < 10 || !is_numeric($add_form['npm'])) {
        $add_error = 'NPM harus berupa angka minimal 10 digit!';
    } else {
        $npm_safe = mysqli_real_escape_string($koneksi, $add_form['npm']);
        $check_sql = "SELECT id FROM student WHERE npm = '" . $npm_safe . "'";
        $check_res = mysqli_query($koneksi, $check_sql);

        if (mysqli_num_rows($check_res) > 0) {
            $add_error = 'NPM sudah terdaftar dalam sistem!';
        } else {
            $insert_sql = "INSERT INTO student (nama, npm, prodi, angkatan) VALUES (" .
                "'" . mysqli_real_escape_string($koneksi, $add_form['nama']) . "'," .
                "'" . $npm_safe . "'," .
                "'" . mysqli_real_escape_string($koneksi, $add_form['prodi']) . "'," .
                "'" . mysqli_real_escape_string($koneksi, $add_form['angkatan']) . "')";

            if (mysqli_query($koneksi, $insert_sql)) {
                $add_success = 'Data berhasil ditambahkan!';
                $add_form = [
                    'nama' => '',
                    'npm' => '',
                    'prodi' => '',
                    'angkatan' => ''
                ];
            } else {
                $add_error = 'Terjadi kesalahan: ' . mysqli_error($koneksi);
            }
        }
    }
}
