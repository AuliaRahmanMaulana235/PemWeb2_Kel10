<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "film";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$limit = 20; 
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT id, rating, kualitas, durasi, judul, kategori FROM film LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$sql_count = "SELECT COUNT(id) AS total FROM film";
$count_result = $conn->query($sql_count);
$row = $count_result->fetch_assoc();
$total_records = $row['total'];
$total_pages = ceil($total_records / $limit);

$max_links = 5;
$start_page = max(1, $page - floor($max_links / 2));
$end_page = min($total_pages, $start_page + $max_links - 1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Film</title>
    <link rel="stylesheet" href="css/styles.css"> 
    <script>
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'success_create'): ?>
                alert("Film berhasil ditambahkan!");
            <?php elseif ($_GET['status'] == 'success_update'): ?>
                alert("Film berhasil diperbarui!");
            <?php elseif ($_GET['status'] == 'success_delete'): ?>
                alert("Film berhasil dihapus!");
            <?php endif; ?>
        <?php endif; ?>
        function confirmDelete() {
            return confirm("Apakah Anda yakin ingin menghapus data ini?");
        }
    </script>
</head>
<body>

<h2>Daftar Film</h2>

<?php if (!empty($status_message)) { ?>
    <div class="alert">
        <strong>Success!</strong> <?php echo $status_message; ?>
    </div>
<?php } ?>

<a href="page/tambah.php" class="btn">Tambah Film</a>

<table>
    <tr>
        <th>No</th>
        <th>Rating</th>
        <th>Kualitas</th>
        <th>Durasi (menit)</th>
        <th>Judul</th>
        <th>Kategori</th>
        <th>Aksi</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["rating"] . "</td>
                    <td>" . $row["kualitas"] . "</td>
                    <td>" . $row["durasi"] . "</td>
                    <td>" . $row["judul"] . "</td>
                    <td>" . $row["kategori"] . "</td>
                    <td>
                        <a href='page/edit.php?id=" . $row["id"] . "' class='btn btn-edit'>Edit</a> |
                        <a href='page/delete.php?id=" . $row["id"] . "' class='btn btn-delete' onclick=\"return confirmDelete();\">Hapus</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
    }
    ?>
</table>

<div class="pagination">
    <?php
    if ($page > 1) {
        echo "<a href='index.php?page=" . ($page - 1) . "'>&laquo; Sebelumnya</a> ";
    }

    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $page) {
            echo "<a href='index.php?page=" . $i . "' class='active'>" . $i . "</a> ";
        } else {
            echo "<a href='index.php?page=" . $i . "'>" . $i . "</a> ";
        }
    }

    if ($page < $total_pages) {
        echo "<a href='index.php?page=" . ($page + 1) . "'>Selanjutnya &raquo;</a>";
    }
    ?>
</div>

<footer>
    Copyright © 2024 Movie in the House
</footer>

</body>
</html>

<?php
$conn->close();
?>
