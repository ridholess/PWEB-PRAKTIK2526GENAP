<?php

date_default_timezone_set('Asia/Jakarta');
$waktuSaatIni = date('l, d F Y | H:i:s');

$jasa = [
    [
        "title" => "UI/UX Design",
        "desc" => "Lorem ipsum dolor sit amet.",
        "icon" => "🎨"
    ],
    [
        "title" => "Front-End Slicing",
        "desc" => "Lorem ipsum dolor sit amet.",
        "icon" => "💻"
    ],
    [
        "title" => "Back-End Logic",
        "desc" => "Lorem ipsum dolor sit amet.",
        "icon" => "⚙️"
    ]
];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belajar PHP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <header class="text-center mb-5">
            <h1 class="font-weight-bold">Belajar PHP Dasar</h1>
            <p class="text-muted">Waktu saat ini (Jakarta): 
                <span class="badge badge-dark"><?php echo $waktuSaatIni; ?></span>
            </p>
        </header>

        <main>
            <div class="row">
            <?php foreach($jasa as $j) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body text-center">
                            <h1 class="display-4"><?= $j['icon']; ?></h1>
                            <h5 class="card-title mt-3"><?= $j['title']; ?></h5>
                            <p class="card-text text-secondary"><?= $j['desc']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            </div>
        </main>
    </div>
</body>
</html>