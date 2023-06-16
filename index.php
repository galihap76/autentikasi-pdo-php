<?php
session_start();

if (!isset($_SESSION['login']) && !isset($_SESSION['username'])) {
    header('Location: login.php');
    die();
} else {

    session_regenerate_id();
    $identity_username = $_SESSION['identity'];
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    Nama pengguna Anda adalah : <?php echo $identity_username; ?>
    <br>
    <br>

    <a href="logout.php">Log out</a>

    <?php

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        echo "<script>
    Swal.fire(
        'BERHASIL!',
        'Selamat datang $username.',
        'success'
    )
    </script>";

        // hapus session success registrasi
        unset($_SESSION['username']);

        // cek jika password berhasil di ubah
    }

    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>
