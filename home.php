<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

$select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
$select_likes->execute([$user_id]);
$total_likes = $select_likes->rowCount();

$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
$select_comments->execute([$user_id]);
$total_comments = $select_comments->rowCount();

$select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
$select_bookmark->execute([$user_id]);
$total_bookmarked = $select_bookmark->rowCount();

$select_booking = $conn->prepare("SELECT * FROM `booking` WHERE user_id = ?");
$select_booking->execute([$user_id]);
$total_booked = $select_booking->rowCount();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Beranda</title>

   <!-- Tautan font awesome CDN  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Tautan berkas CSS kustom  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- Bagian pilihan cepat dimulai -->

<section class="quick-select">

   <h1 class="heading">Opsi Cepat</h1>

   <div class="box-container">

      <?php
         if($user_id != ''){
      ?>
      <div class="box">
         <h3 class="title">Suka dan Komentar</h3>
         <p>Total suka: <span><?= $total_likes; ?></span></p>
         <a href="likes.php" class="inline-btn">Lihat Suka</a>
         <p>Total komentar: <span><?= $total_comments; ?></span></p>
         <a href="comments.php" class="inline-btn">Lihat Komentar</a>
         <p>Playlist tersimpan: <span><?= $total_bookmarked; ?></span></p>
         <a href="bookmark.php" class="inline-btn">Lihat Bookmark</a>
         <p>Booking tersimpan: <span><?= $total_booked; ?></span></p>
         <a href="booking.php" class="inline-btn">Lihat Jadwal</a>
      </div>
      <?php
         }else{ 
      ?>
      <div class="box" style="text-align: center;">
         <h3 class="title">Silakan login atau daftar</h3>
          <div class="flex-btn" style="padding-top: .5rem;">
            <a href="login.php" class="option-btn">Login</a>
            <a href="register.php" class="option-btn">Daftar</a>
         </div>
      </div>
      <?php
      }
      ?>

      <div class="box">
         <h3 class="title">Kategori Teratas</h3>
         <div class="flex">
            <a href="search_course.php?"><i class="fas fa-code"></i><span>Developer</span></a>
            <a href="search_course.php?"><i class="fas fa-chart-simple"></i><span>Bisnis</span></a>
            <a href="search_course.php?"><i class="fas fa-pen"></i><span>Desain</span></a>
            <a href="search_course.php?"><i class="fas fa-chart-line"></i><span>Pemasaran</span></a>
            <a href="search_course.php?"><i class="fas fa-music"></i><span>Musik</span></a>
            <a href="search_course.php?"><i class="fas fa-camera"></i><span>Fotografi</span></a>
            <a href="search_course.php?"><i class="fas fa-cog"></i><span>Perangkat Lunak</span></a>
            <a href="search_course.php?"><i class="fas fa-vial"></i><span>Ilmu Pengetahuan</span></a>
         </div>
      </div>

      <div class="box">
         <h3 class="title">Topik Populer</h3>
         <div class="flex">
            <a href="search_course.php?"><i class="fab fa-html5"></i><span>HTML</span></a>
            <a href="search_course.php?"><i class="fab fa-css3"></i><span>CSS</span></a>
            <a href="search_course.php?"><i class="fab fa-js"></i><span>Javascript</span></a>
            <a href="search_course.php?"><i class="fab fa-react"></i><span>React</span></a>
            <a href="search_course.php?"><i class="fab fa-php"></i><span>PHP</span></a>
            <a href="search_course.php?"><i class="fab fa-bootstrap"></i><span>Bootstrap</span></a>
         </div>
      </div>

      <div class="box tutor">
         <h3 class="title">Menjadi Tutor</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, laudantium.</p>
         <a href="admin/register.php" class="inline-btn">Mulai Sekarang</a>
      </div>

   </div>

</section>

<!-- Bagian pilihan cepat berakhir -->

<!-- Bagian kursus dimulai -->

<section class="courses">

   <h1 class="heading">Kursus Terbaru</h1>

   <div class="box-container">

      <?php
         $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE status = ? or status = ? ORDER BY date DESC LIMIT 6");
         $select_courses->execute(['active', 'aktif']);
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
         echo '<p class="empty">Belum ada kursus ditambahkan!</p>';
      }
      ?>

   </div>

   <div class="more-btn">
      <a href="courses.php" class="inline-option-btn">Lihat Lebih Banyak</a>
   </div>

</section>

<!-- Bagian kursus berakhir -->

<!-- Bagian footer dimulai -->
<?php include 'components/footer.php'; ?>
<!-- Bagian footer berakhir -->

<!-- Tautan berkas JS kustom  -->
<script src="js/script.js"></script>
   
</body>
</html>
