-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Feb 2025 pada 11.16
-- Versi server: 10.4.32-MariaDB-log
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas_wp1`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `varian` varchar(50) DEFAULT NULL,
  `ukuran` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `keranjang`
--

INSERT INTO `keranjang` (`id`, `product_id`, `quantity`, `varian`, `ukuran`, `created_at`) VALUES
(17, 4, 1, 'Putih', 'S', '2025-02-08 09:13:57'),
(18, 3, 1, 'Cream', 'L', '2025-02-08 09:14:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `rating` varchar(11) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `variants` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`variants`)),
  `sizes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sizes`)),
  `category` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `rating`, `description`, `image_url`, `variants`, `sizes`, `category`, `created_at`) VALUES
(1, 'Koko Muslim', 242000, '4', 'Ini merupakan Koko Outfit', 'https://down-id.img.susercontent.com/file/975b426e28d4f8924d21629c65869243', '[\"Putih\", \"Cream\", \"Biru\"]', '[\"S\", \"M\", \"L\", \"XL\"]', 'Muslim Outfit', '2025-02-07 22:21:54'),
(2, 'Dress Muslim', 315000, '4.5', 'Ini adalah Dress Muslim', 'https://images.tokopedia.net/img/cache/700/VqbcmM/2023/3/3/3e88c1d9-2de7-4f9a-a17f-650597c72d4a.jpg', '[\"Putih\", \"Cream\", \"Biru\", \"Pink\"]', '[\"S\", \"M\", \"L\", \"XL\"]', 'Muslim Outfit', '2025-02-07 22:23:58'),
(3, 'Casual Oversize', 282000, '4', 'Ini adalah casual oversize', 'https://heylocal.id/blog/wp-content/uploads/2024/06/PAC_1158-4-682x1024.jpg', '[\"Putih\", \"Cream\", \"Biru\", \"Hitam\"]', '[\"S\", \"M\", \"L\", \"XL\"]', 'Casual Outfit', '2025-02-08 03:02:05'),
(4, 'Adidas Casual', 345000, '5', 'Ini adalah adidas casual', 'https://images.unsplash.com/photo-1536243298747-ea8874136d64?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', '[\"Putih\", \"Cream\", \"Biru\", \"Hitam\"]', '[\"S\", \"M\", \"L\", \"XL\"]', 'Casual Outfit', '2025-02-08 03:03:50'),
(5, 'Sleepless Shirt', 105000, '4', 'Ini adalah sleepless shirt', 'https://i.pinimg.com/736x/91/f9/3d/91f93d762c0d4de771ac3f20ae18ce0c.jpg', '[\"Putih\", \"Cream\", \"Biru\", \"Hitam\"]', '[\"S\", \"M\", \"L\", \"XL\"]', 'Streetwear Outfit', '2025-02-08 10:07:16'),
(6, 'Oversize streetweaar', 175000, '4.5', 'Ini adalah oversize streetwear', 'https://i.pinimg.com/236x/96/5e/e8/965ee8dfac6b3efa85f91d24f2fa3722.jpg', '[\"Putih\", \"Cream\", \"Biru\", \"Hitam\"]', '[\"S\", \"M\", \"L\", \"XL\", \"XXL\"]', 'Streetwear Outfit', '2025-02-08 10:07:20'),
(7, 'Strip Vintage', 222000, '5', 'Ini adalah strip vintage', 'https://lh7-rt.googleusercontent.com/docsz/AD_4nXcN4whFZWw__7Jcu1ZFLroGozU3aOis3_yqZemzeGohe36m7MbOm4P5UDKUJXsse21GA9R5O_mIBAyEA-DBPI3hajD3p2u-ZlXhsoKoxH-HVtpWGjnMnx3MxYrKao82zDj3vG24pBpBr_pBylKLhxZBZqnR?key=PQyhf6bQNwvGGmqHMQBcEw', '[\"Putih\", \"Cream\", \"Biru\", \"Hitam\"]', '[\"S\", \"M\", \"L\", \"XL\", \"XXL\"]', 'Vintage Outfit', '2025-02-08 10:09:54'),
(8, '70\'s Retro', 202000, '5', 'Ini adalah 70\'s Retro', 'https://gadingkostum.com/assets/upload/images/iaa0122.jpg', '[\"Putih\", \"Cream\", \"Biru\", \"Hitam\"]', '[\"S\", \"M\", \"L\", \"XL\", \"XXL\"]', 'Vintage Outfit', '2025-02-08 10:09:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(12) NOT NULL,
  `username` varchar(24) DEFAULT NULL,
  `email` varchar(24) DEFAULT NULL,
  `password` varchar(24) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
