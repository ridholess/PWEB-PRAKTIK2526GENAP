<?php
require 'koneksi.php';

$search = trim($_GET['search'] ?? '');
$sort = $_GET['sort'] ?? 'nama';
$dir = ($_GET['dir'] ?? 'asc') === 'desc' ? 'desc' : 'asc';
$per_page = (int) ($_GET['per_page'] ?? 5);
$page = max(1, (int) ($_GET['page'] ?? 1));

$allowed_sorts = ['nama', 'npm', 'prodi', 'angkatan'];
if (!in_array($sort, $allowed_sorts))
    $sort = 'nama';
$per_page = in_array($per_page, [5, 10, 25, 50]) ? $per_page : 10;
$search_like = '%' . mysqli_real_escape_string($koneksi, $search) . '%';

$count_sql = "SELECT COUNT(*) AS total FROM student
              WHERE nama LIKE '$search_like'
                 OR npm  LIKE '$search_like'
                 OR prodi LIKE '$search_like'
                 OR angkatan LIKE '$search_like'";
$count_res = mysqli_query($koneksi, $count_sql);
$total_rows = (int) mysqli_fetch_assoc($count_res)['total'];
$total_pages = max(1, (int) ceil($total_rows / $per_page));
$page = min($page, $total_pages);
$offset = ($page - 1) * $per_page;

$data_sql = "SELECT id, nama, npm, prodi, angkatan FROM student
             WHERE nama LIKE '$search_like'
                OR npm  LIKE '$search_like'
                OR prodi LIKE '$search_like'
                OR angkatan LIKE '$search_like'
             ORDER BY $sort $dir
             LIMIT $per_page OFFSET $offset";
$data_res = mysqli_query($koneksi, $data_sql);

require 'function.php';

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="icon" type="image/png"
        href="https://res.cloudinary.com/dsirus0pz/image/upload/v1774681310/uty-campus_i8pc7v.png">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="min-h-screen flex flex-col">

    <!-- Main Content -->
    <main class="flex-1 px-6 py-10 max-w-6xl mx-auto w-full">

        <h1 class="text-3xl font-black italic tracking-widest text-black mb-2 flex items-center gap-3">
            Data Mahasiswa 
            <span class="bg-[#000] text-white text-xs font-medium italic px-3 py-1.5 rounded-md shadow-[2px_2px_0px_#E8715A] align-middle">Week-8</span>
        </h1>
        <p class="text-[#7A6E6A] text-sm mb-8">Daftar seluruh mahasiswa yang terdaftar dalam sistem Portal UTY.</p>

        <div class="bg-white border-2 border-black shadow-[6px_6px_0px_#E8715A] rounded-xl overflow-hidden">

            <!-- Controls: Search + Per-Page (submitted as GET form) -->
            <form method="GET" action="index.php" id="filter-form"
                class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 px-6 py-4 border-b-2 border-black">
                <!-- Preserve sort & dir -->
                <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
                <input type="hidden" name="dir" value="<?= htmlspecialchars($dir) ?>">
                <input type="hidden" name="page" value="1">

                <!-- Search -->
                <div class="relative w-full sm:w-72">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#7A6E6A]"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z" />
                    </svg>
                    <input id="search-input" type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                        placeholder="Cari nama, npm, prodi..." autocomplete="off"
                        class="w-full pl-9 pr-4 py-2.5 border-2 border-black rounded-md text-sm font-medium text-black placeholder-[#7A6E6A] outline-none shadow-[3px_3px_0px_rgba(0,0,0,0.15)] focus:shadow-[3px_3px_0px_#E8715A] transition-all duration-200 bg-[#F7EDE8]" />
                </div>

                <!-- Per-Page + Submit -->
                <div class="flex items-center gap-2 text-sm text-[#7A6E6A] font-medium">
                    <span>Tampilkan</span>
                    <select name="per_page" id="per-page-select"
                        onchange="document.getElementById('filter-form').submit()"
                        class="border-2 border-black px-3 py-2 rounded-md text-black font-semibold bg-[#F7EDE8] outline-none shadow-[2px_2px_0px_rgba(0,0,0,0.15)] cursor-pointer">
                        <?php foreach ([5, 10, 25, 50] as $opt): ?>
                            <option value="<?= $opt ?>" <?= $per_page === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span>data</span>
                    <a href="add_data.php"
                        class="ml-2 bg-[#000] text-white text-xs font-bold px-4 py-2 rounded-md shadow-[2px_2px_0px_#E8715A] hover:shadow-[0px_0px_0px] transition-all duration-200 no-underline inline-block">
                        Tambah Data
                    </a>
                </div>
            </form>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#F7EDE8] border-b-2 border-black">
                        <tr>
                            <th class="px-6 py-4 font-black text-black uppercase tracking-wider text-xs w-12">#</th>
                            <?php
                            $cols = ['nama' => 'Nama', 'npm' => 'NPM', 'prodi' => 'Prodi', 'angkatan' => 'Angkatan'];
                            foreach ($cols as $col => $label):
                                ?>
                                <th
                                    class="px-6 py-4 font-black uppercase tracking-wider text-xs cursor-pointer select-none transition-colors <?= $sort === $col ? 'text-[#E8715A]' : 'text-black hover:text-[#E8715A]' ?>">
                                    <a href="<?= sort_url($col) ?>"
                                        class="flex items-center gap-1 no-underline text-inherit">
                                        <?= $label ?> <span><?= sort_icon($col) ?></span>
                                    </a>
                                </th>
                            <?php endforeach; ?>
                            <th class="px-6 py-4 font-black text-black uppercase tracking-wider text-xs">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if ($total_rows === 0): ?>
                            <tr>
                                <td colspan="6" class="text-center py-16 text-[#7A6E6A] font-semibold italic">
                                    Tidak ada data yang ditemukan.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = $offset + 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($data_res)): ?>
                                <tr class="transition-colors duration-150">
                                    <td class="px-6 py-4 text-[#7A6E6A] font-semibold">
                                        <?= $no++ ?>
                                    </td>
                                    <td class="px-6 py-4 text-black font-semibold">
                                        <?= htmlspecialchars($row['nama']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-black font-mono">
                                        <?= htmlspecialchars($row['npm']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-black">
                                        <?= htmlspecialchars($row['prodi']) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-block bg-[#000] text-white text-xs font-bold px-3 py-1 rounded-full shadow-[2px_2px_0px_#E8715A]">
                                            <?= htmlspecialchars($row['angkatan']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <a href="edit_data.php?id=<?= $row['id'] ?>"
                                                class="bg-[#007BFF] text-white text-xs font-bold px-3 py-1 rounded-md shadow-[2px_2px_0px_rgba(0,123,255,0.5)] hover:shadow-[0px_0px_0px] transition-all duration-200 no-underline">
                                                Edit
                                            </a>
                                            <a href="delete_data.php?id=<?= $row['id'] ?>"
                                                class="bg-[#DC3545] text-white text-xs font-bold px-3 py-1 rounded-md shadow-[2px_2px_0px_rgba(220,53,69,0.5)] hover:shadow-[0px_0px_0px] transition-all duration-200 no-underline"
                                                onclick="return confirm('Yakin ingin menghapus data ini?');">
                                                Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Footer: Info + Pagination -->
            <?php require './templates/footerDataTable.php'; ?>
        </div>

    </main>

</body>

</html>