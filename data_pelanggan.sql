-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Des 2025 pada 04.34
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
-- Database: `data_pelanggan`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Subtotal` (IN `p_id_transaksi` CHAR(5))   begin
select
dt.id_transaksi,
sum(dt.jumlah) as sub_total
from detail_transaksi dt
where dt.id_transaksi = p_id_transaksi
group by dt.id_transaksi;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TotalPembayaran` (IN `p_id_pelanggan` CHAR(5))   begin
select
pl.id_pelanggan,
pl.nama_pelanggan,
count(pb.id_pembayaran) as total_pembayaran
from pembayaran pb
join pelanggan pl on pb.id_pelanggan = pl.id_pelanggan
where pl.id_pelanggan = p_id_pelanggan
group by pl.id_pelanggan, pl.nama_pelanggan;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TotalTransaksi` (IN `p_id_admin` CHAR(5))   begin
select
a.id_admin,
a.nama_admin,
count(t.id_transaksi) as total_transaksi
from transaksi t
join admin a on t.id_admin = a.id_admin
where a.id_admin = p_id_admin
group by a.id_admin, a.nama_admin;
end$$

--
-- Fungsi
--
CREATE DEFINER=`root`@`localhost` FUNCTION `HitungPelangganBeliProduk` (`p_id_produk` CHAR(5)) RETURNS INT(11)  begin
declare v_jumlah int;
select count(distinct t.id_pelanggan)
into v_jumlah
from detail_transaksi dt
join transaksi t on dt.id_transaksi = t.id_transaksi
where dt.id_produk = p_id_produk;
return v_jumlah;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `HitungTotalPembayaran` (`p_id_transaksi` CHAR(5)) RETURNS BIGINT(20) DETERMINISTIC begin
declare v_total bigint;
select sum(dt.jumlah * p.harga)
into v_total
from detail_transaksi dt
join produk p on dt.id_produk = p.id_produk
where dt.id_transaksi = p_id_transaksi;
return v_total;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `HitungTotalPenjualanProduk` (`p_id_produk` CHAR(5)) RETURNS BIGINT(20)  begin
declare v_total bigint;
select sum(dt.jumlah * p.harga)
into v_total
from detail_transaksi dt
join produk p on dt.id_produk = p.id_produk
where dt.id_produk = p_id_produk;
return v_total;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `ID_ADMIN` char(5) NOT NULL,
  `USERNAME` varchar(10) DEFAULT NULL,
  `PASSWORD` varchar(8) DEFAULT NULL,
  `NAMA_ADMIN` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`ID_ADMIN`, `USERNAME`, `PASSWORD`, `NAMA_ADMIN`) VALUES
('A001', 'admin01', 'pass1234', 'Agus Wahyudi'),
('A002', 'admin02', 'admin456', 'Budi Santoso'),
('A003', 'admin03', 'login781', 'Siti Aminah');

--
-- Trigger `admin`
--
DELIMITER $$
CREATE TRIGGER `admin_delete` AFTER DELETE ON `admin` FOR EACH ROW begin
insert into log_aktivitas
values (null, 'admin', 'delete', current_user(), now());
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `admin_insert` AFTER INSERT ON `admin` FOR EACH ROW begin
insert into log_aktivitas
values (null, 'admin', 'insert', current_user(), now());
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `admin_update` AFTER UPDATE ON `admin` FOR EACH ROW begin
insert into log_aktivitas
values (null, 'admin', 'update', current_user(), now());
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `ID_PRODUK` char(5) NOT NULL,
  `ID_TRANSAKSI` char(5) NOT NULL,
  `JUMLAH` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`ID_PRODUK`, `ID_TRANSAKSI`, `JUMLAH`) VALUES
('PR001', 'T0001', 2),
('PR001', 'T0002', 10),
('PR002', 'T0002', 1),
('PR003', 'T0003', 1),
('PR004', 'T0004', 2),
('PR005', 'T0005', 1),
('PR006', 'T0006', 1),
('PR007', 'T0007', 1),
('PR008', 'T0008', 1),
('PR009', 'T0009', 2),
('PR010', 'T0010', 1);

--
-- Trigger `detail_transaksi`
--
DELIMITER $$
CREATE TRIGGER `KurangiStokProduk` AFTER INSERT ON `detail_transaksi` FOR EACH ROW begin
update produk
set stok = stok - new.jumlah
where id_produk = new.id_produk;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdatePenjualanProduk` AFTER INSERT ON `detail_transaksi` FOR EACH ROW begin
update produk
set total_terjual = hitungtotalpenjualanproduk(new.id_produk)
where id_produk = new.id_produk;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdateTotalPembayaran` AFTER INSERT ON `detail_transaksi` FOR EACH ROW begin
update transaksi
set total_bayar = hitungtotalpembayaran(new.id_transaksi)
where id_transaksi = new.id_transaksi;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `detail_transaksi_delete` AFTER DELETE ON `detail_transaksi` FOR EACH ROW begin
insert into log_aktivitas
values (null, 'detail_transaksi', 'delete', current_user(), now());
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `detail_transaksi_insert` AFTER INSERT ON `detail_transaksi` FOR EACH ROW begin
insert into log_aktivitas
values (null, 'detail_transaksi', 'insert', current_user(), now());
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `detail_transaksi_update` AFTER UPDATE ON `detail_transaksi` FOR EACH ROW begin
insert into log_aktivitas
values (null, 'detail_transaksi', 'update', current_user(), now());
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_tahunan`
--

