<?php
include 'db_connect.php';

// Fungsi untuk menghapus siswa berdasarkan ID
function deleteStudent($conn, $id) {
    $sql = "DELETE FROM students WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Periksa apakah parameter ID siswa ada dalam URL
if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    // Jika ada ID, coba hapus siswa
    $deleted = deleteStudent($conn, $id);
    
    if ($deleted) {
        // Jika berhasil menghapus, set variabel JavaScript untuk menampilkan pesan sukses
        echo "<script>var successMessage = 'Siswa berhasil dihapus';</script>";
    } else {
        // Jika gagal menghapus, set variabel JavaScript untuk menampilkan pesan kesalahan
        echo "<script>var errorMessage = 'Error: Gagal menghapus siswa';</script>";
    }
}

// Query untuk mengambil data siswa
$sql = "SELECT * FROM students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa</title>
    <!-- Menggunakan Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Tambahan JavaScript untuk menampilkan pesan -->
    <script>
        // Fungsi untuk menghilangkan pesan sukses atau pesan kesalahan setelah beberapa detik
        function hideMessage() {
            var successMessageElement = document.getElementById("successMessage");
            var errorMessageElement = document.getElementById("errorMessage");
            
            if (successMessageElement) {
                successMessageElement.style.display = "none";
            }
            if (errorMessageElement) {
                errorMessageElement.style.display = "none";
            }
        }

        // Setelah 3 detik, panggil fungsi hideMessage
        setTimeout(hideMessage, 3000);
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Daftar Siswa</h2>
        <a href="save_student.php" class="btn btn-primary mb-2">Tambah Siswa</a>
        <div id="successMessage" class="alert alert-success" style="display:none;">
            <p>Siswa berhasil dihapus</p>
        </div>
        <div id="errorMessage" class="alert alert-danger" style="display:none;">
            <p>Error: Gagal menghapus siswa</p>
        </div>
        <!-- Tabel dengan kelas Bootstrap -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Usia</th>
                    <th>Alamat</th>
                    <th>Kontak</th>
                    <th>Riwayat Belajar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["age"] . "</td>";
                    echo "<td>" . $row["address"] . "</td>";
                    echo "<td>" . $row["contact_info"] . "</td>";
                    echo "<td>" . $row["learning_history"] . "</td>";
                    // Tombol Edit dan Hapus dengan kelas Bootstrap
                    echo "<td>
                        <a href='update_student.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'>Edit</a> 
                        <a href='list_students.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus siswa ini?\")'>Hapus</a>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
