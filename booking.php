<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location:home.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Booking</title>

   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="booked">

   <h1 class="heading">Daftar Jadwal Bimbingan yang Dibooking</h1>

   <div class="box-container">

      <?php
         $select_booking = $conn->prepare("SELECT * FROM `booking` WHERE user_id = ?");
         $select_booking->execute([$user_id]);
         if($select_booking->rowCount() > 0){
            while($fetch_booking = $select_booking->fetch(PDO::FETCH_ASSOC)){
               $select_counseling = $conn->prepare("SELECT * FROM `counseling_schedule` WHERE id = ? AND (status = ? or status = ?) ORDER BY date DESC");
               $select_counseling->execute([$fetch_booking['counseling_schedule_id'], 'active', 'aktif']);
               if($select_counseling->rowCount() > 0){
                  while($fetch_counseling = $select_counseling->fetch(PDO::FETCH_ASSOC)){

                  $counseling_id = $fetch_counseling['id'];

                  $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
                  $select_tutor->execute([$fetch_counseling['tutor_id']]);
                  $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
      ?>
      <div class="box">
         <div class="tutor">
            <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['name']; ?></h3>
               <span><?= $fetch_counseling['date']; ?></span>
            </div>
         </div>
         <h3 class="subject"><?= $fetch_counseling['subject']; ?></h3>
         <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_counseling['date']; ?></span></div>
         <div class="time"><i class="fas fa-clock"></i><span><?= $fetch_counseling['time']; ?></span></div>
         <a href="counseling_schedule.php?get_id=<?= $counseling_id; ?>" class="inline-btn">Lihat Detail</a>
      </div>
      <?php
               }
            } else {
               echo '<p class="empty">Tidak ada bimbingan yang ditemukan!</p>';
            }
         }
      } else {
         echo '<p class="empty">Belum ada yang dibookmark!</p>';
      }
      ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<!-- Tautan file JS kustom  -->
<script src="js/script.js"></script>
   
</body>
</html>
