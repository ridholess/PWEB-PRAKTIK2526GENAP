<?php
$password_asli = "staff123";
$password_enkripsi = password_hash($password_asli, PASSWORD_DEFAULT);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p>password asli: <?= $password_asli; ?></p>
    <p>password enkripsi: <?= $password_enkripsi; ?></p>
</body>

</html>