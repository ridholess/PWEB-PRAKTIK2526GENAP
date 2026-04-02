<?php

$koneksi = mysqli_connect("localhost", "root", "", "db_week7_tk");

if (mysqli_connect_error()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}

?>