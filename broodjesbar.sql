SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `broodjesbar`
--
CREATE DATABASE IF NOT EXISTS `broodjesbar` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `broodjesbar`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestellingen`
--

DROP TABLE IF EXISTS `bestellingen`;
CREATE TABLE `bestellingen` (
  `bestelID` int(11) NOT NULL,
  `broodjeID` int(11) NOT NULL,
  `klantID` int(11) NOT NULL,
  `afhalingsmoment` datetime NOT NULL,
  `statusID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `broodjes`
--

DROP TABLE IF EXISTS `broodjes`;
CREATE TABLE `broodjes` (
  `ID` int(11) NOT NULL,
  `Naam` varchar(50) NOT NULL,
  `Omschrijving` varchar(500) NOT NULL,
  `Prijs` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `broodjes`
--

INSERT INTO `broodjes` (`ID`, `Naam`, `Omschrijving`, `Prijs`) VALUES
(1, 'Kaas', 'Broodje met jonge kaas', '1.90'),
(2, 'Ham', 'Broodje met natuurham', '1.90'),
(3, 'Kaas en ham', 'Broodje met kaas en ham', '2.10'),
(4, 'Fitness kip', 'kip natuur, yoghurtdressing, perzik, tuinkers, tomaat en komkommer', '3.50'),
(5, 'Broodje Sombrero', 'kip natuur, andalousesaus, rode paprika, maïs, sla, komkommer, tomaat, ei en ui ', '3.70'),
(6, 'Broodje americain-tartaar', 'americain, tartaarsaus, ui, komkommer, ei en tuinkers ', '3.50'),
(7, 'Broodje Indian kip', 'kip natuur, ananas, tuinkers, komkommer en curry dressing', '4.00'),
(8, 'Grieks broodje', 'feta, tuinkers, komkommer, tomaat en olijventapenade', '3.90'),
(9, 'Tonijntino', 'tonijn pikant, ui, augurk, martinosaus en (tabasco)', '2.60'),
(10, 'Wrap exotisch', 'kip natuur, cocktailsaus, sla, tomaat, komkommer, ei en ananas', '3.70'),
(11, 'Wrap kip/spek', 'Kip natuur, spek, BBQ saus, sla, tomaat en komkommer', '4.00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klanten`
--

DROP TABLE IF EXISTS `klanten`;
CREATE TABLE `klanten` (
  `klantID` int(11) NOT NULL,
  `voornaam` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `achternaam` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `statussen`
--

DROP TABLE IF EXISTS `statussen`;
CREATE TABLE `statussen` (
  `statusID` int(11) NOT NULL,
  `Status` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `statussen`
--

INSERT INTO `statussen` (`statusID`, `Status`) VALUES
(1, 'Besteld'),
(2, 'Gemaakt'),
(3, 'Afgehaald');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `bestellingen`
--
ALTER TABLE `bestellingen`
  ADD PRIMARY KEY (`bestelID`),
  ADD KEY `broodjeID` (`broodjeID`),
  ADD KEY `klantID` (`klantID`),
  ADD KEY `statusID` (`statusID`);

--
-- Indexen voor tabel `broodjes`
--
ALTER TABLE `broodjes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `klanten`
--
ALTER TABLE `klanten`
  ADD PRIMARY KEY (`klantID`);

--
-- Indexen voor tabel `statussen`
--
ALTER TABLE `statussen`
  ADD PRIMARY KEY (`statusID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `bestellingen`
--
ALTER TABLE `bestellingen`
  MODIFY `bestelID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `broodjes`
--
ALTER TABLE `broodjes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT voor een tabel `klanten`
--
ALTER TABLE `klanten`
  MODIFY `klantID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `statussen`
--
ALTER TABLE `statussen`
  MODIFY `statusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `bestellingen`
--
ALTER TABLE `bestellingen`
  ADD CONSTRAINT `bestellingen_ibfk_1` FOREIGN KEY (`broodjeID`) REFERENCES `broodjes` (`ID`),
  ADD CONSTRAINT `bestellingen_ibfk_2` FOREIGN KEY (`statusID`) REFERENCES `statussen` (`statusID`),
  ADD CONSTRAINT `bestellingen_ibfk_3` FOREIGN KEY (`klantID`) REFERENCES `klanten` (`klantID`);
COMMIT;
