<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION["login"])) {
    header("Location: ./");
    exit;
}

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// Verify student exists
$check_sql = "SELECT id FROM student WHERE id = $id";
$check_res = mysqli_query($koneksi, $check_sql);

if (mysqli_num_rows($check_res) === 0) {
    header('Location: index.php');
    exit;
}

// Delete the student
$delete_sql = "DELETE FROM student WHERE id = $id";

if (mysqli_query($koneksi, $delete_sql)) {
    header('Location: index.php');
    exit;
} else {
    // If delete fails, redirect back
    header('Location: index.php');
    exit;
}
?>
