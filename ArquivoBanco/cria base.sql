-- phpMyAdmin SQL Dump
-- version 4.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 21/10/2017 às 13:53
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
CREATE DATABASE IF NOT EXISTS `PI4` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `PI4`;

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
(1, 'marca 1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `client`
--

CREATE TABLE `client` (
  `client_id` int(11) NOT NULL,
  `client_nome` varchar(80) NOT NULL,
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

INSERT INTO `client` (`client_id`, `client_nome`, `client_email`, `client_cpf`, `client_sex`, `client_password`, `client_birthday`, `client_tel`, `client_cel`, `client_direct_mail`, `client_adress_type`, `client_adress_cep`, `client_adress_logradouro`, `client_adress_number`, `client_adress_complements`, `client_adress_district`, `client_adress_city`, `client_adress_state`, `client_status`, `client_user_name`) VALUES
(2, 'teste', 'teste@teste', '123456788', 'm', '123456', '1000-01-01 00:00:00', '12345678', '12345674', 0, 'teste', '21354684', '213132465', 12, 'teste', 'teste', 'teste', 'teste', 0, 'w'),
(3, 'teste', 'teste@teste', '123456788', 'm', '123456', '1000-01-01 00:00:00', '12345678', '12345674', 0, 'teste', '21354684', '213132465', 12, 'teste', 'teste', 'teste', 'teste', 0, NULL),
(4, 'teste', 'teste@teste', '123456788', 'm', 'a01a95ca9c0e2824ad9b', '1000-01-01 00:00:00', '12345678', '12345674', 0, 'teste', '21354684', '213132465', 12, 'teste', 'teste', 'teste', 'teste', 0, NULL),
(5, 'teste', 'teste@teste', '123456788', 'm', 'a01a95ca9c0e2824ad9b', '1000-01-01 00:00:00', '12345678', '12345674', 0, 'teste', '21354684', '213132465', 12, 'teste', 'teste', 'teste', 'teste', 0, NULL),
(6, 'teste', 'teste@teste', '123456788', 'm', '$2y$10$UITIkAH4RuuA5rYhJRKgSOlyJWy4CmNTIQON6Juq.DiTaXjfdxDqq', '1000-01-01 00:00:00', '12345678', '12345674', 0, 'teste', '21354684', '213132465', 12, 'teste', 'teste', 'teste', 'teste', 0, 'wmv');

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
(1, 'Masculino', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `product_color`
--

CREATE TABLE `product_color` (
  `product_id_color` int(11) NOT NULL,
  `product_color` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `product_color`
--

INSERT INTO `product_color` (`product_id_color`, `product_color`) VALUES
(1, 'azul'),
(2, 'vermelho'),
(3, 'preto'),
(4, 'rosa'),
(5, 'verde');

-- --------------------------------------------------------

--
-- Estrutura para tabela `product_size`
--

CREATE TABLE `product_size` (
  `product_id_size` int(11) NOT NULL,
  `product_size` varchar(5) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `product_size`
--

INSERT INTO `product_size` (`product_id_size`, `product_size`) VALUES
(1, 'PP'),
(2, 'P'),
(3, 'M'),
(4, 'G'),
(5, 'GG'),
(6, 'XG');

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
  `product_stock_quantity` int(11) NOT NULL,
  `product_img_relative_url` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `product_status` tinyint(1) DEFAULT NULL,
  `brands_brand_id` int(11) NOT NULL,
  `departaments_departament_id` int(11) NOT NULL,
  `fk_product_id_color` int(11) DEFAULT NULL,
  `fk_product_size_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_model`, `product_code`, `product_specification`, `product_purchase_price`, `product_profit_margin`, `product_promotional_price`, `product_length`, `product_width`, `product_heigth`, `product_stock_quantity`, `product_img_relative_url`, `product_status`, `brands_brand_id`, `departaments_departament_id`, `fk_product_id_color`, `fk_product_size_id`) VALUES
(39, 'P5', 'model', 1, 'especificação', 10, 10, 0, 1, 1, 1, 1, 'sdsds', 0, 1, 1, 1, 5),
(47, 'p1', 'model', 2, 'especificaÃ§Ã£o', 10, 10, 0, 1, 1, 1, 1, 'sdsds', 0, 1, 1, 2, 1),
(48, 'p1', 'model', 1, 'especificaÃ§Ã£o', 10, 10, 0, 1, 1, 1, 1, 'sdsds', 0, 1, 1, 2, 3),
(49, 'p1', 'model', 0, 'especificaÃ§Ã£o', 10, 10, 0, 1, 1, 1, 1, 'sdsds', 0, 1, 1, NULL, NULL),
(50, 'p1', 'model', 0, '', 10, 10, 0, 1, 1, 1, 1, 'sdsds', 0, 1, 1, NULL, NULL),
(51, 'p1', 'model', 0, 'especificaÃ§Ã£o', 10, 10, 0, 1, 1, 1, 1, 'sdsds', 0, 1, 1, NULL, NULL),
(52, 'p1', 'model', 0, 'especificação', 10, 10, 0, 1, 1, 1, 1, 'sdsds', 0, 1, 1, NULL, NULL),
(53, 'p1', 'model', 0, 'especificação', 10, 10, 0, 1, 1, 1, 1, 'sdsds', 0, 1, 1, NULL, NULL),
(54, 'p1', 'model', 0, 'especificação', 10, 10, 0, 1, 1, 1, 1, 'sdsds', 0, 1, 1, NULL, NULL),
(55, 'p1', 'model', 0, 'especificação', 10, 10, 0, 1, 1, 1, 1, 'sdsds', 0, 1, 1, NULL, NULL),
(56, 'p1', 'model', 0, 'especificação', 10, 10, 0, 1, 1, 1, 1, 'sdsds', 0, 1, 1, NULL, NULL),
(57, 'p1', 'model', 0, 'especificação', 10, 10, 0, 1, 1, 1, 1, 'sdsds', 0, 1, 1, NULL, NULL),
(58, 'p1', 'model', 0, 'especificação', 10, 10, 0, 1, 1, 1, 1, 'sdsds', 0, 1, 1, NULL, NULL),
(59, 'p1', 'model', 0, 'especificação', 10, 10, 0, 1, 1, 1, 1, 'sdsds', 0, 1, 1, NULL, NULL),
(60, 'p1', 'model', 0, 'especificação', 10, 10, 0, 1, 1, 1, 1, 'sdsds', 0, 1, 1, NULL, NULL),
(61, 'p1', 'model', 0, 'especificação', 10, 10, 0, 1, 1, 1, 1, 'sdsds', 0, 1, 1, NULL, NULL),
(62, 'Camiseta teste 1', 'Gola V', 4, 'Espec', 50, 10, 0, 50, 50, 50, 10, 'urls teste', 1, 1, 1, 1, 1),
(63, 'Camiseta teste 2', 'X-men', 5, 'Espec', 50, 10, 0, 50, 50, 50, 10, 'urls teste', 1, 1, 1, 1, 1),
(64, 'Camiseta ', 'regata', 9, 'Espec', 50, 10, 0, 50, 50, 50, 5, 'urls teste', 1, 1, 1, 1, 1),
(66, 'fsdf', 'edfw', 1, 'Espec', 50, 10, 0, 50, 50, 50, 123, 'urls teste', 1, 1, 1, 1, 4),
(67, 'Camiseta Hulk', 'Manga longa', 70, 'Espec', 50, 10, 0, 50, 50, 50, 20, 'urls teste', 1, 1, 1, 1, 1),
(70, 'asdfasdf', 'asdfasd', 555, 'Espec', 50, 10, 0, 50, 50, 50, 0, 'urls teste', 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `produto`
--

INSERT INTO `produto` (`id`, `tipo`, `nome`) VALUES
(1, 'nome', 'nome'),
(3, 'teste3', 'teste3'),
(4, 'teste', 'teste'),
(5, 'teste', 'teste'),
(6, 'teste', 'teste'),
(7, 'teste', 'teste'),
(8, 'teste', 'teste'),
(9, 'teste', 'teste'),
(10, 'testeDao', 'testeDao'),
(11, 'testeDao', 'testeDao'),
(12, 'testeDao', 'testeDao'),
(13, 'testeDao', 'testeDao'),
(14, 'testeDao', 'testeDao'),
(15, 'testeDao', 'testeDao'),
(16, 'testeDao', 'testeDao'),
(17, 'testeDao', 'testeDao'),
(18, 'testeDao', 'testeDao'),
(19, 'testeDao', 'testeDao'),
(20, 'testeDao', 'testeDao'),
(21, 'testeDao', 'testeDao'),
(22, 'testeDao', 'testeDao'),
(23, 'testeDao', 'testeDao'),
(24, 'testeDao', 'testeDao'),
(25, 'testeDao', 'testeDao'),
(26, 'testeDao', 'testeDao'),
(27, 'testeDao', 'testeDao'),
(28, 'testeDao', 'testeDao'),
(29, 'testeDao', 'testeDao'),
(30, 'testeDao', 'testeDao'),
(31, 'testeDao', 'testeDao'),
(32, 'teste3', 'teste3'),
(33, 'teste3', 'teste3'),
(34, 'teste3', 'teste3'),
(35, 'teste3', 'teste3'),
(36, 'teste3', 'teste3'),
(37, 'testeDao', 'testeDao'),
(38, 'testeDao', 'testeDao'),
(39, 'testeDao', 'testeDao'),
(40, 'testeDao', 'testeDao'),
(41, 'teste3', 'teste3'),
(42, 'testeDao', 'testeDao'),
(43, 'testeDao', 'testeDao'),
(44, 'testeDao', 'testeDao'),
(45, 'testeDao', 'testeDao'),
(46, 'testeDao', 'testeDao'),
(47, 'testeDao', 'testeDao'),
(48, 'testeDao', 'testeDao'),
(49, 'testeDao', 'testeDao'),
(50, 'testeDao', 'testeDao'),
(51, 'testeDao', 'testeDao'),
(52, 'testeDao', 'testeDao'),
(53, 'testeDao', 'testeDao');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`) VALUES
(8, 'w', '$2y$10$LMuWODXUR5fdeQZ7b.1vkOO28tXDm4A.k0FIVanDf4TNqzyDH93O6'),
(9, 'ww', '$2y$10$P5lv/hMGEIuZ3OZUZ1xf5.GWEiU4nIYGocHq4vDmV2PQbT4nDEEoW'),
(11, 'Aug', '$2y$10$RmCWAEbbDStnnNtJN/8p1eMPVYVxliifsM6DeNT40H8A6GHK5O3mq');

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
  ADD UNIQUE KEY `client_user_name` (`client_user_name`);

--
-- Índices de tabela `departaments`
--
ALTER TABLE `departaments`
  ADD PRIMARY KEY (`departament_id`);

--
-- Índices de tabela `product_color`
--
ALTER TABLE `product_color`
  ADD PRIMARY KEY (`product_id_color`);

--
-- Índices de tabela `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`product_id_size`);

--
-- Índices de tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_products_brand_idx` (`brands_brand_id`),
  ADD KEY `fk_products_departaments1_idx` (`departaments_departament_id`),
  ADD KEY `fk_product_id_color` (`fk_product_id_color`),
  ADD KEY `fk_product_size_id` (`fk_product_size_id`);

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
  ADD UNIQUE KEY `user_name` (`user_name`);

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
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de tabela `departaments`
--
ALTER TABLE `departaments`
  MODIFY `departament_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de tabela `product_color`
--
ALTER TABLE `product_color`
  MODIFY `product_id_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de tabela `product_size`
--
ALTER TABLE `product_size`
  MODIFY `product_id_size` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_brand` FOREIGN KEY (`brands_brand_id`) REFERENCES `brands` (`brand_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_products_departaments1` FOREIGN KEY (`departaments_departament_id`) REFERENCES `departaments` (`departament_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`fk_product_id_color`) REFERENCES `product_color` (`product_id_color`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`fk_product_size_id`) REFERENCES `product_size` (`product_id_size`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
