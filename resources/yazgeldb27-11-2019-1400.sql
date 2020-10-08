-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 27 Kas 2019, 11:49:32
-- Sunucu sürümü: 10.1.21-MariaDB
-- PHP Sürümü: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `yazgeldb`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `aders`
--

CREATE TABLE `aders` (
  `id` int(11) NOT NULL,
  `dersId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `isActive` enum('A','P') COLLATE utf8_turkish_ci NOT NULL,
  `createDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bolumler`
--

CREATE TABLE `bolumler` (
  `id` int(11) NOT NULL,
  `bolumKodu` varchar(150) COLLATE utf8_turkish_ci NOT NULL,
  `bolumAdi` varchar(150) COLLATE utf8_turkish_ci NOT NULL,
  `fakulteId` int(11) NOT NULL,
  `isActive` enum('A','P') COLLATE utf8_turkish_ci NOT NULL DEFAULT 'P',
  `createDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dersler`
--

CREATE TABLE `dersler` (
  `id` int(11) NOT NULL,
  `dersKodu` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `dersAdi` varchar(150) COLLATE utf8_turkish_ci NOT NULL,
  `donemId` int(11) NOT NULL,
  `isActive` enum('A','P') COLLATE utf8_turkish_ci NOT NULL DEFAULT 'P',
  `createDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `donem`
--

CREATE TABLE `donem` (
  `id` int(11) NOT NULL,
  `yıl` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `donem` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `isActive` enum('A','P') COLLATE utf8_turkish_ci NOT NULL DEFAULT 'P',
  `createDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fakulte`
--

CREATE TABLE `fakulte` (
  `id` int(11) NOT NULL,
  `fakulteKodu` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `fakulteAdi` varchar(150) COLLATE utf8_turkish_ci NOT NULL,
  `isActive` enum('A','P') COLLATE utf8_turkish_ci NOT NULL DEFAULT 'P',
  `createDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `fakulte`
--

INSERT INTO `fakulte` (`id`, `fakulteKodu`, `fakulteAdi`, `isActive`, `createDate`) VALUES
(1, 'TEK1', 'Teknoloji Fakültesi', 'A', '2019-11-27 12:08:04');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notlar`
--

CREATE TABLE `notlar` (
  `id` int(11) NOT NULL,
  `aDersId` int(11) NOT NULL,
  `VFB` enum('V','F','B') COLLATE utf8_turkish_ci NOT NULL,
  `fileName` varchar(150) COLLATE utf8_turkish_ci NOT NULL,
  `createDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `profil`
--

CREATE TABLE `profil` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `ad` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `soyad` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `unvan` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `bolumNo` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `fakulteNo` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `resim` varchar(150) COLLATE utf8_turkish_ci NOT NULL,
  `createDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `profil`
--

INSERT INTO `profil` (`id`, `userId`, `ad`, `soyad`, `unvan`, `bolumNo`, `fakulteNo`, `resim`, `createDate`) VALUES
(3, 4, 'Ali', 'Veli', '', '12341234', '12341234', '1574542019-ali-veli.jpeg', '2019-11-23 23:46:59'),
(5, 6, 'Faruk', 'Bey', 'Dr. Ögr.', '123123', 'TEK1', '1574707473-faruk-bey.jpeg', '2019-11-25 21:44:33'),
(7, 8, 'ksci', 'leesin', '', '123', '123123', '1574838582-ksci-leesin.png', '2019-11-27 10:09:42');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `class` enum('admin','user') COLLATE utf8_turkish_ci NOT NULL DEFAULT 'user',
  `sicilNo` bigint(20) NOT NULL,
  `userName` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8 NOT NULL,
  `phoneNumber` varchar(20) CHARACTER SET utf8 NOT NULL,
  `isActive` enum('A','P') COLLATE utf8_turkish_ci NOT NULL DEFAULT 'P',
  `createDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `user`
--

INSERT INTO `user` (`id`, `class`, `sicilNo`, `userName`, `password`, `email`, `phoneNumber`, `isActive`, `createDate`) VALUES
(4, 'admin', 1231231231233, 'ali123', '25f9e794323b453885f5181f1b624d0b', 'asdsa@gmail.com', '5325631231', 'A', '2019-11-23 23:46:59'),
(6, 'admin', 54345345345, 'farukbey', '25f9e794323b453885f5181f1b624d0b', 'asd12sa@gmail.com', '5325631212', 'A', '2019-11-25 21:44:33'),
(8, 'user', 1231231231231, 'ksatarım', '2b405b99ae4e8670bea564d4413a3bcb', 'ksci@gmail.com', '5487123465', 'A', '2019-11-27 10:09:42');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `aders`
--
ALTER TABLE `aders`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `bolumler`
--
ALTER TABLE `bolumler`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bolumKodu` (`bolumKodu`);

--
-- Tablo için indeksler `dersler`
--
ALTER TABLE `dersler`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dersKodu` (`dersKodu`);

--
-- Tablo için indeksler `donem`
--
ALTER TABLE `donem`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `fakulte`
--
ALTER TABLE `fakulte`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fakulteKodu` (`fakulteKodu`);

--
-- Tablo için indeksler `notlar`
--
ALTER TABLE `notlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userId` (`userId`);

--
-- Tablo için indeksler `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sicilNo` (`sicilNo`),
  ADD UNIQUE KEY `userName` (`userName`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `aders`
--
ALTER TABLE `aders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `bolumler`
--
ALTER TABLE `bolumler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `dersler`
--
ALTER TABLE `dersler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `donem`
--
ALTER TABLE `donem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `fakulte`
--
ALTER TABLE `fakulte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `notlar`
--
ALTER TABLE `notlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Tablo için AUTO_INCREMENT değeri `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
