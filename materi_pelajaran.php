<!DOCTYPE html>
<html>
<head>
  <title>Materi Pelajaran</title>
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
                <a href =''>ETS</a>
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
  <h1>Materi Pelajaran</h1><br><br>
  <table border="1" width="100%">
    <tr>
      <th>ID</th>
      <th>Mata Pelajaran</th>
      <th>Tingkat Kelas</th>
      <th>Actions</th>
    </tr>
    <?php
      include "db_connect.php";

      // Buat query untuk menampilkan semua data siswa
      $sql = $pdo->prepare("SELECT * FROM materi_pelajaran");
      $sql->execute();

      while ($data = $sql->fetch()) {
        echo "<tr>";
        echo "<td>{$data['id']}</td>";
        echo "<td>{$data['mata_pelajaran']}</td>";
        echo "<td>{$data['tingkat_kelas']}</td>";
        echo "<td><a href='modul.php?id={$data['id']}'>Modul</a> | <a href='video.php?id={$data['id']}'>Video</a> | <a href='latihan_soal.php?id={$data['id']}'>Latihan Soal</a></td>";
        echo "</tr>";
      }
    ?>
  </table><br><br>
</body>
</html>
