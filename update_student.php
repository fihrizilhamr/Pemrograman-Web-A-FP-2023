<?php
include 'db_connect.php';

// Ambil ID siswa dari parameter URL
$id = $_GET['id'];

// Query untuk mengambil data siswa berdasarkan ID
$sql = "SELECT * FROM students WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa</title>
    <!-- Menggunakan Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Data Siswa</h2>
        <form action="save_updated_student.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="age">Usia:</label>
                <input type="number" class="form-control" id="age" name="age" value="<?php echo $row['age']; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Alamat:</label>
                <textarea class="form-control" id="address" name="address" rows="3" required><?php echo $row['address']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="contact_info">Kontak:</label>
                <input type="text" class="form-control" id="contact_info" name="contact_info" value="<?php echo $row['contact_info']; ?>" required>
            </div>
            <div class="form-group">
                <label for="learning_history">Riwayat Belajar:</label>
                <textarea class="form-control" id="learning_history" name="learning_history" rows="3"><?php echo $row['learning_history']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="list_students.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
