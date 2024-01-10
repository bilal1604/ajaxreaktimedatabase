<?php
include 'Database.php';

$db = new Database();
$con = $db->Connect();

// Handling CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $npm = isset($_GET['npm']) ? $_GET['npm'] : '';
    readMahasiswa($con, $npm);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle POST request
    $npm = isset($_POST['npm']) ? $_POST['npm'] : '';
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $studi = isset($_POST['studi']) ? $_POST['studi'] : '';
    $semester = isset($_POST['semester']) ? $_POST['semester'] : '';
    $type_pembayaran = isset($_POST['type_pembayaran']) ? $_POST['type_pembayaran'] : '';
    $tingkat_pembayaran = isset($_POST['tingkat_pembayaran']) ? $_POST['tingkat_pembayaran'] : '';
    $total_pembayaran = isset($_POST['total_pembayaran']) ? $_POST['total_pembayaran'] : '';

    createMahasiswa($con, $npm, $nama, $studi, $semester, $type_pembayaran, $tingkat_pembayaran, $total_pembayaran);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    // Handle PATCH request
    parse_str(file_get_contents("php://input"), $_PATCH);
    $id = isset($_PATCH['id']) ? $_PATCH['id'] : '';
    $npm = isset($_PATCH['npm']) ? $_PATCH['npm'] : '';
    $nama = isset($_PATCH['nama']) ? $_PATCH['nama'] : '';
    $studi = isset($_PATCH['studi']) ? $_PATCH['studi'] : '';
    $semester = isset($_PATCH['semester']) ? $_PATCH['semester'] : '';
    $type_pembayaran = isset($_PATCH['type_pembayaran']) ? $_PATCH['type_pembayaran'] : '';
    $tingkat_pembayaran = isset($_PATCH['tingkat_pembayaran']) ? $_PATCH['tingkat_pembayaran'] : '';
    $total_pembayaran = isset($_PATCH['total_pembayaran']) ? $_PATCH['total_pembayaran'] : '';

    updateMahasiswa($con, $id, $npm, $nama, $studi, $semester, $type_pembayaran, $tingkat_pembayaran, $total_pembayaran);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Handle DELETE request
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id = isset($_DELETE['id']) ? $_DELETE['id'] : '';
    deleteMahasiswa($con, $id);
}

function readMahasiswa($con, $npm)
{
    $query = "SELECT * FROM db_mahasiswa WHERE npm LIKE '%$npm%'";
    $result = mysqli_query($con, $query);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($data);
}

function createMahasiswa($con, $npm, $nama, $studi, $semester, $type_pembayaran, $tingkat_pembayaran, $total_pembayaran)
{
    $query = "INSERT INTO db_mahasiswa (npm, nama, studi, semester, type_pembayaran, tingkat_pembayaran, total_pembayaran) 
              VALUES ('$npm', '$nama', '$studi', '$semester', '$type_pembayaran', '$tingkat_pembayaran', '$total_pembayaran')";
    
    if (mysqli_query($con, $query)) {
        echo "Data berhasil ditambahkan.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($con);
    }
}

function updateMahasiswa($con, $id, $npm, $nama, $studi, $semester, $type_pembayaran, $tingkat_pembayaran, $total_pembayaran)
{
    $query = "UPDATE db_mahasiswa SET npm='$npm', nama='$nama', studi='$studi', semester='$semester', 
              type_pembayaran='$type_pembayaran', tingkat_pembayaran='$tingkat_pembayaran', total_pembayaran='$total_pembayaran' 
              WHERE id=$id";
    
    if (mysqli_query($con, $query)) {
        echo "Data berhasil diperbarui.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($con);
    }
}

function deleteMahasiswa($con, $id)
{
    $query = "DELETE FROM db_mahasiswa WHERE id=$id";
    
    if (mysqli_query($con, $query)) {
        echo "Data berhasil dihapus.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($con);
    }
}
?>
