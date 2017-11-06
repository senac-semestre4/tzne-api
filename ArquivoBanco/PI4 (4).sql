-- phpMyAdmin SQL Dump
-- version 4.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 05/11/2017 às 20:33
-- Versão do servidor: 5.5.52-0+deb7u1
-- Versão do PHP: 5.6.30-1~dotdeb+zts+7.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `PI4`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`) VALUES
(1, 'Comics');

-- --------------------------------------------------------

--
-- Estrutura para tabela `client`
--

CREATE TABLE `client` (
  `client_id` int(11) NOT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `client_email` varchar(80) NOT NULL,
  `client_cpf` varchar(25) NOT NULL,
  `client_sex` varchar(1) NOT NULL,
  `client_password` varchar(60) NOT NULL,
  `client_birthday` datetime NOT NULL,
  `client_tel` varchar(20) NOT NULL,
  `client_cel` varchar(20) NOT NULL,
  `client_direct_mail` tinyint(1) DEFAULT NULL,
  `client_adress_type` varchar(15) NOT NULL,
  `client_adress_cep` varchar(11) NOT NULL,
  `client_adress_logradouro` varchar(255) NOT NULL,
  `client_adress_number` int(11) NOT NULL,
  `client_adress_complements` varchar(50) DEFAULT NULL,
  `client_adress_district` varchar(255) NOT NULL,
  `client_adress_city` varchar(255) NOT NULL,
  `client_adress_state` varchar(255) NOT NULL,
  `client_status` tinyint(1) DEFAULT NULL,
  `client_user_name` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `client`
--

INSERT INTO `client` (`client_id`, `client_name`, `client_email`, `client_cpf`, `client_sex`, `client_password`, `client_birthday`, `client_tel`, `client_cel`, `client_direct_mail`, `client_adress_type`, `client_adress_cep`, `client_adress_logradouro`, `client_adress_number`, `client_adress_complements`, `client_adress_district`, `client_adress_city`, `client_adress_state`, `client_status`, `client_user_name`) VALUES
(1, 'teste', 'teste@teste', '123456788', 'm', '$2y$10$KGzSywQ68F1YeFUxPXYYdubzTprqdyQ2apvqs70lvTbijatYgY6cS', '1000-01-01 00:00:00', '12345678', '12345674', 0, 'teste', '21354684', '213132465', 12, 'teste', 'teste', 'teste', 'teste', 0, NULL),
(2, NULL, 'TSETE@TESTE', '123465', '1', '$2y$10$shXFQuj8yqs3nWHm8QOM6OJuirrtY4bp/Kgu44a7g9sNA3iV5UhLK', '2017-10-11 00:00:00', '123456', '12345678', 0, 'teste', '12345687', 'teste', 123456, 'teste', 'teste', 'teste', 'teste', 1, NULL),
(4, NULL, 'TSETE@TESTEf', '123465', '1', '$2y$10$gPpSWZ8v4/NHKXt8ua.up.h5P8EV0ynGKhMFylgaq/YgvVxWB5GDy', '2017-10-11 00:00:00', '123456', '12345678', 0, 'teste', '12345687', 'teste', 123456, 'teste', 'teste', 'teste', 'teste', 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `departaments`
--

CREATE TABLE `departaments` (
  `departament_id` int(11) NOT NULL,
  `departament_name` varchar(50) DEFAULT NULL,
  `departament_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `departaments`
--

INSERT INTO `departaments` (`departament_id`, `departament_name`, `departament_status`) VALUES
(1, 'Feminino', 1),
(2, 'Masculino', 1),
(3, 'Infantil', 1),
(4, 'Promoção', 1),
(5, 'Acessórios', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `product_model` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `product_code` int(11) DEFAULT NULL,
  `product_specification` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `product_purchase_price` decimal(10,0) NOT NULL,
  `product_profit_margin` decimal(10,0) DEFAULT NULL,
  `product_promotional_price` decimal(10,0) DEFAULT NULL,
  `product_length` float NOT NULL,
  `product_width` float NOT NULL,
  `product_heigth` float NOT NULL,
  `product_img_relative_url` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `product_status` tinyint(1) DEFAULT NULL,
  `brands_brand_id` int(11) NOT NULL,
  `departaments_departament_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_model`, `product_code`, `product_specification`, `product_purchase_price`, `product_profit_margin`, `product_promotional_price`, `product_length`, `product_width`, `product_heigth`, `product_img_relative_url`, `product_status`, `brands_brand_id`, `departaments_departament_id`) VALUES
