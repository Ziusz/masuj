-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 15 Sty 2023, 13:17
-- Wersja serwera: 5.7.40-0ubuntu0.18.04.1
-- Wersja PHP: 7.2.24-0ubuntu0.18.04.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `masujmnie_app`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `availability`
--

CREATE TABLE `availability` (
  `id` int(11) NOT NULL,
  `masseur_id` int(11) NOT NULL,
  `monday` tinyint(1) NOT NULL,
  `monday_start` time NOT NULL,
  `monday_stop` time NOT NULL,
  `tuesday` tinyint(1) NOT NULL,
  `tuesday_start` time NOT NULL,
  `tuesday_stop` time NOT NULL,
  `wednesday` tinyint(1) NOT NULL,
  `wednesday_start` time NOT NULL,
  `wednesday_stop` time NOT NULL,
  `thursday` tinyint(1) NOT NULL,
  `thursday_start` time NOT NULL,
  `thursday_stop` time NOT NULL,
  `friday` tinyint(1) NOT NULL,
  `friday_start` time NOT NULL,
  `friday_stop` time NOT NULL,
  `saturday` tinyint(1) NOT NULL,
  `saturday_start` time NOT NULL,
  `saturday_stop` time NOT NULL,
  `sunday` tinyint(1) NOT NULL,
  `sunday_start` time NOT NULL,
  `sunday_stop` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `availability`
--

INSERT INTO `availability` (`id`, `masseur_id`, `monday`, `monday_start`, `monday_stop`, `tuesday`, `tuesday_start`, `tuesday_stop`, `wednesday`, `wednesday_start`, `wednesday_stop`, `thursday`, `thursday_start`, `thursday_stop`, `friday`, `friday_start`, `friday_stop`, `saturday`, `saturday_start`, `saturday_stop`, `sunday`, `sunday_start`, `sunday_stop`) VALUES
(1, 2, 0, '10:00:00', '16:00:00', 0, '10:00:00', '16:00:00', 0, '10:00:00', '16:30:00', 1, '15:00:00', '22:00:00', 1, '09:00:00', '22:30:00', 0, '10:00:00', '18:30:00', 1, '17:00:00', '17:30:00'),
(2, 3, 1, '10:00:00', '18:45:00', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00', 0, '00:00:00', '00:00:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `district` varchar(255) COLLATE utf8_polish_ci NOT NULL DEFAULT 'Ca??e miasto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `cities`
--

INSERT INTO `cities` (`id`, `name`, `district`) VALUES
(1, 'Warszawa', 'Bemowo'),
(2, 'Warszawa', 'Bia??o????ka'),
(3, 'Warszawa', 'Bielany'),
(4, 'Warszawa', 'Mokot??w'),
(5, 'Warszawa', 'Ochota'),
(6, 'Warszawa', 'Praga-Po??udnie'),
(7, 'Warszawa', 'Praga-P????noc'),
(8, 'Warszawa', 'Rembert??w'),
(9, 'Warszawa', 'Targ??wek'),
(10, 'Warszawa', 'Ursus'),
(11, 'Krak??w', 'Bie??czyce'),
(12, 'Krak??w', 'Bie??an??w-Prokocim'),
(13, 'Krak??w', 'Pr??dnik Bia??y'),
(14, 'Krak??w', '??agiewniki-Borek Fa????cki'),
(15, 'Krak??w', 'Bronowice'),
(16, 'Krak??w', 'Czy??yny'),
(17, 'Krak??w', 'Pr??dnik Czerwony'),
(18, 'Krak??w', 'D??bniki'),
(19, 'Krak??w', 'Podg??rze Duchackie'),
(20, 'Krak??w', 'Grzeg??rzki'),
(21, '????d??', 'Ba??uty'),
(22, '????d??', 'G??rna'),
(23, '????d??', 'Polesie'),
(24, '????d??', 'Widzew'),
(25, '????d??', '??r??dmie??cie'),
(26, 'Wroc??aw', 'Fabryczna'),
(27, 'Wroc??aw', 'Krzyki'),
(28, 'Wroc??aw', 'Stare Miasto'),
(29, 'Wroc??aw', 'Psie Pole'),
(30, 'Wroc??aw', '??r??dmie??cie'),
(31, 'Pozna??', 'Chartowo'),
(32, 'Pozna??', 'D??biec'),
(33, 'Pozna??', 'G??rczyn'),
(34, 'Pozna??', 'Grunwald'),
(35, 'Pozna??', 'Junikowo'),
(36, 'Pozna??', 'Je??yce'),
(37, 'Pozna??', 'Komandoria'),
(38, 'Pozna??', 'Stare Miasto'),
(39, 'Pozna??', 'Naramowice'),
(40, 'Pozna??', 'Ogrody'),
(41, 'Gda??sk', 'Anio??ki'),
(42, 'Gda??sk', 'Br??towo'),
(43, 'Gda??sk', 'Brze??no'),
(44, 'Gda??sk', 'Che??m (Gda??sk Po??udnie)'),
(45, 'Gda??sk', 'VII Dw??r'),
(46, 'Gda??sk', 'Krakowiec - G??rki Zachodnie'),
(47, 'Gda??sk', '??abianka - Wejhera - Jelitkowo - Tysi??clecia'),
(48, 'Gda??sk', 'Jasie??'),
(49, 'Gda??sk', 'Kokoszki'),
(50, 'Gda??sk', 'Orunia - ??w. Wojciech - Lipce'),
(51, 'Szczecin', 'Bukowo'),
(52, 'Szczecin', 'Bukowe'),
(53, 'Szczecin', 'Centrum'),
(54, 'Szczecin', 'D??bie'),
(55, 'Szczecin', 'Gumie??ce'),
(56, 'Szczecin', 'Gol??cino'),
(57, 'Szczecin', 'Krzekowo'),
(58, 'Szczecin', 'Kijewo'),
(59, 'Szczecin', 'Majowe'),
(60, 'Szczecin', 'Niebuszewo'),
(61, 'Bydgoszcz', 'Ca??e miasto'),
(62, 'Lublin', 'Ca??e miasto'),
(63, 'Bia??ystok', 'Antoniuk'),
(64, 'Bia??ystok', 'Bacieczki'),
(65, 'Bia??ystok', 'Bema'),
(66, 'Bia??ystok', 'Bia??ostoczek'),
(67, 'Bia??ystok', 'Bojary'),
(68, 'Bia??ystok', 'Centrum'),
(69, 'Bia??ystok', 'Dojlidy G??rne'),
(70, 'Bia??ystok', 'Dziesi??ciny II'),
(71, 'Bia??ystok', 'Le??na Dolina'),
(72, 'Bia??ystok', 'Dziesi??ciny I'),
(73, 'Katowice', 'Bogucice'),
(74, 'Katowice', 'Za????ska Ha??da-Bryn??w'),
(75, 'Katowice', 'Szopienice-Burowiec'),
(76, 'Katowice', 'Bryn??w-Osiedle Zgrzebioka'),
(77, 'Katowice', 'D??br??wka Ma??a'),
(78, 'Katowice', 'D??b'),
(79, 'Katowice', 'Giszowiec'),
(80, 'Katowice', 'We??nowiec-J??zefowiec'),
(81, 'Katowice', 'Jan??w-Nikiszowiec'),
(82, 'Katowice', 'Kostuchna'),
(83, 'Gdynia', 'Babie Do??y'),
(84, 'Gdynia', 'Pustki Cisowskie-Demptowo'),
(85, 'Gdynia', 'Chwarzno-Wiczlino'),
(86, 'Gdynia', 'Cisowa'),
(87, 'Gdynia', 'Chylonia'),
(88, 'Gdynia', 'Dzia??ki Le??ne'),
(89, 'Gdynia', 'D??browa'),
(90, 'Gdynia', 'Kamienna G??ra'),
(91, 'Gdynia', 'Grab??wek'),
(92, 'Gdynia', 'Wielki Kack'),
(93, 'Cz??stochowa', 'Wyczerpy - Anio????w'),
(94, 'Cz??stochowa', 'B??eszno'),
(95, 'Cz??stochowa', 'Zawodzie - D??bie'),
(96, 'Cz??stochowa', 'D??b??w'),
(97, 'Cz??stochowa', 'Grab??wka'),
(98, 'Cz??stochowa', 'Ostatni Grosz'),
(99, 'Cz??stochowa', 'Kiedrzyn'),
(100, 'Cz??stochowa', 'Kawodrza'),
(101, 'Cz??stochowa', 'Lisiniec'),
(102, 'Cz??stochowa', 'Mir??w'),
(103, 'Radom', 'Ca??e miasto'),
(104, 'Toru??', 'Ca??e miasto'),
(105, 'Sosnowiec', 'Ca??e miasto'),
(106, 'Kielce', 'Ca??e miasto'),
(107, 'Rzesz??w', 'Ca??e miasto'),
(108, 'Warszawa', '??r??dmie??cie'),
(109, 'Warszawa', 'Wilan??w'),
(110, 'Warszawa', 'W??ochy'),
(111, 'Warszawa', '??oliborz'),
(112, 'Warszawa', 'Ursyn??w'),
(113, 'Warszawa', 'Wawer'),
(114, 'Warszawa', 'Weso??a');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `delay` int(11) NOT NULL,
  `cycle` int(11) NOT NULL DEFAULT '30',
  `activated_to` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `companies`
--

INSERT INTO `companies` (`id`, `owner_id`, `name`, `delay`, `cycle`, `activated_to`) VALUES
(1, 2, 'Testowa Firma', 6, 30, '2031-08-03 06:30:43');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `masseur_id` int(11) NOT NULL,
  `polish` tinyint(1) NOT NULL,
  `english` tinyint(1) NOT NULL,
  `german` tinyint(1) NOT NULL,
  `italian` tinyint(1) NOT NULL,
  `french` tinyint(1) NOT NULL,
  `ukrainian` tinyint(1) NOT NULL,
  `russian` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `languages`
--

INSERT INTO `languages` (`id`, `masseur_id`, `polish`, `english`, `german`, `italian`, `french`, `ukrainian`, `russian`) VALUES
(1, 2, 1, 0, 0, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `masseurcities`
--

CREATE TABLE `masseurcities` (
  `id` int(11) NOT NULL,
  `masseur_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `masseurcities`
--

INSERT INTO `masseurcities` (`id`, `masseur_id`, `city_id`) VALUES
(21, 3, 23),
(22, 3, 21),
(25, 3, 24),
(26, 3, 25),
(27, 3, 106),
(28, 3, 107),
(29, 2, 23),
(30, 3, 1),
(31, 2, 1),
(32, 2, 2),
(33, 2, 3),
(34, 2, 4),
(35, 2, 5),
(36, 2, 6),
(37, 2, 7),
(38, 2, 8),
(39, 2, 9),
(40, 2, 10),
(41, 2, 108),
(42, 2, 109),
(43, 2, 110),
(44, 2, 111),
(45, 2, 112),
(46, 2, 113),
(47, 2, 114),
(48, 2, 14),
(49, 2, 16),
(50, 2, 112),
(51, 2, 113),
(52, 2, 21),
(53, 2, 22),
(54, 2, 23),
(55, 2, 24),
(56, 2, 25);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text COLLATE utf8_polish_ci NOT NULL,
  `seen` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `content`, `seen`) VALUES
(3, 3, 'Dzi??kujemy za z??o??enie rezerwacji! Otrzymasz powiadomienie, gdy masa??ysta potwierdzi twoj?? wizyt??.', 0),
(4, 2, 'Masz now?? rezerwacj??!\nData i godzina: 22.01.2022 23:00\nImi?? i nazwisko: Test Testowy\nAdres: , Pozna??\nNumer telefonu: 1492481\nAdres e-mail: test@test.com', 1),
(5, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 1),
(6, 2, 'Twoja rezerwacja zosta??a odrzucona.', 1),
(7, 2, 'Zmieniono termin rezerwacji z 2022-01-19 02:49:00 na 25.01.2022 04:50', 1),
(8, 2, 'Zmieniono termin rezerwacji z 2022-01-19 02:49:00 na 25.01.2022 04:50', 1),
(9, 2, 'Zmieniono termin rezerwacji z 25.01.2022 04:50 na 26.01.2022 12:15', 1),
(10, 2, 'Zmieniono termin rezerwacji z 25.01.2022 04:50 na 26.01.2022 12:15', 1),
(11, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 1),
(12, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 1),
(13, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 1),
(14, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 1),
(15, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 1),
(16, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 1),
(17, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 1),
(18, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 1),
(19, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 1),
(20, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 1),
(21, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 1),
(22, 2, 'Dzi??kujemy za z??o??enie rezerwacji! Otrzymasz powiadomienie, gdy masa??ysta potwierdzi twoj?? wizyt??.', 0),
(23, 2, 'Masz now?? rezerwacj??!\nData i godzina: 22.01.2022 06:51\nImi?? i nazwisko: Test Testowy\nAdres: qwqw, Pabianice\nNumer telefonu: +481298129\nAdres e-mail: admin@test.com', 1),
(24, 2, 'Dzi??kujemy za z??o??enie rezerwacji! Otrzymasz powiadomienie, gdy masa??ysta potwierdzi twoj?? wizyt??.', 1),
(25, 2, 'Masz now?? rezerwacj??!\nData i godzina: 22.01.2022 00:00\nImi?? i nazwisko: Test Testowy\nAdres: qwqw, Pabianice\nNumer telefonu: +481298129\nAdres e-mail: admin@test.com', 1),
(26, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 0),
(27, 2, 'Twoja rezerwacja zosta??a odrzucona.', 0),
(28, 6, 'Dzi??kujemy za z??o??enie rezerwacji! Otrzymasz powiadomienie, gdy masa??ysta potwierdzi twoj?? wizyt??.', 1),
(29, 2, 'Masz now?? rezerwacj??!\nData i godzina: 2022-01-29 15:30\nImi?? i nazwisko: Klient Typowy\nAdres: ul. Kliencka 13, Klientowo\nNumer telefonu: 000\nAdres e-mail: klient@test.com', 0),
(30, 6, 'Zmieniono termin rezerwacji z 29.01.2022 15:30 na 28.01.2022 22:08', 1),
(31, 2, 'Zmieniono termin rezerwacji z 29.01.2022 15:30 na 28.01.2022 22:08', 0),
(32, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 0),
(33, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 0),
(34, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 0),
(35, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 0),
(36, 2, 'Twoja rezerwacja zosta??a zaakceptowana.', 0),
(37, 2, 'Twoja rezerwacja zosta??a odrzucona.', 0),
(38, 2, 'Twoja rezerwacja zosta??a odrzucona.', 0),
(39, 2, 'Twoja rezerwacja zosta??a odrzucona.', 0),
(40, 5, 'Dzi??kujemy za z??o??enie rezerwacji! Otrzymasz powiadomienie, gdy masa??ysta potwierdzi twoj?? wizyt??.', 1),
(41, 5, 'Dzi??kujemy za z??o??enie rezerwacji! Otrzymasz powiadomienie, gdy masa??ysta potwierdzi twoj?? wizyt??.', 0),
(42, 2, 'Masz now?? rezerwacj??!\nData i godzina: 2022-01-28 17:30\nImi?? i nazwisko: Admin Adminowy\nAdres: Test, test\nNumer telefonu: +48000\nAdres e-mail: admin@test.com', 0),
(43, 5, 'Dzi??kujemy za z??o??enie rezerwacji! Otrzymasz powiadomienie, gdy masa??ysta potwierdzi twoj?? wizyt??.', 0),
(44, 2, 'Masz now?? rezerwacj??!\nData i godzina: 2022-02-18 18:00\nImi?? i nazwisko: Admin Adminowy\nAdres: Test, test\nNumer telefonu: +48000\nAdres e-mail: admin@test.com', 0),
(45, 5, 'Dzi??kujemy za z??o??enie rezerwacji! Otrzymasz powiadomienie, gdy masa??ysta potwierdzi twoj?? wizyt??.', 0),
(46, 2, 'Masz now?? rezerwacj??!\nData i godzina: 2022-02-11 17:30\nImi?? i nazwisko: Admin Adminowy\nAdres: Test, test\nNumer telefonu: +48000\nAdres e-mail: admin@test.com', 0),
(47, 5, 'Zmieniono termin rezerwacji z 21.01.2022 15:00 na 21.01.2022 15:00', 0),
(48, 2, 'Zmieniono termin rezerwacji z 21.01.2022 15:00 na 21.01.2022 15:00', 0),
(49, 2, 'Dzi??kujemy za z??o??enie rezerwacji! Otrzymasz powiadomienie, gdy masa??ysta potwierdzi twoj?? wizyt??.', 0),
(50, 2, 'Masz now?? rezerwacj??!\nData i godzina: 2022-09-15 18:30\nImi?? i nazwisko: Test Kierownik\nAdres: qwqw, Pabianice\nNumer telefonu: +481298129\nAdres e-mail: kierownik@test.com', 0),
(51, 5, 'Dzi??kujemy za z??o??enie rezerwacji! Otrzymasz powiadomienie, gdy masa??ysta potwierdzi twoj?? wizyt??.', 0),
(52, 2, 'Masz now?? rezerwacj??!\nData i godzina: 2022-09-18 17:00\nImi?? i nazwisko: Admin Adminowy\nAdres: Test, test\nNumer telefonu: +48000\nAdres e-mail: admin@test.com', 0),
(53, 5, 'Dzi??kujemy za z??o??enie rezerwacji! Otrzymasz powiadomienie, gdy masa??ysta potwierdzi twoj?? wizyt??.', 0),
(54, 2, 'Masz now?? rezerwacj??!\nData i godzina: 2022-09-22 15:00\nImi?? i nazwisko: Admin Adminowy\nAdres: Test, test\nNumer telefonu: +48000\nAdres e-mail: admin@test.com', 0),
(55, 2, 'Dzi??kujemy za z??o??enie rezerwacji! Otrzymasz powiadomienie, gdy masa??ysta potwierdzi twoj?? wizyt??.', 0),
(56, 2, 'Masz now?? rezerwacj??!\nData i godzina: 2023-01-27 12:00\nImi?? i nazwisko: Test Kierownik\nAdres: qwqw, Pabianice\nNumer telefonu: +481298129\nAdres e-mail: kierownik@test.com', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dotpay_id` varchar(16) COLLATE utf8_polish_ci NOT NULL,
  `date` datetime NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `dotpay_id`, `date`, `amount`) VALUES
(1, 2, 'M9957-18718', '2022-01-22 14:31:12', 300),
(2, 2, 'M9944-27942', '2022-01-22 15:01:26', 100),
(3, 2, 'M9944-27955', '2022-01-22 14:57:58', 300),
(4, 2, 'M9998-10118', '2022-01-22 15:16:11', 1200),
(5, 2, 'M9944-27942', '2022-01-22 15:01:26', 100),
(6, 2, 'M9998-10120', '2022-01-22 15:11:33', 1200),
(7, 2, 'M9965-61155', '2022-01-22 14:02:03', 100),
(8, 2, 'M9965-94962', '2022-01-22 14:02:19', 300),
(9, 2, 'M9965-94961', '2022-01-22 14:02:28', 1200),
(10, 2, 'M9957-18724', '2022-01-22 14:28:39', 1200),
(11, 2, 'M9957-18723', '2022-01-22 14:29:11', 300),
(12, 2, 'M9957-18722', '2022-01-22 14:29:42', 300),
(13, 2, 'M9998-10119', '2022-01-22 15:15:23', 1200),
(14, 2, 'M9944-27940', '2022-01-22 15:05:28', 1200),
(15, 2, 'M9998-10118', '2022-01-22 15:16:11', 1200),
(16, 2, 'M9957-18718', '2022-01-22 14:31:12', 300),
(17, 2, 'M9944-27958', '2022-01-22 14:55:41', 1200),
(18, 2, 'M9998-10120', '2022-01-22 15:11:33', 1200),
(19, 2, 'M9944-27955', '2022-01-22 14:57:58', 300),
(20, 2, 'M9960-62276', '2022-01-22 14:39:23', 1200),
(21, 2, 'M9960-62275', '2022-01-22 14:40:09', 1200),
(22, 2, 'M9998-10119', '2022-01-22 15:15:23', 1200),
(23, 2, 'M9979-22531', '2022-01-22 14:16:00', 1200),
(24, 2, 'M9998-10118', '2022-01-22 15:16:11', 1200),
(25, 2, 'M9944-27942', '2022-01-22 15:01:26', 100),
(26, 2, 'M9959-47178', '2022-01-22 14:44:12', 300),
(27, 2, 'M9959-47175', '2022-01-22 14:45:02', 1200),
(28, 2, 'M9944-27940', '2022-01-22 15:05:28', 1200),
(29, 2, 'M9959-47174', '2022-01-22 14:45:48', 300),
(30, 2, 'M9998-10120', '2022-01-22 15:11:33', 1200),
(31, 2, 'M9957-18724', '2022-01-22 14:28:39', 1200),
(32, 2, 'M9957-18723', '2022-01-22 14:29:11', 300),
(33, 2, 'M9957-18722', '2022-01-22 14:29:42', 300),
(34, 2, 'M9998-10119', '2022-01-22 15:15:23', 1200),
(35, 2, 'M9944-27958', '2022-01-22 14:55:41', 1200),
(36, 2, 'M9998-10118', '2022-01-22 15:16:11', 1200),
(37, 2, 'M9957-18718', '2022-01-22 14:31:12', 300),
(38, 2, 'M9944-27955', '2022-01-22 14:57:58', 300),
(39, 2, 'M9944-27942', '2022-01-22 15:01:26', 100),
(40, 2, 'M9960-62276', '2022-01-22 14:39:23', 1200),
(41, 2, 'M9960-62275', '2022-01-22 14:40:09', 1200),
(42, 2, 'M9944-27940', '2022-01-22 15:05:28', 1200),
(43, 2, 'M9959-47178', '2022-01-22 14:44:12', 300),
(44, 2, 'M9959-47175', '2022-01-22 14:45:02', 1200),
(45, 2, 'M9959-47174', '2022-01-22 14:45:48', 300),
(46, 2, 'M9998-10120', '2022-01-22 15:11:33', 1200),
(47, 2, 'M9998-10119', '2022-01-22 15:15:23', 1200),
(48, 2, 'M9998-10118', '2022-01-22 15:16:11', 1200),
(49, 2, 'M9944-27958', '2022-01-22 14:55:41', 1200),
(50, 2, 'M9944-27955', '2022-01-22 14:57:58', 300),
(51, 2, 'M9944-27942', '2022-01-22 15:01:26', 100),
(52, 2, 'M9944-27940', '2022-01-22 15:05:28', 1200),
(53, 2, 'M9998-10120', '2022-01-22 15:11:33', 1200),
(54, 2, 'M9998-10119', '2022-01-22 15:15:23', 1200),
(55, 2, 'M9998-10118', '2022-01-22 15:16:11', 1200),
(56, 2, 'M9930-47190', '2022-01-23 07:54:54', 100),
(57, 2, 'M9930-47190', '2022-01-23 07:54:54', 100),
(58, 2, 'M9930-47190', '2022-01-23 07:54:54', 100),
(59, 2, 'M9997-02557', '2022-01-23 08:21:09', 100),
(60, 2, 'M9997-02555', '2022-01-23 08:21:26', 100),
(61, 2, 'M9918-20595', '2022-01-23 08:24:48', 100),
(62, 2, 'M9930-47190', '2022-01-23 07:54:54', 100),
(63, 2, 'M9997-02557', '2022-01-23 08:21:09', 100),
(64, 2, 'M9997-02555', '2022-01-23 08:21:26', 100),
(65, 2, 'M9918-20595', '2022-01-23 08:24:48', 100),
(66, 2, 'M9997-02557', '2022-01-23 08:21:09', 100),
(67, 2, 'M9997-02555', '2022-01-23 08:21:26', 100),
(68, 2, 'M9918-20595', '2022-01-23 08:24:48', 100),
(69, 2, 'M9930-47190', '2022-01-23 07:54:54', 100),
(70, 2, 'M9997-02557', '2022-01-23 08:21:09', 100),
(71, 2, 'M9997-02555', '2022-01-23 08:21:26', 100),
(72, 2, 'M9918-20595', '2022-01-23 08:24:48', 100),
(73, 2, 'M9930-47190', '2022-01-23 07:54:54', 100),
(74, 2, 'M9997-02557', '2022-01-23 08:21:09', 100),
(75, 2, 'M9997-02555', '2022-01-23 08:21:26', 100),
(76, 2, 'M9918-20595', '2022-01-23 08:24:48', 100),
(77, 2, 'M9997-02557', '2022-01-23 08:21:09', 100),
(78, 2, 'M9997-02555', '2022-01-23 08:21:26', 100),
(79, 2, 'M9918-20595', '2022-01-23 08:24:48', 100),
(80, 2, 'M9943-21907', '2022-01-29 15:15:02', 100),
(81, 2, 'M9990-95467', '2022-01-29 15:16:03', 1200),
(82, 2, 'M9990-95469', '2022-01-29 15:16:52', 100),
(83, 2, 'M9943-21907', '2022-01-29 15:15:02', 100),
(84, 2, 'M9990-95467', '2022-01-29 15:16:03', 1200),
(85, 2, 'M9990-95469', '2022-01-29 15:16:52', 100),
(86, 2, 'M9943-21907', '2022-01-29 15:15:02', 100),
(87, 2, 'M9990-95467', '2022-01-29 15:16:03', 1200),
(88, 2, 'M9990-95469', '2022-01-29 15:16:52', 100),
(89, 2, 'M9943-21907', '2022-01-29 15:15:02', 100),
(90, 2, 'M9990-95467', '2022-01-29 15:16:03', 1200),
(91, 2, 'M9990-95469', '2022-01-29 15:16:52', 100),
(92, 2, 'M9943-21907', '2022-01-29 15:15:02', 100),
(93, 2, 'M9990-95467', '2022-01-29 15:16:03', 1200),
(94, 2, 'M9990-95469', '2022-01-29 15:16:52', 100),
(95, 2, 'M9943-21907', '2022-01-29 15:15:02', 100),
(96, 2, 'M9990-95467', '2022-01-29 15:16:03', 1200),
(97, 2, 'M9990-95469', '2022-01-29 15:16:52', 100),
(98, 2, 'M9971-79276', '2022-01-29 23:09:15', 100),
(99, 2, 'M9971-79276', '2022-01-29 23:09:15', 100),
(100, 2, 'M9971-79276', '2022-01-29 23:09:15', 100),
(101, 2, 'M9971-79276', '2022-01-29 23:09:15', 100),
(102, 2, 'M9971-79276', '2022-01-29 23:09:15', 100),
(103, 2, 'M9971-79276', '2022-01-29 23:09:15', 100);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `masseur_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `address` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `service_type` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `service_price` double NOT NULL,
  `payment` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `notice` text COLLATE utf8_polish_ci NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text COLLATE utf8_polish_ci,
  `status` enum('Oczekuj??ca','Zaakceptowana','Anulowana','') COLLATE utf8_polish_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `reservations`
--

INSERT INTO `reservations` (`id`, `client_id`, `masseur_id`, `date`, `address`, `city`, `service_type`, `service_price`, `payment`, `notice`, `rating`, `comment`, `status`, `created_at`) VALUES
(1, 2, 2, '2022-01-19 22:00:00', 'ul. Jana Paw??a 21', 'Krak??w', 'Masa?? Tajski', 129, 'Karta', 'Kod do klatki: 2137', 5, '', 'Anulowana', '2022-01-17 05:22:47'),
(2, 2, 2, '2022-01-26 12:15:00', 'qwqw', 'Pabianice', '', 0, '', 'Test', 5, 'csscscs', 'Anulowana', '2022-01-19 02:49:55'),
(3, 3, 2, '2022-01-22 23:00:00', '', 'Pozna??', '', 0, '', 'Test', 0, '', 'Oczekuj??ca', '2022-01-19 02:58:30'),
(4, 2, 2, '2022-01-22 06:51:00', 'qwqw', 'Pabianice', 'Masa?? / Masa?? tajski', 129, 'Karta', 'Test', 5, 'Super masa??', 'Oczekuj??ca', '2022-01-19 06:53:13'),
(5, 2, 2, '2022-01-22 12:00:00', 'qwqw', 'Pabianice', 'Masa?? / Masa?? tajski', 129, 'Karta', 'Test', 0, '', 'Oczekuj??ca', '2022-01-20 08:15:41'),
(6, 6, 2, '2022-01-28 22:08:00', 'ul. Kliencka 13', 'Klientowo', 'Masa?? / Masa?? tajski', 129, 'Karta', 'Test', 4, 'Pierwszy komentarz', 'Oczekuj??ca', '2022-01-20 11:17:27'),
(8, 5, 2, '2022-02-17 18:00:00', 'Test', 'test', 'Masa?? / Masa?? tajski', 129, 'Karta', 'Test maila', 0, NULL, 'Oczekuj??ca', '2022-01-21 13:31:07'),
(9, 5, 2, '2022-02-18 18:00:00', 'Test', 'test', 'Fizjoterapia / Terapia', 40, 'Karta', 'Test', 0, NULL, 'Oczekuj??ca', '2022-01-21 13:33:28'),
(10, 5, 2, '2022-02-14 11:30:00', 'Test', 'test', 'Masa?? / Masa?? tajski', 129, 'Karta', 'Test maila', 0, NULL, 'Oczekuj??ca', '2022-01-21 13:34:38'),
(11, 2, 2, '2022-08-18 18:30:00', 'qwqw', 'Pabianice', 'Masa?? / Masa?? tajski', 129, 'Karta', '', 0, NULL, 'Zaakceptowana', '2022-08-12 18:39:38'),
(12, 5, 2, '2022-09-18 17:00:00', 'Test', 'test', 'Masa?? / Masa?? tajski', 129, 'Karta', '', 0, NULL, 'Oczekuj??ca', '2022-09-17 11:42:47'),
(13, 5, 2, '2022-09-22 08:30:00', 'Test', 'test', 'Fizjoterapia / Terapia', 40, 'Got??wka', '', 0, NULL, 'Zaakceptowana', '2022-09-17 14:25:16'),
(14, 5, 6, '2022-09-26 13:44:11', 'Test', 'Pozna??', 'Masa?? Tajski', 149, 'Karta', 'Test', 4, NULL, 'Anulowana', '2022-09-23 13:44:11'),
(15, 5, 6, '2022-11-15 13:44:11', 'Test', 'Pozna??', 'Masa?? Tajski', 149, 'Karta', 'Test', 4, NULL, 'Zaakceptowana', '2022-09-23 13:44:11'),
(16, 5, 6, '2022-11-18 13:44:11', 'Test', 'Pozna??', 'Masa?? Tajski', 149, 'Karta', 'Test', 4, NULL, 'Oczekuj??ca', '2022-09-23 13:44:11'),
(17, 5, 6, '2022-11-16 13:44:11', 'Test', 'Pozna??', 'Masa?? Tajski', 149, 'Karta', 'Test', 4, NULL, 'Anulowana', '2022-09-23 13:44:11'),
(18, 2, 2, '2023-01-27 12:00:00', 'qwqw', 'Pabianice', 'Fizjoterapia / Terapia', 40, 'Karta', '', 0, NULL, 'Oczekuj??ca', '2023-01-15 09:39:16');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `masseur_id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `services`
--

INSERT INTO `services` (`id`, `masseur_id`, `category`, `name`, `duration`, `price`) VALUES
(2, 2, 'Masa??', 'Masa?? tajski', 60, 129),
(3, 2, 'Fizjoterapia', 'Terapia', 30, 40);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `birth_date` date NOT NULL,
  `gender` enum('Brak','M????czyzna','Kobieta','Inna') COLLATE utf8_polish_ci NOT NULL,
  `street` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_polish_ci NOT NULL DEFAULT 'default.png',
  `role` enum('Klient','Masa??ysta','Kierownik','Administrator') COLLATE utf8_polish_ci NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `specializations` enum('Masa??ysta','Fizjoterapeuta','Masa??ysta i Fizjoterapeuta','') COLLATE utf8_polish_ci DEFAULT NULL,
  `experience` text COLLATE utf8_polish_ci,
  `location` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `payment` enum('Karta','Got??wka','Karta i got??wka','') COLLATE utf8_polish_ci NOT NULL,
  `language` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `tel`, `birth_date`, `gender`, `street`, `city`, `avatar`, `role`, `company_id`, `specializations`, `experience`, `location`, `payment`, `language`, `created_at`, `confirmed_at`, `blocked`) VALUES
(2, 'Test', 'Kierownik', 'kierownik@test.com', '$2y$10$gJrO9R6IK7nQHwvvy5IJH.Atdv4kL3WvaUsFQpCLbsLpKGaFklf8W', '+481298129', '2002-03-21', 'M????czyzna', 'qwqw', 'Pabianice', '173906640061f5c6711ac962.52731796.png', 'Kierownik', 1, 'Fizjoterapeuta', 'Jestem\r\nwqrpoiq\r\nqrwpqorwqiwrop', 'Pozna??', 'Karta i got??wka', 'Polski', '2022-01-16 07:24:23', '2022-01-16 00:00:00', 0),
(3, 'Test', 'Masa??ysta', 'masazysta@test.com', '$2y$10$gJrO9R6IK7nQHwvvy5IJH.Atdv4kL3WvaUsFQpCLbsLpKGaFklf8W', '1492481', '2011-09-21', 'Brak', '', 'Pozna??', 'default.png', 'Masa??ysta', 1, 'Masa??ysta i Fizjoterapeuta', '', 'Pozna??', 'Karta', 'Polski', '2022-01-16 18:52:03', NULL, 0),
(5, 'Admin', 'Adminowy', 'admin@test.com', '$2y$10$gJrO9R6IK7nQHwvvy5IJH.Atdv4kL3WvaUsFQpCLbsLpKGaFklf8W', '+48000', '2022-01-20', 'M????czyzna', 'Test', 'test', 'default.png', 'Administrator', NULL, '', 'test', 'test', '', 'test', '2022-01-20 09:45:25', '2022-01-20 09:45:25', 0),
(6, 'Klient', 'Typowy', 'klient@test.com', '$2y$10$gJrO9R6IK7nQHwvvy5IJH.Atdv4kL3WvaUsFQpCLbsLpKGaFklf8W', ',;', '2022-01-20', 'M????czyzna', 'ul. Kliencka 13', 'Klientowo', 'default.png', 'Klient', NULL, 'Fizjoterapeuta', 'tetwetwe', 'tewtewewt', 'Karta i got??wka', 'te', '2022-01-20 09:46:21', '2022-01-20 09:46:21', 0),
(8, 'Testowy', 'Pracownik', 'arch.spaluch@gmail.com', '$2y$10$y86mzK9eADodUNUfnRxqXOKI.up/EHH3HkyxLzTdFT348J96.mHbe', '883526888', '2000-02-22', 'Brak', NULL, NULL, 'default.png', 'Masa??ysta', 1, NULL, NULL, NULL, 'Karta', NULL, '2022-01-27 21:08:55', NULL, 0);

--
-- Indeksy dla zrzut??w tabel
--

--
-- Indeksy dla tabeli `availability`
--
ALTER TABLE `availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `masseur_id` (`masseur_id`);

--
-- Indeksy dla tabeli `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indeksy dla tabeli `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `masseur_id` (`masseur_id`);

--
-- Indeksy dla tabeli `masseurcities`
--
ALTER TABLE `masseurcities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `masseur_id` (`masseur_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indeksy dla tabeli `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `masseur_id` (`masseur_id`);

--
-- Indeksy dla tabeli `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `masseur_id` (`masseur_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `availability`
--
ALTER TABLE `availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT dla tabeli `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `masseurcities`
--
ALTER TABLE `masseurcities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT dla tabeli `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT dla tabeli `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT dla tabeli `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT dla tabeli `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ograniczenia dla zrzut??w tabel
--

--
-- Ograniczenia dla tabeli `availability`
--
ALTER TABLE `availability`
  ADD CONSTRAINT `availability_ibfk_1` FOREIGN KEY (`masseur_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `languages`
--
ALTER TABLE `languages`
  ADD CONSTRAINT `languages_ibfk_1` FOREIGN KEY (`masseur_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `masseurcities`
--
ALTER TABLE `masseurcities`
  ADD CONSTRAINT `masseurcities_ibfk_1` FOREIGN KEY (`masseur_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `masseurcities_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`);

--
-- Ograniczenia dla tabeli `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`masseur_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`masseur_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
