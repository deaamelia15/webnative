-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Des 2024 pada 05.07
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
  `tanggal_lahir` date DEFAULT NULL,
  `umur` int(11) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `tanggal_daftar` date DEFAULT curdate(),
  `no_antrian` int(11) NOT NULL,
  `id_data` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_pasien`
--

INSERT INTO `daftar_pasien` (`id_pasien`, `nik`, `nama_pasien`, `tanggal_lahir`, `umur`, `alamat`, `tanggal_daftar`, `no_antrian`, `id_data`) VALUES
(7, '34569', 'Ulfiatin', '2322-12-12', 26, 'Miadong', '2024-12-17', 0, NULL),
(8, '1313', 'jkk', '2333-12-14', 20, 'Daegu', '2024-12-17', 0, NULL),
(10, '1315', 'Dea Amelia', '2000-04-15', 19, 'Daegu', '2024-12-17', 0, NULL),
(11, '2502', 'Desi Kurniasih', '2000-02-01', 24, 'ciampel', '2024-12-17', 0, NULL),
(12, '123456', 'Raden Firda', '2003-05-14', 21, 'cikampek', '2024-12-17', 0, NULL),
(13, '12345', 'jk', '1997-12-14', 26, 'Miadong, Seoul', '2024-12-17', 0, NULL),
(14, '1313', 'carat', '2005-04-15', 19, 'Seoul', '2024-12-17', 0, 1),
(15, '43785', 'Dea Amelia', '2005-04-15', 19, 'Ciasem', '2024-12-18', 0, NULL),
(16, '2502', 'carat', '2000-03-15', 24, 'Miadong', '2024-12-18', 0, 2),
(17, '1313', 'carat', '2000-04-15', 24, 'Daegu', '2024-12-18', 0, 1),
(18, '1317', 'carat', '2000-04-15', 24, 'Mapo', '2024-12-18', 0, NULL),
(19, '12345', 'jk', '1997-03-12', 27, 'Busan', '2024-12-18', 0, NULL),
(20, '1313', 'Dea Amelia', '2003-04-15', 21, 'Daegu', '2024-12-18', 0, 1),
(21, '1317', 'Dea Amelia', '2000-04-14', 24, 'Ciasem', '2024-12-18', 0, NULL),
(22, '1243', 'Ulfiatin', '2004-03-12', 20, 'Klari', '2024-12-18', 0, NULL),
(23, '9843', 'Raden Firda', '2000-12-09', 24, 'Cikampek', '2024-12-18', 0, NULL),
(24, '6543', 'fai', '2000-05-06', 24, 'karawang', '2024-12-18', 0, NULL),
(25, '5435', 'jk', '1999-12-23', 25, 'Miadong', '2024-12-18', 0, NULL),
(26, '1254', 'Dea Amelia', '2000-04-17', 24, 'Miadong', '2024-12-18', 0, NULL),
(27, '433333', 'Fai', '2024-12-19', 19, 'Karawang', '2024-12-19', 0, NULL),
(28, '1244', 'dea', '2024-02-04', 14, 'ciasem', '2024-12-19', 0, NULL),
(29, '6365', 'jk', '2000-12-13', 24, 'Daegu', '2024-12-19', 0, NULL),
(30, '8732', 'Dea Amelia', '2000-04-15', 24, 'Subang', '2024-12-19', 0, NULL),
(31, '2502', 'jk', '2000-04-15', 24, 'Miadong', '2024-12-19', 1, 2),
(32, '2502', 'jk', '1998-10-19', 26, 'Miadong', '2024-12-19', 2, 2),
(33, '1313', 'jk', '0098-08-09', 26, 'Ciasem', '2024-12-19', 3, 1),
(34, '1313', 'Ulfiatin', '0233-12-13', 15, 'Subang', '2024-12-19', 4, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pasien`
--

CREATE TABLE `data_pasien` (
  `id_data` int(11) NOT NULL,
  `nik` int(11) NOT NULL,
  `nama_pasien` varchar(50) NOT NULL,
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
(1, 1313, 'jkk', 67, 185, 100, 'kangen army', 'kangen beratt'),
(2, 2502, 'Desi Kurniasih', 47, 152, 80, 'kit perut', 'sakit perut'),
(3, 123456, 'Raden Firda', 56, 153, 100, 'kit gigi', 'sakit gigi'),
(4, 1313, 'jkk', 56, 176, 100, 'mau konser', 'kangen sebong');

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
(2, 15, 'Umum', 'Jeonghan', 'kangen', '2024-12-18');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `daftar_pasien`
--
ALTER TABLE `daftar_pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD KEY `fk_id_data` (`id_data`);

--
-- Indeks untuk tabel `data_pasien`
--
ALTER TABLE `data_pasien`
  ADD PRIMARY KEY (`id_data`);

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
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `data_pasien`
--
ALTER TABLE `data_pasien`
  MODIFY `id_data` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  MODIFY `id_rekam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `daftar_pasien`
--
ALTER TABLE `daftar_pasien`
  ADD CONSTRAINT `daftar_pasien_ibfk_1` FOREIGN KEY (`id_data`) REFERENCES `data_pasien` (`id_data`),
  ADD CONSTRAINT `fk_id_data` FOREIGN KEY (`id_data`) REFERENCES `data_pasien` (`id_data`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD CONSTRAINT `fk_id_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `daftar_pasien` (`id_pasien`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
