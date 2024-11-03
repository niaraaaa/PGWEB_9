-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Nov 2024 pada 15.21
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
-- Database: `pgweb8`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `penduduk`
--

CREATE TABLE `penduduk` (
  `kecamatan` text NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `luas` double NOT NULL,
  `jumlah_penduduk` double NOT NULL,
  `delete_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penduduk`
--

INSERT INTO `penduduk` (`kecamatan`, `latitude`, `longitude`, `luas`, `jumlah_penduduk`, `delete_id`) VALUES
('moyudan', -7.7774, 110.2478, 27.262, 31497, 1),
('minggir', -7.7318, 110.2484, 27.27, 19886, 4),
('Seyegan', -7.7265, 110.3003, 16.63, 47129, 5),
('Gamping', -7.2903, 110.3202, 29.25, 108674, 6);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `penduduk`
--
ALTER TABLE `penduduk`
  ADD PRIMARY KEY (`delete_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `penduduk`
--
ALTER TABLE `penduduk`
  MODIFY `delete_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
