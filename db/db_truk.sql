-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Bulan Mei 2022 pada 08.51
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_truk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` int(11) NOT NULL,
  `nama_divisi` varchar(255) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `nidn` varchar(50) NOT NULL,
  `jk` varchar(15) NOT NULL,
  `status` varchar(3) NOT NULL DEFAULT 'on'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `divisi`
--

INSERT INTO `divisi` (`id_divisi`, `nama_divisi`, `nip`, `nidn`, `jk`, `status`) VALUES
(13, 'Tepung', '178654', '001', 'Roda4', 'on'),
(14, 'Ekspor', '143521', '002', 'Roda6', 'on'),
(15, 'Bahan', '890765', '003', 'Roda4', 'on'),
(16, 'Delivery', '087654', '004', 'Roda4', 'on');

-- --------------------------------------------------------

--
-- Struktur dari tabel `muatan`
--

CREATE TABLE `muatan` (
  `id_muatan` int(11) NOT NULL,
  `nama_muatan` varchar(255) NOT NULL,
  `jenjang` varchar(5) NOT NULL,
  `status` varchar(3) NOT NULL DEFAULT 'on'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `muatan`
--

INSERT INTO `muatan` (`id_muatan`, `nama_muatan`, `jenjang`, `status`) VALUES
(21, '50 Ton', '26', 'on'),
(22, '70 Ton', '30', 'on'),
(23, '65 Ton', '28', 'on'),
(24, '80 Ton', '30', 'on');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `tbl_truk`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `tbl_truk` (
`id_truk` int(11)
,`tahun` int(11)
,`nama_truk` varchar(255)
,`nama_muatan` varchar(255)
,`nama_divisi` varchar(255)
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `truk`
--

CREATE TABLE `truk` (
  `id_truk` int(11) NOT NULL,
  `id_muatan` int(11) NOT NULL,
  `id_divisi` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `nama_truk` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `truk`
--

INSERT INTO `truk` (`id_truk`, `id_muatan`, `id_divisi`, `tahun`, `nama_truk`) VALUES
(23, 21, 13, 2015, 'Hino 500'),
(24, 22, 14, 2018, 'Volvo S1'),
(25, 23, 15, 2020, 'Scania 112'),
(26, 21, 16, 2014, 'Mitsubishi Fuso');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`) VALUES
(1, 'Anggika Wardani', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Struktur untuk view `tbl_truk`
--
DROP TABLE IF EXISTS `tbl_truk`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tbl_truk`  AS SELECT `truk`.`id_truk` AS `id_truk`, `truk`.`tahun` AS `tahun`, `truk`.`nama_truk` AS `nama_truk`, `muatan`.`nama_muatan` AS `nama_muatan`, `divisi`.`nama_divisi` AS `nama_divisi` FROM ((`truk` join `muatan` on(`muatan`.`id_muatan` = `truk`.`id_muatan`)) join `divisi` on(`divisi`.`id_divisi` = `truk`.`id_divisi`)) ORDER BY `truk`.`id_truk` ASC ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indeks untuk tabel `muatan`
--
ALTER TABLE `muatan`
  ADD PRIMARY KEY (`id_muatan`);

--
-- Indeks untuk tabel `truk`
--
ALTER TABLE `truk`
  ADD PRIMARY KEY (`id_truk`),
  ADD KEY `fk_muatan` (`id_muatan`),
  ADD KEY `fk_divisi` (`id_divisi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `muatan`
--
ALTER TABLE `muatan`
  MODIFY `id_muatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `truk`
--
ALTER TABLE `truk`
  MODIFY `id_truk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `truk`
--
ALTER TABLE `truk`
  ADD CONSTRAINT `fk_divisi` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id_divisi`),
  ADD CONSTRAINT `fk_muatan` FOREIGN KEY (`id_muatan`) REFERENCES `muatan` (`id_muatan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
