-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 13, 2024 at 03:07 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tambak`
--

-- --------------------------------------------------------

--
-- Table structure for table `alat`
--

CREATE TABLE `alat` (
  `id_alat` bigint UNSIGNED NOT NULL,
  `gambar` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_satuan` bigint NOT NULL,
  `satuan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `anco`
--

CREATE TABLE `anco` (
  `id_anco` bigint UNSIGNED NOT NULL,
  `kd_anco` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_cek` date NOT NULL,
  `waktu_cek` time NOT NULL,
  `pemberian_pakan` int NOT NULL,
  `jamPemberian_pakan` time NOT NULL,
  `kondisi_pakan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kondisi_udang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_fase_tambak` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_alat`
--

CREATE TABLE `detail_alat` (
  `id_detail_alat` bigint UNSIGNED NOT NULL,
  `kd_detail_alat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_alat` bigint UNSIGNED NOT NULL,
  `id_gudang` bigint UNSIGNED NOT NULL,
  `stok_alat` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_obat`
--

CREATE TABLE `detail_obat` (
  `id_detail_obat` bigint UNSIGNED NOT NULL,
  `kd_detail_obat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_obat` bigint UNSIGNED NOT NULL,
  `id_gudang` bigint UNSIGNED NOT NULL,
  `stok_obat` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_pakan`
--

CREATE TABLE `detail_pakan` (
  `id_detail_pakan` bigint UNSIGNED NOT NULL,
  `kd_detail_pakan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pakan` bigint UNSIGNED NOT NULL,
  `id_gudang` bigint UNSIGNED NOT NULL,
  `stok_pakan` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_user`
--

CREATE TABLE `detail_user` (
  `id_detail_user` bigint UNSIGNED NOT NULL,
  `kd_detail_user` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_gudang` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fase_tambak`
--

CREATE TABLE `fase_tambak` (
  `id_fase_tambak` bigint UNSIGNED NOT NULL,
  `kd_fase_tambak` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_panen` date NOT NULL,
  `jumlah_tebar` int NOT NULL,
  `densitas` int NOT NULL,
  `id_kolam` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `id_gudang` bigint UNSIGNED NOT NULL,
  `gambar` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `panjang` bigint NOT NULL,
  `lebar` bigint NOT NULL,
  `luas` bigint NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kematian_udang`
--

CREATE TABLE `kematian_udang` (
  `id_kematian_udang` bigint UNSIGNED NOT NULL,
  `kd_kematian_udang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size_udang` int NOT NULL,
  `berat_udang` int NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_fase_tambak` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kolam`
--

CREATE TABLE `kolam` (
  `id_kolam` bigint UNSIGNED NOT NULL,
  `kd_kolam` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_kolam` enum('kotak','bundar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `panjang_kolam` int NOT NULL,
  `lebar_kolam` int NOT NULL,
  `luas_kolam` int NOT NULL,
  `kedalaman` int NOT NULL,
  `id_tambak` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kualitas_air`
--

CREATE TABLE `kualitas_air` (
  `kualitas_air` bigint UNSIGNED NOT NULL,
  `kd_kualitas_air` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_cek` date NOT NULL,
  `waktu_cek` time NOT NULL,
  `pH` int NOT NULL,
  `salinitas` int NOT NULL,
  `DO` int NOT NULL,
  `suhu` int NOT NULL,
  `kejernihan_air` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warna_air` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_fase_tambak` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_08_11_013319_create_gudang_table', 1),
(6, '2024_08_11_014153_create_alat_table', 1),
(7, '2024_08_11_014928_create_obat_table', 1),
(8, '2024_08_11_015512_create_pakan_table', 1),
(9, '2024_08_11_015938_create_role_table', 1),
(10, '2024_08_12_082137_create_user_table', 2),
(11, '2024_08_12_084428_create_detail_user_table', 3),
(12, '2024_08_12_085526_create_detail_pakan_table', 4),
(13, '2024_08_12_090030_create_detail_alat_table', 5),
(14, '2024_08_12_095248_create_detail_obat_table', 6),
(15, '2024_08_12_100022_create_transaksi_pakan_table', 6),
(16, '2024_08_12_101022_create_transaksi_alat_table', 6),
(17, '2024_08_12_101542_create_transaksi_obat_table', 6),
(18, '2024_08_13_073822_create_tambak_table', 7),
(19, '2024_08_13_080510_create_kolam_table', 8),
(20, '2024_08_13_081059_create_fase_tambak_table', 9),
(21, '2024_08_13_074753_create_anco_table', 10),
(22, '2024_08_13_135630_create_tambak_table', 11),
(23, '2024_08_13_135631_create_user_tambak_table', 12),
(24, '2024_08_13_140127_create_kolam_table', 12),
(25, '2024_08_13_140249_create_fase_tambak_table', 12),
(26, '2024_08_13_140353_create_anco_table', 12),
(27, '2024_08_13_140446_create_kualitas_air_table', 12),
(28, '2024_08_13_140526_create_penanganan_table', 13),
(29, '2024_08_13_140630_create_sampling_table', 14),
(30, '2024_08_13_140729_create_pakan_harian_table', 14),
(31, '2024_08_13_140831_create_kematian_udang_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` bigint UNSIGNED NOT NULL,
  `gambar` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_satuan` bigint NOT NULL,
  `satuan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pakan`
--

CREATE TABLE `pakan` (
  `id_pakan` bigint UNSIGNED NOT NULL,
  `gambar` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_satuan` bigint NOT NULL,
  `satuan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pakan_harian`
--

CREATE TABLE `pakan_harian` (
  `id_pakan_harian` bigint UNSIGNED NOT NULL,
  `kd_pakan_harian` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_cek` date NOT NULL,
  `waktu_cek` time NOT NULL,
  `DOC` int NOT NULL,
  `berat_udang` int NOT NULL,
  `total_pakan` int NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_fase_tambak` bigint UNSIGNED NOT NULL,
  `id_detail_pakan` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penanganan`
--

CREATE TABLE `penanganan` (
  `id_penanganan` bigint UNSIGNED NOT NULL,
  `kd_penanganan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_cek` date NOT NULL,
  `waktu_cek` time NOT NULL,
  `pemberian_mineral` int NOT NULL,
  `pemberian_vitamin` int NOT NULL,
  `pemberian_obat` int NOT NULL,
  `penambahan_air` int NOT NULL,
  `pengurangan_air` int NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_fase_tambak` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` bigint UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sampling`
--

CREATE TABLE `sampling` (
  `id_sampling` bigint UNSIGNED NOT NULL,
  `kd_sampling` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_cek` date NOT NULL,
  `waktu_cek` time NOT NULL,
  `DOC` int NOT NULL,
  `berat_udang` int NOT NULL,
  `size_udang` int NOT NULL,
  `interval_hari` int NOT NULL,
  `harga_udang` bigint NOT NULL,
  `input_fr` int NOT NULL,
  `total_pakan` int NOT NULL,
  `ADG_udang` int NOT NULL,
  `biomassa` int NOT NULL,
  `populasi_ekor` int NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_fase_tambak` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tambak`
--

CREATE TABLE `tambak` (
  `id_tambak` bigint UNSIGNED NOT NULL,
  `gambar` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_tambak` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `luas_lahan` int NOT NULL,
  `luas_tambak` int NOT NULL,
  `lokasi_tambak` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_alat`
--

CREATE TABLE `transaksi_alat` (
  `id_transaksi_alat` bigint UNSIGNED NOT NULL,
  `kd_transaksi_alat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_transaksi` enum('masuk','keluar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` bigint NOT NULL,
  `id_detail_alat` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_obat`
--

CREATE TABLE `transaksi_obat` (
  `id_transaksi_obat` bigint UNSIGNED NOT NULL,
  `kd_transaksi_obat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_transaksi` enum('masuk','keluar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` bigint NOT NULL,
  `id_detail_obat` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_pakan`
--

CREATE TABLE `transaksi_pakan` (
  `id_transaksi_pakan` bigint UNSIGNED NOT NULL,
  `kd_transaksi_pakan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_transaksi` enum('masuk','keluar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` bigint NOT NULL,
  `id_detail_pakan` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` bigint UNSIGNED NOT NULL,
  `id_role` bigint UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gaji_pokok` bigint NOT NULL,
  `komisi` bigint NOT NULL,
  `tunjangan` bigint NOT NULL,
  `potongan_gaji` bigint NOT NULL,
  `posisi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_tambak`
--

CREATE TABLE `user_tambak` (
  `id_user_tambak` bigint UNSIGNED NOT NULL,
  `kd_user_tambak` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_tambak` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`id_alat`),
  ADD UNIQUE KEY `alat_nama_unique` (`nama`);

--
-- Indexes for table `anco`
--
ALTER TABLE `anco`
  ADD PRIMARY KEY (`id_anco`),
  ADD UNIQUE KEY `anco_kd_anco_unique` (`kd_anco`),
  ADD KEY `anco_id_fase_tambak_index` (`id_fase_tambak`);

--
-- Indexes for table `detail_alat`
--
ALTER TABLE `detail_alat`
  ADD PRIMARY KEY (`id_detail_alat`),
  ADD UNIQUE KEY `detail_alat_kd_detail_alat_unique` (`kd_detail_alat`),
  ADD KEY `detail_alat_id_alat_index` (`id_alat`),
  ADD KEY `detail_alat_id_gudang_index` (`id_gudang`);

--
-- Indexes for table `detail_obat`
--
ALTER TABLE `detail_obat`
  ADD PRIMARY KEY (`id_detail_obat`),
  ADD UNIQUE KEY `detail_obat_kd_detail_obat_unique` (`kd_detail_obat`),
  ADD KEY `detail_obat_id_obat_index` (`id_obat`),
  ADD KEY `detail_obat_id_gudang_index` (`id_gudang`);

--
-- Indexes for table `detail_pakan`
--
ALTER TABLE `detail_pakan`
  ADD PRIMARY KEY (`id_detail_pakan`),
  ADD UNIQUE KEY `detail_pakan_kd_detail_pakan_unique` (`kd_detail_pakan`),
  ADD KEY `detail_pakan_id_pakan_index` (`id_pakan`),
  ADD KEY `detail_pakan_id_gudang_index` (`id_gudang`);

--
-- Indexes for table `detail_user`
--
ALTER TABLE `detail_user`
  ADD PRIMARY KEY (`id_detail_user`),
  ADD UNIQUE KEY `detail_user_kd_detail_user_unique` (`kd_detail_user`),
  ADD KEY `detail_user_id_gudang_index` (`id_gudang`),
  ADD KEY `detail_user_id_user_index` (`id_user`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fase_tambak`
--
ALTER TABLE `fase_tambak`
  ADD PRIMARY KEY (`id_fase_tambak`),
  ADD UNIQUE KEY `fase_tambak_kd_fase_tambak_unique` (`kd_fase_tambak`),
  ADD KEY `fase_tambak_id_kolam_index` (`id_kolam`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id_gudang`),
  ADD UNIQUE KEY `gudang_nama_unique` (`nama`);

--
-- Indexes for table `kematian_udang`
--
ALTER TABLE `kematian_udang`
  ADD PRIMARY KEY (`id_kematian_udang`),
  ADD UNIQUE KEY `kematian_udang_kd_kematian_udang_unique` (`kd_kematian_udang`),
  ADD KEY `kematian_udang_id_fase_tambak_index` (`id_fase_tambak`);

--
-- Indexes for table `kolam`
--
ALTER TABLE `kolam`
  ADD PRIMARY KEY (`id_kolam`),
  ADD UNIQUE KEY `kolam_kd_kolam_unique` (`kd_kolam`),
  ADD KEY `kolam_id_tambak_index` (`id_tambak`);

--
-- Indexes for table `kualitas_air`
--
ALTER TABLE `kualitas_air`
  ADD PRIMARY KEY (`kualitas_air`),
  ADD UNIQUE KEY `kualitas_air_kd_kualitas_air_unique` (`kd_kualitas_air`),
  ADD KEY `kualitas_air_id_fase_tambak_index` (`id_fase_tambak`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`),
  ADD UNIQUE KEY `obat_nama_unique` (`nama`);

--
-- Indexes for table `pakan`
--
ALTER TABLE `pakan`
  ADD PRIMARY KEY (`id_pakan`),
  ADD UNIQUE KEY `pakan_nama_unique` (`nama`);

--
-- Indexes for table `pakan_harian`
--
ALTER TABLE `pakan_harian`
  ADD PRIMARY KEY (`id_pakan_harian`),
  ADD UNIQUE KEY `pakan_harian_kd_pakan_harian_unique` (`kd_pakan_harian`),
  ADD KEY `pakan_harian_id_fase_tambak_index` (`id_fase_tambak`),
  ADD KEY `pakan_harian_id_detail_pakan_index` (`id_detail_pakan`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `penanganan`
--
ALTER TABLE `penanganan`
  ADD PRIMARY KEY (`id_penanganan`),
  ADD UNIQUE KEY `penanganan_kd_penanganan_unique` (`kd_penanganan`),
  ADD KEY `penanganan_id_fase_tambak_index` (`id_fase_tambak`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`),
  ADD UNIQUE KEY `role_nama_unique` (`nama`);

--
-- Indexes for table `sampling`
--
ALTER TABLE `sampling`
  ADD PRIMARY KEY (`id_sampling`),
  ADD UNIQUE KEY `sampling_kd_sampling_unique` (`kd_sampling`),
  ADD KEY `sampling_id_fase_tambak_index` (`id_fase_tambak`);

--
-- Indexes for table `tambak`
--
ALTER TABLE `tambak`
  ADD PRIMARY KEY (`id_tambak`),
  ADD UNIQUE KEY `tambak_nama_tambak_unique` (`nama_tambak`);

--
-- Indexes for table `transaksi_alat`
--
ALTER TABLE `transaksi_alat`
  ADD PRIMARY KEY (`id_transaksi_alat`),
  ADD UNIQUE KEY `transaksi_alat_kd_transaksi_alat_unique` (`kd_transaksi_alat`),
  ADD KEY `transaksi_alat_id_detail_alat_index` (`id_detail_alat`);

--
-- Indexes for table `transaksi_obat`
--
ALTER TABLE `transaksi_obat`
  ADD PRIMARY KEY (`id_transaksi_obat`),
  ADD UNIQUE KEY `transaksi_obat_kd_transaksi_obat_unique` (`kd_transaksi_obat`),
  ADD KEY `transaksi_obat_id_detail_obat_index` (`id_detail_obat`);

--
-- Indexes for table `transaksi_pakan`
--
ALTER TABLE `transaksi_pakan`
  ADD PRIMARY KEY (`id_transaksi_pakan`),
  ADD UNIQUE KEY `transaksi_pakan_kd_transaksi_pakan_unique` (`kd_transaksi_pakan`),
  ADD KEY `transaksi_pakan_id_detail_pakan_index` (`id_detail_pakan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `user_nama_unique` (`nama`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `user_id_role_index` (`id_role`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_tambak`
--
ALTER TABLE `user_tambak`
  ADD PRIMARY KEY (`id_user_tambak`),
  ADD UNIQUE KEY `user_tambak_kd_user_tambak_unique` (`kd_user_tambak`),
  ADD KEY `user_tambak_id_user_index` (`id_user`),
  ADD KEY `user_tambak_id_tambak_index` (`id_tambak`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alat`
--
ALTER TABLE `alat`
  MODIFY `id_alat` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `anco`
--
ALTER TABLE `anco`
  MODIFY `id_anco` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_alat`
--
ALTER TABLE `detail_alat`
  MODIFY `id_detail_alat` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_obat`
--
ALTER TABLE `detail_obat`
  MODIFY `id_detail_obat` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_pakan`
--
ALTER TABLE `detail_pakan`
  MODIFY `id_detail_pakan` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_user`
--
ALTER TABLE `detail_user`
  MODIFY `id_detail_user` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fase_tambak`
--
ALTER TABLE `fase_tambak`
  MODIFY `id_fase_tambak` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id_gudang` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kematian_udang`
--
ALTER TABLE `kematian_udang`
  MODIFY `id_kematian_udang` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kolam`
--
ALTER TABLE `kolam`
  MODIFY `id_kolam` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kualitas_air`
--
ALTER TABLE `kualitas_air`
  MODIFY `kualitas_air` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pakan`
--
ALTER TABLE `pakan`
  MODIFY `id_pakan` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pakan_harian`
--
ALTER TABLE `pakan_harian`
  MODIFY `id_pakan_harian` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penanganan`
--
ALTER TABLE `penanganan`
  MODIFY `id_penanganan` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sampling`
--
ALTER TABLE `sampling`
  MODIFY `id_sampling` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tambak`
--
ALTER TABLE `tambak`
  MODIFY `id_tambak` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_alat`
--
ALTER TABLE `transaksi_alat`
  MODIFY `id_transaksi_alat` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_obat`
--
ALTER TABLE `transaksi_obat`
  MODIFY `id_transaksi_obat` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_pakan`
--
ALTER TABLE `transaksi_pakan`
  MODIFY `id_transaksi_pakan` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_tambak`
--
ALTER TABLE `user_tambak`
  MODIFY `id_user_tambak` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anco`
--
ALTER TABLE `anco`
  ADD CONSTRAINT `anco_id_fase_tambak_foreign` FOREIGN KEY (`id_fase_tambak`) REFERENCES `fase_tambak` (`id_fase_tambak`);

--
-- Constraints for table `detail_alat`
--
ALTER TABLE `detail_alat`
  ADD CONSTRAINT `detail_alat_id_alat_foreign` FOREIGN KEY (`id_alat`) REFERENCES `alat` (`id_alat`),
  ADD CONSTRAINT `detail_alat_id_gudang_foreign` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id_gudang`);

--
-- Constraints for table `detail_obat`
--
ALTER TABLE `detail_obat`
  ADD CONSTRAINT `detail_obat_id_gudang_foreign` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id_gudang`),
  ADD CONSTRAINT `detail_obat_id_obat_foreign` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`);

--
-- Constraints for table `detail_pakan`
--
ALTER TABLE `detail_pakan`
  ADD CONSTRAINT `detail_pakan_id_gudang_foreign` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id_gudang`),
  ADD CONSTRAINT `detail_pakan_id_pakan_foreign` FOREIGN KEY (`id_pakan`) REFERENCES `pakan` (`id_pakan`);

--
-- Constraints for table `detail_user`
--
ALTER TABLE `detail_user`
  ADD CONSTRAINT `detail_user_id_gudang_foreign` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id_gudang`),
  ADD CONSTRAINT `detail_user_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `fase_tambak`
--
ALTER TABLE `fase_tambak`
  ADD CONSTRAINT `fase_tambak_id_kolam_foreign` FOREIGN KEY (`id_kolam`) REFERENCES `kolam` (`id_kolam`);

--
-- Constraints for table `kematian_udang`
--
ALTER TABLE `kematian_udang`
  ADD CONSTRAINT `kematian_udang_id_fase_tambak_foreign` FOREIGN KEY (`id_fase_tambak`) REFERENCES `fase_tambak` (`id_fase_tambak`);

--
-- Constraints for table `kolam`
--
ALTER TABLE `kolam`
  ADD CONSTRAINT `kolam_id_tambak_foreign` FOREIGN KEY (`id_tambak`) REFERENCES `tambak` (`id_tambak`);

--
-- Constraints for table `kualitas_air`
--
ALTER TABLE `kualitas_air`
  ADD CONSTRAINT `kualitas_air_id_fase_tambak_foreign` FOREIGN KEY (`id_fase_tambak`) REFERENCES `fase_tambak` (`id_fase_tambak`);

--
-- Constraints for table `pakan_harian`
--
ALTER TABLE `pakan_harian`
  ADD CONSTRAINT `pakan_harian_id_detail_pakan_foreign` FOREIGN KEY (`id_detail_pakan`) REFERENCES `detail_pakan` (`id_detail_pakan`),
  ADD CONSTRAINT `pakan_harian_id_fase_tambak_foreign` FOREIGN KEY (`id_fase_tambak`) REFERENCES `fase_tambak` (`id_fase_tambak`);

--
-- Constraints for table `penanganan`
--
ALTER TABLE `penanganan`
  ADD CONSTRAINT `penanganan_id_fase_tambak_foreign` FOREIGN KEY (`id_fase_tambak`) REFERENCES `fase_tambak` (`id_fase_tambak`);

--
-- Constraints for table `sampling`
--
ALTER TABLE `sampling`
  ADD CONSTRAINT `sampling_id_fase_tambak_foreign` FOREIGN KEY (`id_fase_tambak`) REFERENCES `fase_tambak` (`id_fase_tambak`);

--
-- Constraints for table `transaksi_alat`
--
ALTER TABLE `transaksi_alat`
  ADD CONSTRAINT `transaksi_alat_id_detail_alat_foreign` FOREIGN KEY (`id_detail_alat`) REFERENCES `detail_alat` (`id_detail_alat`);

--
-- Constraints for table `transaksi_obat`
--
ALTER TABLE `transaksi_obat`
  ADD CONSTRAINT `transaksi_obat_id_detail_obat_foreign` FOREIGN KEY (`id_detail_obat`) REFERENCES `detail_obat` (`id_detail_obat`);

--
-- Constraints for table `transaksi_pakan`
--
ALTER TABLE `transaksi_pakan`
  ADD CONSTRAINT `transaksi_pakan_id_detail_pakan_foreign` FOREIGN KEY (`id_detail_pakan`) REFERENCES `detail_pakan` (`id_detail_pakan`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_id_role_foreign` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`);

--
-- Constraints for table `user_tambak`
--
ALTER TABLE `user_tambak`
  ADD CONSTRAINT `user_tambak_id_tambak_foreign` FOREIGN KEY (`id_tambak`) REFERENCES `tambak` (`id_tambak`),
  ADD CONSTRAINT `user_tambak_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
