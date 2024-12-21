-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Des 2024 pada 19.32
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_klinik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_pasien`
--

CREATE TABLE `daftar_pasien` (
  `id_pasien` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `nama_pasien` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `umur` int(11) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tanggal_daftar` date NOT NULL DEFAULT curdate(),
  `no_antrian` int(11) NOT NULL,
  `id_data` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_pasien`
--

INSERT INTO `daftar_pasien` (`id_pasien`, `nik`, `nama_pasien`, `tanggal_lahir`, `umur`, `alamat`, `tanggal_daftar`, `no_antrian`, `id_data`) VALUES
(8, '1334', 'yoon', '2000-02-12', 24, 'Subang', '2024-12-20', 1, NULL),
(12, '2321', 'sc', '2000-02-13', 24, 'subang', '2024-12-20', 2, NULL),
(14, '6731', 'dino', '2000-12-07', 24, 'ckp', '2024-12-20', 3, NULL),
(15, '5542', 'dey', '2003-08-12', 21, 'subang', '2024-12-20', 4, NULL),
(17, '2313', 'dk', '2000-03-12', 24, 'seoul', '2024-12-20', 5, NULL),
(18, '1314', 'deyo', '2000-02-15', 24, 'subang', '2024-12-21', 6, NULL),
(19, '4313', 'yoon jh', '2005-05-06', 19, 'seoul', '2024-12-21', 7, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pasien`
--

CREATE TABLE `data_pasien` (
  `id_data` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `nama_pasien` varchar(100) NOT NULL,
  `berat_badan` int(11) NOT NULL,
  `tinggi_badan` int(11) NOT NULL,
  `tekanan_darah` int(11) NOT NULL,
  `keluhan` varchar(100) NOT NULL,
  `diagnosis` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_pasien`
--

INSERT INTO `data_pasien` (`id_data`, `nik`, `nama_pasien`, `berat_badan`, `tinggi_badan`, `tekanan_darah`, `keluhan`, `diagnosis`) VALUES
(5, '1334', 'yoon', 64, 178, 100, 'sakit tangan', 'pegal'),
(8, '6731', '', 67, 176, 100, 'kit gigi', 'sakit gigi'),
(12, '1314', 'deyo', 53, 165, 100, 'pusing', 'migrain'),
(15, '2321', 'sc', 65, 179, 100, 'sakit perut', 'lapar');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekam_medis`
--

CREATE TABLE `rekam_medis` (
  `id_rekam` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `poli` text NOT NULL,
  `nama_dokter` text NOT NULL,
  `diagnosis` text NOT NULL,
  `tanggal_rekam` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rekam_medis`
--

INSERT INTO `rekam_medis` (`id_rekam`, `id_pasien`, `poli`, `nama_dokter`, `diagnosis`, `tanggal_rekam`) VALUES
(2, 15, 'Umum', 'Jeonghan', 'kangen', '2024-12-18'),
(3, 12, 'Umum', 'yoon', 'pusing', '2024-12-21'),
(4, 15, 'Umum', 'sc', 'kit kepala', '2024-12-21'),
(5, 19, 'Gigi', 'sc', 'kit gigi', '2024-12-21');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `daftar_pasien`
--
ALTER TABLE `daftar_pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD UNIQUE KEY `nik` (`nik`,`tanggal_daftar`),
  ADD UNIQUE KEY `no_antrian` (`no_antrian`),
  ADD KEY `id_data` (`id_data`);

--
-- Indeks untuk tabel `data_pasien`
--
ALTER TABLE `data_pasien`
  ADD PRIMARY KEY (`id_data`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indeks untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD PRIMARY KEY (`id_rekam`),
  ADD KEY `fk_id_pasien` (`id_pasien`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `daftar_pasien`
--
ALTER TABLE `daftar_pasien`
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `data_pasien`
--
ALTER TABLE `data_pasien`
  MODIFY `id_data` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  MODIFY `id_rekam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `daftar_pasien`
--
ALTER TABLE `daftar_pasien`
  ADD CONSTRAINT `daftar_pasien_ibfk_1` FOREIGN KEY (`id_data`) REFERENCES `data_pasien` (`id_data`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD CONSTRAINT `fk_id_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `daftar_pasien` (`id_pasien`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
