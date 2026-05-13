<?php
function page_url(array $overrides = []): string
{
    $params = array_merge([
        'search' => $_GET['search'] ?? '',
        'sort' => $_GET['sort'] ?? 'nama',
        'dir' => $_GET['dir'] ?? 'asc',
        'per_page' => $_GET['per_page'] ?? 5,
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