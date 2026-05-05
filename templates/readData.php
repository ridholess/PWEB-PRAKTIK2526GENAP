<?php 
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

?>