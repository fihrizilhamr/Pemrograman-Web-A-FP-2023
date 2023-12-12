<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

if(isset($_POST['submit'])){

   $id = unique_id();
   $status = $_POST['status'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);
   $subject = $_POST['subject'];
   $subject = filter_var($subject, FILTER_SANITIZE_STRING);
   $date = $_POST['date'];
   $date = filter_var($date, FILTER_SANITIZE_STRING);
   $time = $_POST['time'];
   $time = filter_var($time, FILTER_SANITIZE_STRING);

   $add_schedule = $conn->prepare("INSERT INTO `counseling_schedule` (id, tutor_id, subject, date, time, status) VALUES (?, ?, ?, ?, ?, ?)");
   $add_schedule->execute([$id, $tutor_id, $subject, $date, $time, $status]);

   $message[] = 'Jadwal bimbingan berhasil ditambahkan!';
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

   <h1 class="heading">Tambah Jadwal Bimbingan</h1>

   <form action="" method="post">
      <p>Status Jadwal <span>*</span></p>
      <select name="status" class="box" required>
         <option value="" selected disabled>-- Pilih Status --</option>
         <option value="active">Aktif</option>
         <option value="deactive">Nonaktif</option>
      </select>
      <p>Mata Pelajaran <span>*</span></p>
      <input type="text" name="subject" maxlength="50" required placeholder="Masukkan mata pelajaran" class="box">
      <p>Tanggal <span>*</span></p>
      <input type="date" name="date" required class="box">
      <p>Waktu <span>*</span></p>
      <input type="time" name="time" required class="box">
      <input type="submit" value="Tambah Jadwal" name="submit" class="btn">
   </form>

</section>

<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>
