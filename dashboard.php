<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$nama_user = $_SESSION["nama_user"];

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

$data_sql = "SELECT nama, npm, prodi, angkatan FROM student
             WHERE nama LIKE '$search_like'
                OR npm  LIKE '$search_like'
                OR prodi LIKE '$search_like'
                OR angkatan LIKE '$search_like'
             ORDER BY $sort $dir
             LIMIT $per_page OFFSET $offset";
$data_res = mysqli_query($koneksi, $data_sql);

function page_url(array $overrides = []): string
{
    $params = array_merge([
        'search' => $_GET['search'] ?? '',
        'sort' => $_GET['sort'] ?? 'nama',
        'dir' => $_GET['dir'] ?? 'asc',
        'per_page' => $_GET['per_page'] ?? 10,
        'page' => $_GET['page'] ?? 1,
    ], $overrides);
    return 'dashboard.php?' . http_build_query($params);
}

function sort_url(string $col): string
{
    $current_sort = $_GET['sort'] ?? 'nama';
    $current_dir = $_GET['dir'] ?? 'asc';
    $new_dir = ($current_sort === $col && $current_dir === 'asc') ? 'desc' : 'asc';
    return page_url(['sort' => $col, 'dir' => $new_dir, 'page' => 1]);
}

function sort_icon(string $col): string
{
    $current_sort = $_GET['sort'] ?? 'nama';
    $current_dir = $_GET['dir'] ?? 'asc';
    if ($current_sort !== $col)
        return '↕';
    return $current_dir === 'asc' ? '↑' : '↓';
}
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
    <style>
        body {
            background-color: #F7EDE8;
            font-family: 'Montserrat Alternates', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #F7EDE8;
        }

        ::-webkit-scrollbar-thumb {
            background: #E8715A;
            border-radius: 3px;
        }

        tbody tr:hover {
            background-color: #fdf0ec;
        }

        .page-btn-active {
            background-color: #000;
            color: #fff;
            box-shadow: 3px 3px 0px #E8715A;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="flex items-center justify-between px-6 py-4 border-b-2 border-black">
        <span class="text-black font-bold text-base tracking-wide">
            Selamat datang, <span class="italic text-[#E8715A]"><?= htmlspecialchars($nama_user) ?></span> 👋
        </span>
        <a href="logout.php" id="btn-logout"
            class="bg-[#000] text-white text-sm font-semibold px-6 py-3 rounded-md shadow-[4px_4px_0px_#E8715A] hover:shadow-[0px_0px_0px] transition-all duration-300 ease-in-out no-underline">
            Logout
        </a>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 px-6 py-10 max-w-6xl mx-auto w-full">

        <h1 class="text-3xl font-black italic tracking-widest text-black mb-2">Data Mahasiswa</h1>
        <p class="text-[#7A6E6A] text-sm mb-8">Daftar seluruh mahasiswa yang terdaftar dalam sistem Portal UTY.</p>

        <div class="bg-white border-2 border-black shadow-[6px_6px_0px_#E8715A] rounded-xl overflow-hidden">

            <!-- Controls: Search + Per-Page (submitted as GET form) -->
            <form method="GET" action="dashboard.php" id="filter-form"
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
                    <button type="submit"
                        class="ml-2 bg-[#000] text-white text-xs font-bold px-4 py-2 rounded-md shadow-[2px_2px_0px_#E8715A] hover:shadow-[0px_0px_0px] transition-all duration-200 cursor-pointer">
                        Cari
                    </button>
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
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if ($total_rows === 0): ?>
                            <tr>
                                <td colspan="5" class="text-center py-16 text-[#7A6E6A] font-semibold italic">
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
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Footer: Info + Pagination -->
            <div
                class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 px-6 py-4 border-t-2 border-black bg-[#F7EDE8]">

                <!-- Info -->
                <p class="text-sm text-[#7A6E6A] font-medium">
                    <?php
                    $from = $total_rows === 0 ? 0 : $offset + 1;
                    $to = min($offset + $per_page, $total_rows);
                    echo "Menampilkan {$from}–{$to} dari {$total_rows} data";
                    ?>
                </p>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <div class="flex flex-wrap gap-2">

                        <!-- Prev -->
                        <?php if ($page > 1): ?>
                            <a href="<?= page_url(['page' => $page - 1]) ?>"
                                class="px-3.5 py-2 border-2 border-black rounded-md text-sm font-bold bg-white text-black shadow-[2px_2px_0px_rgba(0,0,0,0.15)] hover:shadow-[2px_2px_0px_#E8715A] transition-all duration-200 no-underline">
                                ‹
                            </a>
                        <?php else: ?>
                            <span
                                class="px-3.5 py-2 border-2 border-black rounded-md text-sm font-bold bg-white text-black opacity-40 cursor-not-allowed">‹</span>
                        <?php endif; ?>

                        <!-- Page numbers -->
                        <?php
                        $startP = max(1, $page - 2);
                        $endP = min($total_pages, $startP + 4);
                        if ($endP - $startP < 4)
                            $startP = max(1, $endP - 4);
                        for ($p = $startP; $p <= $endP; $p++):
                            ?>
                            <?php if ($p === $page): ?>
                                <span
                                    class="page-btn-active px-3.5 py-2 border-2 border-black rounded-md text-sm font-bold cursor-default">
                                    <?= $p ?>
                                </span>
                            <?php else: ?>
                                <a href="<?= page_url(['page' => $p]) ?>"
                                    class="px-3.5 py-2 border-2 border-black rounded-md text-sm font-bold bg-white text-black shadow-[2px_2px_0px_rgba(0,0,0,0.15)] hover:shadow-[2px_2px_0px_#E8715A] transition-all duration-200 no-underline">
                                    <?= $p ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <!-- Next -->
                        <?php if ($page < $total_pages): ?>
                            <a href="<?= page_url(['page' => $page + 1]) ?>"
                                class="px-3.5 py-2 border-2 border-black rounded-md text-sm font-bold bg-white text-black shadow-[2px_2px_0px_rgba(0,0,0,0.15)] hover:shadow-[2px_2px_0px_#E8715A] transition-all duration-200 no-underline">
                                ›
                            </a>
                        <?php else: ?>
                            <span
                                class="px-3.5 py-2 border-2 border-black rounded-md text-sm font-bold bg-white text-black opacity-40 cursor-not-allowed">›</span>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

            </div>
        </div>

    </main>

</body>

</html>