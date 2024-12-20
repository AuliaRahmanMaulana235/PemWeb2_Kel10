<?php

$servername = "localhost";
$username = "root";
$password = "";    
$dbname = "film";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':

        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $category = isset($_GET['category']) ? $_GET['category'] : '';

        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 30;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $offset = ($page - 1) * $limit;

        $sql = "SELECT * FROM film WHERE 1"; 

        if ($search) {
            $sql .= " AND judul LIKE '%" . $conn->real_escape_string($search) . "%'"; 
        }

        if ($category) {
            $sql .= " AND kategori = '" . $conn->real_escape_string($category) . "'"; 
        }

        $sql .= " LIMIT $limit OFFSET $offset";

        $result = $conn->query($sql);

        $films = [];
        while ($row = $result->fetch_assoc()) {
            $films[] = $row;
        }

        $sql_count = "SELECT COUNT(id) AS total FROM film WHERE 1"; 

        if ($search) {
            $sql_count .= " AND judul LIKE '%" . $conn->real_escape_string($search) . "%'";
        }
        if ($category) {
            $sql_count .= " AND kategori = '" . $conn->real_escape_string($category) . "'";
        }

        $count_result = $conn->query($sql_count);
        $row = $count_result->fetch_assoc();
        $total_pages = ceil($row['total'] / $limit);

        $response = [
            'current_page' => $page,
            'total_pages' => $total_pages,
            'data' => $films
        ];

        echo json_encode($response);
        break;

    case 'POST':

        $data = json_decode(file_get_contents('php://input'), true);

        $rating = $data['rating'];
        $kualitas = $data['kualitas'];
        $durasi = $data['durasi'];
        $judul = $data['judul'];
        $kategori = $data['kategori'];

        $sql = "INSERT INTO film (rating, kualitas, durasi, judul, kategori) VALUES ('$rating', '$kualitas', '$durasi', '$judul', '$kategori')";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['message' => 'Data Film berhasil ditambahkan']);
        } else {
            echo json_encode(['error' => 'Gagal menambahkan film']);
        }
        break;

    case 'PUT':

        $data = json_decode(file_get_contents('php://input'), true);

        $id = $data['id'];
        $rating = $data['rating'];
        $kualitas = $data['kualitas'];
        $durasi = $data['durasi'];
        $judul = $data['judul'];
        $kategori = $data['kategori'];

        $sql = "UPDATE film SET rating='$rating', kualitas='$kualitas', durasi='$durasi', judul='$judul', kategori='$kategori' WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['message' => 'Data Film berhasil diperbarui']);
        } else {
            echo json_encode(['error' => 'Gagal memperbarui film']);
        }
        break;

    case 'DELETE':

        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];

        $sql = "DELETE FROM film WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['message' => 'Data Film berhasil dihapus']);
        } else {
            echo json_encode(['error' => 'Gagal menghapus film']);
        }
        break;

    default:
        echo json_encode(['error' => 'Method tidak didukung']);
        break;
}

$conn->close();
?>
