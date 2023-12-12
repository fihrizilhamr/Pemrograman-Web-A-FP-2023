<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

$select_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
$select_playlists->execute([$tutor_id]);
$total_playlists = $select_playlists->rowCount();

$select_contents = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
$select_contents->execute([$tutor_id]);
$total_contents = $select_contents->rowCount();

$select_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
$select_likes->execute([$tutor_id]);
$total_likes = $select_likes->rowCount();

$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
$select_comments->execute([$tutor_id]);
$total_comments = $select_comments->rowCount();

$select_schedules = $conn->prepare("SELECT * FROM `counseling_schedule` WHERE tutor_id = ?");
$select_schedules->execute([$tutor_id]);
$total_schedules = $select_schedules->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profil</title>

   <!-- Tautan font awesome cdn  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Tautan berkas CSS kustom  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>
   
<section class="tutor-profile" style="min-height: calc(100vh - 19rem);"> 

   <h1 class="heading">Detail Profil</h1>

   <div class="details">
      <div class="tutor">
         <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <span><?= $fetch_profile['profession']; ?></span>
         <a href="update.php" class="inline-btn">Perbarui Profil</a>
      </div>
      <div class="flex">
         <div class="box">
            <span><?= $total_playlists; ?></span>
            <p>Total Daftar Putar</p>
            <a href="playlists.php" class="btn">Lihat Daftar Putar</a>
         </div>
         <div class="box">
            <span><?= $total_contents; ?></span>
            <p>Total Video</p>
            <a href="contents.php" class="btn">Lihat Video</a>
         </div>
         <div class="box">
            <span><?= $total_likes; ?></span>
            <p>Total Suka</p>
            <a href="contents.php" class="btn">Lihat Video</a>
         </div>
         <div class="box">
            <span><?= $total_comments; ?></span>
            <p>Total Komentar</p>
            <a href="comments.php" class="btn">Lihat Komentar</a>
         </div>
         <div class="box">
            <span><?= $total_schedules; ?></span>
            <p>Total Jadwal</p>
            <a href="schedule.php" class="btn">Lihat Jadwal</a>
         </div>
      </div>
   </div>

</section>















<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>