CREATE TABLE `laporan_tahunan` (
  `id_laporan` int(11) NOT NULL,
  `tahun` year(4) NOT NULL,
  `total_penjualan` bigint(20) NOT NULL,
  `tanggal_rekap` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL,
  `nama_tabel` varchar(50) DEFAULT NULL,
  `jenis_aksi` varchar(10) DEFAULT NULL,
  `user_aksi` varchar(100) DEFAULT NULL,
  `waktu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id_log`, `nama_tabel`, `jenis_aksi`, `user_aksi`, `waktu`) VALUES
(3, 'detail_transaksi', 'insert', 'root@localhost', '2025-12-22 21:08:29'),
(4, 'transaksi', 'update', 'root@localhost', '2025-12-22 21:08:29'),
(5, 'detail_transaksi', 'delete', 'root@localhost', '2025-12-22 21:09:52'),
(6, 'detail_transaksi', 'insert', 'root@localhost', '2025-12-22 21:09:56'),
(7, 'transaksi', 'update', 'root@localhost', '2025-12-22 21:09:56'),
(8, 'admin', 'update', 'root@localhost', '2025-12-22 21:22:47'),
(9, 'admin', 'update', 'root@localhost', '2025-12-22 21:22:54'),
(10, 'admin', 'update', 'root@localhost', '2025-12-22 21:22:54'),
(11, 'pelanggan', 'update', 'root@localhost', '2025-12-22 21:23:36'),
(12, 'pelanggan', 'update', 'root@localhost', '2025-12-22 21:23:36'),
(13, 'pelanggan', 'update', 'root@localhost', '2025-12-22 21:23:36'),
(14, 'pelanggan', 'update', 'root@localhost', '2025-12-22 21:23:36'),
(15, 'pelanggan', 'update', 'root@localhost', '2025-12-22 21:23:36'),
(16, 'pelanggan', 'update', 'root@localhost', '2025-12-22 21:23:36'),
(17, 'pelanggan', 'update', 'root@localhost', '2025-12-22 21:23:36'),
(18, 'pelanggan', 'update', 'root@localhost', '2025-12-22 21:23:36'),
(19, 'pelanggan', 'update', 'root@localhost', '2025-12-22 21:23:36'),
(20, 'pelanggan', 'update', 'root@localhost', '2025-12-22 21:23:36'),
(21, 'pembayaran', 'update', 'root@localhost', '2025-12-22 21:23:48'),
(22, 'pembayaran', 'update', 'root@localhost', '2025-12-22 21:23:48'),
(23, 'pembayaran', 'update', 'root@localhost', '2025-12-22 21:23:48'),
(24, 'pembayaran', 'update', 'root@localhost', '2025-12-22 21:23:48'),
(25, 'pembayaran', 'update', 'root@localhost', '2025-12-22 21:23:48'),
(26, 'pembayaran', 'update', 'root@localhost', '2025-12-22 21:23:48'),
(27, 'pembayaran', 'update', 'root@localhost', '2025-12-22 21:23:48'),
(28, 'pembayaran', 'update', 'root@localhost', '2025-12-22 21:23:48'),
(29, 'pembayaran', 'update', 'root@localhost', '2025-12-22 21:23:48'),
(30, 'pembayaran', 'update', 'root@localhost', '2025-12-22 21:23:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `ID_PELANGGAN` char(5) NOT NULL,
  `NAMA_PELANGGAN` varchar(20) DEFAULT NULL,
  `ALAMAT` longtext DEFAULT NULL,
  `NO_TELEPON` char(16) DEFAULT NULL,
  `EMAIL` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`ID_PELANGGAN`, `NAMA_PELANGGAN`, `ALAMAT`, `NO_TELEPON`, `EMAIL`) VALUES
