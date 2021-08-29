-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Agu 2021 pada 06.51
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_simskul`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `photo` varchar(225) NOT NULL DEFAULT 'profile.jpg',
  `fullname` varchar(225) NOT NULL,
  `email` varchar(225) DEFAULT NULL,
  `password` varchar(225) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'admin',
  `phone` varchar(15) DEFAULT NULL,
  `activation_code` varchar(4) DEFAULT NULL,
  `token` varchar(16) DEFAULT NULL,
  `token_expired` datetime DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `registered_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`admin_id`, `username`, `photo`, `fullname`, `email`, `password`, `role`, `phone`, `activation_code`, `token`, `token_expired`, `is_active`, `registered_at`) VALUES
(1, 'superadmin', 'profile.jpg', 'SuperAdmin', 'superadmin@simskul.com', '$2y$10$CErM.PEjf8Hls1tM8xwDWeqDW6n6ns1amQbophNjjs8KbUDlauKSa', 'superadmin', NULL, NULL, '0dzNQRITk88tIj0H', '2021-06-14 07:25:14', 1, '2021-05-21 09:18:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_announcement`
--

CREATE TABLE `tb_announcement` (
  `announcement_id` int(11) UNSIGNED NOT NULL,
  `announcement_title` varchar(225) NOT NULL,
  `announcement_desc` mediumtext NOT NULL,
  `announcement_for` varchar(7) NOT NULL DEFAULT 'all',
  `announced_by` varchar(225) NOT NULL,
  `announced_at` datetime NOT NULL DEFAULT current_timestamp(),
  `announced_until` datetime NOT NULL,
  `at_school_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_announcement`
--

INSERT INTO `tb_announcement` (`announcement_id`, `announcement_title`, `announcement_desc`, `announcement_for`, `announced_by`, `announced_at`, `announced_until`, `at_school_year`) VALUES
(14, 'Bagi Raport Siswa', '&lt;p&gt;Diberitahukan kepada Orang Tua Peserta Didik SMK Negeri 2 Kota Jambi kelas X, XI dan XII Tahun Pelajaran 2020-2021.&lt;/p&gt;&lt;ol&gt;&lt;li&gt;Pembagian Laporan Hasil Penilaian Akhir Semester Ganjil Tahun Pelajaran 2020/2021 akan dilaksanakan Pada Hari&amp;nbsp;Kamis&lt;span style=&quot;background-color: transparent;&quot;&gt;, 22 Juli 2021 Pukul 09:00 WIB s.d. 13:00 WIB&lt;/span&gt;;&lt;/li&gt;&lt;li&gt;Raport diambil oleh Orang Tua/Wali Murid;&lt;/li&gt;&lt;li&gt;Libur Semester Tahun Pelajaran 2020/2021 dari&amp;nbsp;&lt;em style=&quot;background-color: transparent;&quot;&gt;Tanggal 20 Juli 2021&lt;/em&gt;&amp;nbsp;s.d&amp;nbsp;&lt;em style=&quot;background-color: transparent;&quot;&gt;01 Desember 2021&lt;/em&gt;;&lt;/li&gt;&lt;li&gt;Masuk Sekolah Semester Genap Tahun Pelajaran 2020/2021&amp;nbsp;&lt;em style=&quot;background-color: transparent;&quot;&gt;tanggal 02 Desember 2021&lt;/em&gt;;&lt;/li&gt;&lt;/ol&gt;&lt;p&gt;Demikian pemberitahuan ini kami sampaikan , atas perhatian Bapak/Ibu kami ucapkan terimakasih.&lt;/p&gt;', 'all', 'siswanto', '2021-07-22 16:33:00', '2021-07-24 16:34:00', 6),
(15, 'Pengumuman hari bagi raport', '&lt;p&gt;Diberitahukan kepada Orang Tua Peserta Didik SMK Negeri 2 Kota Jambi kelas X, XI dan XII Tahun Pelajaran 2020-2021.&lt;/p&gt;&lt;ol&gt;&lt;li&gt;Pembagian Laporan Hasil Penilaian Akhir Semester Ganjil Tahun Pelajaran 2020/2021 akan dilaksanakan Pada Hari&amp;nbsp;Kamis&lt;span style=&quot;background-color: transparent;&quot;&gt;, 22 Juli 2021 Pukul 09:00 WIB s.d. 13:00 WIB&lt;/span&gt;;&lt;/li&gt;&lt;li&gt;Raport diambil oleh Orang Tua/Wali Murid;&lt;/li&gt;&lt;li&gt;Libur Semester Tahun Pelajaran 2020/2021 dari&amp;nbsp;&lt;em style=&quot;background-color: transparent;&quot;&gt;Tanggal 20 Juli 2021&lt;/em&gt;&amp;nbsp;s.d&amp;nbsp;&lt;em style=&quot;background-color: transparent;&quot;&gt;01 Desember 2021&lt;/em&gt;;&lt;/li&gt;&lt;li&gt;Masuk Sekolah Semester Genap Tahun Pelajaran 2020/2021&amp;nbsp;&lt;em style=&quot;background-color: transparent;&quot;&gt;tanggal 02 Desember 2021&lt;/em&gt;;&lt;/li&gt;&lt;/ol&gt;&lt;p&gt;Demikian pemberitahuan ini kami sampaikan , atas perhatian Bapak/Ibu kami ucapkan terimakasih.&lt;/p&gt;', 'all', 'superadmin', '2021-07-22 17:51:00', '2021-07-23 17:51:00', 6);

--
-- Trigger `tb_announcement`
--
DELIMITER $$
CREATE TRIGGER `create_announcement_log` AFTER INSERT ON `tb_announcement` FOR EACH ROW BEGIN
INSERT INTO tb_log_activity (log_type,log_desc,log_action,log_username) VALUES ('announcement',NEW.announcement_title,'create',NEW.announced_by);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_announcement_log` AFTER UPDATE ON `tb_announcement` FOR EACH ROW BEGIN
INSERT INTO tb_log_activity (log_type,log_desc,log_action,log_username) VALUES ('announcement',NEW.announcement_title,'update',NEW.announced_by);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_assignment`
--

CREATE TABLE `tb_assignment` (
  `assignment_id` int(11) NOT NULL,
  `assignment_code` varchar(8) NOT NULL,
  `assignment_title` varchar(225) NOT NULL,
  `assignment_desc` mediumtext NOT NULL,
  `point` int(11) NOT NULL,
  `assigned_by` varchar(225) NOT NULL,
  `class_group` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]',
  `subject` int(11) DEFAULT NULL,
  `start_at` datetime NOT NULL,
  `due_at` datetime DEFAULT NULL,
  `at_school_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_assignment`
--

INSERT INTO `tb_assignment` (`assignment_id`, `assignment_code`, `assignment_title`, `assignment_desc`, `point`, `assigned_by`, `class_group`, `subject`, `start_at`, `due_at`, `at_school_year`) VALUES
(45, 'UIW2IX', 'Tugas Mandiri 1.2', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Coba kalian cari informasi dari buku sejarah atau internet mengenai nar&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;nama kabinet dari mulai presiden pertama sampai dengan presiden saat&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Tulislah informasi yang kalian temukan pada tabel di bawah ini.&lt;/span&gt;&lt;/p&gt;&lt;ul&gt;&lt;li&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Nama Presiden dan Nama Kabinet&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Presiden Ke-&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Nama Presiden&lt;/span&gt;&lt;/li&gt;&lt;li&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Nama Kabinet&lt;/span&gt;&lt;/li&gt;&lt;/ul&gt;', 100, 'siswanto', '[\"QPTMAT\",\"9K825R\",\"IBFPU0\",\"7M761A\",\"ZRF01F\"]', 6, '2021-07-22 16:54:00', '2021-07-23 16:57:00', 6);

--
-- Trigger `tb_assignment`
--
DELIMITER $$
CREATE TRIGGER `delete_assignment` BEFORE DELETE ON `tb_assignment` FOR EACH ROW BEGIN
DELETE FROM tb_assignment_result WHERE tb_assignment_result.assignment = old.assignment_code;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_assignment_result`
--

CREATE TABLE `tb_assignment_result` (
  `assignment_result_id` int(11) NOT NULL,
  `assignment` varchar(8) NOT NULL,
  `answer` longtext DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `submitted_by` varchar(225) NOT NULL,
  `submitted_at` datetime NOT NULL DEFAULT current_timestamp(),
  `at_school_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_assignment_result`
--

INSERT INTO `tb_assignment_result` (`assignment_result_id`, `assignment`, `answer`, `value`, `submitted_by`, `submitted_at`, `at_school_year`) VALUES
(22, 'UIW2IX', '&lt;p&gt;&lt;span style=&quot;background-color: rgb(246, 246, 249); color: rgb(0, 0, 0);&quot;&gt;Zaman pengembangan dan penyusunan falsafah agama, yaitu zaman orang berfilsafat atas dasar Weda&lt;/span&gt;&lt;/p&gt;', 99, 'alfazrihadirizki', '2021-07-22 18:05:04', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_bank_question`
--

CREATE TABLE `tb_bank_question` (
  `bank_question_id` int(11) NOT NULL,
  `bank_question_title` varchar(225) NOT NULL,
  `questions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '[]' CHECK (json_valid(`questions`)),
  `created_by` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_bank_question`
--

INSERT INTO `tb_bank_question` (`bank_question_id`, `bank_question_title`, `questions`, `created_by`) VALUES
(8, 'Latihan soal Sejarah Kelas 10', '[126,125,124,123,122,121,120,119,118,117]', 'superadmin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_class`
--

CREATE TABLE `tb_class` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_class`
--

INSERT INTO `tb_class` (`class_id`, `class_name`) VALUES
(1, 'X'),
(5, 'XII'),
(9, 'XI');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_class_group`
--

CREATE TABLE `tb_class_group` (
  `class_group_id` int(11) NOT NULL,
  `class_group_code` varchar(6) NOT NULL,
  `class` int(11) NOT NULL,
  `major` int(11) NOT NULL,
  `unit_major` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_class_group`
--

INSERT INTO `tb_class_group` (`class_group_id`, `class_group_code`, `class`, `major`, `unit_major`) VALUES
(3, 'FAC1VB', 5, 3, '2'),
(5, '9K825R', 5, 1, '2'),
(10045, '4J2A0J', 1, 12, '2'),
(10046, 'SIGUWC', 1, 12, '3'),
(10047, 'Z2R61A', 1, 12, '4'),
(10048, '8G7P2A', 1, 12, '5'),
(10049, '6NXLM8', 1, 7, '1'),
(10050, 'UGKS1P', 1, 7, '2'),
(10051, '255LA0', 1, 7, '3'),
(10052, '0M4ND6', 1, 7, '4'),
(10053, 'EK9IWD', 1, 7, '5'),
(10054, '8FQLMF', 1, 1, '1'),
(10055, 'MTVHIN', 1, 1, '2'),
(10056, 'B0VK1J', 1, 1, '3'),
(10057, 'OYBEHD', 1, 1, '4'),
(10058, 'D1L15O', 1, 1, '5'),
(10059, '8GQAUX', 1, 9, '1'),
(10060, '0L197B', 1, 9, '2'),
(10061, 'S3RXY1', 1, 9, '3'),
(10062, '62OZQ6', 1, 9, '4'),
(10063, '8P145C', 1, 9, '5'),
(10064, '8RFACC', 1, 11, '1'),
(10065, 'ZLYT93', 1, 11, '2'),
(10066, '6XF79W', 1, 11, '3'),
(10067, '58VZHZ', 1, 11, '4'),
(10068, 'VCOU7U', 1, 11, '5'),
(10069, 'IITL9T', 1, 6, '1'),
(10070, '7TBOON', 1, 6, '2'),
(10071, 'W55SGH', 1, 6, '3'),
(10072, 'HTZNKY', 1, 6, '4'),
(10073, 'OWVELT', 1, 6, '5'),
(10074, '8IXG0O', 1, 3, '1'),
(10075, 'C1UOTS', 1, 3, '2'),
(10076, 'HZ959H', 1, 3, '3'),
(10077, 'VDI97K', 1, 3, '4'),
(10078, 'CZOAML', 1, 3, '5'),
(10079, 'CBVYUC', 9, 12, '1'),
(10080, 'VHK7VR', 9, 12, '2'),
(10081, '3BOTD5', 9, 12, '3'),
(10082, 'VCGEF2', 9, 12, '4'),
(10083, 'NUI1DX', 9, 12, '5'),
(10084, 'B5FQ8O', 9, 7, '1'),
(10085, 'HZBNMJ', 9, 7, '2'),
(10086, 'EKOAHE', 9, 7, '3'),
(10087, 'F11MGM', 9, 7, '4'),
(10088, 'CJAMFI', 9, 7, '5'),
(10089, 'NSLD13', 9, 1, '1'),
(10090, 'H73GCI', 9, 1, '2'),
(10091, '30L2L7', 9, 1, '3'),
(10092, 'PJ4TBW', 9, 1, '4'),
(10093, 'GLAG70', 9, 1, '5'),
(10094, '79ILOT', 9, 9, '1'),
(10095, 'I1Y2FV', 9, 9, '2'),
(10096, '98E7PS', 9, 9, '3'),
(10097, 'OQIQQU', 9, 9, '4'),
(10098, '9EVSJW', 9, 9, '5'),
(10099, '29D9YT', 9, 11, '1'),
(10100, '948PBA', 9, 11, '2'),
(10101, 'DQZC3Y', 9, 11, '3'),
(10102, 'HJFULQ', 9, 11, '4'),
(10103, '3PY7NY', 9, 11, '5'),
(10104, 'E72YPC', 9, 6, '1'),
(10105, '0AEA68', 9, 6, '2'),
(10106, 'AONFBO', 9, 6, '3'),
(10107, 'ANU7FS', 9, 6, '4'),
(10108, '9D9M5S', 9, 6, '5'),
(10109, 'P0RJVT', 9, 3, '1'),
(10110, 'T99B3P', 9, 3, '2'),
(10111, 'ROGOKA', 9, 3, '3'),
(10112, 'UA6CK7', 9, 3, '4'),
(10113, 'VTFHVC', 9, 3, '5'),
(10114, '2IPKF1', 5, 12, '1'),
(10115, 'BI30YR', 5, 12, '2'),
(10116, 'WS36XF', 5, 12, '3'),
(10117, 'Y9YF56', 5, 12, '4'),
(10118, 'ZESNBW', 5, 12, '5'),
(10119, 'LEL6XZ', 5, 7, '1'),
(10120, '4ABC0X', 5, 7, '2'),
(10121, '9YW8SW', 5, 7, '3'),
(10122, 'QX54RS', 5, 7, '4'),
(10123, 'QLJF6J', 5, 7, '5'),
(10124, 'QPTMAT', 5, 1, '1'),
(10126, 'IBFPU0', 5, 1, '3'),
(10127, '7M761A', 5, 1, '4'),
(10128, 'ZRF01F', 5, 1, '5'),
(10129, '7AOKWH', 5, 9, '1'),
(10130, 'TQQ2PJ', 5, 9, '2'),
(10131, 'LRPQA5', 5, 9, '3'),
(10132, 'TFVJC6', 5, 9, '4'),
(10133, 'EN7056', 5, 9, '5'),
(10134, 'GIHW33', 5, 11, '1'),
(10135, '9JWQ42', 5, 11, '2'),
(10136, 'XFFQD3', 5, 11, '3'),
(10137, 'D51GJ6', 5, 11, '4'),
(10138, 'R3NS93', 5, 11, '5'),
(10139, '9KJ6BN', 5, 6, '1'),
(10140, 'EXRTUY', 5, 6, '2'),
(10141, '0T22S9', 5, 6, '3'),
(10142, 'J7C8YP', 5, 6, '4'),
(10143, '2BO1BT', 5, 6, '5'),
(10144, 'AVLRIK', 5, 3, '1'),
(10146, 'LSTKQ7', 5, 3, '3'),
(10147, '3OXOC6', 5, 3, '4'),
(10148, '9HSQJ5', 5, 3, '5'),
(10149, 'GTR0AZ', 1, 12, '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_major`
--

CREATE TABLE `tb_major` (
  `major_id` int(11) NOT NULL,
  `major_name` varchar(225) NOT NULL,
  `major_code` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_major`
--

INSERT INTO `tb_major` (`major_id`, `major_name`, `major_code`) VALUES
(1, 'Multimedia', 'MM'),
(3, 'Teknik Komputer Jaringan', 'TKJ'),
(6, 'Rekayasa Perangkat Lunak', 'RPL'),
(7, 'Produksi Grafika', 'GF'),
(9, 'Otomatisasi dan Tata Kelola Perkantoran', 'OTKP'),
(11, 'Pemasaran', 'PM'),
(12, 'Akuntansi dan Keuangan Lembaga', 'AK');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_material`
--

CREATE TABLE `tb_material` (
  `material_id` int(11) UNSIGNED NOT NULL,
  `material_code` varchar(8) NOT NULL,
  `material_title` varchar(225) NOT NULL,
  `material_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `class_group` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]',
  `subject` int(11) DEFAULT NULL,
  `created_by` varchar(225) NOT NULL,
  `publish_at` datetime NOT NULL DEFAULT current_timestamp(),
  `at_school_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_material`
--

INSERT INTO `tb_material` (`material_id`, `material_code`, `material_title`, `material_desc`, `class_group`, `subject`, `created_by`, `publish_at`, `at_school_year`) VALUES
(14, 'D0GV6H', 'Perilaku persatuan dan kesatuan', '&lt;p class=&quot;ql-align-justify&quot;&gt;Untuk menjaga persatuan dan kesatuan, setiap warga negara wajib menjalankan perilaku yang mencerminkan persatuan dan kesatuan. Perilaku yang mencerminkan perwujudan persatuan dan kesatuan dalam keluarga, sekolah, masyarakat, bangsa dan negara adalah sebagai berikut.&lt;/p&gt;&lt;p class=&quot;ql-align-justify&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;h2&gt;Perilaku yang mencerminkan perwujudan persatuan dan kesatuan&lt;/h2&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;h3 class=&quot;ql-align-justify&quot;&gt;Di Lingkungan Keluarga&lt;/h3&gt;&lt;ul&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Saling mencintai anggota keluarga&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Akui keberadaan dan fungsi setiap anggota keluarga&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Kembangkan sikap toleransi dan tepa salira&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Jangan memaksakan keinginan orang lain&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Ada keterbukaan di antara anggota keluarga&lt;/li&gt;&lt;/ul&gt;&lt;h3 class=&quot;ql-align-justify&quot;&gt;Di Lingkungan Sekolah&lt;/h3&gt;&lt;ul&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Bersihkan lingkungan bersama&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Mengunjungi salah satu warga yang sedang sakit&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Bekerja sama dalam menjaga keamanan lingkungan.&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Saling menghormati orang yang berbeda agama, tidak membedakan suku.&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Bekerja sama membangun lingkungan sekitar.&lt;/li&gt;&lt;/ul&gt;&lt;h3 class=&quot;ql-align-justify&quot;&gt;Di dalam komunitas&lt;/h3&gt;&lt;ul&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Hidup rukun dengan semangat kekeluargaan antar anggota masyarakat&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Setiap anggota masyarakat memecahkan masalah sosial bersama&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Berbaur dengan sesama warga tidak membedakan suku, agama, ras, atau aliran&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Menggunakan bahasa Indonesia dengan baik dan benar dalam pergaulan antar suku&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Menyelenggarakan bakti sosial di masyarakat&lt;/li&gt;&lt;/ul&gt;&lt;h3 class=&quot;ql-align-justify&quot;&gt;Di Lingkungan Negara&lt;/h3&gt;&lt;ul&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Menempatkan kepentingan bangsa dan negara di atas kepentingan pribadi dan golongan&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Memberikan kesempatan yang sama kepada suku bangsa untuk memperkenalkan kesenian daerahnya ke daerah lain.&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Mempromosikan asosiasi demi persatuan dan kesatuan nasional&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Memberikan kesempatan yang sama bagi semua daerah untuk mengembangkan budaya daerah lainnya&lt;/li&gt;&lt;/ul&gt;&lt;p class=&quot;ql-align-justify&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;ql-align-justify&quot;&gt;Agar persatuan dan kesatuan tetap terjaga, semua warga negara harus menghindari tindakan yang dapat merusak persatuan dan kesatuan.&lt;/p&gt;&lt;p class=&quot;ql-align-justify&quot;&gt;Berikut adalah contoh perilaku yang tidak mencerminkan persatuan dan kesatuan:&lt;/p&gt;&lt;ul&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Mengalihkan tanggung jawab untuk saling membersihkan lingkungan&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Tidak peduli dengan kondisi lingkungan sekitarnya&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Tidak mau ikut patroli karena alasan sibuk dengan pekerjaan&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Hanya berteman dengan agama atau etnis yang sama&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Egois / tidak mau bekerja sama&lt;/li&gt;&lt;/ul&gt;&lt;p class=&quot;ql-align-justify&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;h2 class=&quot;ql-align-justify&quot;&gt;Akibat kurangnya mengimplementasikan persatuan&lt;/h2&gt;&lt;h3 class=&quot;ql-align-justify&quot;&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3 class=&quot;ql-align-justify&quot;&gt;Di dalam keluarga:&lt;/h3&gt;&lt;ul&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Sering terjadi pertengkaran antar anggota keluarga&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Dapat menyebabkan anggota keluarga merasa tidak nyaman di rumah&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Dapat berdampak negatif pada anak, misalnya anak terjebak dalam pergaulan bebas akibat kurangnya perhatian dari orang tua&lt;/li&gt;&lt;/ul&gt;&lt;h3 class=&quot;ql-align-justify&quot;&gt;Di sekolah :&lt;/h3&gt;&lt;ul&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Kurangnya adaptasi ke grup,&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Biasanya sendiri dengan urusan sendiri,&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Setidaknya seorang teman&lt;/li&gt;&lt;/ul&gt;&lt;h3 class=&quot;ql-align-justify&quot;&gt;Dalam masyarakat:&lt;/h3&gt;&lt;ul&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Dikecualikan dari masyarakat,&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Kurangnya interaksi sosial dengan komunitas,&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Tidak bisa mentolerir atau menerima orang lain&lt;/li&gt;&lt;/ul&gt;&lt;h3 class=&quot;ql-align-justify&quot;&gt;Dalam bangsa dan negara:&lt;/h3&gt;&lt;ul&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Menjatuhkan satu sama lain,&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Tidak peduli dengan persatuan negara,&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Lebih egois daripada masalah negara&lt;/li&gt;&lt;/ul&gt;&lt;p class=&quot;ql-align-justify&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;h2 class=&quot;ql-align-justify&quot;&gt;Bagaimana membangun dan membiasakan diri pada komitmen bersama:&lt;/h2&gt;&lt;p class=&quot;ql-align-justify&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;h3 class=&quot;ql-align-justify&quot;&gt;Di sekolah :&lt;/h3&gt;&lt;ul&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Dengan membuat ciri khas motto / yel-yel sekolah baik dalam kegiatan organisasi maupun ekstrakurikuler agar siswa termotivasi untuk melakukan yang terbaik sesuai dengan yang diharapkan. Moto adalah: Disiplin, Komitmen, dan Tanggung Jawab, Ya&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Dengan mensosialisasikan pendidikan karakter di sekolah dalam kurun waktu tertentu&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Senantiasa Guru dan anggota sekolah harus memberi contoh yang baik dan menjadi panutan bagi siswa&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Sekolah harus memiliki dorongan motivasi yang baik agar dapat menginspirasi siswa dan guru&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Instansi Pendidikan wajib memiliki peraturan / regulasi yang baik dan tegas&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Sekolah wajib memiliki visi dan misi yang jelas&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Sekolah harus menyiapkan wadah untuk membiasakan diri dengan komitmen dalam persatuan seperti dalam kegiatan / organisasi ekstrakurikuler&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Warga sekolah harus bekerja sama &ndash; sama untuk mewujudkan Visi dan Misi serta cita-cita mencerdaskan kehidupan bangsa&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Memberikan motivasi / arahan kepada siswa&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Sekolah harus menjadi tempat yang menyenangkan untuk menjadi rumah kedua. Guru harus menjadi orang tua pengganti yang baik dan menanamkan sikap berkomitmen&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Sekolah harus memenuhi dan menyediakan sarana, prasarana dan sarana yang baik serta mendukung siswa dalam proses pembelajaran&lt;/li&gt;&lt;/ul&gt;&lt;h3 class=&quot;ql-align-justify&quot;&gt;Di Lingkungan Keluarga:&lt;/h3&gt;&lt;ul&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Menghormati satu sama lain dalam keluarga&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Memprioritaskan kepentingan bersama dalam keluarga daripada kepentingan pribadi&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Jaga persaudaraan dengan baik&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Biasakan menerapkan komitmen tersebut dalam kehidupan sehari-hari,&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Harus tahu lebih banyak tentang bagaimana menjaga persatuan dan keutuhan negara,&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Hormati orang tua Anda, katakan dengan sopan lembut dan cintai dia.&lt;/li&gt;&lt;/ul&gt;&lt;h3 class=&quot;ql-align-justify&quot;&gt;Di dalam komunitas:&lt;/h3&gt;&lt;ul&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Membiasakan hidup bersama atau bekerja bersama dalam masyarakat,&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Solidaritas,&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Menghargai dan menghormati, dan&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Taatilah peraturan yang ada di masyarakat&lt;/li&gt;&lt;/ul&gt;&lt;h3 class=&quot;ql-align-justify&quot;&gt;Di dalam bangsa dan negara:&lt;/h3&gt;&lt;ul&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Untuk melindungi negara agar bisa hidup aman dan damai,&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Patuhi peraturan,&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Mencintai tanah air, dan&lt;/li&gt;&lt;li class=&quot;ql-align-justify&quot;&gt;Tetap berkomitmen pada negara&lt;/li&gt;&lt;/ul&gt;', '[\"QPTMAT\",\"9K825R\",\"IBFPU0\",\"7M761A\",\"ZRF01F\"]', 8, 'siswanto', '2021-07-09 09:04:00', 6);

--
-- Trigger `tb_material`
--
DELIMITER $$
CREATE TRIGGER `delete_material_comment` BEFORE DELETE ON `tb_material` FOR EACH ROW BEGIN
DELETE FROM tb_material_comment WHERE material = OLD.material_code;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_question`
--

CREATE TABLE `tb_question` (
  `question_id` int(11) NOT NULL,
  `question_type` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `question_text` text NOT NULL,
  `choice` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]',
  `answer_key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_by` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_question`
--

INSERT INTO `tb_question` (`question_id`, `question_type`, `question_text`, `choice`, `answer_key`, `created_by`) VALUES
(117, 'mc', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Berikut empat fase perkembangan agama Hindu di India, kecuali&hellip;.&lt;/span&gt;&lt;/p&gt;', '[\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Zaman Weda&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Zaman Brahmana&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Zaman Upanisad&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Zaman Buddha&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Zaman Sudra&lt;\\/span&gt;&lt;\\/p&gt;\"]', '4', 'siswanto'),
(118, 'mc', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Zaman pengembangan dan penyusunan falsafah agama, yaitu zaman orang berfilsafat atas dasar Weda adalah&hellip;.&lt;/span&gt;&lt;/p&gt;', '[\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Zaman Weda&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Zaman Brahmana&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Zaman Upanisad&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Zaman Buddha&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Zaman Sudra&lt;\\/span&gt;&lt;\\/p&gt;\"]', '2', 'superadmin'),
(119, 'mc', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Teori Brahamana diprakarsai oleh&hellip;.&lt;/span&gt;&lt;/p&gt;', '[\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;C.C. Berg&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Dr. N. J. Krom&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Van Leur&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;F.D.K Bosch&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Moens dan Bosch&lt;\\/span&gt;&lt;\\/p&gt;\"]', '2', 'superadmin'),
(120, 'mc', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Kitab Weda ditulis dengan Bahasa Sansekerta yang hanya dipahami oleh kaum&hellip;&lt;/span&gt;&lt;/p&gt;', '[\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Brahmana&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Ksatria&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Waisya&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Sudra&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Pedagang&lt;\\/span&gt;&lt;\\/p&gt;\"]', '0', 'superadmin'),
(121, 'mc', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Menurut teori Ksatria, agama Hindu dibawa ke Indonesia oleh kaum&hellip;..&lt;/span&gt;&lt;/p&gt;', '[\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Brahmana&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Ksatria&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Waisaya&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Sudra&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Pedagang&lt;\\/span&gt;&lt;\\/p&gt;\"]', '1', 'superadmin'),
(122, 'mc', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Orang-orang yang tergolong dalam Kasta Sudra adalah&hellip;.&lt;/span&gt;&lt;/p&gt;', '[\"&lt;p&gt;raja&lt;\\/p&gt;\",\"&lt;p&gt;bangsawan&lt;\\/p&gt;\",\"&lt;p&gt;pedagang&lt;\\/p&gt;\",\"&lt;p&gt;prajurit perang&lt;\\/p&gt;\",\"&lt;p&gt;kaum buangan&lt;\\/p&gt;\"]', '4', 'superadmin'),
(123, 'mc', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Teori arus balik dicetuskan oleh&hellip;.&lt;/span&gt;&lt;/p&gt;', '[\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;C.C. Berg&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Dr. N. J. Krom&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Van Leur&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;F.D.K Bosch&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Moens dan Bosch&lt;\\/span&gt;&lt;\\/p&gt;\"]', '3', 'superadmin'),
(124, 'mc', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Agama yang memiliki usia terpanjang dan merupakan agama pertama dikenal manusia adalah&hellip;.&lt;/span&gt;&lt;/p&gt;', '[\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Islam&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;Hindhu&lt;\\/p&gt;\",\"&lt;p&gt;Budha&lt;\\/p&gt;\",\"&lt;p&gt;Khatolik&lt;\\/p&gt;\",\"&lt;p&gt;Kristen&lt;\\/p&gt;\"]', '1', 'superadmin'),
(125, 'mc', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Agama Hindu muncul di Indonesia pada tahun &hellip;. SM.&lt;/span&gt;&lt;/p&gt;', '[\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;&plusmn; 1500&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;&plusmn; 500&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;&plusmn; 3500&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;&plusmn; 2000&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;&plusmn; 1000&lt;\\/span&gt;&lt;\\/p&gt;\"]', '0', 'superadmin'),
(126, 'mc', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;Hubungan dagang antara masyarakat Nusantara dengan para pedagang dari wilayah Hindu-Buddha menyebabkan adanya&hellip;.&lt;/span&gt;&lt;/p&gt;', '[\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;asimilasi budaya&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;akulturasi budaya&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;konsilidasi budaya&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;adaptasi budaya&lt;\\/span&gt;&lt;\\/p&gt;\",\"&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0);&quot;&gt;koalisi budaya&lt;\\/span&gt;&lt;\\/p&gt;\"]', '0', 'superadmin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_quiz`
--

CREATE TABLE `tb_quiz` (
  `quiz_id` int(11) NOT NULL,
  `quiz_code` varchar(6) NOT NULL,
  `quiz_title` varchar(225) NOT NULL,
  `questions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '[]' CHECK (json_valid(`questions`)),
  `assigned_by` varchar(225) NOT NULL,
  `subject` int(11) DEFAULT NULL,
  `class_group` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]',
  `question_model` int(11) NOT NULL DEFAULT 0 COMMENT '0=normal;1=random;',
  `show_ans_key` int(11) NOT NULL DEFAULT 0 COMMENT '0=no;1=yes;',
  `time` int(11) DEFAULT NULL,
  `start_at` datetime NOT NULL DEFAULT current_timestamp(),
  `due_at` datetime DEFAULT NULL,
  `at_school_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_quiz`
--

INSERT INTO `tb_quiz` (`quiz_id`, `quiz_code`, `quiz_title`, `questions`, `assigned_by`, `subject`, `class_group`, `question_model`, `show_ans_key`, `time`, `start_at`, `due_at`, `at_school_year`) VALUES
(24, '6CW931', 'Latihan ke-1', '[125,124,123,122,121,120,119,118,117,126]', 'siswanto', 6, '[\"QPTMAT\",\"9K825R\",\"IBFPU0\",\"7M761A\",\"ZRF01F\"]', 1, 0, 15, '2021-07-23 14:26:00', '2021-07-24 14:26:00', 6);

--
-- Trigger `tb_quiz`
--
DELIMITER $$
CREATE TRIGGER `delete_quiz` BEFORE DELETE ON `tb_quiz` FOR EACH ROW BEGIN 
DELETE FROM tb_quiz_result WHERE quiz = OLD.quiz_code;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_quiz_result`
--

CREATE TABLE `tb_quiz_result` (
  `quiz_result_id` int(11) NOT NULL,
  `quiz` varchar(6) NOT NULL,
  `answer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `essay_score` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]',
  `value` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=process;1=completed;2=timeout;',
  `submitted_by` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `submitted_at` datetime DEFAULT NULL,
  `at_school_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_quiz_result`
--

INSERT INTO `tb_quiz_result` (`quiz_result_id`, `quiz`, `answer`, `essay_score`, `value`, `status`, `submitted_by`, `created_at`, `submitted_at`, `at_school_year`) VALUES
(18, '6CW931', '{\"122\": \"4\", \"124\": \"1\", \"125\": \"0\", \"120\": \"0\", \"123\": \"3\", \"119\": \"3\", \"118\": \"0\", \"121\": \"4\", \"126\": \"0\", \"117\": \"4\"}', '[]', 70, 1, 'alfazrihadirizki', '2021-07-24 10:10:01', '2021-07-24 10:19:00', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_school_year`
--

CREATE TABLE `tb_school_year` (
  `school_year_id` int(11) NOT NULL,
  `school_year_title` varchar(25) NOT NULL,
  `school_year_status` int(11) NOT NULL COMMENT '0=inactive;1=active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_school_year`
--

INSERT INTO `tb_school_year` (`school_year_id`, `school_year_title`, `school_year_status`) VALUES
(3, '2017/2018', 0),
(4, '2018/2019', 0),
(5, '2019/2020', 0),
(6, '2020/2021', 1),
(9, '2021/2022', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_student`
--

CREATE TABLE `tb_student` (
  `student_id` int(11) NOT NULL,
  `student_username` varchar(25) NOT NULL,
  `nis` varchar(25) NOT NULL,
  `pob` varchar(225) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(6) NOT NULL,
  `religion` varchar(25) DEFAULT NULL,
  `address` varchar(8) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `curr_class_group` varchar(6) DEFAULT NULL,
  `class_history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '{}'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_student`
--

INSERT INTO `tb_student` (`student_id`, `student_username`, `nis`, `pob`, `dob`, `gender`, `religion`, `address`, `phone`, `curr_class_group`, `class_history`) VALUES
(1, 'alfazrihadirizki', '14697', 'Palembang', '2004-01-14', 'male', 'islam', NULL, '0831212121352', '9K825R', '[{\"class\": \"FAC1VB\", \"year\": 3},{\"class\": \"9K825R\", \"year\": 4}]'),
(4, 'agielherlianto', '14798', NULL, NULL, 'male', 'islam', NULL, '0831212121352', '9K825R', '[{\"class\": \"FAC1VB\", \"year\": 3},{\"class\": \"9K825R\", \"year\": 4}]'),
(8, 'agussetiawan', '14682', 'Jambi', '2003-08-01', 'male', 'islam', NULL, NULL, '9K825R', '{}'),
(9, 'abimanyukuncorowahyu', '14666', 'Jambi', '2003-01-05', 'male', 'islam', NULL, NULL, '9K825R', '{}'),
(10, 'denisyahrawan', '14784', 'Jambi', '2003-06-10', 'male', 'islam', NULL, '16612393659', '9K825R', '{}'),
(12, 'dilajunitasari', '14785', 'Jambi', '2001-01-01', 'female', 'islam', NULL, NULL, '9K825R', '{}'),
(14, 'adisaputra', '14673', 'Palembang', '2003-03-29', 'male', 'islam', NULL, NULL, '2IPKF1', '{}'),
(15, 'ahmadrifai', '14686', 'Palembang', '2002-09-28', 'male', 'islam', NULL, NULL, '2IPKF1', '{}'),
(16, 'ahmadtubagusriana', '14688', 'Palembang', '2003-07-09', 'male', 'islam', NULL, NULL, '2IPKF1', '{}');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_subject`
--

CREATE TABLE `tb_subject` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(225) NOT NULL,
  `subject_code` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_subject`
--

INSERT INTO `tb_subject` (`subject_id`, `subject_name`, `subject_code`) VALUES
(1, 'Matematika', 'MTK'),
(2, 'Bahasa Indonesia', 'BINDO'),
(4, 'Bahasa Inggris', 'BING'),
(5, 'Ilmu Pengetahuan Alam', 'IPA'),
(6, 'Ilmu Pengetahuan Sejarah', 'IPS'),
(8, 'Pendidikan Kewarganegaraan', 'PKN'),
(9, 'Kimia', 'IPA.K'),
(11, 'Pendidikan Agama Islam', 'PAI'),
(12, 'Pendidikan Jasmani Olahraga dan Kesehatan', 'PJOK'),
(13, 'Teknik Pengambilan Audio Video', 'TPAV'),
(15, 'Sejarah', 'SJR');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_teacher`
--

CREATE TABLE `tb_teacher` (
  `teacher_id` int(11) NOT NULL,
  `teacher_username` varchar(225) NOT NULL,
  `nip` varchar(25) NOT NULL,
  `pob` varchar(225) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(25) NOT NULL,
  `religion` varchar(25) DEFAULT NULL,
  `address` varchar(225) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `teaching_class` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]' CHECK (json_valid(`teaching_class`)),
  `teaching_subject` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]' CHECK (json_valid(`teaching_subject`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_teacher`
--

INSERT INTO `tb_teacher` (`teacher_id`, `teacher_username`, `nip`, `pob`, `dob`, `gender`, `religion`, `address`, `phone`, `teaching_class`, `teaching_subject`) VALUES
(1, 'budiyanto', '0030134778', 'Palembang', '1980-01-20', 'male', 'islam', NULL, '088276605782', '[\"2IPKF1\",\"LEL6XZ\",\"QPTMAT\",\"7AOKWH\",\"GIHW33\",\"9KJ6BN\",\"AVLRIK\"]', '[2,4]'),
(3, 'siswanti', '0020134778', 'Jambi', '1970-05-13', 'female', 'islam', 'Jl. Darma Pala Rt.02 Kel. Kebon IX Kab. Muaro Jambi', '088276605782', '[]', '[]'),
(5, 'siswanto', '0020134778', 'Papua', '1995-08-19', 'male', 'islam', NULL, '088276605782', '[\"QPTMAT\",\"9K825R\",\"IBFPU0\",\"7M761A\",\"ZRF01F\"]', '[6]'),
(9, 'imelda', '19900131202011998', 'Jambi', '2021-12-31', 'female', 'islam', NULL, '087799104638', '[]', '[]'),
(10, 'nuraini', '19900131202011999', 'Jambi', NULL, 'female', 'islam', NULL, NULL, '[]', '[]'),
(11, 'ariyandi', '19900131202011999', 'Jambi', '1981-01-01', 'male', 'islam', NULL, NULL, '[\"GTR0AZ\"]', '[2]'),
(12, 'Natalia', '19900131202011990', 'Jambi', '1981-01-01', 'female', 'islam', NULL, NULL, '[\"GTR0AZ\",\"4J2A0J\",\"SIGUWC\",\"Z2R61A\",\"8G7P2A\"]', '[]');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `photo` varchar(225) NOT NULL DEFAULT 'avatar-default.jpg',
  `fullname` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `role` varchar(25) NOT NULL,
  `activation_code` varchar(6) DEFAULT NULL,
  `token` varchar(225) DEFAULT NULL,
  `token_expired` datetime DEFAULT NULL,
  `is_active` int(1) NOT NULL DEFAULT 0,
  `registered_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `username`, `photo`, `fullname`, `email`, `password`, `role`, `activation_code`, `token`, `token_expired`, `is_active`, `registered_at`) VALUES
(1, 'superadmin', 'avatar-s-1.jpg', 'Administrator', 'admin@admin.com', '$2y$10$CErM.PEjf8Hls1tM8xwDWeqDW6n6ns1amQbophNjjs8KbUDlauKSa', 'superadmin', NULL, 'LjijkCiK70B2rIU9', '2021-07-16 00:23:43', 1, '2021-02-20 14:20:46'),
(2, 'alfazrihadirizki', 'avatar-s-2.jpg', 'Alfazri Hadi RIzki', 'alfazrihadirizki@gmail.com', '$2y$10$CErM.PEjf8Hls1tM8xwDWeqDW6n6ns1amQbophNjjs8KbUDlauKSa', 'student', '2004', 'y6ySzUrN5NCPL6tk', '2021-07-16 03:29:00', 1, '2021-02-20 14:31:29'),
(3, 'budiyanto', 'avatar-s-3.jpg', 'Budiyanto s.Pd', 'budiyanto@gmail.com', '', 'teacher', '2000', 'gMLhadUCyANsY6CK', '2021-06-20 17:18:15', 1, '2021-02-20 14:31:29'),
(10, 'siswanto', 'avatar-s-4.jpg', 'Siswanto', 'siswanto@gmail.com', '$2y$10$CErM.PEjf8Hls1tM8xwDWeqDW6n6ns1amQbophNjjs8KbUDlauKSa', 'teacher', '2000', '8Ph1Uhuf6vzgqV6M', '2021-06-27 06:50:02', 1, '2021-02-20 14:31:29'),
(17, 'siswanti', '1623733812_0ea4abbbc1daabbd8072.jpg', 'Siswanti', 'siswanti@gmail.com', '$2y$10$5E0TBF1dKmhzAHPqK1gnq.ySUJvg.XH95YctndhFup.hMPILAQ4ym', 'teacher', '2000', '', '2021-03-06 17:27:40', 1, '2021-02-20 14:31:29'),
(18, 'agielherlianto', '1623815983_466b0a2a37837a3c663c.jpg', 'Agiel Herlianto', 'agielherlianto@gmail.com', '', 'student', '2004', '', '2021-06-21 10:29:04', 1, '2021-02-20 14:31:29'),
(24, 'imelda', '1623825500_a2aba1f8da75413f161f.jpg', 'Imelda', 'imelda@gmail.com', '', 'teacher', NULL, NULL, NULL, 1, '2021-06-16 13:38:20'),
(38, 'agussetiawan', 'avatar-default.jpg', 'Agus Setiawan', 'agussetiawan@gmail.com', '$2y$10$pXmOEVF151eG/luuVaRtb.33ycWlq13sIYy4SVEDxd1tooTOhkapK', 'student', NULL, NULL, NULL, 0, '2021-06-16 16:09:44'),
(39, 'abimanyukuncorowahyu', 'avatar-default.jpg', 'Abimanyu Kuncoro Wahyu', 'abimanyukuncorowahyu@gmail.com', '$2y$10$cVNq.dNE51uOWdgdPGV1ZOEVG0ZPEZ9uuPxn3HiEwyXnbUvBZyFFu', 'student', NULL, NULL, NULL, 0, '2021-06-16 16:10:57'),
(40, 'denisyahrawan', 'avatar-default.jpg', 'Deni Syahrawan', 'denisyahrawan@gmail.com', '', 'student', NULL, NULL, NULL, 0, '2021-06-16 16:14:27'),
(42, 'dilajunitasari', 'avatar-default.jpg', 'Dila Junita Sari', 'dilajunitasari@gmail.com', '$2y$10$P5/c51dn4qoNx4ls3yqGeuPlsnQJ.SuW2t8re7ckTRqN9So4N/4Ni', 'student', NULL, NULL, NULL, 1, '2021-07-13 14:38:25'),
(43, 'nuraini', 'avatar-default.jpg', 'Nuraini', 'nuraini@gmail.com', '$2y$10$4e7SYg5qzzbGCVYPhO4LOOeMNG5M8ZdQUP2.xunVKRpWqUxNqgX9m', 'teacher', NULL, NULL, NULL, 0, '2021-07-13 14:44:54'),
(47, 'ariyandi', 'avatar-default.jpg', 'Ariyandi s.Pd', 'ariyandi@gmail.com', '$2y$10$8dRPlwUIGeiSQNbwsM2BDetotLeYJ5X/pulFTAevjhg0wY5hqVXCe', 'teacher', NULL, NULL, NULL, 1, '2021-07-23 13:37:19'),
(48, 'Natalia', 'avatar-default.jpg', 'Natalia s.Pd', 'natalia@gmail.com', '$2y$10$iCcBoFdcNPy9b5papQZz2O5I4yvQGUv/X5gPg9Svn.xkrur8gbx/K', 'teacher', NULL, NULL, NULL, 1, '2021-07-23 13:38:05'),
(49, 'adisaputra', 'avatar-default.jpg', 'Adi Saputra', 'adisaputra@gmail.com', '$2y$10$f5aGyCoDhx5IS55WCJYg2uNlHjXNrFqaATfjKMRYxPA5EhVxsmKKq', 'student', NULL, NULL, NULL, 1, '2021-07-23 13:53:23'),
(50, 'ahmadrifai', 'avatar-default.jpg', 'Ahmad Rifa&#039;i', 'ahmadrifai@gmail.com', '$2y$10$DrxcMgUY9zis1qDxn1ZyFuY2X5m4ncQhYBLnkK3qsVQWza4.ajpyO', 'student', NULL, NULL, NULL, 1, '2021-07-23 13:54:52'),
(51, 'ahmadtubagusriana', 'avatar-default.jpg', 'AHMAD TUBAGUS RIANA', 'ahmadtubagusriana@gmail.com', '$2y$10$HtHtqL2qoDGtDA2Bvd3fSee85bD5LVp2UxFsrZpeKD3.MSlDocgeq', 'student', NULL, NULL, NULL, 1, '2021-07-23 13:56:15');

--
-- Trigger `tb_user`
--
DELIMITER $$
CREATE TRIGGER `delete_user` AFTER DELETE ON `tb_user` FOR EACH ROW BEGIN
DELETE FROM tb_teacher WHERE tb_teacher.teacher_username = old.username;
DELETE FROM tb_student WHERE tb_student.student_username = old.username;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indeks untuk tabel `tb_announcement`
--
ALTER TABLE `tb_announcement`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indeks untuk tabel `tb_assignment`
--
ALTER TABLE `tb_assignment`
  ADD PRIMARY KEY (`assignment_id`),
  ADD UNIQUE KEY `assignment_code` (`assignment_code`);

--
-- Indeks untuk tabel `tb_assignment_result`
--
ALTER TABLE `tb_assignment_result`
  ADD PRIMARY KEY (`assignment_result_id`);

--
-- Indeks untuk tabel `tb_bank_question`
--
ALTER TABLE `tb_bank_question`
  ADD PRIMARY KEY (`bank_question_id`);

--
-- Indeks untuk tabel `tb_class`
--
ALTER TABLE `tb_class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indeks untuk tabel `tb_class_group`
--
ALTER TABLE `tb_class_group`
  ADD PRIMARY KEY (`class_group_id`),
  ADD UNIQUE KEY `class_group_code` (`class_group_code`),
  ADD KEY `majors_fk` (`major`),
  ADD KEY `class_fk` (`class`);

--
-- Indeks untuk tabel `tb_major`
--
ALTER TABLE `tb_major`
  ADD PRIMARY KEY (`major_id`);

--
-- Indeks untuk tabel `tb_material`
--
ALTER TABLE `tb_material`
  ADD PRIMARY KEY (`material_id`),
  ADD UNIQUE KEY `material_code` (`material_code`),
  ADD KEY `subject` (`subject`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `tb_question`
--
ALTER TABLE `tb_question`
  ADD PRIMARY KEY (`question_id`);

--
-- Indeks untuk tabel `tb_quiz`
--
ALTER TABLE `tb_quiz`
  ADD PRIMARY KEY (`quiz_id`),
  ADD UNIQUE KEY `quiz_code` (`quiz_code`);

--
-- Indeks untuk tabel `tb_quiz_result`
--
ALTER TABLE `tb_quiz_result`
  ADD PRIMARY KEY (`quiz_result_id`);

--
-- Indeks untuk tabel `tb_school_year`
--
ALTER TABLE `tb_school_year`
  ADD PRIMARY KEY (`school_year_id`);

--
-- Indeks untuk tabel `tb_student`
--
ALTER TABLE `tb_student`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `student_username` (`student_username`);

--
-- Indeks untuk tabel `tb_subject`
--
ALTER TABLE `tb_subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indeks untuk tabel `tb_teacher`
--
ALTER TABLE `tb_teacher`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_announcement`
--
ALTER TABLE `tb_announcement`
  MODIFY `announcement_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `tb_assignment`
--
ALTER TABLE `tb_assignment`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `tb_assignment_result`
--
ALTER TABLE `tb_assignment_result`
  MODIFY `assignment_result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `tb_bank_question`
--
ALTER TABLE `tb_bank_question`
  MODIFY `bank_question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tb_class`
--
ALTER TABLE `tb_class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tb_class_group`
--
ALTER TABLE `tb_class_group`
  MODIFY `class_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10150;

--
-- AUTO_INCREMENT untuk tabel `tb_major`
--
ALTER TABLE `tb_major`
  MODIFY `major_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tb_material`
--
ALTER TABLE `tb_material`
  MODIFY `material_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tb_question`
--
ALTER TABLE `tb_question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT untuk tabel `tb_quiz`
--
ALTER TABLE `tb_quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `tb_quiz_result`
--
ALTER TABLE `tb_quiz_result`
  MODIFY `quiz_result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `tb_school_year`
--
ALTER TABLE `tb_school_year`
  MODIFY `school_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tb_student`
--
ALTER TABLE `tb_student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `tb_subject`
--
ALTER TABLE `tb_subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `tb_teacher`
--
ALTER TABLE `tb_teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_class_group`
--
ALTER TABLE `tb_class_group`
  ADD CONSTRAINT `class_fk` FOREIGN KEY (`class`) REFERENCES `tb_class` (`class_id`),
  ADD CONSTRAINT `majors_fk` FOREIGN KEY (`major`) REFERENCES `tb_major` (`major_id`);

--
-- Ketidakleluasaan untuk tabel `tb_material`
--
ALTER TABLE `tb_material`
  ADD CONSTRAINT `tb_material_ibfk_1` FOREIGN KEY (`subject`) REFERENCES `tb_subject` (`subject_id`),
  ADD CONSTRAINT `tb_material_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `tb_user` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
