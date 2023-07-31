<?php
session_start();
include 'db.php';

// Cek jika sudah login
if (isset($_SESSION['login'])) {

    // Paksa pengguna ke halaman index.php
    header('Location: index.php');
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: white;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>

    <?php

    // Cek apakah tombol 'ubah' sudah ditekan pada form sebelumnya
    if (isset($_POST['ubah'])) {

        // Function sanitize input
        function sanitizeInput($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Dapatkan data username, password, dan konfirmasi password dari form
        $username = sanitizeInput($_POST['username']);
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        // hash password menggunakan algoritma default PHP
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Persiapkan statement untuk mengecek apakah username sudah ada
        $stmt_check = $conn->prepare("SELECT username FROM tbl_auth WHERE username = :username");
        $stmt_check->bindParam(":username", $username);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        // Persiapkan statement untuk melakukan update password berdasarkan field username
        $stmt_update = $conn->prepare("UPDATE tbl_auth SET password = :password WHERE username = :username");
        $stmt_update->bindParam(":password", $password_hash);
        $stmt_update->bindParam(":username", $username);
        $stmt_update->execute();

        // Cek apakah username tidak ada di database
        if ($result === false) {

            // Tampilkan pesan 
            echo "<script>
        Swal.fire(
            'GAGAL',
            'Proses ubah password gagal di lakukan.',
            'error'
        )
        </script>";

            // Cek jika konfirmasi password tidak sesuai
        } else if ($password !== $password2) {

            // Tampilkan pesan
            echo "<script>
        Swal.fire(
            'GAGAL',
            'Maaf konfirmasi password Anda tidak sesuai.',
            'error'
        )
        </script>";

            // Cek jika berhasil di update
        } else if ($stmt_update->rowCount() > 0) {

            // Set session dan redirect ke halaman login
            $_SESSION['forgot_username'] = $username;
            $_SESSION['forgot_password'] = $password;
            $_SESSION['success_change'] = true;
            header('Location: login.php');
        }

        // Tutup koneksi
        $conn = null;
    }
    ?>

    <!-- Section -->
    <section class="vh-100">

        <!-- Container -->
        <div class="container h-100">

            <!-- Row -->
            <div class="row d-flex justify-content-center align-items-center h-100">

                <!-- Col -->
                <div class="col-12 col-md-8 col-lg-6 col-xl-5 mt-4">

                    <!-- Card -->
                    <div class="card shadow-lg p-3 mb-5 bg-body rounded" style="border: 2px solid white;">

                        <!-- Card body -->
                        <div class="card-body p-5">

                            <!-- Lupa password -->
                            <h3 class="mb-5 text-center">Lupa Password</h3>
                            <!-- </Akhir lupa password -->

                            <!-- Form -->
                            <form method="post" action="">

                                <!-- Username -->
                                <div class="mb-4">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="text" id="username" class="form-control" name="username" autocomplete="off" maxlength="20" required />
                                </div>
                                <!-- </Akhir username -->

                                <!-- Password -->
                                <div class="mb-4">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" required />
                                </div>
                                <!-- </Akhir password -->

                                <!-- Konfirmasi password -->
                                <div class="mb-4">
                                    <label class="form-label" for="password2">Konfirmasi Password</label>
                                    <input type="password" id="password2" name="password2" class="form-control" required />
                                </div>
                                <!-- </Akhir konfirmasi password -->

                                <!-- Tombol ubah -->
                                <div class="text-center">
                                    <button class="btn btn-primary w-75 text-center rounded-pill" type="submit" name="ubah">Ubah</button>
                                </div>
                                <!-- </Akhir tombol ubah -->

                            </form>
                            <!-- </Akhir form -->

                            <!-- Garis -->
                            <hr class="my-4">
                            <!-- </Akhir garis -->

                            <!-- Login -->
                            <div class="text-center">
                                <a href="login.php">Kembali</a>
                            </div>
                            <!-- </Akhir Login -->

                        </div>
                        <!-- </Akhir card body -->

                    </div>
                    <!-- </Akhir card -->

                </div>
                <!-- </Akhir col -->

            </div>
            <!-- </Akhir row -->

        </div>
        <!-- </Akhir container -->

    </section>
    <!-- </Akhir section -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>
