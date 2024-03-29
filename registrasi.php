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
    <title>Registrasi</title>
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
    // Mengecek apakah variabel $_POST['registrasi'] sudah di-set atau belum
    if (isset($_POST['registrasi'])) {

        // Function sanitize input
        function sanitizeInput($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Mengambil data username dan password dari form registrasi
        $username = sanitizeInput($_POST['username']);
        $password = $_POST['password'];

        // Meng-hash password dengan algoritma default
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Mencari apakah username sudah ada di database
        $sql = "SELECT username FROM tbl_auth WHERE username = :username";
        $stmt_check = $conn->prepare($sql);
        $stmt_check->bindParam(":username", $username);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        // Jika hasil query menghasilkan lebih dari 0 baris, artinya username sudah ada di database
        if ($stmt_check->rowCount() > 0) {

            // Tampilkan pesan
            echo "<script>
        Swal.fire(
            'GAGAL',
            'Maaf proses registrasi Anda gagal di lakukan.',
            'error'
        )
        </script>";

            // Jika username belum ada di database
        } else {

            // Lakukan proses penyimpanan data registrasi ke database
            $stmt_insert = $conn->prepare("INSERT INTO tbl_auth (username, password) VALUES (:username, :password)");
            $stmt_insert->bindParam(":username", $username);
            $stmt_insert->bindParam(":password", $password_hash);

            // Jika proses penyimpanan berhasil
            if ($stmt_insert->execute()) {

                // Set session dan alihkan ke halaman login
                $_SESSION['username_register'] = $username;
                $_SESSION['password_register'] = $password;
                $_SESSION['success'] = true;
                header('Location: login.php');
            }
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
                <div class="col-12 col-md-8 col-lg-6 col-xl-5 mt-5">

                    <!-- Card -->
                    <div class="card shadow-lg p-3 mb-5 bg-body rounded" style="border: 2px solid white;">

                        <!-- Card body -->
                        <div class="card-body p-5">

                            <!-- Registrasi -->
                            <h3 class="mb-5 text-center">Registrasi</h3>
                            <!-- </Akhir registrasi -->

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
                                    <input type="password" id="password" class="form-control" name="password" required />
                                </div>
                                <!-- </Akhir password -->

                                <!-- Tombol registrasi -->
                                <div class="text-center">
                                    <button class="btn btn-primary w-75 text-center rounded-pill" name="registrasi" type="submit">Registrasi</button>
                                </div>
                                <!-- </Akhir tombol registrasi -->

                            </form>
                            <!-- </Akhir form -->

                            <!-- Garis -->
                            <hr class="my-4">
                            <!-- </Akhir garis -->

                            <!-- Belum registrasi -->
                            <div class="text-center">
                                <a href="login.php">Kembali</a>
                            </div>
                            <!-- </Akhir belum registrasi -->

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
