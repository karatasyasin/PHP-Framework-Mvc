-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 03 Haz 2021, 19:46:21
-- Sunucu sürümü: 10.4.18-MariaDB
-- PHP Sürümü: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `mvcproje`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `adresler`
--

CREATE TABLE `adresler` (
  `id` int(11) NOT NULL,
  `uyeid` int(11) NOT NULL,
  `adres` text COLLATE utf8_turkish_ci NOT NULL,
  `varsayilan` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `alt_kategori`
--

CREATE TABLE `alt_kategori` (
  `id` int(11) NOT NULL,
  `cocuk_kat_id` int(11) NOT NULL,
  `ana_kat_id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `alt_kategori`
--

INSERT INTO `alt_kategori` (`id`, `cocuk_kat_id`, `ana_kat_id`, `ad`) VALUES
(1, 1, 1, 'Tişört'),
(2, 1, 1, 'Pantolon'),
(3, 1, 1, 'Ceket'),
(4, 1, 1, 'Gömlek'),
(5, 2, 1, 'Atlet'),
(6, 2, 1, 'Boxer'),
(10, 3, 1, 'Klasik'),
(9, 3, 1, 'Spor'),
(11, 4, 2, 'Çamaşır'),
(12, 4, 2, 'İçlik'),
(13, 5, 2, 'Deri'),
(14, 5, 2, 'Kumaş'),
(15, 6, 2, 'Spor'),
(16, 6, 2, 'Klasik'),
(17, 6, 2, 'Deri Kordon'),
(18, 7, 3, 'Işıklı'),
(19, 7, 3, 'Spor'),
(20, 7, 3, 'İlk Adım'),
(21, 8, 3, 'Araba'),
(22, 8, 3, 'Bebek'),
(23, 8, 3, 'Tren'),
(24, 9, 3, 'Zıbın'),
(25, 9, 3, 'Tişört'),
(26, 9, 3, 'Pantolon');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ana_kategori`
--

CREATE TABLE `ana_kategori` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `ana_kategori`
--

INSERT INTO `ana_kategori` (`id`, `ad`) VALUES
(1, 'ERKEK'),
(2, 'KADIN'),
(3, 'ÇOCUK');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayarlar`
--

CREATE TABLE `ayarlar` (
  `id` int(11) NOT NULL,
  `title` varchar(150) COLLATE utf8_turkish_ci NOT NULL,
  `sayfaAciklama` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `anahtarKelime` text COLLATE utf8_turkish_ci NOT NULL,
  `uyelerGoruntuAdet` int(11) NOT NULL,
  `uyelerAramaAdet` int(11) NOT NULL,
  `uyelerYorumAdet` int(11) NOT NULL,
  `urunlerGoruntuAdet` int(11) NOT NULL,
  `urunlerAramaAdet` int(11) NOT NULL,
  `urunlerKategoriAdet` int(11) NOT NULL,
  `ArayuzUrunlerGoruntuAdet` int(11) NOT NULL,
  `uyeYorumAdet` int(11) NOT NULL,
  `bultenGoruntuAdet` int(11) NOT NULL,
  `bakimzaman` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `yedekzaman` varchar(30) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `ayarlar`
--

INSERT INTO `ayarlar` (`id`, `title`, `sayfaAciklama`, `anahtarKelime`, `uyelerGoruntuAdet`, `uyelerAramaAdet`, `uyelerYorumAdet`, `urunlerGoruntuAdet`, `urunlerAramaAdet`, `urunlerKategoriAdet`, `ArayuzUrunlerGoruntuAdet`, `uyeYorumAdet`, `bultenGoruntuAdet`, `bakimzaman`, `yedekzaman`) VALUES
(1, 'TEZ UYGULAMASI', 'PHP-Framework-MVC-E-ticaret', 'PHP, Framework, MVC, Eticaret, Egitim', 3, 3, 2, 8, 3, 3, 3, 3, 5, '04.05.2021-10:11', '04.05.2021-12:33');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bankabilgileri`
--

CREATE TABLE `bankabilgileri` (
  `id` int(11) NOT NULL,
  `banka_ad` varchar(30) NOT NULL,
  `hesap_ad` varchar(70) NOT NULL,
  `hesap_no` varchar(15) NOT NULL,
  `iban_no` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `bankabilgileri`
--

INSERT INTO `bankabilgileri` (`id`, `banka_ad`, `hesap_ad`, `hesap_no`, `iban_no`) VALUES
(1, 'İŞ BANKASI ', 'MARKET-İŞ BANKASI ', '34154241 ', 'TR00 0000 0000 0000 0000 0000 14 '),
(2, 'AKBANK', 'MARKET-AKBANK', '25415245', 'TR00 0000 0000 0000 0000 0000 19'),
(5, 'GARANTİ', 'MARKET-GARANTİ', '34154241 ', 'TR00 0000 0000 0000 0000 0000 29');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bulten`
--

CREATE TABLE `bulten` (
  `id` int(11) NOT NULL,
  `mailadres` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `tarih` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cocuk_kategori`
--

CREATE TABLE `cocuk_kategori` (
  `id` int(11) NOT NULL,
  `ana_kat_id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `cocuk_kategori`
--

INSERT INTO `cocuk_kategori` (`id`, `ana_kat_id`, `ad`) VALUES
(1, 1, 'Dış Giyim'),
(2, 1, 'İç Giyim'),
(3, 1, 'Ayakkabı'),
(4, 2, 'İç Giyim'),
(5, 2, 'Çanta'),
(6, 2, 'Saat'),
(7, 3, 'Ayakkabı'),
(8, 3, 'Oyuncak'),
(9, 3, 'Giyim');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `iletisim`
--

CREATE TABLE `iletisim` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `mail` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `konu` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `mesaj` text COLLATE utf8_turkish_ci NOT NULL,
  `tarih` varchar(20) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pazarlama_mail_gruplar`
--

CREATE TABLE `pazarlama_mail_gruplar` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `pazarlama_mail_gruplar`
--

INSERT INTO `pazarlama_mail_gruplar` (`id`, `ad`) VALUES
(1, 'Mail-Erkekler Grubu'),
(2, 'Mail-Kadınlar Grubu'),
(3, 'Mail-Çocuklar Grubu');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pazarlama_mail_sablonlar`
--

CREATE TABLE `pazarlama_mail_sablonlar` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) NOT NULL,
  `icerik` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `pazarlama_mail_sablonlar`
--

INSERT INTO `pazarlama_mail_sablonlar` (`id`, `ad`, `icerik`) VALUES
(1, 'Mail-Bayram Kutlama', 'Mail-Bayramınız Mübarek olsun. Değerli üyemiz..'),
(2, 'Mail-Genel Kampanya Yeni', 'Mail-Yeni fırsatlar...'),
(3, 'Mail-İndirim', 'Mail-Patron çıldırdı..');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `renkyonetimi`
--

CREATE TABLE `renkyonetimi` (
  `id` int(11) NOT NULL,
  `header` varchar(6) NOT NULL,
  `sepet` varchar(6) NOT NULL,
  `kategoriic` varchar(6) NOT NULL,
  `sepeteeklebuton` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `renkyonetimi`
--

INSERT INTO `renkyonetimi` (`id`, `header`, `sepet`, `kategoriic`, `sepeteeklebuton`) VALUES
(1, '9056F7', 'E5DDE7', 'C381D8', 'B29AB9');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparisler`
--

CREATE TABLE `siparisler` (
  `id` int(11) NOT NULL,
  `siparis_no` int(11) NOT NULL,
  `adresid` int(11) NOT NULL,
  `uyeid` int(11) NOT NULL,
  `urunad` varchar(30) COLLATE utf8_turkish_ci NOT NULL,
  `urunadet` int(11) NOT NULL,
  `urunfiyat` int(11) NOT NULL,
  `toplamfiyat` int(11) NOT NULL,
  `kargodurum` int(11) NOT NULL DEFAULT 0,
  `odemeturu` varchar(10) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL DEFAULT 0,
  `tarih` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `resim` varchar(100) NOT NULL,
  `sloganUst` varchar(50) NOT NULL,
  `sloganAlt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `slider`
--

INSERT INTO `slider` (`id`, `resim`, `sloganUst`, `sloganAlt`) VALUES
(1, 'res1.jpg', 'resim 1 slogan Ust', 'resim 1 slogan Alt'),
(2, 'res2.jpg', 'resim 2 slogan Ust', 'resim 2 slogan Alt'),
(3, 'res3.jpg', 'resim 3 slogan Ust', 'resim 3 slogan Alt');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `teslimatbilgileri`
--

CREATE TABLE `teslimatbilgileri` (
  `id` int(11) NOT NULL,
  `siparis_no` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `soyad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `mail` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `telefon` varchar(20) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE `urunler` (
  `id` int(11) NOT NULL,
  `ana_kat_id` int(11) NOT NULL,
  `cocuk_kat_id` int(11) NOT NULL,
  `katid` int(11) NOT NULL,
  `urunad` varchar(80) CHARACTER SET utf8 NOT NULL,
  `res1` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `res2` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `res3` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL DEFAULT 0,
  `aciklama` text COLLATE utf8_turkish_ci NOT NULL,
  `kumas` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `urtYeri` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `renk` varchar(10) COLLATE utf8_turkish_ci NOT NULL,
  `fiyat` float NOT NULL,
  `stok` int(11) NOT NULL,
  `ozellik` text COLLATE utf8_turkish_ci NOT NULL,
  `ekstraBilgi` text COLLATE utf8_turkish_ci NOT NULL,
  `satisadet` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`id`, `ana_kat_id`, `cocuk_kat_id`, `katid`, `urunad`, `res1`, `res2`, `res3`, `durum`, `aciklama`, `kumas`, `urtYeri`, `renk`, `fiyat`, `stok`, `ozellik`, `ekstraBilgi`, `satisadet`) VALUES
(1, 1, 1, 1, 'Beyaz Tişört', '1.png', '2.png', '3.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Beyaz', 380, 9999, 'Beyaz Tişört için özellikler', 'Beyaz Tişört için ekstra bilgi', 10),
(3, 1, 1, 2, 'Kumaş Pantolon', '7.png', '8.png', '9.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Likra', 'Afrika', 'pembe', 140, 10000, 'Pembe Tişört için özellikler', 'Pembe Tişört için ekstra bilgi', 5),
(4, 1, 1, 2, 'Kot Pantolon', '10.png', '11.png', '12.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Sarı', 90, 100, 'Kırmızı Tişört için özellikler', 'Kırmızı Tişört için ekstra bilgi', 8),
(5, 1, 1, 3, 'Keten Ceket', '13.png', '14.png', '15.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 9),
(6, 1, 1, 3, 'Kumaş Ceket', '16.png', '17.png', '18.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(9, 1, 1, 9, 'Mor Tişört', 'p9.jpg', 'l1.jpg', 'p9.jpg', 1, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Mor', 157, 10000, 'Mor Tişört için özellikler', 'Mor Tişört için ekstra bilgi', 0),
(10, 1, 1, 4, 'Keten Gömlek', '19.png', '20.png', '21.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Beyaz', 380, 10000, 'Beyaz Tişört için özellikler', 'Beyaz Tişört için ekstra bilgi', 0),
(11, 1, 1, 4, 'Yazlık Gömlek', '22.png', '23.png', '24.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Sarı', 270, 10000, 'Sarı Tişört için özellikler', 'Sarı Tişört için ekstra bilgi', 0),
(12, 1, 2, 5, 'Beyaz Atlet', '25.png', '26.png', '27.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Likra', 'Afrika', 'pembe', 140, 10000, 'Pembe Tişört için özellikler', 'Pembe Tişört için ekstra bilgi', 0),
(13, 1, 2, 5, 'Kırmızı Atlet', '28.png', '29.png', '30.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Sarı', 90, 10000, 'Kırmızı Tişört için özellikler', 'Kırmızı Tişört için ekstra bilgi', 0),
(14, 1, 2, 6, 'Keten Ceket', '31.png', '32.png', '33.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(15, 1, 2, 6, 'Kumaş Ceket', '34.png', '35.png', '36.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(16, 1, 3, 10, 'Sarı', '37.png', '38.png', '39.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Likra', 'Afrika', 'pembe', 140, 10000, 'Pembe Tişört için özellikler', 'Pembe Tişört için ekstra bilgi', 0),
(17, 1, 3, 10, 'Kahverengi', '40.png', '41.png', '42.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Sarı', 90, 10000, 'Kırmızı Tişört için özellikler', 'Kırmızı Tişört için ekstra bilgi', 0),
(18, 1, 3, 9, 'Nike-Beyaz', '43.png', '44.png', '45.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(19, 1, 3, 9, 'Adidas-Mavi', '46.png', '47.png', '48.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(20, 2, 4, 11, 'Çamaşır-1', '49.png', '50.png', '51.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Likra', 'Afrika', 'pembe', 140, 10000, 'Pembe Tişört için özellikler', 'Pembe Tişört için ekstra bilgi', 0),
(21, 2, 4, 11, 'Çamaşır-1', '52.png', '53.png', '54.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Sarı', 90, 10000, 'Kırmızı Tişört için özellikler', 'Kırmızı Tişört için ekstra bilgi', 0),
(22, 2, 4, 12, 'X MODEL', '55.png', '56.png', '57.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(23, 2, 4, 12, 'Y MODEL', '58.png', '59.png', '60.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(24, 2, 5, 13, 'Timsah Derisi', '61.png', '62.png', '63.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Likra', 'Afrika', 'pembe', 140, 10000, 'Pembe Tişört için özellikler', 'Pembe Tişört için ekstra bilgi', 0),
(25, 2, 5, 13, 'Sinek Derisi', '64.png', '65.png', '66.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Sarı', 90, 10000, 'Kırmızı Tişört için özellikler', 'Kırmızı Tişört için ekstra bilgi', 0),
(26, 2, 5, 14, 'Keten', '67.png', '68.png', '69.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(27, 2, 5, 14, 'Bez', '70.png', '71.png', '72.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(28, 2, 6, 15, 'Kırmızı', '73.png', '74.png', '75.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Likra', 'Afrika', 'pembe', 140, 10000, 'Pembe Tişört için özellikler', 'Pembe Tişört için ekstra bilgi', 0),
(29, 2, 6, 15, 'Turkuaz', '76.png', '77.png', '78.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Sarı', 90, 10000, 'Kırmızı Tişört için özellikler', 'Kırmızı Tişört için ekstra bilgi', 0),
(30, 2, 6, 16, 'X MODEL', '79.png', '80.png', '81.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(31, 2, 6, 16, 'Y MODEL', '82.png', '83.png', '84.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(32, 2, 6, 17, 'Yerli Üretim', '85.png', '86.png', '87.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(33, 2, 6, 17, 'İthal', '88.png', '89.png', '90.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(34, 3, 7, 18, 'Mavi', '91.png', '92.png', '93.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(35, 3, 7, 18, 'Kırmızı', '94.png', '95.png', '96.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(36, 3, 7, 19, 'Işıklı', '97.png', '98.png', '99.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Likra', 'Afrika', 'pembe', 140, 10000, 'Pembe Tişört için özellikler', 'Pembe Tişört için ekstra bilgi', 0),
(37, 3, 7, 19, 'Normal', '100.png', '101.png', '102.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Sarı', 90, 10000, 'Kırmızı Tişört için özellikler', 'Kırmızı Tişört için ekstra bilgi', 0),
(38, 3, 7, 20, '0-3 Yaş', '103.png', '104.png', '105.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(39, 3, 7, 20, '3-6 Yaş', '106.png', '107.png', '108.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(40, 3, 8, 21, 'Metal', '109.png', '110.png', '111.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 190, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(41, 3, 8, 21, 'Tahta', '112.png', '113.png', '114.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(43, 3, 8, 22, 'Benekli', '118.png', '119.png', '120.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 9997, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(44, 3, 8, 23, 'Kara Tren', '121.png', '122.png', '123.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 189, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(45, 3, 8, 23, 'Tahta Tren', '124.png', '125.png', '126.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 10000, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(46, 3, 9, 24, 'Yeni Doğan', '127.png', '128.png', '129.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Likra', 'Afrika', 'pembe', 140, 9999, 'Pembe Tişört için özellikler', 'Pembe Tişört için ekstra bilgi', 0),
(47, 3, 9, 24, 'Pamuklu', '130.png', '131.png', '132.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Saten', 'Kamboçya', 'Sarı', 90, 9998, 'Kırmızı Tişört için özellikler', 'Kırmızı Tişört için ekstra bilgi', 0),
(48, 3, 9, 25, 'Polo', '133.png', '134.png', '135.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, 185, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(49, 3, 9, 25, 'Pamuk', '136.png', '137.png', '138.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 9996, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0),
(50, 3, 9, 26, 'Kot Pantolon', '139.png', '140.png', '141.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Pamuk', 'Çin', 'Gri', 147, -5, 'Gri Tişört için özellikler', 'Gri Tişört için ekstra bilgi', 0),
(51, 1, 3, 9, 'Kumaş Pantolon', '142.png', '143.png', '144.png', 0, 'ÜRÜN HAKKINDA AÇIKLAMA=Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo\r\n\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever', 'Keten', 'Uganda', 'Mavi', 169, 9991, 'Mavi Tişört için özellikler', 'Mavi Tişört için ekstra bilgi', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uye_panel`
--

CREATE TABLE `uye_panel` (
  `id` int(11) NOT NULL,
  `ad` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  `soyad` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `telefon` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL DEFAULT 1,
  `mailgrup` int(11) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `uye_panel`
--

INSERT INTO `uye_panel` (`id`, `ad`, `soyad`, `mail`, `sifre`, `telefon`, `durum`, `mailgrup`) VALUES
(14, 'yasin', 'karatas', 'tezmvcmarket@gmail.com', 'q5ijvc1oU5CRScAmNgZuacZfAA==', '05301112233', 1, 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yonetim`
--

CREATE TABLE `yonetim` (
  `id` int(11) NOT NULL,
  `ad` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `yetki` int(11) NOT NULL,
  `siparisYonetim` int(11) NOT NULL DEFAULT 0,
  `kategoriYonetim` int(11) NOT NULL DEFAULT 0,
  `uyeYonetim` int(11) NOT NULL DEFAULT 0,
  `urunYonetim` int(11) NOT NULL DEFAULT 0,
  `muhasebeYonetim` int(11) NOT NULL DEFAULT 0,
  `yoneticiYonetim` int(11) NOT NULL DEFAULT 0,
  `bultenYonetim` int(11) NOT NULL DEFAULT 0,
  `sistemayarYonetim` int(11) NOT NULL DEFAULT 0,
  `sistembakimYonetim` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `yonetim`
--

INSERT INTO `yonetim` (`id`, `ad`, `sifre`, `yetki`, `siparisYonetim`, `kategoriYonetim`, `uyeYonetim`, `urunYonetim`, `muhasebeYonetim`, `yoneticiYonetim`, `bultenYonetim`, `sistemayarYonetim`, `sistembakimYonetim`) VALUES
(10, 'yasin', 'q5ijvc1oU5CRScAmNgZuacZfAA==', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(16, 'veli', 'q5ijvc1oU5CRScAmNgZuacZfAA==', 2, 0, 0, 0, 1, 0, 0, 1, 0, 0),
(19, 'ahmet', 'q5ijvc1oU5CRScAmNgZuacZfAA==', 3, 0, 0, 1, 0, 0, 0, 1, 0, 0),
(20, 'mehmet', 'q5ijvc1oU5CRScAmNgZuacZfAA==', 2, 1, 0, 0, 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `id` int(11) NOT NULL,
  `uyeid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `ad` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  `icerik` text COLLATE utf8_turkish_ci NOT NULL,
  `tarih` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `adresler`
--
ALTER TABLE `adresler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `alt_kategori`
--
ALTER TABLE `alt_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ana_kategori`
--
ALTER TABLE `ana_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ayarlar`
--
ALTER TABLE `ayarlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `bankabilgileri`
--
ALTER TABLE `bankabilgileri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `bulten`
--
ALTER TABLE `bulten`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `cocuk_kategori`
--
ALTER TABLE `cocuk_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `iletisim`
--
ALTER TABLE `iletisim`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `pazarlama_mail_gruplar`
--
ALTER TABLE `pazarlama_mail_gruplar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `pazarlama_mail_sablonlar`
--
ALTER TABLE `pazarlama_mail_sablonlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `renkyonetimi`
--
ALTER TABLE `renkyonetimi`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `siparisler`
--
ALTER TABLE `siparisler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `teslimatbilgileri`
--
ALTER TABLE `teslimatbilgileri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `uye_panel`
--
ALTER TABLE `uye_panel`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yonetim`
--
ALTER TABLE `yonetim`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `adresler`
--
ALTER TABLE `adresler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `alt_kategori`
--
ALTER TABLE `alt_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Tablo için AUTO_INCREMENT değeri `ana_kategori`
--
ALTER TABLE `ana_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `ayarlar`
--
ALTER TABLE `ayarlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `bankabilgileri`
--
ALTER TABLE `bankabilgileri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `bulten`
--
ALTER TABLE `bulten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- Tablo için AUTO_INCREMENT değeri `cocuk_kategori`
--
ALTER TABLE `cocuk_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `iletisim`
--
ALTER TABLE `iletisim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `pazarlama_mail_gruplar`
--
ALTER TABLE `pazarlama_mail_gruplar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `pazarlama_mail_sablonlar`
--
ALTER TABLE `pazarlama_mail_sablonlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `renkyonetimi`
--
ALTER TABLE `renkyonetimi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `siparisler`
--
ALTER TABLE `siparisler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Tablo için AUTO_INCREMENT değeri `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `teslimatbilgileri`
--
ALTER TABLE `teslimatbilgileri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Tablo için AUTO_INCREMENT değeri `uye_panel`
--
ALTER TABLE `uye_panel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `yonetim`
--
ALTER TABLE `yonetim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
