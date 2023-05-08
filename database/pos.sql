-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Bulan Mei 2023 pada 04.25
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(11) NOT NULL,
  `kode_akun` text NOT NULL,
  `nama_akun` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`id_akun`, `kode_akun`, `nama_akun`) VALUES
(1, '11021', 'Kas Besar'),
(2, '110', 'Kas Besar');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(256) NOT NULL,
  `harga_modal` int(11) NOT NULL,
  `satuan_besar` int(11) NOT NULL,
  `satuan_kecil` int(11) NOT NULL,
  `uom_besar` varchar(20) NOT NULL,
  `uom_kecil` varchar(20) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `harga_modal`, `satuan_besar`, `satuan_kecil`, `uom_besar`, `uom_kecil`, `kuantitas`, `status`) VALUES
(1, 'PIPA PARALONTE GAJAHMADA', 10000, 1, 20, 'KONTOL', 'BIJI', 20015, 'Y'),
(2, 'GSM', 10000, 1, 30, 'KONTOL', 'BIJI', 40010, 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cash_masuk`
--

CREATE TABLE `cash_masuk` (
  `id_cmasuk` int(11) NOT NULL,
  `nomor_masuk` int(11) NOT NULL,
  `nomor_bukti` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(11) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `kontak` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  `alamat` varchar(256) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id_customer`, `nama`, `kontak`, `keterangan`, `alamat`, `status`) VALUES
