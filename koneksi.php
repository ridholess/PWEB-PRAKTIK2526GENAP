<?php

$koneksi = mysqli_connect("localhost", "root", "", "db_week9");

if (mysqli_connect_error()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}

?>