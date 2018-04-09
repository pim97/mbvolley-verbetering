-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 02 okt 2017 om 08:48
-- Serverversie: 10.1.21-MariaDB
-- PHP-versie: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `mbvolley`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruiker`
--

DROP TABLE IF EXISTS `gebruiker`;
CREATE TABLE `gebruiker` (
  `id` int(11) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `gebruiker`
--

INSERT INTO `gebruiker` (`id`, `userid`, `password`) VALUES
  (1, 'admin', '$2y$10$gFF.xdZHR4vAVY8IXU8CpuA81YUEv2t5Wa2Tkiz2T5ihY2/kkb4QG');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klas`
--

DROP TABLE IF EXISTS `klas`;
CREATE TABLE `klas` (
  `code` char(2) NOT NULL,
  `naam` varchar(50) NOT NULL DEFAULT '<naam>'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `klas`
--

INSERT INTO `klas` (`code`, `naam`) VALUES
  ('D1', 'Dames 1'),
  ('D2', 'Dames 2'),
  ('H1', 'Heren 1'),
  ('H2', 'Heren 2'),
  ('H3', 'Heren 3');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `lid`
--

DROP TABLE IF EXISTS `lid`;
CREATE TABLE `lid` (
  `id` int(11) NOT NULL,
  `naam` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `lid`
--

INSERT INTO `lid` (`id`, `naam`) VALUES
  (1, 'Crista Ahern'),
  (2, 'Lina Petrin'),
  (3, 'Larae Smallwood'),
  (4, 'Jackson Steger'),
  (5, 'Darcel Mccarville'),
  (6, 'Jenny Hyler'),
  (7, 'Mable Harrod'),
  (8, 'Aleida Buff'),
  (9, 'Bailey Eisenhower'),
  (10, 'Mose Campion'),
  (11, 'Shae Pfannenstiel'),
  (12, 'Reid Bugbee'),
  (13, 'Emmitt Frye'),
  (14, 'Danielle Digennaro'),
  (15, 'Gertrud Schalk'),
  (16, 'Ha Halpern'),
  (17, 'Marica Bess'),
  (18, 'Manuel Reader'),
  (19, 'Zella Cloe'),
  (20, 'Reinaldo Shuffler');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ronde`
--

DROP TABLE IF EXISTS `ronde`;
CREATE TABLE `ronde` (
  `id` int(11) NOT NULL,
  `tijd` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `ronde`
--

INSERT INTO `ronde` (`id`, `tijd`) VALUES
  (1, '19:15:00'),
  (2, '20:15:00'),
  (3, '21:15:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `speelweek`
--

DROP TABLE IF EXISTS `speelweek`;
CREATE TABLE `speelweek` (
  `id` int(11) NOT NULL,
  `datum` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `speelweek`
--

INSERT INTO `speelweek` (`id`, `datum`) VALUES
  (1, '2014-09-09'),
  (2, '2014-09-16'),
  (3, '2014-09-23'),
  (4, '2014-09-30'),
  (5, '2014-10-07'),
  (6, '2014-10-14'),
  (7, '2014-10-21'),
  (8, '2014-10-28'),
  (9, '2014-11-04'),
  (10, '2014-11-11'),
  (11, '2014-11-18'),
  (12, '2014-11-25'),
  (13, '2014-12-02'),
  (14, '2014-12-09'),
  (15, '2014-12-16'),
  (16, '2015-01-06'),
  (17, '2015-01-13'),
  (18, '2015-01-20'),
  (19, '2015-01-27'),
  (20, '2015-02-03'),
  (21, '2015-02-10'),
  (22, '2015-02-17'),
  (23, '2015-02-24'),
  (24, '2015-03-03'),
  (25, '2015-03-10'),
  (26, '2015-03-17'),
  (27, '2015-03-24'),
  (28, '2015-03-31'),
  (29, '2015-04-07'),
  (30, '2015-04-14'),
  (31, '2015-04-21'),
  (32, '2015-04-28'),
  (33, '2015-05-05'),
  (34, '2015-05-12'),
  (35, '2015-05-19'),
  (36, '2015-05-26');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `team`
--

DROP TABLE IF EXISTS `team`;
CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `klasse` char(2) NOT NULL,
  `naam` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `team`
--

INSERT INTO `team` (`id`, `klasse`, `naam`) VALUES
  (1, 'H1', 'Munter Volley 1'),
  (2, 'H1', 'De Graaf Assurantien'),
  (3, 'H1', 'Sport2000 Mdb/\'t Znd'),
  (4, 'H3', 'SMA Zeeland'),
  (5, 'H3', 'Bowling d Kruitmolen'),
  (6, 'H2', 'Munter Volley 2'),
  (7, 'D1', 'Vlijtig Liesje'),
  (8, 'D1', 'Res. Valkenisse'),
  (9, 'D1', 'The Tube');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `team_has_lid`
--

DROP TABLE IF EXISTS `team_has_lid`;
CREATE TABLE `team_has_lid` (
  `team` int(11) NOT NULL,
  `lid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `team_has_lid`
--

INSERT INTO `team_has_lid` (`team`, `lid`) VALUES
  (1, 1),
  (1, 2),
  (1, 3),
  (1, 4),
  (1, 5),
  (1, 6),
  (1, 7),
  (2, 8),
  (2, 9),
  (2, 10),
  (2, 11),
  (2, 12),
  (2, 13),
  (2, 14),
  (2, 15),
  (3, 1),
  (3, 2),
  (3, 16),
  (3, 17),
  (3, 18),
  (3, 19),
  (3, 20),
  (4, 3),
  (4, 4),
  (4, 5),
  (4, 6),
  (4, 7),
  (4, 8),
  (4, 9),
  (4, 10),
  (4, 11),
  (5, 12),
  (5, 13),
  (5, 14),
  (5, 15),
  (5, 16),
  (5, 17),
  (5, 18),
  (6, 1),
  (6, 2),
  (6, 3),
  (6, 4),
  (6, 5),
  (6, 6),
  (6, 19),
  (6, 20),
  (7, 7),
  (7, 8),
  (7, 9),
  (7, 10),
  (7, 11),
  (7, 12),
  (8, 1),
  (8, 2),
  (8, 13),
  (8, 14),
  (8, 15),
  (8, 16),
  (8, 17),
  (8, 18),
  (8, 19),
  (8, 20),
  (9, 3),
  (9, 4),
  (9, 5),
  (9, 6),
  (9, 7),
  (9, 8),
  (9, 9);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `uitslag_set`
--

DROP TABLE IF EXISTS `uitslag_set`;
CREATE TABLE `uitslag_set` (
  `wedstrijd` int(11) NOT NULL,
  `set` int(11) NOT NULL,
  `score_a` int(11) DEFAULT '0',
  `score_b` int(11) DEFAULT '0',
  `punten_a` int(11) DEFAULT '0',
  `punten_b` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `uitslag_set`
--

INSERT INTO `uitslag_set` (`wedstrijd`, `set`, `score_a`, `score_b`, `punten_a`, `punten_b`) VALUES
  (1, 1, 18, 25, 0, 2),
  (1, 2, 11, 25, 0, 2),
  (1, 3, 23, 25, 0, 2),
  (1, 4, 12, 4, 2, 0),
  (2, 1, 25, 11, 2, 0),
  (2, 2, 25, 3, 2, 0),
  (2, 3, 25, 23, 2, 0),
  (2, 4, 12, 25, 0, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `wedstrijd`
--

DROP TABLE IF EXISTS `wedstrijd`;
CREATE TABLE `wedstrijd` (
  `id` int(11) NOT NULL,
  `speelweek` int(11) NOT NULL,
  `ronde` int(11),
  `veld` int(11) NOT NULL,
  `team_a` int(11) DEFAULT NULL,
  `team_b` int(11) DEFAULT NULL,
  `scheids` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `wedstrijd`
--

INSERT INTO `wedstrijd` (`id`, `speelweek`, `ronde`, `veld`, `team_a`, `team_b`, `scheids`) VALUES
  (1, 1, 1, 2, 7, 8, 9),
  (2, 1, 1, 3, 1, 2, 3),
  (3, 1, 1, 4, NULL, NULL, NULL),
  (4, 1, 1, 5, NULL, NULL, NULL),
  (5, 1, 1, 6, NULL, NULL, NULL),
  (6, 1, 2, 1, NULL, NULL, NULL),
  (7, 1, 2, 2, NULL, NULL, NULL),
  (8, 1, 2, 3, NULL, NULL, NULL),
  (9, 1, 2, 4, NULL, NULL, NULL),
  (10, 1, 2, 5, NULL, NULL, NULL),
  (11, 1, 2, 6, NULL, NULL, NULL),
  (12, 1, 3, 1, NULL, NULL, NULL),
  (13, 1, 3, 2, 7, 9, 8),
  (14, 1, 3, 3, NULL, NULL, NULL),
  (15, 1, 3, 4, NULL, NULL, NULL),
  (16, 1, 3, 5, NULL, NULL, NULL),
  (17, 2, 3, 6, NULL, NULL, NULL),
  (18, 2, 1, 1, NULL, NULL, NULL),
  (19, 2, 1, 2, 8, 9, 7),
  (20, 2, 1, 3, NULL, NULL, NULL),
  (21, 2, 1, 4, NULL, NULL, NULL),
  (22, 2, 1, 5, NULL, NULL, NULL),
  (23, 2, 1, 6, NULL, NULL, NULL),
  (24, 2, 2, 1, NULL, NULL, NULL),
  (25, 2, 2, 2, NULL, NULL, NULL),
  (26, 2, 2, 3, NULL, NULL, NULL),
  (27, 2, 2, 4, NULL, NULL, NULL),
  (28, 2, 2, 5, NULL, NULL, NULL),
  (29, 2, 2, 6, NULL, NULL, NULL),
  (30, 2, 3, 1, NULL, NULL, NULL),
  (31, 2, 3, 2, NULL, NULL, NULL),
  (32, 2, 3, 3, NULL, NULL, NULL),
  (33, 2, 3, 4, NULL, NULL, NULL),
  (34, 2, 3, 5, NULL, NULL, NULL),
  (35, 2, 3, 6, NULL, NULL, NULL),
  (36, 3, 1, 1, NULL, NULL, NULL),
  (37, 3, 1, 2, NULL, NULL, NULL),
  (38, 3, 1, 3, NULL, NULL, NULL),
  (39, 3, 1, 4, NULL, NULL, NULL),
  (40, 3, 1, 5, NULL, NULL, NULL),
  (41, 3, 1, 6, NULL, NULL, NULL),
  (42, 3, 2, 1, NULL, NULL, NULL),
  (43, 3, 2, 2, NULL, NULL, NULL),
  (44, 3, 2, 3, NULL, NULL, NULL),
  (45, 3, 2, 4, NULL, NULL, NULL),
  (46, 3, 2, 5, NULL, NULL, NULL),
  (47, 3, 2, 6, NULL, NULL, NULL),
  (48, 3, 3, 1, NULL, NULL, NULL),
  (49, 3, 3, 2, NULL, NULL, NULL),
  (50, 3, 3, 3, NULL, NULL, NULL),
  (51, 3, 3, 4, NULL, NULL, NULL),
  (52, 3, 3, 5, NULL, NULL, NULL),
  (53, 3, 3, 6, NULL, NULL, NULL),
  (54, 4, 1, 1, NULL, NULL, NULL),
  (55, 4, 1, 2, NULL, NULL, NULL),
  (56, 4, 1, 3, NULL, NULL, NULL),
  (57, 4, 1, 4, NULL, NULL, NULL),
  (58, 4, 1, 5, NULL, NULL, NULL),
  (59, 4, 1, 6, NULL, NULL, NULL),
  (60, 4, 2, 1, NULL, NULL, NULL),
  (61, 4, 2, 2, NULL, NULL, NULL),
  (62, 4, 2, 3, NULL, NULL, NULL),
  (63, 4, 2, 4, NULL, NULL, NULL),
  (64, 4, 2, 5, NULL, NULL, NULL),
  (65, 4, 2, 6, NULL, NULL, NULL),
  (66, 4, 3, 1, NULL, NULL, NULL),
  (67, 4, 3, 2, NULL, NULL, NULL),
  (68, 4, 3, 3, NULL, NULL, NULL),
  (69, 4, 3, 4, NULL, NULL, NULL),
  (70, 4, 3, 5, NULL, NULL, NULL),
  (71, 4, 3, 6, NULL, NULL, NULL),
  (72, 5, 1, 1, NULL, NULL, NULL),
  (73, 5, 1, 2, NULL, NULL, NULL),
  (74, 5, 1, 3, NULL, NULL, NULL),
  (75, 5, 1, 4, NULL, NULL, NULL),
  (76, 5, 1, 5, NULL, NULL, NULL),
  (77, 5, 1, 6, NULL, NULL, NULL),
  (78, 5, 2, 1, NULL, NULL, NULL),
  (79, 5, 2, 2, NULL, NULL, NULL),
  (80, 5, 2, 3, NULL, NULL, NULL),
  (81, 5, 2, 4, NULL, NULL, NULL),
  (82, 5, 2, 5, NULL, NULL, NULL),
  (83, 5, 2, 6, NULL, NULL, NULL),
  (84, 5, 3, 1, NULL, NULL, NULL),
  (85, 5, 3, 2, NULL, NULL, NULL),
  (86, 5, 3, 3, NULL, NULL, NULL),
  (87, 5, 3, 4, NULL, NULL, NULL),
  (88, 5, 3, 5, NULL, NULL, NULL),
  (89, 5, 3, 6, NULL, NULL, NULL),
  (90, 6, 1, 1, NULL, NULL, NULL),
  (91, 6, 1, 2, NULL, NULL, NULL),
  (92, 6, 1, 3, NULL, NULL, NULL),
  (93, 6, 1, 4, NULL, NULL, NULL),
  (94, 6, 1, 5, NULL, NULL, NULL),
  (95, 6, 1, 6, NULL, NULL, NULL),
  (96, 6, 2, 1, NULL, NULL, NULL),
  (97, 6, 2, 2, NULL, NULL, NULL),
  (98, 6, 2, 3, NULL, NULL, NULL),
  (99, 6, 2, 4, NULL, NULL, NULL),
  (100, 6, 2, 5, NULL, NULL, NULL),
  (101, 6, 2, 6, NULL, NULL, NULL),
  (102, 6, 3, 1, NULL, NULL, NULL),
  (103, 6, 3, 2, NULL, NULL, NULL),
  (104, 6, 3, 3, NULL, NULL, NULL),
  (105, 6, 3, 4, NULL, NULL, NULL),
  (106, 6, 3, 5, NULL, NULL, NULL),
  (107, 6, 3, 6, NULL, NULL, NULL),
  (108, 7, 1, 1, NULL, NULL, NULL),
  (109, 7, 1, 2, NULL, NULL, NULL),
  (110, 7, 1, 3, NULL, NULL, NULL),
  (111, 7, 1, 4, NULL, NULL, NULL),
  (112, 7, 1, 5, NULL, NULL, NULL),
  (113, 7, 1, 6, NULL, NULL, NULL),
  (114, 7, 2, 1, NULL, NULL, NULL),
  (115, 7, 2, 2, NULL, NULL, NULL),
  (116, 7, 2, 3, NULL, NULL, NULL),
  (117, 7, 2, 4, NULL, NULL, NULL),
  (118, 7, 2, 5, NULL, NULL, NULL),
  (119, 7, 2, 6, NULL, NULL, NULL),
  (120, 7, 3, 1, NULL, NULL, NULL),
  (121, 7, 3, 2, NULL, NULL, NULL),
  (122, 7, 3, 3, NULL, NULL, NULL),
  (123, 7, 3, 4, NULL, NULL, NULL),
  (124, 7, 3, 5, NULL, NULL, NULL),
  (125, 7, 3, 6, NULL, NULL, NULL),
  (126, 8, 1, 1, NULL, NULL, NULL),
  (127, 8, 1, 2, NULL, NULL, NULL),
  (128, 8, 1, 3, NULL, NULL, NULL),
  (129, 8, 1, 4, NULL, NULL, NULL),
  (130, 8, 1, 5, NULL, NULL, NULL),
  (131, 8, 1, 6, NULL, NULL, NULL),
  (132, 8, 2, 1, NULL, NULL, NULL),
  (133, 8, 2, 2, NULL, NULL, NULL),
  (134, 8, 2, 3, NULL, NULL, NULL),
  (135, 8, 2, 4, NULL, NULL, NULL),
  (136, 8, 2, 5, NULL, NULL, NULL),
  (137, 8, 2, 6, NULL, NULL, NULL),
  (138, 8, 3, 1, NULL, NULL, NULL),
  (139, 8, 3, 2, NULL, NULL, NULL),
  (140, 8, 3, 3, NULL, NULL, NULL),
  (141, 8, 3, 4, NULL, NULL, NULL),
  (142, 8, 3, 5, NULL, NULL, NULL),
  (143, 8, 3, 6, NULL, NULL, NULL),
  (144, 9, 1, 1, NULL, NULL, NULL),
  (145, 9, 1, 2, NULL, NULL, NULL),
  (146, 9, 1, 3, NULL, NULL, NULL),
  (147, 9, 1, 4, NULL, NULL, NULL),
  (148, 9, 1, 5, NULL, NULL, NULL),
  (149, 9, 1, 6, NULL, NULL, NULL),
  (150, 9, 2, 1, NULL, NULL, NULL),
  (151, 9, 2, 2, NULL, NULL, NULL),
  (152, 9, 2, 3, NULL, NULL, NULL),
  (153, 9, 2, 4, NULL, NULL, NULL),
  (154, 9, 2, 5, NULL, NULL, NULL),
  (155, 9, 2, 6, NULL, NULL, NULL),
  (156, 9, 3, 1, NULL, NULL, NULL),
  (157, 9, 3, 2, NULL, NULL, NULL),
  (158, 9, 3, 3, NULL, NULL, NULL),
  (159, 9, 3, 4, NULL, NULL, NULL),
  (160, 9, 3, 5, NULL, NULL, NULL),
  (161, 9, 3, 6, NULL, NULL, NULL),
  (162, 9, 1, 1, NULL, NULL, NULL),
  (163, 10, 1, 2, NULL, NULL, NULL),
  (164, 10, 1, 3, NULL, NULL, NULL),
  (165, 10, 1, 4, NULL, NULL, NULL),
  (166, 10, 1, 5, NULL, NULL, NULL),
  (167, 10, 1, 6, NULL, NULL, NULL),
  (168, 10, 2, 1, NULL, NULL, NULL),
  (169, 10, 2, 2, NULL, NULL, NULL),
  (170, 10, 2, 3, NULL, NULL, NULL),
  (171, 10, 2, 4, NULL, NULL, NULL),
  (172, 10, 2, 5, NULL, NULL, NULL),
  (173, 10, 2, 6, NULL, NULL, NULL),
  (174, 10, 3, 1, NULL, NULL, NULL),
  (175, 10, 3, 2, NULL, NULL, NULL),
  (176, 10, 3, 3, NULL, NULL, NULL),
  (177, 10, 3, 4, NULL, NULL, NULL),
  (178, 10, 3, 5, NULL, NULL, NULL),
  (179, 10, 3, 6, NULL, NULL, NULL);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `gebruiker`
--
ALTER TABLE `gebruiker`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid_unique` (`userid`);

--
-- Indexen voor tabel `klas`
--
ALTER TABLE `klas`
  ADD PRIMARY KEY (`code`);

--
-- Indexen voor tabel `lid`
--
ALTER TABLE `lid`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `ronde`
--
ALTER TABLE `ronde`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `speelweek`
--
ALTER TABLE `speelweek`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_team_klas_idx` (`klasse`);

--
-- Indexen voor tabel `team_has_lid`
--
ALTER TABLE `team_has_lid`
  ADD PRIMARY KEY (`team`,`lid`),
  ADD KEY `fk_team_has_lid_lid1_idx` (`lid`),
  ADD KEY `fk_team_has_lid_team1_idx` (`team`);

--
-- Indexen voor tabel `uitslag_set`
--
ALTER TABLE `uitslag_set`
  ADD PRIMARY KEY (`wedstrijd`,`set`);

--
-- Indexen voor tabel `wedstrijd`
--
ALTER TABLE `wedstrijd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_wedstrijd_speelweek` (`speelweek`),
  ADD KEY `FK_wedstrijd_ronde` (`ronde`),
  ADD KEY `FK_wedstrijd_team_a` (`team_a`),
  ADD KEY `FK_wedstrijd_team_b` (`team_b`),
  ADD KEY `FK_wedstrijd_scheids` (`scheids`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `gebruiker`
--
ALTER TABLE `gebruiker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `lid`
--
ALTER TABLE `lid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT voor een tabel `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT voor een tabel `wedstrijd`
--
ALTER TABLE `wedstrijd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;
--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `fk_team_klas` FOREIGN KEY (`klasse`) REFERENCES `klas` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `team_has_lid`
--
ALTER TABLE `team_has_lid`
  ADD CONSTRAINT `fk_team_has_lid_lid1` FOREIGN KEY (`lid`) REFERENCES `lid` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_team_has_lid_team1` FOREIGN KEY (`team`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `uitslag_set`
--
ALTER TABLE `uitslag_set`
  ADD CONSTRAINT `FKuitslag_set_wedstrijd` FOREIGN KEY (`wedstrijd`) REFERENCES `wedstrijd` (`id`);

--
-- Beperkingen voor tabel `wedstrijd`
--
ALTER TABLE `wedstrijd`
  ADD CONSTRAINT `FK_wedstrijd_ronde` FOREIGN KEY (`ronde`) REFERENCES `ronde` (`id`),
  ADD CONSTRAINT `FK_wedstrijd_scheids` FOREIGN KEY (`scheids`) REFERENCES `team` (`id`),
  ADD CONSTRAINT `FK_wedstrijd_speelweek` FOREIGN KEY (`speelweek`) REFERENCES `speelweek` (`id`),
  ADD CONSTRAINT `FK_wedstrijd_team_a` FOREIGN KEY (`team_a`) REFERENCES `team` (`id`),
  ADD CONSTRAINT `FK_wedstrijd_team_b` FOREIGN KEY (`team_b`) REFERENCES `team` (`id`);
