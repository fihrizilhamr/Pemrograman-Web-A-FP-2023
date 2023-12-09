USE test;
CREATE TABLE `materi_pelajaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mata_pelajaran` varchar(50) NOT NULL,
  `tingkat_kelas` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `modul_pelajaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pelajaran_id` int(11) NOT NULL,
  `modul` text NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`pelajaran_id`) REFERENCES `materi_pelajaran`(`id`)
);

CREATE TABLE `video_pelajaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pelajaran_id` int(11) NOT NULL,
  `video` text NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`pelajaran_id`) REFERENCES `materi_pelajaran`(`id`)
);

CREATE TABLE `latihan_soal_pelajaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pelajaran_id` int(11) NOT NULL,
  `latihan_soal` text NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`pelajaran_id`) REFERENCES `materi_pelajaran`(`id`)
);

-- Insert data ke dalam tabel 
INSERT INTO materi_pelajaran (mata_pelajaran, tingkat_kelas) VALUES ('Pemrograman Web', 'Semester 5');
INSERT INTO modul_pelajaran (pelajaran_id, modul) VALUES (1, 'https://fajarbaskoro.blogspot.com/2018/02/pweb-1-1-hosting-dan-domain.html');
INSERT INTO video_pelajaran (pelajaran_id, video) VALUES (1, 'https://youtu.be/5JwWqjd4e9o?si=9afdeF89zCpJCODI');
INSERT INTO video_pelajaran (pelajaran_id, video) VALUES (1, 'https://youtu.be/AfueM3yvXuw');
INSERT INTO latihan_soal_pelajaran (pelajaran_id, latihan_soal) VALUES (1, 'https://fajarbaskoro.blogspot.com/2023/12/lembaga-bimbingan-belajar.html');
