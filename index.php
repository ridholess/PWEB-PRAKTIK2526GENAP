<?php

date_default_timezone_set('Asia/Jakarta');
$waktuSaatIni = date('l, d F Y | H:i:s');

$mahasiswa = [
    [
        "nama" => "Mahasiswa 1",
        "npm" => "1111111111",
        "prodi" => "Ilkom",
        "angkatan" => "2024"
    ],
    [
        "nama" => "Mahasiswa 2",
        "npm" => "2222222222",
        "prodi" => "Psikologi",
        "angkatan" => "2024"
    ],
    [
        "nama" => "Mahasiswa 3",
        "npm" => "3333333333",
        "prodi" => "Informatika",
        "angkatan" => "2024"
    ]
];

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web App with MySQL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <header class="text-center mb-5">
            <h1 class="font-weight-bold">Koneksi PHP & MySQL</h1>
            <p class="text-muted font-weight-light font-italic">Jakarta hari ini: 
                <span class="badge badge-dark"><?= $waktuSaatIni; ?></span>
            </p>
        </header>

        <main>
            <div class="row">
            <?php foreach($mahasiswa as $mhs) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 border-0 card-neo">
                        <div class="card-body text-center">
                            <h1 class="display-4">
                                <img src="./images/uty-large.png" alt="Logo UTY" width="72" height="72">
                            </h1>
                            <h5 class="card-title mt-4 mb-2 font-weight-bold"><?= $mhs['nama']; ?></h5>
                            <h6 class="card-subtitle mb-3 text-muted"><?= $mhs['npm']; ?></h6>
                            <p class="card-text mb-3"><?= $mhs['prodi']; ?></p>
                            <p class="card-text mb-0"><span class="badge badge-pill badge-info px-3 py-2">Angkatan <?= $mhs['angkatan']; ?></span></p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            </div>
        </main>
    </div>
</body>
</html>