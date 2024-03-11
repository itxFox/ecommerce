-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versione server:              10.4.25-MariaDB - mariadb.org binary distribution
-- S.O. server:                  Win64
-- HeidiSQL Versione:            12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dump della struttura del database ecommerce
CREATE DATABASE IF NOT EXISTS `ecommerce` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `ecommerce`;

-- Dump della struttura di tabella ecommerce.categorieprodotti
CREATE TABLE IF NOT EXISTS `categorieprodotti` (
  `id_categoria` int(255) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) DEFAULT NULL,
  `descrizione` text DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella ecommerce.categorieprodotti: ~5 rows (circa)
INSERT INTO `categorieprodotti` (`id_categoria`, `nome`, `descrizione`) VALUES
	(1, 'Sedie', 'Sedie per soggiorno e cucina'),
	(2, 'Divani', 'Divani comodi e moderni'),
	(3, 'Tavoli', 'Tavoli per soggiorno e cucina'),
	(4, 'Armadi', 'Armadi spaziosi e funzionali'),
	(5, 'Lavandini', 'Lavandini moderni e resistenti');

-- Dump della struttura di tabella ecommerce.clienti
CREATE TABLE IF NOT EXISTS `clienti` (
  `id_customer` int(255) NOT NULL AUTO_INCREMENT,
  `email` varchar(25) DEFAULT NULL,
  `passw` varchar(200) DEFAULT NULL,
  `amministratore` tinyint(1) DEFAULT 0,
  `nome` varchar(40) DEFAULT NULL,
  `indirizzo` varchar(50) DEFAULT NULL,
  `citta` varchar(15) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_customer`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella ecommerce.clienti: ~2 rows (circa)
INSERT INTO `clienti` (`id_customer`, `email`, `passw`, `amministratore`, `nome`, `indirizzo`, `citta`, `telefono`) VALUES
	(30, 'sdaniel.hofman@itis.pr.it', '$2y$10$4SNdVCeRRi5uJRSRfgySW.b7pK.MBPCG6bR3HQcK52Nd55lp3bjz2', 1, 'Daniel', 'via Hof-White 1', 'Parma', '666666666'),
	(33, 'sdanilo.folli@itis.pr.it', '$2y$10$pvrs9YjrjXlEwW6/NQCvvufrxiLB74aHoqddvqbmCV0bBqsTEPBe2', 0, 'Danilo', 'via Folli 12', 'Parma', '1234567891');

-- Dump della struttura di tabella ecommerce.opzioni
CREATE TABLE IF NOT EXISTS `opzioni` (
  `id_opzione` int(255) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_opzione`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella ecommerce.opzioni: ~3 rows (circa)
INSERT INTO `opzioni` (`id_opzione`, `nome`) VALUES
	(1, 'Colore personalizzato'),
	(2, 'Materiale resistente'),
	(3, 'Montaggio incluso');

-- Dump della struttura di tabella ecommerce.ordini
CREATE TABLE IF NOT EXISTS `ordini` (
  `id_ordine` int(255) NOT NULL AUTO_INCREMENT,
  `id_prodotto` int(255) DEFAULT NULL,
  `id_customer` int(11) DEFAULT NULL,
  `quantita` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ordine`),
  KEY `id_prodotto` (`id_prodotto`),
  KEY `fk_id_customer` (`id_customer`),
  CONSTRAINT `fk_id_customer` FOREIGN KEY (`id_customer`) REFERENCES `clienti` (`id_customer`),
  CONSTRAINT `ordini_ibfk_1` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotti` (`id_prodotto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella ecommerce.ordini: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce.prodotti
CREATE TABLE IF NOT EXISTS `prodotti` (
  `id_prodotto` int(255) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) DEFAULT NULL,
  `prezzo` double(10,2) DEFAULT NULL,
  `peso` double(10,2) DEFAULT NULL,
  `descrizione` text DEFAULT NULL,
  `immagine` longblob DEFAULT NULL,
  `categoria` int(255) DEFAULT NULL,
  `stock` int(255) DEFAULT NULL,
  PRIMARY KEY (`id_prodotto`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella ecommerce.prodotti: ~6 rows (circa)
INSERT INTO `prodotti` (`id_prodotto`, `nome`, `prezzo`, `peso`, `descrizione`, `immagine`, `categoria`, `stock`) VALUES
	(1, 'Sedia', 20.99, 8.50, 'Sedia moderna con struttura in legno.', _binary 0x6675726e69747572652f63686169722e6a7067, 1, 50),
	(2, 'Divano', 499.99, 90.00, 'Divano spazioso e confortevole.', _binary 0x6675726e69747572652f736f66612e6a7067, 2, 20),
	(3, 'Lavandino', 249.99, 120.00, 'Lavandino moderno e resistente.', _binary 0x6675726e69747572652f62617468726f6f6d2e6a7067, 5, 30),
	(4, 'Armadio', 699.99, 90.00, 'Armadio spazioso con 3 ante.', _binary 0x6675726e69747572652f77617264726f62652e6a7067, 4, 10),
	(5, 'Tavolo', 70.99, 70.00, 'Tavolo da pranzo in legno robusto.', _binary 0x6675726e69747572652f7461626c652e6a7067, 3, 40),
	(18, 'Tavolo in metallo', 300.00, 40.00, 'tavolo resistente in acciaio', _binary 0x6675726e69747572652f7461626c65322e6a7067, 3, 16);

-- Dump della struttura di tabella ecommerce.prodotti_categorie
CREATE TABLE IF NOT EXISTS `prodotti_categorie` (
  `id_prodotti_categorie` int(255) NOT NULL AUTO_INCREMENT,
  `id_prodotto` int(255) DEFAULT NULL,
  `id_categoria` int(255) DEFAULT NULL,
  PRIMARY KEY (`id_prodotti_categorie`),
  KEY `id_prodotto` (`id_prodotto`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `prodotti_categorie_ibfk_1` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotti` (`id_prodotto`),
  CONSTRAINT `prodotti_categorie_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorieprodotti` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella ecommerce.prodotti_categorie: ~5 rows (circa)
INSERT INTO `prodotti_categorie` (`id_prodotti_categorie`, `id_prodotto`, `id_categoria`) VALUES
	(1, 1, 1),
	(2, 2, 2),
	(3, 3, 5),
	(4, 4, 4),
	(5, 5, 3);

-- Dump della struttura di tabella ecommerce.prodotti_opzioni
CREATE TABLE IF NOT EXISTS `prodotti_opzioni` (
  `id_prodotti_opzioni` int(255) NOT NULL AUTO_INCREMENT,
  `id_prodotto` int(255) DEFAULT NULL,
  `id_opzione` int(255) DEFAULT NULL,
  PRIMARY KEY (`id_prodotti_opzioni`),
  KEY `id_prodotto` (`id_prodotto`),
  KEY `id_opzione` (`id_opzione`),
  CONSTRAINT `prodotti_opzioni_ibfk_1` FOREIGN KEY (`id_prodotto`) REFERENCES `prodotti` (`id_prodotto`),
  CONSTRAINT `prodotti_opzioni_ibfk_2` FOREIGN KEY (`id_opzione`) REFERENCES `opzioni` (`id_opzione`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella ecommerce.prodotti_opzioni: ~5 rows (circa)
INSERT INTO `prodotti_opzioni` (`id_prodotti_opzioni`, `id_prodotto`, `id_opzione`) VALUES
	(1, 1, 1),
	(2, 2, 2),
	(3, 3, 3),
	(4, 4, 1),
	(5, 4, 2);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
