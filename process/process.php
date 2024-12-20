<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "film";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['create'])) {
    $rating = $_POST['rating'];
    $kualitas = $_POST['kualitas'];
    $durasi = $_POST['durasi'];
    $judul = $_POST['judul'];
    $kategori = $_POST['kategori'];

    $sql = "INSERT INTO film (rating, kualitas, durasi, judul, kategori) VALUES ('$rating', '$kualitas', '$durasi', '$judul', '$kategori')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../index.php?status=success_create");
        exit(); 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $rating = $_POST['rating'];
    $kualitas = $_POST['kualitas'];
    $durasi = $_POST['durasi'];
    $judul = $_POST['judul'];
    $kategori = $_POST['kategori'];

    $sql = "UPDATE film SET rating='$rating', kualitas='$kualitas', durasi='$durasi', judul='$judul', kategori='$kategori' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../index.php?status=success_update");
        exit(); 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM film WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../index.php?status=success_delete");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
