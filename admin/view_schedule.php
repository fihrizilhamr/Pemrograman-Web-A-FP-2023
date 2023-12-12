<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

if(isset($_GET['get_id'])){
   $schedule_id = $_GET['get_id'];
}else{
   $schedule_id = '';
   header('location:schedule.php');
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Detail Jadwal Bimbingan</title>

   <!-- Tautan font awesome cdn  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Tautan berkas CSS kustom  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>
   
<section class="view-schedule">

   <h1 class="heading">Detail Jadwal Bimbingan</h1>

   <?php
      $select_schedule = $conn->prepare("SELECT * FROM `counseling_schedule` WHERE id = ? AND tutor_id = ?");
      $select_schedule->execute([$schedule_id, $tutor_id]);
      if($select_schedule->rowCount() > 0){
         $fetch_schedule = $select_schedule->fetch(PDO::FETCH_ASSOC);
   ?>
   <div class="row">
      <div class="details">
         <h3 class="title"><?= $fetch_schedule['subject']; ?></h3>
         <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_schedule['date']; ?></span></div>
         <div class="time"><i class="fas fa-clock"></i><span><?= $fetch_schedule['time']; ?></span></div>
         <div class="status"><i class="fas fa-info-circle"></i><span><?= $fetch_schedule['status']; ?></span></div>
         <form action="schedule.php" method="post" class="flex-btn">
            <input type="submit" value="Kembali" class="btn">
         </form>
      </div>
   </div>
   <?php
      } else {
         echo '<p class="empty">Jadwal tidak ditemukan!</p>';
      }
   ?>

</section>

<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>
