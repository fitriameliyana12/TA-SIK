-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Jan 2025 pada 06.07
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eklinik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `antrian`
--

CREATE TABLE `antrian` (
  `id_antrian` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `keluhan` text NOT NULL,
  `jam_terapi` time NOT NULL,
  `tanggal_terapi` date NOT NULL,
  `status` enum('disetujui','ditolak','tertunda') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `antrian`
--

INSERT INTO `antrian` (`id_antrian`, `id_pasien`, `id`, `keluhan`, `jam_terapi`, `tanggal_terapi`, `status`) VALUES
(3, 3, 1, 'sakit kaki', '09:00:00', '2025-01-17', 'disetujui'),
(4, 5, 1, 'sakit punggung nyeri', '08:00:00', '2025-01-25', 'disetujui'),
(5, 3, 3, 'rgfrs', '12:00:00', '2025-01-18', 'tertunda'),
(6, 7, 1, 'sakit', '10:00:00', '2025-01-17', 'tertunda'),
(7, 3, 1, 'sakit hati', '09:00:00', '2025-01-18', 'tertunda');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `fisioterapis`
--

CREATE TABLE `fisioterapis` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `kehadiran` enum('Hadir','Izin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `fisioterapis`
--

INSERT INTO `fisioterapis` (`id`, `id_user`, `nama`, `tanggal_lahir`, `alamat`, `jenis_kelamin`, `kehadiran`) VALUES
(1, 10, 'Raras Laksmi', '1999-06-16', 'Jombang', 'Perempuan', 'Hadir'),
(3, 15, 'Nita Anita', '2024-12-29', 'gsdz', 'Perempuan', 'Hadir');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(17, '2014_10_12_000000_create_users_table', 1),
(18, '2014_10_12_100000_create_password_resets_table', 1),
(19, '2019_08_19_000000_create_failed_jobs_table', 1),
(20, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(21, '2021_10_06_125210_create_dokters_table', 1),
(22, '2021_10_06_125401_create_obats_table', 1),
(23, '2021_10_06_164841_create_perjanjians_table', 1),
(24, '2021_10_07_034502_create_pasiens_table', 1),
(25, '2024_11_03_170110_create_fisioterapis_table', 2),
(26, '2024_11_15_165531_rename_pasiens_table_to_pasien', 3),
(27, '2024_11_18_153907_rename_users_to_user', 4),
(28, '2024_12_20_062944_update_user_table', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `no_rekam_medis` varchar(50) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `id_user`, `no_rekam_medis`, `nama`, `tanggal_lahir`, `jenis_kelamin`, `alamat`) VALUES
(3, 11, 'AB1234', 'tina mutia', '2003-05-13', 'Perempuan', 'Malang'),
(4, 15, 'A154B', 'Nita Anita', '1999-06-03', 'Perempuan', 'Kediri'),
(5, 12, 'A134BD', 'AndiNew', '1994-10-12', 'Laki-Laki', 'Surabaya'),
(6, 16, 'A154BX', 'Lia Meliana', '1994-11-17', 'Perempuan', 'Surabaya'),
(7, 18, 'A1253', 'LIAYA', '2025-01-01', 'Perempuan', 'malang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekam_medis`
--

CREATE TABLE `rekam_medis` (
  `id_rekam_medis` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_antrian` int(11) NOT NULL,
  `diagnosa` text NOT NULL,
  `penanganan` text NOT NULL,
  `pemeriksaan_umum` text NOT NULL,
  `pemeriksaan_fisioterapis` text NOT NULL,
  `tujuan_program` text NOT NULL,
  `intervensi` text NOT NULL,
  `evaluasi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rekam_medis`
--

INSERT INTO `rekam_medis` (`id_rekam_medis`, `id_pasien`, `id`, `id_user`, `id_antrian`, `diagnosa`, `penanganan`, `pemeriksaan_umum`, `pemeriksaan_fisioterapis`, `tujuan_program`, `intervensi`, `evaluasi`) VALUES
(1, 3, 1, 11, 3, 'panas', 'dikompres', 'baik', 'perlu tindakan', 'biar sembuh', 'mengurangi rasa sakit dengan dikompres air hangat', 'dikompres air hangat terus '),
(2, 3, 1, 11, 7, 'sakit hati', 'di ceksuhu', 'noncfl', 'oh iya', 'biar sembuh', 'oke', 'jangan pikiran');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `role` enum('admin','fisioterapis','pasien') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `telepon`, `role`, `foto`, `created_at`, `updated_at`) VALUES
(9, 'doni', '$2y$10$iYPyyfDVeJROTFoAqGEiseD0xGZpA97XRjdrF75TcuMHXDiArxjse', '6287333444222', 'admin', '', '2024-12-21 02:24:27', '2024-12-21 13:27:19'),
(10, 'raras', '$2y$10$MfrmU7DeF.qC1qu1rGzC9OBQrchOJytZjLelXRqYnu7EQxtCcAXoC', '6288999000111', 'fisioterapis', '1736700836.PNG', '2024-12-25 02:00:32', '2025-01-12 09:53:56'),
(11, 'tina', '$2y$10$cE5o43Fjw5ltJMX2OeU4geY.62JVO3G/LVoO2lVa441EReNrTQmmy', '6285333222444', 'pasien', '1736700590.png', '2024-12-25 07:02:30', '2025-01-12 09:49:52'),
(12, 'andi', '$2y$10$LlMl.8HS8dtN5bM91ddCWObwH6CSwV3AWHNK9o4m/jJXvMXSKIUnG', '6285333111222', 'pasien', NULL, '2025-01-03 18:14:11', '2025-01-03 18:14:11'),
(15, 'nita', '$2y$10$AdULMGR8P4h/5jbfqq7EueBI8gex5VORB1pltDCGAIiunfGblMapW', '6285333444888', 'fisioterapis', NULL, '2025-01-03 18:32:53', '2025-01-03 20:30:02'),
(16, 'Lia', '$2y$10$TAQhwYVBpjdIi9nSK3wNB.uXbZbZWru2HVCcZuLTrOUeKhwuvQZ5y', '6288999000222', 'pasien', NULL, '2025-01-03 21:29:28', '2025-01-05 04:34:04'),
(17, 'dina', '$2y$10$gaE8VYBMHVnrtRrGOtLPeeUZTWcvYvgIQjaukDuv0L7dhN.dQVz9a', '6285444777111', 'pasien', NULL, '2025-01-05 08:25:12', '2025-01-05 08:25:12'),
(18, 'liaaaaaaaa', '$2y$10$OdV3O.bIM0vb.EFhy08kGONNW4nGIOPyzzoI4k/qOUZZvzhPFmyfu', '6285338384567', 'admin', NULL, '2025-01-08 18:44:44', '2025-01-08 18:44:44');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`id_antrian`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `fk_id_fisioterapis` (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `fisioterapis`
--
ALTER TABLE `fisioterapis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_fisioterapis_new` (`id_user`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD KEY `fk_id_user` (`id_user`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD PRIMARY KEY (`id_rekam_medis`),
  ADD KEY `fk_id_pasien_rm` (`id_pasien`),
  ADD KEY `fk_id_antrian_rm` (`id_antrian`),
  ADD KEY `fk_id_fisioterapis_rm` (`id`),
  ADD KEY `fk_id_id_user_rm` (`id_user`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `antrian`
--
ALTER TABLE `antrian`
  MODIFY `id_antrian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `fisioterapis`
--
ALTER TABLE `fisioterapis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  MODIFY `id_rekam_medis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `antrian`
--
ALTER TABLE `antrian`
  ADD CONSTRAINT `fk_id_fisioterapis` FOREIGN KEY (`id`) REFERENCES `fisioterapis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `fisioterapis`
--
ALTER TABLE `fisioterapis`
  ADD CONSTRAINT `fk_id_fisioterapis_new` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD CONSTRAINT `fk_id_antrian_rm` FOREIGN KEY (`id_antrian`) REFERENCES `antrian` (`id_antrian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_fisioterapis_rm` FOREIGN KEY (`id`) REFERENCES `fisioterapis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_id_user_rm` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_pasien_rm` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
