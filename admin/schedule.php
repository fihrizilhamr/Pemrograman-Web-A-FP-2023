<?php
include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

if(isset($_POST['delete_schedule'])){
   $delete_id = $_POST['schedule_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
   $delete_schedule = $conn->prepare("DELETE FROM `counseling_schedule` WHERE id = ?");
   $delete_schedule->execute([$delete_id]);
   $message[] = 'Jadwal bimbingan dihapus!';
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dasbor</title>

   <!-- Tautan font awesome cdn  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Tautan berkas CSS kustom  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>
   
<section class="schedules">

   <h1 class="heading">Jadwal Bimbingan Anda</h1>

   <div class="box-container">

      <div class="box" style="text-align: center;">
         <h3 class="title" style="margin-bottom: .5rem;">Buat Jadwal Bimbingan Baru</h3>
         <a href="add_schedule.php" class="btn">Tambahkan Jadwal</a>
      </div>

      <?php
      $select_schedules = $conn->prepare("SELECT * FROM `counseling_schedule` WHERE tutor_id = ? ORDER BY date DESC");
      $select_schedules->execute([$tutor_id]);
      if($select_schedules->rowCount() > 0){
         while($fetch_schedules = $select_schedules->fetch(PDO::FETCH_ASSOC)){
            $schedule_id = $fetch_schedules['id'];
      ?>
      <div class="box">
         <div class="flex">
            <div><i class="fas fa-dot-circle" style="<?php if($fetch_schedules['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"></i><span style="<?php if($fetch_schedules['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"><?= $fetch_schedules['status']; ?></span></div>
            <div><i class="fas fa-calendar"></i><span><?= $fetch_schedules['date']; ?></span></div>
            <div><i class="fas fa-clock"></i><span><?= $fetch_schedules['time']; ?></span></div>
         </div>
         <h3 class="title"><?= $fetch_schedules['subject']; ?></h3>
         <!-- <p class="description"><?= $fetch_schedules['status']; ?></p> -->
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="schedule_id" value="<?= $schedule_id; ?>">
            <a href="update_schedule.php?get_id=<?= $schedule_id; ?>" class="option-btn">Perbarui</a>
            <input type="submit" value="Hapus" class="delete-btn" onclick="return confirm('Hapus jadwal ini?');" name="delete_schedule">
         </form>
         <a href="view_schedule.php?get_id=<?= $schedule_id; ?>" class="btn">Lihat Jadwal</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">Belum ada jadwal bimbingan ditambahkan!</p>';
      }
      ?>

   </div>

</section>

<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>
