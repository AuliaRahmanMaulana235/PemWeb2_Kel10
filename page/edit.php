<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "film";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "SELECT * FROM film WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Film</title>
    <link rel="stylesheet" href="../css/page.css">
    <script>
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success_update') { ?>
            alert("Film berhasil diperbarui!");
        <?php } ?>
    </script>
</head>
<body>
    <form action="../process/process.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        
        <label for="rating">Rating:</label>
        <input type="text" name="rating" value="<?php echo $row['rating']; ?>" required><br>
        
        <label for="kualitas">Kualitas:</label>
        <input type="text" name="kualitas" value="<?php echo $row['kualitas']; ?>" required><br>
        
        <label for="durasi">Durasi:</label>
        <input type="text" name="durasi" value="<?php echo $row['durasi']; ?>" required><br>
        
        <label for="judul">Judul:</label>
        <input type="text" name="judul" value="<?php echo $row['judul']; ?>" required><br>
        
        <label for="kategori">Kategori:</label>
        <input type="text" name="kategori" value="<?php echo $row['kategori']; ?>" required><br>
        
        <input type="submit" name="update" value="Update Film">
    </form>
</body>
</html>


<?php
$conn->close();
?>
