<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

$get_id = isset($_GET['get_id']) ? $_GET['get_id'] : '';

if (isset($_POST['save_list'])) {

    if ($user_id != '') {

        $list_id = $_POST['list_id'];
        $list_id = filter_var($list_id, FILTER_SANITIZE_STRING);

        $select_list = $conn->prepare("SELECT * FROM `booking` WHERE user_id = ? AND counseling_schedule_id = ?");
        $select_list->execute([$user_id, $list_id]);

        if ($select_list->rowCount() > 0) {
            $remove_booking = $conn->prepare("DELETE FROM `booking` WHERE user_id = ? AND counseling_schedule_id = ?");
            $remove_booking->execute([$user_id, $list_id]);
            $message[] = 'Booking dihapus!';
        } else {
            $insert_booking = $conn->prepare("INSERT INTO `booking`(user_id, counseling_schedule_id) VALUES(?, ?)");
            $insert_booking->execute([$user_id, $list_id]);
            $message[] = 'Booking disimpan!';
        }
    } else {
        $message[] = 'Silakan login terlebih dahulu!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Bimbingan</title>

    <!-- Tautan font awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Tautan berkas CSS kustom -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <!-- Bagian jadwal bimbingan dimulai -->

    <section class="schedule-container">
    <h1 class="heading">Jadwal Bimbingan</h1>
    <div class="row">
        <?php
        $select_schedule = $conn->prepare("SELECT * FROM `counseling_schedule` WHERE id = ? AND (status = ? or status = ?) ORDER BY date ASC, time ASC");
        $select_schedule->execute([$get_id, 'active', 'aktif']);

        if ($select_schedule->rowCount() > 0) {
            $fetch_schedule = $select_schedule->fetch(PDO::FETCH_ASSOC);
            $schedule_id = $fetch_schedule['id'];

            // Periksa apakah tutor_id tersedia sebelum mengambil data tutor
            if (!empty($fetch_schedule['tutor_id'])) {
                $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ? LIMIT 1");
                $select_tutor->execute([$fetch_schedule['tutor_id']]);

                // Periksa apakah tutor ditemukan sebelum mengambil datanya
                if ($select_tutor->rowCount() > 0) {
                    $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
                } else {
                    // Tutor tidak ditemukan, atur $fetch_tutor menjadi array kosong atau null
                    $fetch_tutor = null;
                }
            } else {
                // tutor_id tidak tersedia, atur $fetch_tutor menjadi array kosong atau null
                $fetch_tutor = null;
            }

            $select_booking = $conn->prepare("SELECT * FROM `booking` WHERE user_id = ? AND counseling_schedule_id = ?");
            $select_booking->execute([$user_id, $schedule_id]);
        } else {
            echo '<p class="empty">Jadwal bimbingan tidak tersedia!</p>';
        }
        ?>

        <div class="col">
            <form action="" method="post" class="save-list">
                <input type="hidden" name="list_id" value="<?= $schedule_id; ?>">
                <?php
                if ($select_booking->rowCount() > 0) {
                ?>
                    <button type="submit" name="save_list"><i class="fas fa-bookmark"></i><span>Tersimpan</span></button>
                <?php
                } else {
                ?>
                    <button type="submit" name="save_list"><i class="far fa-bookmark"></i><span>Booking Jadwal</span></button>
                <?php
                }
                ?>
            </form>
            <div class="box">
                <h3><?= $fetch_schedule['subject']; ?></h3>
                <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_schedule['date']; ?></span></div>
                <div class="time"><i class="fas fa-clock"></i><span><?= $fetch_schedule['time']; ?></span></div>
            </div>
        </div>

        <div class="col">
            <div class="tutor">
                <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
                <div>
                    <h3><?= $fetch_tutor['name']; ?></h3>
                    <span><?= $fetch_tutor['profession']; ?></span>
                </div>
            </div>
        </div>

    </div>
</section>

    <!-- Bagian jadwal bimbingan berakhir -->

    <?php include 'components/footer.php'; ?>

    <!-- Tautan berkas JS kustom -->
    <script src="js/script.js"></script>

</body>

</html>