(10, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 0, 1, 1),
(11, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(12, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(13, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(14, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(15, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(16, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(17, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(18, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(19, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(20, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(21, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(22, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(23, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(24, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(25, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(26, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(27, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(28, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(29, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(30, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(31, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(32, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(33, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(34, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(35, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(36, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(37, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(38, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(39, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(40, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(41, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(42, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(43, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(44, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(45, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(46, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(47, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(48, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(49, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(50, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(51, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(52, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(53, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(54, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(55, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(56, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(57, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(58, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(59, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(60, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(61, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(62, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(63, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(64, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(65, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(66, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(67, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(68, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(69, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(70, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(71, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(72, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(73, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(74, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(75, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(76, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(77, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(78, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(79, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(80, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(81, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(82, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(83, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(84, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(85, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(86, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(87, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(88, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(89, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(90, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(91, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(92, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(93, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(94, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(95, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(96, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(97, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(98, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(99, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(100, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(101, 'Teste', 'teste', 123, 'especificação', 10, 10, 0, 1, 1, 1, 'sdsds', 1, 1, 1),
(102, 'vdfv', 'bgb', 12345641, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(103, 'vdfv', 'bgb', 12345641, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(104, 'testesteste', 'rqwertesteste', 21321, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(105, 'testest', 'testset', 33333333, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(106, 'Test', 'asdfasdfas', 2147483647, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(107, 'Teste', 'teste', 123, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(108, 'Teste', 'teste', 123, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(109, 'Teste', 'dfasf', 0, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(110, '11', '1', 1, '1', 1, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(111, 'Testeste', 'testestestest', 55555555, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(112, 'Testest', 'taesatse', 777777, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 0, 1, 1),
(113, 'Testest', 'taesatse', 777777, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 0, 1, 1),
(114, 'Testest', 'taesatse', 777777, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 0, 1, 1),
(115, 'Testest', 'taesatse', 777777, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 0, 1, 1),
(116, 'teste', 'teste', 444444, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(117, 'teste', 'teste', 444444, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(118, 'Teste', '656565', 12, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(119, 'testest', 'teste', 123456, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 0, 1, 1),
(120, 'Produto teste', 'Teste', 123456, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(121, 'Produto teste', 'Teste', 123456, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(122, 'Produto teste', 'Teste', 123456, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(123, 'Produto teste', 'Teste', 123456, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(124, 'Produto teste', 'Teste', 123456, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(125, 'Produto teste', 'Teste', 123456, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(126, 'Produto teste', 'Teste', 123456, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(127, 'Produto teste', 'Teste', 123456, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(128, 'Produto teste', 'Teste', 123456, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(129, 'Produto teste', 'Teste', 123456, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(130, 'Produto teste', 'Teste', 123456, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(131, 'Produto teste', 'Teste', 123456, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(132, 'Produto teste', 'Teste', 123456, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(133, 'Teste', 'teste', 0, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(134, 'Teste', 'teste', 0, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(135, 'Testestestestes', 'testestse', 123456, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(136, 'Testestestestes', 'testestse', 123456, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(137, 'Testestes', 'testets', 102, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(138, 'Testestes', 'testets', 102, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(139, 'Testestes', 'testets', 102, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(140, 'Testestes', 'testets', 102, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(141, 'Testestes', 'testets', 102, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(142, 'Testestes', 'testets', 102, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(143, 'Testestes', 'testets', 102, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(144, 'Testest', 'testes', 123123123, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(145, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(146, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(147, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(148, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(149, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(150, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(151, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(152, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(153, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(154, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(155, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(156, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(157, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(158, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(159, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(160, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(161, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(162, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(163, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(164, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(165, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(166, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(167, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(168, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(169, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(170, 'vsdf', '12', 123, '12', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(171, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(172, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(173, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(174, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(175, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(176, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(177, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(178, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(179, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(180, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(181, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(182, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(183, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(184, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(185, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(186, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(187, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(188, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(189, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(190, 'tetwe', 'etwt', 10, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(191, 'tete', 'test', 123, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(192, 'tete', 'test', 123, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(193, 'tete', 'test', 123, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(194, 'tete', 'test', 123, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(195, 'tete', 'test', 123, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(196, 'tete', 'test', 123, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(197, 'tete', 'test', 123, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(198, 'tete', 'test', 123, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(199, 'tete', 'test', 123, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(200, 'teste', 'tewt', 213321, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 1),
(201, 'Teste', 'teste', 48, 'Espec', 50, 10, 0, 50, 50, 50, 'urls teste', 1, 1, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `products_color`
--

CREATE TABLE `products_color` (
  `product_id_color` int(11) NOT NULL,
  `product_color` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `products_color`
--

INSERT INTO `products_color` (`product_id_color`, `product_color`) VALUES
(2, 'preto'),
(3, 'branco'),
(4, 'vermelho'),
(5, 'cinza'),
(6, 'verde'),
(7, 'rosa'),
(8, 'amarelo'),
(9, 'azul');

-- --------------------------------------------------------

--
-- Estrutura para tabela `products_has_products_size_color_qtd`
--

CREATE TABLE `products_has_products_size_color_qtd` (
  `products_product_id` int(11) NOT NULL,
  `products_size_product_id_size` int(11) NOT NULL,
  `products_color_product_id_color` int(11) NOT NULL,
  `product_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `products_has_products_size_color_qtd`
--

INSERT INTO `products_has_products_size_color_qtd` (`products_product_id`, `products_size_product_id_size`, `products_color_product_id_color`, `product_quantity`) VALUES
(10, 2, 2, 10),
(71, 2, 2, 10),
(72, 2, 2, 10),
(73, 2, 2, 10),
(74, 2, 2, 10),
(75, 2, 2, 10),
(76, 2, 2, 10),
(77, 2, 2, 10),
(78, 2, 2, 10),
(79, 2, 2, 10),
(80, 2, 2, 10),
(81, 2, 2, 10),
(82, 2, 2, 10),
(83, 2, 2, 10),
(84, 2, 2, 10),
(84, 3, 3, 10),
(85, 2, 2, 10),
(85, 3, 3, 10),
(86, 2, 2, 10),
(86, 3, 3, 10),
(87, 2, 2, 10),
(87, 3, 3, 10),
(88, 2, 2, 10),
(88, 3, 3, 10),
(89, 2, 2, 10),
(89, 3, 3, 10),
(90, 2, 2, 10),
(90, 3, 3, 10),
(91, 2, 2, 10),
(91, 3, 3, 10),
(92, 2, 2, 10),
(92, 3, 3, 10),
(93, 2, 2, 10),
(93, 3, 3, 10),
(97, 2, 2, 10),
(97, 3, 3, 10),
(98, 2, 3, 10),
(98, 3, 4, 10),
(99, 2, 3, 10),
(99, 3, 4, 10),
(99, 3, 4, 10),
(100, 2, 3, 10),
(100, 3, 4, 10),
(100, 3, 2, 10),
(101, 2, 3, 10),
(101, 3, 4, 10),
(101, 3, 2, 10),
(103, 2, 2, 12),
(104, 2, 2, 30),
(105, 2, 2, 30),
(105, 2, 2, 30),
(106, 2, 2, 30),
(106, 2, 2, 30),
(107, 2, 2, 10),
(108, 3, 2, 10),
(109, 2, 2, 10),
(109, 3, 3, 15),
(110, 3, 3, 15),
(111, 2, 2, 1000),
(112, 2, 2, 200),
(113, 2, 2, 200),
(114, 2, 2, 200),
(115, 2, 2, 200),
(116, 2, 2, 10),
(117, 2, 2, 10),
(118, 2, 2, 10),
(119, 2, 2, 10),
(120, 2, 2, 10),
(121, 2, 2, 10),
(122, 2, 2, 10),
(123, 2, 2, 10),
(124, 2, 2, 10),
(125, 2, 2, 10),
(126, 2, 2, 10),
(127, 2, 2, 10),
(128, 2, 2, 10),
(129, 2, 2, 10),
(130, 2, 2, 10),
(131, 2, 2, 10),
(132, 2, 2, 10),
(133, 2, 2, 10),
(134, 2, 2, 10),
(135, 2, 2, 10),
(136, 2, 2, 10),
(137, 2, 2, 10),
(138, 2, 2, 10),
(139, 2, 2, 10),
(140, 2, 2, 10),
(141, 2, 2, 10),
(142, 2, 2, 10),
(143, 2, 2, 10),
(144, 2, 2, 2),
(145, 2, 2, 10),
(146, 2, 2, 10),
(147, 2, 2, 10),
(148, 2, 2, 10),
(149, 2, 2, 10),
(150, 2, 2, 10),
(151, 2, 2, 10),
(152, 2, 2, 10),
(153, 2, 2, 10),
(154, 2, 2, 10),
(155, 2, 2, 10),
(156, 2, 2, 10),
(157, 2, 2, 10),
(158, 2, 2, 10),
(159, 2, 2, 10),
(160, 2, 2, 10),
(161, 2, 2, 10),
(162, 2, 2, 10),
(163, 2, 2, 10),
(164, 2, 2, 10),
(165, 2, 2, 10),
(166, 2, 2, 10),
(167, 2, 2, 10),
(168, 2, 2, 10),
(169, 2, 2, 10),
(170, 2, 2, 10),
(171, 2, 2, 10),
(172, 2, 2, 10),
(173, 2, 2, 10),
(174, 2, 2, 10),
(175, 2, 2, 10),
(176, 2, 2, 10),
(177, 2, 2, 10),
(178, 2, 2, 10),
(179, 2, 2, 10),
(180, 2, 2, 10),
(181, 2, 2, 10),
(182, 2, 2, 10),
(183, 2, 2, 10),
(184, 2, 2, 10),
(185, 2, 2, 10),
(186, 2, 2, 10),
(187, 2, 2, 10),
(188, 2, 2, 10),
(189, 2, 2, 10),
(190, 2, 2, 10),
(191, 2, 2, 10),
(192, 2, 2, 10),
(193, 2, 2, 10),
(194, 2, 2, 10),
(195, 2, 2, 10),
(196, 2, 2, 10),
(197, 2, 2, 10),
(198, 2, 2, 10),
(199, 2, 2, 10),
(200, 2, 2, 10),
(201, 2, 2, 10);

-- --------------------------------------------------------

--
-- Estrutura para tabela `products_size`
--

CREATE TABLE `products_size` (
  `product_id_size` int(11) NOT NULL,
  `product_size` varchar(5) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `products_size`
--

INSERT INTO `products_size` (`product_id_size`, `product_size`) VALUES
(2, 'PP'),
(3, 'P'),
(4, 'M'),
(5, 'G'),
(6, 'GG'),
(7, 'XG');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) CHARACTER SET utf8 NOT NULL,
  `user_password` varchar(60) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`) VALUES
(3, 'w', '$2y$10$Az2vVFsOoLwsIPJd5OfVT.Hp/MLJdjEmgk7BP4ACcGKQ22ehGpLdS');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Índices de tabela `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `client_email` (`client_email`),
  ADD UNIQUE KEY `client_user_name` (`client_user_name`);

--
-- Índices de tabela `departaments`
--
ALTER TABLE `departaments`
  ADD PRIMARY KEY (`departament_id`);

--
-- Índices de tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_id` (`product_id`),
  ADD KEY `fk_products_brand_idx` (`brands_brand_id`),
  ADD KEY `fk_products_departaments1_idx` (`departaments_departament_id`);

--
-- Índices de tabela `products_color`
--
ALTER TABLE `products_color`
  ADD PRIMARY KEY (`product_id_color`);

--
-- Índices de tabela `products_has_products_size_color_qtd`
--
ALTER TABLE `products_has_products_size_color_qtd`
  ADD KEY `fk_products_has_products_size_products_size1_idx` (`products_size_product_id_size`),
  ADD KEY `fk_products_has_products_size_products1_idx` (`products_product_id`),
  ADD KEY `fk_products_has_products_size_products_color1_idx` (`products_color_product_id_color`);

--
-- Índices de tabela `products_size`
--
ALTER TABLE `products_size`
  ADD PRIMARY KEY (`product_id_size`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de tabela `client`
--
ALTER TABLE `client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de tabela `departaments`
--
ALTER TABLE `departaments`
  MODIFY `departament_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;
--
-- AUTO_INCREMENT de tabela `products_color`
--
ALTER TABLE `products_color`
  MODIFY `product_id_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de tabela `products_size`
--
ALTER TABLE `products_size`
  MODIFY `product_id_size` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_brand` FOREIGN KEY (`brands_brand_id`) REFERENCES `brands` (`brand_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_products_departaments1` FOREIGN KEY (`departaments_departament_id`) REFERENCES `departaments` (`departament_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `products_has_products_size_color_qtd`
--
ALTER TABLE `products_has_products_size_color_qtd`
  ADD CONSTRAINT `fk_products_has_products_size_products1` FOREIGN KEY (`products_product_id`) REFERENCES `products` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_products_has_products_size_products_color1` FOREIGN KEY (`products_color_product_id_color`) REFERENCES `products_color` (`product_id_color`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_products_has_products_size_products_size1` FOREIGN KEY (`products_size_product_id_size`) REFERENCES `products_size` (`product_id_size`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
