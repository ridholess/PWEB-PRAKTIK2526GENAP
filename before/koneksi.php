<?php

$koneksi = mysqli_connect("localhost", "root", "", "db_week7");

if (mysqli_connect_error()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}

?>