<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = new PDO("mysql:host=$servername;dbname=db_auth_pdo", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function tutupKoneksi($stmt = null, $conn = null)
{
    // cek apakah parameter statement dan koneksi tidak null
    if ($stmt !== null && $conn !== null) {
        // tutup statement dan koneksi database
        $stmt->closeCursor();
        $conn = null;
    }
}
