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
   $schedule_id = filter_var($schedule_id, FILTER_SANITIZE_STRING);

   $select_schedule = $conn->prepare("SELECT * FROM `counseling_schedule` WHERE id = ? AND tutor_id = ? LIMIT 1");
   $select_schedule->execute([$schedule_id, $tutor_id]);
   $fetch_schedule = $select_schedule->fetch(PDO::FETCH_ASSOC);

   if(!$fetch_schedule){
      header('location:schedule.php');
   }

   if(isset($_POST['update'])){
      $status = $_POST['status'];
      $status = filter_var($status, FILTER_SANITIZE_STRING);
      $subject = $_POST['subject'];
      $subject = filter_var($subject, FILTER_SANITIZE_STRING);
      $date = $_POST['date'];
      $date = filter_var($date, FILTER_SANITIZE_STRING);
      $time = $_POST['time'];
      $time = filter_var($time, FILTER_SANITIZE_STRING);

      $update_schedule = $conn->prepare("UPDATE `counseling_schedule` SET status=?, subject=?, date=?, time=? WHERE id=? AND tutor_id=?");
      $update_schedule->execute([$status, $subject, $date, $time, $schedule_id, $tutor_id]);

      $message[] = 'Jadwal bimbingan berhasil diperbarui!';
   }
} else {
   header('location:schedule.php');
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
   
<section class="schedule-form">

   <h1 class="heading">Perbarui Jadwal Bimbingan</h1>

   <form action="" method="post">
      <p>Status Jadwal <span>*</span></p>
      <select name="status" class="box" required>
         <option value="active" <?php if($fetch_schedule['status'] == 'active') echo 'selected'; ?>>Aktif</option>
         <option value="canceled" <?php if($fetch_schedule['status'] == 'canceled') echo 'selected'; ?>>Dibatalkan</option>
      </select>
      <p>Mata Pelajaran <span>*</span></p>
      <input type="text" name="subject" maxlength="50" required placeholder="Masukkan mata pelajaran" class="box" value="<?= $fetch_schedule['subject']; ?>">
      <p>Tanggal <span>*</span></p>
      <input type="date" name="date" required class="box" value="<?= $fetch_schedule['date']; ?>">
      <p>Waktu <span>*</span></p>
      <input type="time" name="time" required class="box" value="<?= $fetch_schedule['time']; ?>">
      <input type="submit" value="Perbarui Jadwal" name="update" class="btn">
   </form>

</section>

<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>
