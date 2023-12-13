<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

if(isset($_POST['submit'])){

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
   $select_user->execute([$user_id]);
   $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

   $prev_pass = $fetch_user['password'];
   $prev_image = $fetch_user['image'];

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   if(!empty($name)){
      $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
      $update_name->execute([$name, $user_id]);
   }

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   if(!empty($email)){
      $select_email = $conn->prepare("SELECT email FROM `users` WHERE email = ?");
      $select_email->execute([$email]);
      if($select_email->rowCount() > 0){
         $message[] = 'Email sudah digunakan!';
      }else{
         $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
         $update_email->execute([$email, $user_id]);
      }
   }

   $age = $_POST['age'];
   $age = filter_var($age, FILTER_SANITIZE_STRING);
   $update_age = $conn->prepare("UPDATE `users` SET age = ? WHERE id = ?");
   $update_age->execute([$age, $user_id]);

   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $update_address = $conn->prepare("UPDATE `users` SET address = ? WHERE id = ?");
   $update_address->execute([$address, $user_id]);

   $contact_data = $_POST['contact_data'];
   $contact_data = filter_var($contact_data, FILTER_SANITIZE_STRING);
   $update_contact_data = $conn->prepare("UPDATE `users` SET contact_data = ? WHERE id = ?");
   $update_contact_data->execute([$contact_data, $user_id]);

   $educational_history = $_POST['educational_history'];
   $educational_history = filter_var($educational_history, FILTER_SANITIZE_STRING);
   $update_educational_history = $conn->prepare("UPDATE `users` SET educational_history = ? WHERE id = ?");
   $update_educational_history->execute([$educational_history, $user_id]);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id().'.'.$ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_files/'.$rename;

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'Ukuran gambar terlalu besar!';
      }else{
         $update_image = $conn->prepare("UPDATE `users` SET `image` = ? WHERE id = ?");
         $update_image->execute([$rename, $user_id]);
         move_uploaded_file($image_tmp_name, $image_folder);
         if($prev_image != '' AND $prev_image != $rename){
            unlink('uploaded_files/'.$prev_image);
         }
      }
   }

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   if($old_pass != $empty_pass){
      if($old_pass != $prev_pass){
         $message[] = 'Password lama tidak cocok!';
      }elseif($new_pass != $cpass){
         $message[] = 'Konfirmasi password tidak cocok!';
      }else{
         if($new_pass != $empty_pass){
            $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
            $update_pass->execute([$cpass, $user_id]);
         }else{
            $message[] = 'Harap masukkan password baru!';
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
   <title>Perbarui Profil</title>

   <!-- Tautan font awesome CDN  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Tautan berkas CSS kustom  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="form-container" style="min-height: calc(100vh - 19rem);">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Perbarui Profil</h3>
      <div class="flex">
         <div class="col">
            <p>Nama Anda</p>
            <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" maxlength="100" class="box">
            <p>Email Anda</p>
            <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" maxlength="100" class="box">
            <p>Umur Anda</p>
            <input type="tel" name="age" placeholder="<?= $fetch_profile['age']; ?>" class="box">
            <p>Alamat Anda</p>
            <input type="text" name="address" placeholder="<?= $fetch_profile['address']; ?>" class="box">
            <p>Nomer Telepon Anda</p>
            <input type="tel" name="contact_data" placeholder="<?= $fetch_profile['contact_data']; ?>" class="box">
            <p>Riwayat Pendidikan</p>
            <textarea name="educational_history" placeholder="<?= $fetch_profile['educational_history']; ?>" class="box"></textarea>
            <p>Password Lama</p>
            <input type="password" name="old_pass" placeholder="Masukkan password lama Anda" maxlength="50" class="box">
            <p>Password Baru</p>
            <input type="password" name="new_pass" placeholder="Masukkan password baru Anda" maxlength="50" class="box">
            <p>Konfirmasi Password Baru</p>
            <input type="password" name="cpass" placeholder="Konfirmasi password baru Anda" maxlength="50" class="box">
            <p>Perbarui Gambar</p>
            <input type="file" name="image" accept="image/*" class="box">
         </div>
      </div>
      <input type="submit" name="submit" value="Perbarui Profil" class="btn">
   </form>

</section>

<!-- Bagian update profile berakhir -->

<?php include 'components/footer.php'; ?>

<!-- Tautan berkas JS kustom  -->
<script src="js/script.js"></script>
   
</body>
</html>