('B101', 'Andi Saputra', 'Jl. Merdeka No.10', '081234567801', 'andi@gmail.com'),
('B102', 'Budi Santoso', 'Jl. Ahmad Yani No.5', '081234567802', 'budi@gmail.com'),
('B103', 'Citra Lestari', 'Jl. Sudirman No.12', '081234567803', 'citra@gmail.com'),
('B104', 'Dewi Anggraini', 'Jl. Pahlawan No.7', '081234567804', 'dewi@gmail.com'),
('B105', 'Eko Prasetyo', 'Jl. Diponegoro No.20', '081234567805', 'eko@gmail.com'),
('B106', 'Fajar Maulana', 'Jl. Gatot Subroto No.3', '081234567806', 'fajar@gmail.com'),
('B107', 'Gita Rahmawati', 'Jl. Veteran No.15', '081234567807', 'gita@gmail.com'),
('B108', 'Hendra Wijaya', 'Jl. Sisingamangaraja No.9', '081234567808', 'hendra@gmail.com'),
('B109', 'Intan Permata', 'Jl. Antasari No.11', '081234567809', 'intan@gmail.com'),
('B110', 'Joko Susilo', 'Jl. Hasan Basri No.8', '081234567810', 'joko@gmail.com');

--
-- Trigger `pelanggan`
--
DELIMITER $$
CREATE TRIGGER `pelanggan_delete` AFTER DELETE ON `pelanggan` FOR EACH ROW begin
insert into log_aktivitas
values (null, 'pelanggan', 'delete', current_user(), now());
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pelanggan_insert` AFTER INSERT ON `pelanggan` FOR EACH ROW begin
insert into log_aktivitas
values (null, 'pelanggan', 'insert', current_user(), now());
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pelanggan_update` AFTER UPDATE ON `pelanggan` FOR EACH ROW begin
insert into log_aktivitas
values (null, 'pelanggan', 'update', current_user(), now());
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `ID_PEMBAYARAN` char(5) NOT NULL,
  `ID_PELANGGAN` char(5) NOT NULL,
  `ID_ADMIN` char(5) NOT NULL,
  `TANGGAL_BAYAR` datetime DEFAULT NULL,
  `METODE_PEMBAYARAN` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`ID_PEMBAYARAN`, `ID_PELANGGAN`, `ID_ADMIN`, `TANGGAL_BAYAR`, `METODE_PEMBAYARAN`) VALUES
('P001', 'B103', 'A003', '2025-01-01 10:15:00', 'Tunai'),
('P002', 'B105', 'A002', '2025-01-02 11:20:00', 'Transfer Bank'),
('P003', 'B110', 'A002', '2025-01-03 09:45:00', 'E-Wallet'),
('P004', 'B102', 'A001', '2025-01-04 14:30:00', 'Kartu Debit'),
('P005', 'B109', 'A002', '2025-01-05 16:00:00', 'Tunai'),
('P006', 'B101', 'A001', '2025-01-06 13:10:00', 'Transfer Bank'),
('P007', 'B108', 'A003', '2025-01-07 08:50:00', 'E-Wallet'),
('P008', 'B104', 'A003', '2025-01-08 19:25:00', 'Kartu Kredit'),
('P009', 'B106', 'A002', '2025-01-09 12:40:00', 'Tunai'),
('P010', 'B107', 'A001', '2025-01-10 15:55:00', 'Transfer Bank');

