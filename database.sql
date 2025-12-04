-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql213.infinityfree.com
-- Generation Time: Dec 04, 2025 at 04:01 AM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_40592911_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`) VALUES
(1, 'Market Update', 'market-update', 'Berita update pasar harian'),
(2, 'Analisa Teknikal', 'analisa-teknikal', 'Analisa grafik saham'),
(3, 'Crypto News', 'crypto-news', 'Berita mata uang kripto');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(220) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `ticker_symbol` varchar(20) DEFAULT NULL,
  `market` enum('saham_id','saham_us','crypto','lainnya') NOT NULL DEFAULT 'saham_id',
  `author_id` int(10) UNSIGNED NOT NULL,
  `published_at` datetime DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `category_id`, `title`, `slug`, `content`, `image`, `ticker_symbol`, `market`, `author_id`, `published_at`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'IHSG Menguat, BBCA Pimpin Kenaikan Sektor Perbankan', 'ihsg-menguat-bbca-pimpin', 'Indeks Harga Saham Gabungan (IHSG) ditutup menguat pada perdagangan hari ini. Saham PT Bank Central Asia Tbk (BBCA) menjadi salah satu pendorong utama indeks dengan kenaikan yang signifikan.', NULL, 'BBCA.JK', 'saham_id', 1, '2025-12-03 17:06:33', 'published', '2025-12-03 17:06:33', '2025-12-03 17:48:16'),
(2, 1, 'Tesla (TSLA) Rilis Laporan Kinerja, Saham Melonjak', 'tesla-rilis-kinerja', 'Tesla Inc. (TSLA) baru saja merilis laporan keuangan kuartal terbaru yang melampaui ekspektasi Wall Street. Pendapatan dari sektor energi terbarukan juga menunjukkan pertumbuhan yang impresif.', NULL, 'TSLA', 'saham_us', 1, '2025-12-03 17:06:33', 'published', '2025-12-03 17:06:33', '2025-12-03 17:52:06'),
(3, 3, 'Bitcoin (BTC) Tembus Level Resistance Baru', 'bitcoin-tembus-resistance', 'Pasar kripto kembali bergairah setelah Bitcoin berhasil menembus level psikologis baru hari ini. Kenaikan ini didorong oleh sentimen positif dari persetujuan ETF Spot.', NULL, 'BTC', 'crypto', 1, '2025-12-03 17:06:33', 'published', '2025-12-03 17:06:33', '2025-12-03 17:52:19'),
(4, 1, 'Andry Hakim Borong Saham CBRE, Bakal Ada Aksi Besar', 'andry-hakim-borong-saham-cbre-bakal-ada-aksi-besar', 'Investor Andry Hakim menambah kepemilikannya atas saham PT Cakra Buana Resources Energi Tbk (CBRE).\r\n\r\nAndry Hakim menyebutkan bahwa dirinya membeli 96.700 saham CBRE di harga Rp 1.020 per saham pada 1 Desember 2025. Seluruh nilai transaksinya sebesar Rp 98,63 juta.\r\n\r\n“Tujuan transaksi investasi,” terang Andry Hakim dalam keterbukaan informasi, Rabu (3/12/2025). Setelah transaksi tersebut, ia jadi menggenggam 227.000.074 (5,002%) saham Cakra Buana Resources Energi.', '6930e224be205.jpeg', 'CBRE', 'saham_id', 1, '2025-12-03 17:21:40', 'published', '2025-12-03 17:21:40', '2025-12-03 17:21:40'),
(5, 1, 'Lonjakan Harga Saham CBDK Terkerek Right Issue PANI', 'lonjakan-harga-saham-cbdk-terkerek-right-issue-pani-bagaimana-prospeknya-artikel-ini-telah-tayang-di-katadata-co-id-dengan-judul-lonjakan-harga-saham-cbdk-terkerek-right-issue-pani-bagaimana-prospeknya-https-katadata-co-', 'Harga saham PT Bangun Kosambi Sukses Tbk (CBDK) melesat dalam beberapa hari terakhir. Analis menilai lonjakan tersebut dipicu oleh narasi akuisisi oleh perusahaan induknya, PT Pantai Indah Kapuk Dua Tbk (PANI), seiring rencana aksi korporasi penambahan modal dengan hak memesan efek terlebih dahulu (PMHMETD) atau right issue. Pada perdagangan Selasa (2/12), saham CBDK tercatat naik 4,11% secara intraday pada pukul 15.02 WIB ke level 8.875. Dalam sepekan terakhir, harga saham emiten properti tersebut sudah menguat 33,33% dan melonjak 119,21% sejak melantai di Bursa Efek Indonesia pada 13 Januari lalu.', '', 'CBDK', 'saham_id', 1, '2025-12-03 17:44:53', 'published', '2025-12-03 17:44:53', '2025-12-03 17:45:23'),
(6, 1, 'Retest US$50 Ribu Bisa Dorong Bitcoin ke US$250 Ribu', 'retest-us-50-ribu-bisa-dorong-bitcoin-ke-us-250-ribu', 'Bitcoin (BTC) kembali mencuri perhatian setelah analis veteran Peter Brandt menyampaikan proyeksi ekstrem terkait arah pergerakan harga berikutnya. \r\n\r\nBrandt memperingatkan bahwa aset ini masih berpotensi mengalami koreksi tajam menuju US$50.000 sebelum memulai reli besar yang dapat mendorong harga hingga US$250.000.\r\n\r\nBrandt menegaskan bahwa pola siklus empat tahunan Bitcoin tetap mengikuti struktur historis yang konsisten. \r\n\r\nSetiap siklus umumnya menampilkan kenaikan ke rekor baru, diikuti penurunan signifikan lebih dari 75%, sebelum akhirnya memasuki bull cycle berikutnya. Menurutnya, pola tersebut masih relevan meski terdapat tanda melemahnya kualitas tiap siklus.', '', 'BTC', 'crypto', 1, '2025-12-04 00:12:12', 'published', '2025-12-04 00:12:12', '2025-12-04 00:12:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `role` enum('admin','editor') NOT NULL DEFAULT 'editor',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$lrPgYJmIIkk8wMERlPUuru9w6mXthQgMzQNajTpOMhsKYyot2UcFi', 'William', 'admin', '2025-12-03 17:06:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_news_category` (`category_id`),
  ADD KEY `fk_news_author` (`author_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_author` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_news_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
