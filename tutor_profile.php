<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['tutor_fetch'])){

   $tutor_email = $_POST['tutor_email'];
   $tutor_email = filter_var($tutor_email, FILTER_SANITIZE_STRING);
   $select_tutor = $conn->prepare('SELECT * FROM `tutors` WHERE email = ?');
   $select_tutor->execute([$tutor_email]);

   $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
   $tutor_id = $fetch_tutor['id'];

   $count_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
   $count_playlists->execute([$tutor_id]);
   $total_playlists = $count_playlists->rowCount();

   $count_contents = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
   $count_contents->execute([$tutor_id]);
   $total_contents = $count_contents->rowCount();

   $count_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
   $count_likes->execute([$tutor_id]);
   $total_likes = $count_likes->rowCount();

   $count_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
   $count_comments->execute([$tutor_id]);
   $total_comments = $count_comments->rowCount();

   $select_schedules = $conn->prepare("SELECT * FROM `counseling_schedule` WHERE tutor_id = ?");
   $select_schedules->execute([$tutor_id]);
   $total_schedules = $select_schedules->rowCount();
}else{
   header('location:teachers.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profil Tutor</title>

   <!-- Tautan font awesome CDN  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Tautan berkas CSS kustom  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- Bagian profil tutor dimulai -->

<section class="tutor-profile">

   <h1 class="heading">Detail Profil</h1>

   <div class="details">
      <div class="tutor">
         <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
         <h3><?= $fetch_tutor['name']; ?></h3>
         <span><?= $fetch_tutor['profession']; ?></span>
      </div>
      <div class="flex">
         <p>Total playlist : <span><?= $total_playlists; ?></span></p>
         <p>Total video : <span><?= $total_contents; ?></span></p>
         <p>Total suka : <span><?= $total_likes; ?></span></p>
         <p>Total komentar : <span><?= $total_comments; ?></span></p>
         <p>Total jadwal : <span><?= $total_schedules; ?></span></p>
      </div>
   </div>

</section>

<!-- Bagian profil tutor berakhir -->

<section class="courses">

   <h1 class="heading">Kursus Terbaru</h1>

   <div class="box-container">

      <?php
         $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ? AND (status = ? or status = ?)");
         $select_courses->execute([$tutor_id, 'active', 'aktif']);
         if($select_courses->rowCount() > 0){
            while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
               $course_id = $fetch_course['id'];

               $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
               $select_tutor->execute([$fetch_course['tutor_id']]);
               $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
      ?>
      <div class="box">
         <div class="tutor">
            <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['name']; ?></h3>
               <span><?= $fetch_course['date']; ?></span>
            </div>
         </div>
         <img src="uploaded_files/<?= $fetch_course['thumb']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fetch_course['title']; ?></h3>
         <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">Lihat Playlist</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">Belum ada kursus yang ditambahkan!</p>';
      }
      ?>

   </div>

</section>

<!-- Bagian kursus berakhir -->
<?php include 'components/footer.php'; ?>    

<!-- Tautan berkas JS kustom  -->
<script src="js/script.js"></script>
   
</body>
</html>
