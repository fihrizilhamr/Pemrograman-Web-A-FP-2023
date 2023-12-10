<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data Siswa</title>
    <!-- Menggunakan Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <?php
        include 'db_connect.php';

        $id = $_POST['id'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $contact_info = $_POST['contact_info'];
        $learning_history = $_POST['learning_history'];

        $sql = "UPDATE students SET name='$name', age='$age', address='$address', contact_info='$contact_info', learning_history='$learning_history' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            // Pesan sukses jika data berhasil diperbarui
            echo "<div class='alert alert-success'>Data siswa berhasil diperbarui</div>";
        } else {
            // Pesan kesalahan jika ada masalah dalam penyimpanan data
            echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }

        $conn->close();
        ?>
        <a href="list_students.php" class="btn btn-primary">Kembali ke Daftar Siswa</a>
    </div>
</body>
</html>