(2, 'brian', '1', '-', 'Jl Adam Malik', 'Y'),
(3, 'GENK', '1', '-', 'Adam Malik', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_mobil`
--

CREATE TABLE `data_mobil` (
  `id_mobil` int(11) NOT NULL,
  `plat` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `pemeriksa` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `history_jasa`
--

CREATE TABLE `history_jasa` (
  `id_hjasa` int(11) NOT NULL,
  `id_jasa` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `harga_jasa` int(11) NOT NULL,
  `deskripsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `history_jasa`
--

INSERT INTO `history_jasa` (`id_hjasa`, `id_jasa`, `id_penjualan`, `harga_jasa`, `deskripsi`) VALUES
(1, 1, 6, 20000, '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `history_pembelian`
--

CREATE TABLE `history_pembelian` (
  `id_hbeli` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `harga_barang` bigint(20) NOT NULL,
  `disc` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `bruto` bigint(20) NOT NULL,
  `netto` bigint(20) NOT NULL,
  `user` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `history_pembelian`
--

INSERT INTO `history_pembelian` (`id_hbeli`, `id_pembelian`, `id_barang`, `id_supplier`, `kuantitas`, `harga_barang`, `disc`, `diskon`, `bruto`, `netto`, `user`) VALUES
(1, 1, 1, 23, 5, 10000, 0, 0, 50000, 50000, 'admin'),
(2, 1, 2, 23, 10, 10000, 0, 0, 100000, 100000, 'admin'),
(3, 2, 1, 23, 5, 10000, 0, 0, 50000, 50000, 'admin'),
(4, 2, 2, 23, 20000, 10000, 0, 0, 200000000, 200000000, 'admin'),
(5, 3, 1, 24, 5, 10000, 0, 0, 50000, 50000, 'admin'),
(6, 3, 2, 24, 20000, 10000, 0, 0, 200000000, 200000000, 'admin'),
(7, 4, 1, 23, 20000, 10000, 0, 0, 200000000, 200000000, 'admin'),
(8, 5, 1, 23, 20, 100000, 0, 0, 2000000, 2000000, 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `history_penjualan`
--

CREATE TABLE `history_penjualan` (
  `id_hjual` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `harga_barang` bigint(20) NOT NULL,
  `disc` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `bruto` bigint(20) NOT NULL,
  `netto` bigint(20) NOT NULL,
  `user` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `history_penjualan`
--

INSERT INTO `history_penjualan` (`id_hjual`, `id_penjualan`, `id_barang`, `id_customer`, `kuantitas`, `harga_barang`, `disc`, `diskon`, `bruto`, `netto`, `user`) VALUES
(1, 1, 1, 2, 5, 10000, 0, 0, 50000, 50000, 'admin'),
(2, 2, 2, 3, 20000, 10000, 0, 0, 200000000, 200000000, 'admin'),
(3, 2, 1, 3, 5, 10000, 0, 0, 50000, 50000, 'admin'),
(4, 3, 2, 2, 10, 10000, 0, 0, 100000, 100000, 'admin'),
(5, 4, 1, 2, 10, 10000, 0, 0, 100000, 100000, 'admin'),
(6, 4, 1, 2, 10, 10000, 0, 0, 100000, 100000, 'admin'),
(7, 4, 1, 2, 10, 10000, 0, 0, 100000, 100000, 'admin'),
(8, 4, 1, 3, 10, 10000, 0, 0, 100000, 100000, 'admin'),
(9, 6, 1, 2, 20, 210000, 0, 0, 4200000, 4200000, 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `is_users`
--

CREATE TABLE `is_users` (
  `id_user` int(3) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telepon` varchar(13) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `hak_akses` enum('Super Admin','User','Client','CCTV','Jo','HeadStok','Stok','HeadStokIT','StokIT','Headtransport','SupportKUS','Direktur','PersonKUS','PersonSMP','Head Audit','PersonKPN','PersonARP','PersonKAP','Personalia','KasirKpn','ApKpn','KasirKus','ApKus','KasirArp','ApArp','KasirKap','ApKap','HeadFinance','AccKUS','KasirKas','ApKas','KasirSmp','ApSmp','MIS_1','MIS_2','PersonKAS','Servis','KtuArp','KtuKpn','KtuKap','KtuKus','KtuKas','KtuSmp') NOT NULL,
  `status` enum('aktif','blokir') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `is_users`
--

INSERT INTO `is_users` (`id_user`, `username`, `nama_user`, `password`, `email`, `telepon`, `foto`, `hak_akses`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', '1', 'alex@gmail.com', 'ddadawd', NULL, 'Super Admin', 'aktif', '2023-04-18 02:19:16', '2023-04-18 02:19:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jasa`
--

CREATE TABLE `jasa` (
  `id_jasa` int(11) NOT NULL,
  `nama_jasa` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jasa`
--

INSERT INTO `jasa` (`id_jasa`, `nama_jasa`, `status`) VALUES
(1, 'GANTI OLI', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mobil`
--

CREATE TABLE `mobil` (
  `id_prlkpn` int(11) NOT NULL,
  `prlkpn` varchar(30) NOT NULL,
  `status` varchar(5) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mobil`
--

INSERT INTO `mobil` (`id_prlkpn`, `prlkpn`, `status`) VALUES
(3, 'Baut', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `no_faktur` varchar(256) NOT NULL,
  `nomor_transaksi` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `jatuh_tempo` date DEFAULT NULL,
  `netto` int(11) DEFAULT 0,
  `status_hapus` varchar(1) NOT NULL DEFAULT 'Y',
  `status_pembayaran` varchar(1) NOT NULL DEFAULT 'N',
  `creator` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `no_faktur`, `nomor_transaksi`, `id_supplier`, `tanggal`, `jatuh_tempo`, `netto`, `status_hapus`, `status_pembayaran`, `creator`) VALUES
(1, 'PB/2304/0001', 1, 23, '2023-04-24', '2023-04-25', 150000, 'Y', 'N', 'admin'),
(2, 'PB/2304/0002', 2, 23, '2023-04-24', '2023-04-25', 200050000, 'Y', 'N', 'admin'),
(3, 'PB/2304/0003', 3, 24, '2023-04-24', '2023-04-25', 200050000, 'Y', 'N', 'admin'),
(4, 'PB/2304/0004', 4, 23, '2023-04-26', '2023-04-27', 200000000, 'Y', 'N', 'admin'),
(5, 'PB/2305/0001', 1, 23, '2023-05-05', '2023-06-03', 2000000, 'Y', 'N', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `no_faktur` varchar(256) NOT NULL,
  `nomor_transaksi` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_jasa` int(11) NOT NULL,
  `plat` varchar(20) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `jatuh_tempo` date DEFAULT NULL,
  `netto` int(11) DEFAULT 0,
  `status_hapus` varchar(1) NOT NULL DEFAULT 'Y',
  `status_pembayaran` varchar(1) NOT NULL DEFAULT 'N',
  `creator` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `no_faktur`, `nomor_transaksi`, `id_customer`, `id_jasa`, `plat`, `tanggal`, `jatuh_tempo`, `netto`, `status_hapus`, `status_pembayaran`, `creator`) VALUES
(1, 'PJ/2304/0001', 1, 2, 0, '', '2023-04-24', '2023-04-26', 50000, 'Y', 'N', 'admin'),
(2, 'PJ/2304/0002', 2, 3, 0, '', '2023-04-24', '2023-04-26', 200050000, 'Y', 'N', 'admin'),
(3, 'PJ/2304/0003', 3, 2, 0, '', '2023-04-24', '2023-04-25', 100000, 'Y', 'N', 'admin'),
(4, 'PJ/2304/0004', 4, 3, 0, '', '2023-04-26', '2023-04-27', 200000000, 'Y', 'N', 'admin'),
(5, '', 0, 0, 0, '', '2023-04-30', '0000-00-00', 0, 'Y', 'N', 'admin'),
(6, 'PJ/2305/0001', 1, 2, 0, 'adaw', '2023-05-05', '2023-05-27', 4200000, 'Y', 'N', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `kontak` varchar(20) NOT NULL,
  `no_rekening` varchar(256) NOT NULL,
  `keterangan` text NOT NULL,
  `alamat` varchar(512) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama`, `kontak`, `no_rekening`, `keterangan`, `alamat`, `status`) VALUES
(23, 'Nicholas Yang', '081267643835', '8645185699', 'Pincang', 'Jln. Boulevard Raya', 'Y'),
(24, 'brian', 'dwadw', '1212', '-', 'Jl Adam Malik', 'Y');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `cash_masuk`
--
ALTER TABLE `cash_masuk`
  ADD PRIMARY KEY (`id_cmasuk`);

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indeks untuk tabel `data_mobil`
--
ALTER TABLE `data_mobil`
  ADD PRIMARY KEY (`id_mobil`);

--
-- Indeks untuk tabel `history_jasa`
--
ALTER TABLE `history_jasa`
  ADD PRIMARY KEY (`id_hjasa`);

--
-- Indeks untuk tabel `history_pembelian`
--
ALTER TABLE `history_pembelian`
  ADD PRIMARY KEY (`id_hbeli`);

--
-- Indeks untuk tabel `history_penjualan`
--
ALTER TABLE `history_penjualan`
  ADD PRIMARY KEY (`id_hjual`);

--
-- Indeks untuk tabel `is_users`
--
ALTER TABLE `is_users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `level` (`hak_akses`);

--
-- Indeks untuk tabel `jasa`
--
ALTER TABLE `jasa`
  ADD PRIMARY KEY (`id_jasa`);

--
-- Indeks untuk tabel `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id_prlkpn`);

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `cash_masuk`
--
ALTER TABLE `cash_masuk`
  MODIFY `id_cmasuk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `data_mobil`
--
ALTER TABLE `data_mobil`
  MODIFY `id_mobil` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `history_jasa`
--
ALTER TABLE `history_jasa`
  MODIFY `id_hjasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `history_pembelian`
--
ALTER TABLE `history_pembelian`
  MODIFY `id_hbeli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `history_penjualan`
--
ALTER TABLE `history_penjualan`
  MODIFY `id_hjual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `is_users`
--
ALTER TABLE `is_users`
  MODIFY `id_user` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jasa`
--
ALTER TABLE `jasa`
  MODIFY `id_jasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id_prlkpn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
