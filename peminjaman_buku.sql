-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Mar 2021 pada 06.41
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peminjaman_buku`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_anggota`
--

CREATE TABLE `tb_anggota` (
  `id_anggota` int(3) UNSIGNED ZEROFILL NOT NULL,
  `nama` varchar(20) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `no_hp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_anggota`
--

INSERT INTO `tb_anggota` (`id_anggota`, `nama`, `jenis_kelamin`, `no_hp`) VALUES
(010, 'Elisa', 'Perempuan', '085870005112'),
(012, 'Alex', 'Laki-laki', '081010101010'),
(015, 'Ronaldo', 'Laki-laki', '085');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_buku`
--

CREATE TABLE `tb_buku` (
  `id_buku` int(3) UNSIGNED ZEROFILL NOT NULL,
  `judul` varchar(50) NOT NULL,
  `pengarang` varchar(50) NOT NULL,
  `penerbit` varchar(20) NOT NULL,
  `tahun` int(4) NOT NULL,
  `gambar` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_buku`
--

INSERT INTO `tb_buku` (`id_buku`, `judul`, `pengarang`, `penerbit`, `tahun`, `gambar`) VALUES
(011, 'Laskar Pelangi', 'Febri S', 'Gramedia', 2007, 'default.jpg'),
(016, 'Negeri 5 Menara', 'Ahmad Tohari', 'Media Pustaka', 2009, '6031d33426d8a.png'),
(018, 'Laskar Pelangi 2', 'Andrea', 'Gramedia Bintang', 2009, '60323cfe81231.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_peminjaman`
--

CREATE TABLE `tb_peminjaman` (
  `id_peminjaman` int(3) UNSIGNED ZEROFILL NOT NULL,
  `id_anggota` int(3) UNSIGNED ZEROFILL NOT NULL,
  `id_buku` int(3) UNSIGNED ZEROFILL DEFAULT NULL,
  `tgl_pinjam` date NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `perpanjang` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('Kembali','Dipinjam') NOT NULL DEFAULT 'Dipinjam',
  `tgl_kembali` date DEFAULT NULL,
  `denda` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_peminjaman`
--

INSERT INTO `tb_peminjaman` (`id_peminjaman`, `id_anggota`, `id_buku`, `tgl_pinjam`, `jatuh_tempo`, `perpanjang`, `status`, `tgl_kembali`, `denda`) VALUES
(032, 010, 011, '2021-02-20', '2021-02-21', 0, 'Kembali', '2021-02-21', NULL),
(033, 010, 011, '2021-02-21', '2021-03-07', 1, 'Kembali', '2021-02-21', NULL),
(037, 012, 018, '2021-02-21', '2021-02-28', 0, 'Dipinjam', NULL, NULL),
(038, 015, 016, '2021-02-21', '2021-02-28', 0, 'Dipinjam', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(3) UNSIGNED ZEROFILL NOT NULL,
  `nama` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `level` enum('Administrator','Petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama`, `email`, `password`, `level`) VALUES
(001, 'Febri Sutomo', 'febrisutomo@gmail.com', '$2y$10$YN.YyQGoAE0vks3KCZMUU.5icDgpK0qpZagP/aNT.DacdsPZzUDZ2', 'Administrator'),
(016, 'Febri', 'febrisutomo1@gmail.com', '$2y$10$ING1G1AHG6JIipckjJSHTe6.9wm2Rh91/vt6SG8Lj79CoBdzNv2q6', 'Petugas'),
(017, 'Febri Sutomo', 'admin@gmail.com', '$2y$10$8VaHjGF/DpgZmmNE1Mvdxei0VMmQHVEM6Y4p33rLYbc6x0pOKn.6m', 'Administrator');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_anggota`
--
ALTER TABLE `tb_anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indeks untuk tabel `tb_buku`
--
ALTER TABLE `tb_buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indeks untuk tabel `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_anggota`
--
ALTER TABLE `tb_anggota`
  MODIFY `id_anggota` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tb_buku`
--
ALTER TABLE `tb_buku`
  MODIFY `id_buku` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
  MODIFY `id_peminjaman` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
  ADD CONSTRAINT `tb_peminjaman_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`),
  ADD CONSTRAINT `tb_peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `tb_buku` (`id_buku`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
