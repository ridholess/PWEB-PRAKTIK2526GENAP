<?php
session_start();
require 'koneksi.php';
require 'templates/modal_data/add_data.php';
require 'templates/modal_data/edit_data.php';
require 'templates/modal_data/delete_data.php';
require 'templates/readData.php';
require 'templates/function.php';

if (!isset($_SESSION["login"])) {
    header("Location: ./");
    exit;
}

$nama_user = $_SESSION["nama_user"];


?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="icon" type="image/png"
        href="https://res.cloudinary.com/dsirus0pz/image/upload/v1774681310/uty-campus_i8pc7v.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="page-body">

    <!-- Main Content -->
    <main class="page-main">

        <div class="page-header">
            <h1 class="page-title">
                Data Mahasiswa
                <span class="page-badge">Week-10</span>
            </h1>
            <a href="logout.php"
                class="btn-logout">
                Logout
            </a>
        </div>
        <p class="page-subtitle">Daftar seluruh mahasiswa yang terdaftar dalam sistem Portal UTY.</p>

        <?php if ($add_success): ?>
            <div class="alert-box2 alert-success2">
                <p class="mb-0 alert-text"><?= htmlspecialchars($add_success) ?></p>
                <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
            </div>
        <?php endif; ?>

        <?php if ($edit_success): ?>
            <div class="alert-box2 alert-success2">
                <p class="mb-0 alert-text"><?= htmlspecialchars($edit_success) ?></p>
                <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
            </div>
        <?php endif; ?>

        <?php if ($delete_success): ?>
            <div class="alert-box2 alert-success-danger2">
                <p class="mb-0 alert-text"><?= htmlspecialchars($delete_success) ?></p>
                <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
            </div>
        <?php endif; ?>

        <div class="panel-card">

            <form method="GET" action="dashboard.php" id="filter-form"
                class="table-controls">
                <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
                <input type="hidden" name="dir" value="<?= htmlspecialchars($dir) ?>">
                <input type="hidden" name="page" value="1">

                <div class="control-search">
                    <svg class="search-icon"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z" />
                    </svg>
                    <input id="search-input" type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                        placeholder="Cari nama, npm, prodi..." autocomplete="off"
                        class="input-search" />
                </div>

                <div class="per-page-group">
                    <span>Tampilkan</span>
                    <select name="per_page" id="per-page-select"
                        onchange="document.getElementById('filter-form').submit()"
                        class="per-page-select">
                        <?php foreach ([5, 10, 25, 50] as $opt): ?>
                            <option value="<?= $opt ?>" <?= $per_page === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span>data</span>
                    <button type="button" class="btn-add" data-toggle="modal" data-target="#addDataModal">
                        Tambah Data
                    </button>
                </div>
            </form>

            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="table-head-cell">#</th>
                            <?php
                            $cols = ['nama' => 'Nama', 'npm' => 'NPM', 'prodi' => 'Prodi', 'angkatan' => 'Angkatan'];
                            foreach ($cols as $col => $label):
                                ?>
                                <th
                                    class="table-head-cell sortable <?= $sort === $col ? 'active' : '' ?>">
                                    <a href="<?= sort_url($col) ?>" class="sort-link">
                                        <?= $label ?> <span><?= sort_icon($col) ?></span>
                                    </a>
                                </th>
                            <?php endforeach; ?>
                            <th class="table-head-cell">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($total_rows === 0): ?>
                            <tr>
                                <td colspan="6" class="empty-row">
                                    Tidak ada data yang ditemukan.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = $offset + 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($data_res)): ?>
                                <tr>
                                    <td class="cell-muted">
                                        <?= $no++ ?>
                                    </td>
                                    <td class="cell-strong">
                                        <?= htmlspecialchars($row['nama']) ?>
                                    </td>
                                    <td class="cell-strong">
                                        <?= htmlspecialchars($row['npm']) ?>
                                    </td>
                                    <td class="cell-strong">
                                        <?= htmlspecialchars($row['prodi']) ?>
                                    </td>
                                    <td>
                                        <span class="badge-year">
                                            <?= htmlspecialchars($row['angkatan']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-group">
                                            <button type="button" class="btn-edit"
                                                data-toggle="modal" data-target="#editDataModal"
                                                data-id="<?= (int) $row['id'] ?>"
                                                data-nama="<?= htmlspecialchars($row['nama'], ENT_QUOTES) ?>"
                                                data-npm="<?= htmlspecialchars($row['npm'], ENT_QUOTES) ?>"
                                                data-prodi="<?= htmlspecialchars($row['prodi'], ENT_QUOTES) ?>"
                                                data-angkatan="<?= htmlspecialchars($row['angkatan'], ENT_QUOTES) ?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn-delete"
                                                data-toggle="modal" data-target="#deleteDataModal"
                                                data-id="<?= (int) $row['id'] ?>"
                                                data-nama="<?= htmlspecialchars($row['nama'], ENT_QUOTES) ?>">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php require './templates/footerDataTable.php'; ?>
        </div>

    </main>

    <!-- Modal: Add Data -->
    <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-card">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDataLabel">Tambah Data Mahasiswa</h5>
                    <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="modal-card-subtitle">Tambahkan data mahasiswa baru.</p>

                    <?php if ($add_error): ?>
                        <div class="alert-box alert-error">
                            <p class="mb-0"><?= htmlspecialchars($add_error) ?></p>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="dashboard.php">
                        <input type="hidden" name="modal_action" value="add_data">

                        <div class="form-group-custom">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($add_form['nama'] ?? '') ?>"
                                placeholder="Masukkan nama mahasiswa" required autocomplete="off"
                                class="form-input">
                        </div>

                        <div class="form-group-custom">
                            <label for="npm" class="form-label">NPM</label>
                            <input type="text" id="npm" name="npm" value="<?= htmlspecialchars($add_form['npm'] ?? '') ?>"
                                placeholder="Masukkan NPM (10 digit)" required autocomplete="off"
                                class="form-input">
                        </div>

                        <div class="form-group-custom">
                            <label for="prodi" class="form-label">Program Studi</label>
                            <input type="text" id="prodi" name="prodi" value="<?= htmlspecialchars($add_form['prodi'] ?? '') ?>"
                                placeholder="Masukkan program studi" required autocomplete="off"
                                class="form-input">
                        </div>

                        <div class="form-group-custom">
                            <label for="angkatan" class="form-label">Angkatan</label>
                            <input type="text" id="angkatan" name="angkatan"
                                value="<?= htmlspecialchars($add_form['angkatan'] ?? '') ?>"
                                placeholder="Masukkan tahun angkatan" required autocomplete="off"
                                class="form-input">
                        </div>

                        <div class="modal-actions">
                            <button type="submit" class="btn-submit">Simpan Data</button>
                            <button type="button" class="btn-cancel" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Modal: Add Data -->

    <!-- Modal: Edit Data -->
    <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-card">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataLabel">Edit Data Mahasiswa</h5>
                    <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="modal-card-subtitle">Ubah data mahasiswa yang sudah terdaftar.</p>

                    <?php if ($edit_error): ?>
                        <div class="alert-box alert-error">
                            <p class="mb-0"><?= htmlspecialchars($edit_error) ?></p>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="dashboard.php">
                        <input type="hidden" name="modal_action" value="edit_data">
                        <input type="hidden" name="id" id="edit-id" value="<?= htmlspecialchars($edit_form['id']) ?>">

                        <div class="form-group-custom">
                            <label for="edit-nama" class="form-label">Nama</label>
                            <input type="text" id="edit-nama" name="nama"
                                value="<?= htmlspecialchars($edit_form['nama']) ?>"
                                placeholder="Masukkan nama mahasiswa" required autocomplete="off"
                                class="form-input">
                        </div>

                        <div class="form-group-custom">
                            <label for="edit-npm" class="form-label">NPM</label>
                            <input type="text" id="edit-npm" name="npm"
                                value="<?= htmlspecialchars($edit_form['npm']) ?>"
                                placeholder="Masukkan NPM (10 digit)" required autocomplete="off"
                                class="form-input">
                        </div>

                        <div class="form-group-custom">
                            <label for="edit-prodi" class="form-label">Program Studi</label>
                            <input type="text" id="edit-prodi" name="prodi"
                                value="<?= htmlspecialchars($edit_form['prodi']) ?>"
                                placeholder="Masukkan program studi" required autocomplete="off"
                                class="form-input">
                        </div>

                        <div class="form-group-custom">
                            <label for="edit-angkatan" class="form-label">Angkatan</label>
                            <input type="text" id="edit-angkatan" name="angkatan"
                                value="<?= htmlspecialchars($edit_form['angkatan']) ?>"
                                placeholder="Masukkan tahun angkatan" required autocomplete="off"
                                class="form-input">
                        </div>

                        <div class="modal-actions">
                            <button type="submit" class="btn-submit">Perbarui Data</button>
                            <button type="button" class="btn-cancel" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Modal: Edit Data -->

    <!-- Modal: Delete Data -->
    <div class="modal fade" id="deleteDataModal" tabindex="-1" role="dialog" aria-labelledby="deleteDataLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-card">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteDataLabel">Hapus Data Mahasiswa</h5>
                    <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="modal-card-subtitle">Data yang dihapus tidak bisa dikembalikan.</p>

                    <?php if ($delete_error): ?>
                        <div class="alert-box alert-error">
                            <p class="mb-0"><?= htmlspecialchars($delete_error) ?></p>
                        </div>
                    <?php endif; ?>

                    <p class="delete-note">
                        Yakin ingin menghapus data <span id="delete-name">ini</span>?
                    </p>

                    <form method="POST" action="dashboard.php">
                        <input type="hidden" name="modal_action" value="delete_data">
                        <input type="hidden" name="id" id="delete-id" value="<?= htmlspecialchars($delete_form['id']) ?>">
                        <input type="hidden" name="nama" id="delete-nama" value="<?= htmlspecialchars($delete_form['nama']) ?>">

                        <div class="modal-actions">
                            <button type="submit" class="btn-delete-confirm">Hapus Data</button>
                            <button type="button" class="btn-cancel" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Modal: Delete Data -->

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <?php if ($add_error): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                $('#addDataModal').modal('show');
            });
        </script>
    <?php endif; ?>

    <?php if ($edit_error): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                $('#editDataModal').modal('show');
            });
        </script>
    <?php endif; ?>

    <?php if ($delete_error): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                $('#deleteDataModal').modal('show');
            });
        </script>
    <?php endif; ?>

    <script src="js/main.js"></script>

</body>

</html>