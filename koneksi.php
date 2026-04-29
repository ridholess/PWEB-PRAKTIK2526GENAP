<?php

$koneksi = mysqli_connect("localhost", "root", "", "db_week8");

if (mysqli_connect_error()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}

?>