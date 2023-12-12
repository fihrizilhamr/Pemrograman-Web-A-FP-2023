<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $id = unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $age = $_POST['age'];
   $age = filter_var($age, FILTER_SANITIZE_NUMBER_INT);

   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);

   $contact_data = $_POST['contact_data'];
   $contact_data = filter_var($contact_data, FILTER_SANITIZE_STRING);

   $educational_history = $_POST['educational_history'];
   $educational_history = filter_var($educational_history, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id().'.'.$ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_files/'.$rename;

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);

   if($select_user->rowCount() > 0){
      $message[] = 'Email sudah digunakan!';
   }else{
      if($pass != $cpass){
         $message[] = 'Konfirmasi password tidak sesuai!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(id, name, email, password, age, address, contact_data, educational_history, image) VALUES(?,?,?,?,?,?,?,?,?)");
         $insert_user->execute([$id, $name, $email, $cpass, $age, $address, $contact_data, $educational_history, $rename]);
         move_uploaded_file($image_tmp_name, $image_folder);

         $verify_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
         $verify_user->execute([$email, $pass]);
         $row = $verify_user->fetch(PDO::FETCH_ASSOC);

         if($verify_user->rowCount() > 0){
            setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
            header('location:home.php');
         }
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Halaman Utama</title>

   <!-- Tautan font awesome CDN  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Tautan berkas CSS kustom  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form class="register" action="" method="post" enctype="multipart/form-data">
      <h3>Daftar Akun</h3>
      <div class="flex">
         <div class="col">
            <p>Nama Anda <span>*</span></p>
            <input type="text" name="name" placeholder="Masukkan nama Anda" maxlength="50" required class="box">
            <p>Email Anda <span>*</span></p>
            <input type="email" name="email" placeholder="Masukkan email Anda" maxlength="20" required class="box">
            <p>Umur Anda <span>*</span></p>
            <input type="number" name="age" placeholder="Masukkan umur Anda" required class="box">
            <p>Alamat Anda <span>*</span></p>
            <input type="text" name="address" placeholder="Masukkan alamat Anda" required class="box">
            <p>Nomer Telepon Anda <span>*</span></p>
            <input type="tel" name="contact_data" placeholder="Masukkan nomer telepon Anda" required class="box">
            <p>Riwayat Pendidikan <span>*</span></p>
            <textarea name="educational_history" placeholder="Masukkan riwayat pendidikan Anda" required class="box"></textarea>
            <p>Password Anda <span>*</span></p>
            <input type="password" name="pass" placeholder="Masukkan password Anda" maxlength="20" required class="box">
            <p>Konfirmasi Password <span>*</span></p>
            <input type="password" name="cpass" placeholder="Konfirmasi password Anda" maxlength="20" required class="box">
         </div>
      </div>
      <p>Pilih gambar <span>*</span></p>
      <input type="file" name="image" accept="image/*" required class="box">
      <p class="link">Sudah punya akun? <a href="login.php">Masuk sekarang</a></p>
      <input type="submit" name="submit" value="Daftar Sekarang" class="btn">
   </form>

</section>

<?php include 'components/footer.php'; ?>

<!-- Tautan berkas JS kustom  -->
<script src="js/script.js"></script>
   
</body>
</html>
