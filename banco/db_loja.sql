-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 31-Out-2018 às 13:49
-- Versão do servidor: 5.6.13
-- versão do PHP: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `db_loja`
--
CREATE DATABASE IF NOT EXISTS `db_loja` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_loja`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_carrinho`
--

CREATE TABLE IF NOT EXISTS `tb_carrinho` (
  `CD_CARRINHO` int(11) NOT NULL AUTO_INCREMENT,
  `VL_TOTAL` float(10,2) DEFAULT NULL,
  PRIMARY KEY (`CD_CARRINHO`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `tb_carrinho`
--

INSERT INTO `tb_carrinho` (`CD_CARRINHO`, `VL_TOTAL`) VALUES
(5, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_categoria`
--

CREATE TABLE IF NOT EXISTS `tb_categoria` (
  `CD_CATEGORIA` int(11) NOT NULL AUTO_INCREMENT,
  `NM_CATEGORIA` varchar(200) DEFAULT NULL,
  `DS_ENDERECO` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`CD_CATEGORIA`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `tb_categoria`
--

INSERT INTO `tb_categoria` (`CD_CATEGORIA`, `NM_CATEGORIA`, `DS_ENDERECO`) VALUES
(1, 'Consoles', 'img/consoles.jpg'),
(2, 'Informática', 'img/informatica.jpg'),
(3, 'Smartphones', 'img/smartphones.jpg'),
(4, 'Jogos', 'img/jogos.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_compra`
--

CREATE TABLE IF NOT EXISTS `tb_compra` (
  `CD_COMPRA` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PRODUTO` int(11) DEFAULT NULL,
  `ID_CARRINHO` int(11) DEFAULT NULL,
  `QT_PRODUTO` int(11) DEFAULT NULL,
  PRIMARY KEY (`CD_COMPRA`),
  KEY `ID_PRODUTO` (`ID_PRODUTO`),
  KEY `ID_CARRINHO` (`ID_CARRINHO`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_produto`
--

CREATE TABLE IF NOT EXISTS `tb_produto` (
  `CD_PRODUTO` int(11) NOT NULL AUTO_INCREMENT,
  `NM_PRODUTO` varchar(200) DEFAULT NULL,
  `DS_ENDERECO` varchar(200) DEFAULT NULL,
  `ID_CATEGORIA` int(11) NOT NULL,
  `VL_PRECO` float(10,2) DEFAULT NULL,
  PRIMARY KEY (`CD_PRODUTO`),
  KEY `ID_CATEGORIA` (`ID_CATEGORIA`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Extraindo dados da tabela `tb_produto`
--

INSERT INTO `tb_produto` (`CD_PRODUTO`, `NM_PRODUTO`, `DS_ENDERECO`, `ID_CATEGORIA`, `VL_PRECO`) VALUES
(1, 'Xbox 360', 'img/xbox.jpg', 1, 599.00),
(2, 'Mousepad Gamer', 'img/mouse.jpg', 2, 59.90),
(3, 'God Of War', 'img/godofwar.jpg', 4, 199.00),
(4, 'iPhone X', 'img/iphone.jpg', 3, 4959.90),
(5, 'Playstation 3', 'img/ps3.jpg', 1, 799.00),
(6, 'Teclado Gamer', 'img/teclado.jpg', 2, 79.90),
(7, 'LG K10', 'img/lg.jpg', 3, 579.90),
(8, 'Battlefield', 'img/tiro.jpg', 4, 189.90),
(9, 'Nintendo Switch', 'img/nintendo.jpg', 1, 499.00),
(10, 'Headset Gamer Pro V8-2.9', 'img/head.jpg', 2, 89.90),
(11, 'Asus Zenfone 3', 'img/zenfone.jpg', 3, 1400.99),
(12, 'Frozen', 'img/frozen.jpg', 4, 149.90),
(13, 'Playstation 4', 'img/ps4.jpg', 1, 2599.00),
(14, 'Roteador', 'img/rot.jpg', 2, 99.90),
(15, 'Sony Xperia 4', 'img/sony.jpg', 3, 1599.90),
(16, 'Fifa 2018', 'img/fifa.jpg', 4, 119.90),
(17, 'Super Nintendo', 'img/snes.jpg', 1, 299.90),
(18, 'Pendrive Super-Herois 16GB', 'img/pendrive.jpg', 2, 49.90),
(19, 'Grand Theft Auto V', 'img/gta.jpg', 4, 149.00),
(20, 'Samsung Galaxy S7 Edge', 'img/s7.jpg', 3, 1400.99),
(21, 'Xbox One', 'img/xone.jpg', 1, 1250.28),
(22, 'Placa de Vídeo Geoforce 600XTM', 'img/placa.jpg', 2, 259.90),
(23, 'Moto X', 'img/motox.jpg', 3, 1000.00),
(24, 'Crash Bandicoot N''Sane Trilogy', 'img/crash.jpg', 4, 209.90);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tb_compra`
--
ALTER TABLE `tb_compra`
  ADD CONSTRAINT `tb_compra_ibfk_1` FOREIGN KEY (`ID_PRODUTO`) REFERENCES `tb_produto` (`CD_PRODUTO`),
  ADD CONSTRAINT `tb_compra_ibfk_2` FOREIGN KEY (`ID_CARRINHO`) REFERENCES `tb_carrinho` (`CD_CARRINHO`);

--
-- Limitadores para a tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  ADD CONSTRAINT `tb_produto_ibfk_1` FOREIGN KEY (`ID_CATEGORIA`) REFERENCES `tb_categoria` (`CD_CATEGORIA`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
