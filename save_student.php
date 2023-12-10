<?php
include 'db_connect.php';

// Inisialisasi variabel pesan
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $name = $_POST['name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $contact_info = $_POST['contact_info'];
    $learning_history = $_POST['learning_history'];

    // Query untuk menyimpan data siswa ke database
    $sql = "INSERT INTO students (name, age, address, contact_info, learning_history) VALUES ('$name', '$age', '$address', '$contact_info', '$learning_history')";

    if ($conn->query($sql) === TRUE) {
        // Pesan sukses jika data berhasil disimpan
        $message = "<div class='alert alert-success'>Siswa berhasil didaftarkan.</div>";
        
        // Redirect ke halaman list_students.php setelah siswa berhasil didaftarkan
        header("Location: list_students.php");
        exit(); // Penting: pastikan untuk keluar dari skrip setelah redirect
    } else {
        // Pesan kesalahan jika ada masalah dalam penyimpanan data
        $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Siswa</title>
    <!-- Menggunakan Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Pendaftaran Siswa Baru</h2>
        <!-- Tampilkan pesan -->
        <?php echo $message; ?>
        <form action="save_student.php" method="post">
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="age">Usia:</label>
                <input type="number" class="form-control" id="age" name="age" required>
            </div>
            <div class="form-group">
                <label for="address">Alamat:</label>
                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="contact_info">Kontak:</label>
                <input type="text" class="form-control" id="contact_info" name="contact_info" required>
            </div>
            <div class="form-group">
                <label for="learning_history">Riwayat Belajar:</label>
                <textarea class="form-control" id="learning_history" name="learning_history" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
