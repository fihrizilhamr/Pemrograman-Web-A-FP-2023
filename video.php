<!DOCTYPE html>
<html>
<head>
    <title>Video Materi Pelajaran</title>
    <link href="assets/css/materi-pelajaran-style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="wrapper">
            <div class="logo">
                <a href=''>ETS</a>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="#program">Program</a></li>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#blog">Blog</a></li>
                    <li><a href="#community">Community</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="" class="tombol-biru">Sign Up</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <h1>Video Materi Pelajaran</h1><br><br>
    <?php
        include "db_connect.php";

        // Mendapatkan id dari parameter URL
        $pelajaran_id = isset($_GET['id']) ? $_GET['id'] : die('Error: Materi pelajaran ID tidak ditemukan.');

        // Query untuk mendapatkan video terkait dengan materi pelajaran tertentu
        $sql = $pdo->prepare("SELECT * FROM video_pelajaran WHERE pelajaran_id = :pelajaran_id");
        $sql->bindParam(':pelajaran_id', $pelajaran_id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Video</th></tr>";
            while ($data = $sql->fetch()) {
                echo "<tr>";
                echo "<td>{$data['id']}</td>";
                echo "<td><a href='{$data['video']}' target='_blank'>Video {$data['id']}</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Tidak ada video untuk materi pelajaran ini.</p>";
        }
    ?>
</body>
</html>
