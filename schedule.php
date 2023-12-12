<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
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

    <!-- Tautan berkas CSS kustom untuk halaman schedule -->
    <link rel="stylesheet" href="css/schedule.css">
</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <!-- Bagian jadwal bimbingan dimulai -->

    <section class="schedule">

        <h1 class="heading">Semua Jadwal Bimbingan</h1>

        <div class="box-container">

            <?php
            $select_schedule = $conn->prepare("SELECT * FROM `counseling_schedule` WHERE (status = ? or status = ?) ORDER BY date DESC");
            $select_schedule->execute(['active', 'aktif']);
            if ($select_schedule->rowCount() > 0) {
                while ($fetch_schedule = $select_schedule->fetch(PDO::FETCH_ASSOC)) {
                    $schedule_id = $fetch_schedule['id'];

                    $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
                    $select_tutor->execute([$fetch_schedule['tutor_id']]);
                    $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
            ?>
                    <div class="box">
                        <div class="tutor">
                            <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
                            <div>
                                <h3><?= $fetch_tutor['name']; ?></h3>
                                <span><?= $fetch_schedule['date']; ?>, <?= $fetch_schedule['time']; ?></span>
                            </div>
                        </div>
                        <h3 class="title"><?= $fetch_schedule['subject']; ?></h3>
                        <a href="counseling_schedule.php?get_id=<?= $schedule_id ; ?>" class="inline-btn">Lihat Jadwal</a>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">Belum ada jadwal bimbingan!</p>';
            }
            ?>

        </div>

    </section>

    <!-- Bagian jadwal bimbingan berakhir -->

    <?php include 'components/footer.php'; ?>

    <!-- Tautan berkas JS kustom -->
    <script src="js/script.js"></script>

</body>

</html>
