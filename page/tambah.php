<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Film</title>
    <link rel="stylesheet" href="../css/page.css">
    <script>
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success_create') { ?>
            alert("Film berhasil ditambahkan!");
        <?php } elseif (isset($_GET['status']) && $_GET['status'] == 'success_update') { ?>
            alert("Film berhasil diperbarui!");
        <?php } elseif (isset($_GET['status']) && $_GET['status'] == 'success_delete') { ?>
            alert("Film berhasil dihapus!");
        <?php } ?>
    </script>
</head>
<body>
    <form action="../process/process.php" method="post">
        <label for="rating">Rating:</label>
        <input type="text" name="rating" required><br>
        
        <label for="kualitas">Kualitas:</label>
        <input type="text" name="kualitas" required><br>
        
        <label for="durasi">Durasi:</label>
        <input type="text" name="durasi" required><br>
        
        <label for="judul">Judul:</label>
        <input type="text" name="judul" required><br>
        
        <label for="kategori">Kategori:</label>
        <select name="kategori" required>
            <option value="">Pilih Kategori</option>
            <option value="Action">Action</option>
            <option value="Comedy">Comedy</option>
            <option value="Drama">Drama</option>
            <option value="Horror">Horror</option>
        </select><br>
        
        <input type="submit" name="create" value="Tambah Film">
    </form>
</body>
</html>