--
-- Trigger `pembayaran`
--
DELIMITER $$
CREATE TRIGGER `pembayaran_delete` AFTER DELETE ON `pembayaran` FOR EACH ROW begin
insert into log_aktivitas
values (null, 'pembayaran', 'delete', current_user(), now());
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pembayaran_insert` AFTER INSERT ON `pembayaran` FOR EACH ROW begin
insert into log_aktivitas
values (null, 'pembayaran', 'insert', current_user(), now());
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pembayaran_update` AFTER UPDATE ON `pembayaran` FOR EACH ROW begin
insert into log_aktivitas
values (null, 'pembayaran', 'update', current_user(), now());
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `ID_PRODUK` char(5) NOT NULL,
  `ID_ADMIN` char(5) NOT NULL,
  `ID_PELANGGAN` char(5) DEFAULT NULL,
  `NAMA_PRODUK` char(20) DEFAULT NULL,
  `HARGA` decimal(10,0) DEFAULT NULL,
  `STOK` int(11) DEFAULT NULL,
  `total_terjual` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`ID_PRODUK`, `ID_ADMIN`, `ID_PELANGGAN`, `NAMA_PRODUK`, `HARGA`, `STOK`, `total_terjual`) VALUES
('PR001', 'A003', 'B104', 'Oli Mesin', 50000, 10, 600000),
('PR002', 'A003', 'B106', 'Kampas Rem', 75000, 20, 0),
('PR003', 'A002', 'B102', 'Aki Motor', 350000, 15, 0),
('PR004', 'A001', 'B101', 'Busi', 25000, 50, 0),
('PR005', 'A001', 'B107', 'Filter Udara', 45000, 25, 0),
('PR006', 'A002', 'B108', 'Rantai Motor', 150000, 18, 0),
('PR007', 'A003', 'B103', 'Ban Depan', 300000, 10, 0),
('PR008', 'A003', 'B110', 'Ban Belakang', 350000, 8, 0),
('PR009', 'A001', 'B105', 'Lampu LED', 60000, 40, 0),
('PR010', 'A002', 'B101', 'Spion', 40000, 35, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `ID_TRANSAKSI` char(5) NOT NULL,
  `ID_ADMIN` char(5) NOT NULL,
  `ID_PELANGGAN` char(5) NOT NULL,
  `ID_PEMBAYARAN` char(5) NOT NULL,
  `TANGGAL_TRANSAKSI` datetime DEFAULT NULL,
  `total_bayar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`ID_TRANSAKSI`, `ID_ADMIN`, `ID_PELANGGAN`, `ID_PEMBAYARAN`, `TANGGAL_TRANSAKSI`, `total_bayar`) VALUES
('T0001', 'A001', 'B101', 'P001', '2025-12-01 10:00:00', NULL),
('T0002', 'A002', 'B102', 'P002', '2025-12-02 11:30:00', 575000),
('T0003', 'A003', 'B103', 'P001', '2025-12-03 14:15:00', NULL),
('T0004', 'A001', 'B104', 'P003', '2025-12-04 09:45:00', NULL),
('T0005', 'A002', 'B105', 'P001', '2025-12-05 16:20:00', NULL),
('T0006', 'A003', 'B106', 'P002', '2025-12-06 13:00:00', NULL),
('T0007', 'A001', 'B107', 'P001', '2025-12-07 10:10:00', NULL),
('T0008', 'A002', 'B108', 'P003', '2025-12-08 15:50:00', NULL),
('T0009', 'A003', 'B109', 'P001', '2025-12-09 11:00:00', NULL),
('T0010', 'A001', 'B110', 'P002', '2025-12-10 17:30:00', NULL);

--
-- Trigger `transaksi`
--
DELIMITER $$
CREATE TRIGGER `transaksi_delete` AFTER DELETE ON `transaksi` FOR EACH ROW begin
insert into log_aktivitas
values (null, 'transaksi', 'delete', current_user(), now());
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `transaksi_insert` AFTER INSERT ON `transaksi` FOR EACH ROW begin
insert into log_aktivitas
values (null, 'transaksi', 'insert', current_user(), now());
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `transaksi_update` AFTER UPDATE ON `transaksi` FOR EACH ROW begin
insert into log_aktivitas
values (null, 'transaksi', 'update', current_user(), now());
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_laporan_transaksi`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_laporan_transaksi` (
`id_transaksi` char(5)
,`nama_pelanggan` varchar(20)
,`nama_admin` varchar(20)
,`metode_pembayaran` varchar(30)
,`id_produk` char(5)
,`jumlah` int(11)
,`tanggal_transaksi` datetime
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_pembayaran_lengkap`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_pembayaran_lengkap` (
`id_pembayaran` char(5)
,`nama_pelanggan` varchar(20)
,`nama_admin` varchar(20)
,`metode_pembayaran` varchar(30)
,`tanggal_bayar` datetime
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_laporan_transaksi`
--
DROP TABLE IF EXISTS `view_laporan_transaksi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_laporan_transaksi`  AS SELECT `t`.`ID_TRANSAKSI` AS `id_transaksi`, `pl`.`NAMA_PELANGGAN` AS `nama_pelanggan`, `a`.`NAMA_ADMIN` AS `nama_admin`, `pb`.`METODE_PEMBAYARAN` AS `metode_pembayaran`, `dt`.`ID_PRODUK` AS `id_produk`, `dt`.`JUMLAH` AS `jumlah`, `t`.`TANGGAL_TRANSAKSI` AS `tanggal_transaksi` FROM ((((`transaksi` `t` join `pelanggan` `pl` on(`t`.`ID_PELANGGAN` = `pl`.`ID_PELANGGAN`)) join `admin` `a` on(`t`.`ID_ADMIN` = `a`.`ID_ADMIN`)) join `pembayaran` `pb` on(`t`.`ID_PEMBAYARAN` = `pb`.`ID_PEMBAYARAN`)) join `detail_transaksi` `dt` on(`t`.`ID_TRANSAKSI` = `dt`.`ID_TRANSAKSI`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_pembayaran_lengkap`
--
DROP TABLE IF EXISTS `view_pembayaran_lengkap`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_pembayaran_lengkap`  AS SELECT `pb`.`ID_PEMBAYARAN` AS `id_pembayaran`, `pl`.`NAMA_PELANGGAN` AS `nama_pelanggan`, `a`.`NAMA_ADMIN` AS `nama_admin`, `pb`.`METODE_PEMBAYARAN` AS `metode_pembayaran`, `pb`.`TANGGAL_BAYAR` AS `tanggal_bayar` FROM ((`pembayaran` `pb` join `pelanggan` `pl` on(`pb`.`ID_PELANGGAN` = `pl`.`ID_PELANGGAN`)) join `admin` `a` on(`pb`.`ID_ADMIN` = `a`.`ID_ADMIN`)) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID_ADMIN`);

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`ID_PRODUK`,`ID_TRANSAKSI`),
  ADD KEY `FK_MELIBATKAN2` (`ID_TRANSAKSI`);

--
-- Indeks untuk tabel `laporan_tahunan`
--
ALTER TABLE `laporan_tahunan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`ID_PELANGGAN`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`ID_PEMBAYARAN`),
  ADD KEY `FK_MELAKUKAN1` (`ID_PELANGGAN`),
  ADD KEY `FK_MEMPROSES` (`ID_ADMIN`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`ID_PRODUK`),
  ADD KEY `FK_MEMILIH` (`ID_PELANGGAN`),
  ADD KEY `FK_MENGUNGGAH` (`ID_ADMIN`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`ID_TRANSAKSI`),
  ADD KEY `FK_MELAKUKAN` (`ID_PELANGGAN`),
  ADD KEY `FK_MEMILIKI` (`ID_PEMBAYARAN`),
  ADD KEY `FK_MENANGANI` (`ID_ADMIN`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `laporan_tahunan`
--
ALTER TABLE `laporan_tahunan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `FK_MELIBATKAN2` FOREIGN KEY (`ID_TRANSAKSI`) REFERENCES `transaksi` (`ID_TRANSAKSI`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_TERCATAT` FOREIGN KEY (`ID_PRODUK`) REFERENCES `produk` (`ID_PRODUK`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `FK_MELAKUKAN1` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_MEMPROSES` FOREIGN KEY (`ID_ADMIN`) REFERENCES `admin` (`ID_ADMIN`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `FK_MEMILIH` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_MENGUNGGAH` FOREIGN KEY (`ID_ADMIN`) REFERENCES `admin` (`ID_ADMIN`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `FK_MELAKUKAN` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_MEMILIKI` FOREIGN KEY (`ID_PEMBAYARAN`) REFERENCES `pembayaran` (`ID_PEMBAYARAN`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_MENANGANI` FOREIGN KEY (`ID_ADMIN`) REFERENCES `admin` (`ID_ADMIN`) ON DELETE CASCADE;

DELIMITER $$
--
-- Event
--
CREATE DEFINER=`root`@`localhost` EVENT `RekapPenjualanTahunan` ON SCHEDULE EVERY 1 YEAR STARTS '2026-01-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO begin
insert into laporan_tahunan
(tahun, total_penjualan, tanggal_rekap)
values (year(curdate()) - 1,
(select sum(total_bayar) from transaksi 
where year(tanggal_transaksi) = year(curdate()) - 1),
now());
end$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
