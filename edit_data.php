<?php
require 'koneksi.php';

$error = '';
$success = '';
$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$get_sql = "SELECT id, nama, npm, prodi, angkatan FROM student WHERE id = $id";
$get_res = mysqli_query($koneksi, $get_sql);

if (mysqli_num_rows($get_res) === 0) {
    header('Location: index.php');
    exit;
}

$student = mysqli_fetch_assoc($get_res);
$nama = $student['nama'];
$npm = $student['npm'];
$prodi = $student['prodi'];
$angkatan = $student['angkatan'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $npm = trim($_POST['npm'] ?? '');
    $prodi = trim($_POST['prodi'] ?? '');
    $angkatan = trim($_POST['angkatan'] ?? '');

    if (empty($nama) || empty($npm) || empty($prodi) || empty($angkatan)) {
        $error = 'Semua field harus diisi!';
    } elseif (strlen($npm) < 10 || !is_numeric($npm)) {
        $error = 'NPM harus berupa angka minimal 10 digit!';
    } else {
        $check_sql = "SELECT id FROM student WHERE npm = '" . mysqli_real_escape_string($koneksi, $npm) . "' AND id != $id";
        $check_res = mysqli_query($koneksi, $check_sql);

        if (mysqli_num_rows($check_res) > 0) {
            $error = 'NPM sudah terdaftar untuk mahasiswa lain!';
        } else {
            $update_sql = "UPDATE student SET
                          nama = '" . mysqli_real_escape_string($koneksi, $nama) . "',
                          npm = '" . mysqli_real_escape_string($koneksi, $npm) . "',
                          prodi = '" . mysqli_real_escape_string($koneksi, $prodi) . "',
                          angkatan = '" . mysqli_real_escape_string($koneksi, $angkatan) . "'
                          WHERE id = $id";

            if (mysqli_query($koneksi, $update_sql)) {
                $success = 'Data berhasil diperbarui!';
                // Update student data
                $student['nama'] = $nama;
                $student['npm'] = $npm;
                $student['prodi'] = $prodi;
                $student['angkatan'] = $angkatan;
            } else {
                $error = 'Terjadi kesalahan: ' . mysqli_error($koneksi);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa</title>
    <link rel="icon" type="image/png"
        href="https://res.cloudinary.com/dsirus0pz/image/upload/v1774681310/uty-campus_i8pc7v.png">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
        body {
            background-color: #F7EDE8;
            font-family: 'Montserrat Alternates', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">

    <!-- Main Content -->
    <main class="flex-1 px-6 py-10 max-w-2xl mx-auto w-full">

        <h1 class="text-3xl font-black italic tracking-widest text-black mb-2">Edit Data Mahasiswa</h1>
        <p class="text-[#7A6E6A] text-sm mb-8">Ubah data mahasiswa yang sudah terdaftar dalam sistem Portal UTY.</p>

        <div class="bg-white border-2 border-black shadow-[6px_6px_0px_#E8715A] rounded-xl p-6 overflow-hidden">

            <?php if ($error): ?>
                <div class="mb-4 p-4 bg-[#DC3545] border-2 border-[#DC3545] text-white rounded-md">
                    <p class="font-semibold"><?= htmlspecialchars($error) ?></p>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="mb-4 p-4 bg-[#28A745] border-2 border-[#28A745] text-white rounded-md">
                    <p class="font-semibold"><?= htmlspecialchars($success) ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" action="edit_data.php?id=<?= $id ?>">

                <div class="mb-6">
                    <label for="nama" class="block text-sm font-bold text-black mb-2">Nama</label>
                    <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($nama) ?>"
                        placeholder="Masukkan nama mahasiswa" required autofocus autocomplete="off"
                        class="w-full px-4 py-2.5 border-2 border-black rounded-md text-sm font-medium text-black placeholder-[#7A6E6A] outline-none shadow-[3px_3px_0px_rgba(0,0,0,0.15)] focus:shadow-[3px_3px_0px_#E8715A] transition-all duration-200 bg-[#F7EDE8]">
                </div>

                <div class="mb-6">
                    <label for="npm" class="block text-sm font-bold text-black mb-2">NPM</label>
                    <input type="text" id="npm" name="npm" value="<?= htmlspecialchars($npm) ?>"
                        placeholder="Masukkan NPM (10 digit)"  required autofocus autocomplete="off"
                        class="w-full px-4 py-2.5 border-2 border-black rounded-md text-sm font-medium text-black placeholder-[#7A6E6A] outline-none shadow-[3px_3px_0px_rgba(0,0,0,0.15)] focus:shadow-[3px_3px_0px_#E8715A] transition-all duration-200 bg-[#F7EDE8]">
                </div>

                <div class="mb-6">
                    <label for="prodi" class="block text-sm font-bold text-black mb-2">Program Studi</label>
                    <input type="text" id="prodi" name="prodi" value="<?= htmlspecialchars($prodi) ?>"
                        placeholder="Masukkan program studi" required autofocus autocomplete="off"
                        class="w-full px-4 py-2.5 border-2 border-black rounded-md text-sm font-medium text-black placeholder-[#7A6E6A] outline-none shadow-[3px_3px_0px_rgba(0,0,0,0.15)] focus:shadow-[3px_3px_0px_#E8715A] transition-all duration-200 bg-[#F7EDE8]">
                </div>

                <div class="mb-6">
                    <label for="angkatan" class="block text-sm font-bold text-black mb-2">Angkatan</label>
                    <input type="text" id="angkatan" name="angkatan" value="<?= htmlspecialchars($angkatan) ?>"
                        placeholder="Masukkan tahun angkatan" required autofocus autocomplete="off"
                        class="w-full px-4 py-2.5 border-2 border-black rounded-md text-sm font-medium text-black placeholder-[#7A6E6A] outline-none shadow-[3px_3px_0px_rgba(0,0,0,0.15)] focus:shadow-[3px_3px_0px_#E8715A] transition-all duration-200 bg-[#F7EDE8]">
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-[#007BFF] text-white text-sm font-bold px-6 py-3 rounded-md shadow-[4px_4px_0px_rgba(0,123,255,0.5)] hover:shadow-[0px_0px_0px] transition-all duration-200 cursor-pointer">
                        Perbarui Data
                    </button>
                    <a href="index.php"
                        class="flex-1 bg-[#6C757D] text-white text-sm font-bold px-6 py-3 rounded-md shadow-[4px_4px_0px_rgba(108,117,125,0.5)] hover:shadow-[0px_0px_0px] transition-all duration-200 no-underline text-center">
                        Batal
                    </a>
                </div>

            </form>

        </div>

    </main>
    <!-- End of Main Content  -->

</body>

</html>
