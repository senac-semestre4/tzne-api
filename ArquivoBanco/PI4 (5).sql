-- phpMyAdmin SQL Dump
-- version 4.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 13/11/2017 às 02:19
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
-- Estrutura para tabela `adresses`
--

CREATE TABLE `adresses` (
  `adress_id` int(11) NOT NULL,
  `adress_type` varchar(15) NOT NULL,
  `adress_cep` varchar(10) NOT NULL,
  `adress_logradouro` varchar(255) NOT NULL,
  `adress_number` varchar(20) NOT NULL,
  `adress_complements` varchar(100) NOT NULL,
  `adress_district` varchar(100) NOT NULL,
  `adress_city` varchar(100) NOT NULL,
  `adress_state` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `adresses`
--

INSERT INTO `adresses` (`adress_id`, `adress_type`, `adress_cep`, `adress_logradouro`, `adress_number`, `adress_complements`, `adress_district`, `adress_city`, `adress_state`) VALUES
(1, 'casa', '04918110', 'Rua Hélio Jacy Gouveia', '42', 'Casa 4', 'Jardim Souza', 'São Paulo', 'SP');

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
  `client_birthday` date NOT NULL,
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
(1, 'Everton Roberto', 'everton_roliveira@outlook.com', '411.439.358-70', '1', '$2y$10$gP7SWZ8v4/NHKXt8ua.do.h5P8Er0ynGKhMFylgaq/YgvVxWB5GDy', '1993-04-02', '1155152677', '11951669431', 1, '1', '04918110', 'Rua Helio Jacy Gouveia', 42, 'Casa 4', 'Jd Souza', 'Sao Paulo', 'SP', 1, 'everton');

-- --------------------------------------------------------

--
-- Estrutura para tabela `client_has_adresses`
--

CREATE TABLE `client_has_adresses` (
  `cha_id` int(11) NOT NULL,
  `client_client_id` int(11) NOT NULL,
  `adresses_adress_id` int(11) NOT NULL,
  `adress_main` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `client_has_adresses`
--

INSERT INTO `client_has_adresses` (`cha_id`, `client_client_id`, `adresses_adress_id`, `adress_main`) VALUES
(1, 1, 1, 1);

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
(4, 'Promoção', 0),
(5, 'Acessórios', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `helpdesk_protocols`
--

CREATE TABLE `helpdesk_protocols` (
  `id_protocol` int(11) NOT NULL,
  `client_name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `tel` varchar(200) NOT NULL,
  `short_description` varchar(30) NOT NULL,
  `prob_reported` text NOT NULL,
  `solotion` text,
  `protocol_status` int(11) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `resolved_by` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `helpdesk_protocols`
--

INSERT INTO `helpdesk_protocols` (`id_protocol`, `client_name`, `email`, `tel`, `short_description`, `prob_reported`, `solotion`, `protocol_status`, `creation_date`, `update_date`, `end_date`, `resolved_by`) VALUES
(1, 'Valdisney Windson filho', 'vwf@gmail.com', '11 98565225', '', 'Não consigo acessar a minha área de cliente', NULL, 1, '2017-11-10 18:00:00', NULL, NULL, NULL),
(11, 'Everton', 'everton@gmail.com', '112258855', 'Cancelar compra', 'Quero cancelar a compra de pedido número 10', 'Olá Everton, \r\nConforme solicitado, compra cancelada', 1, '2017-11-12 22:14:45', NULL, NULL, 'Willian'),
(12, 'Karina', 'karina@gmail.com', '11 5585885', 'Falha ao comprar', 'Não consigo comprar a camiseta x', 'Ola', 1, '2017-11-12 22:43:38', NULL, NULL, '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `helpdesk_status`
--

CREATE TABLE `helpdesk_status` (
  `id_status` int(11) NOT NULL,
  `name_status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `helpdesk_status`
--

INSERT INTO `helpdesk_status` (`id_status`, `name_status`) VALUES
(1, 'Aberto'),
(2, 'Em andamento'),
(3, 'Resolvido');

-- --------------------------------------------------------

--
-- Estrutura para tabela `item_for_sale`
--

CREATE TABLE `item_for_sale` (
  `item_for_sale_id` int(11) NOT NULL,
  `sale_id_sale` int(11) NOT NULL,
  `product_product_has_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(19,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `item_for_sale`
--

INSERT INTO `item_for_sale` (`item_for_sale_id`, `sale_id_sale`, `product_product_has_id`, `quantity`, `subtotal`) VALUES
(3, 2, 153, 1, 55.50),
(4, 5, 178, 2, 115.00),
(5, 5, 178, 2, 115.00),
(6, 6, 178, 2, 115.00),
(7, 6, 178, 2, 115.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `newsletter`
--

CREATE TABLE `newsletter` (
  `newsletter_id` int(11) NOT NULL,
  `newsletter_email` varchar(255) NOT NULL,
  `newsletter_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `order_status`
--

CREATE TABLE `order_status` (
  `order_status_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `order_status`
--

INSERT INTO `order_status` (`order_status_id`, `name`) VALUES
(1, 'Pedido em Aprovação'),
(2, 'Produto a ser enviado'),
(3, 'Pedido entregue       ');

-- --------------------------------------------------------

--
-- Estrutura para tabela `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `product_model` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `product_code` int(11) DEFAULT NULL,
  `product_description` text COLLATE utf8_unicode_ci NOT NULL,
  `product_specification` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `product_purchase_price` decimal(19,2) NOT NULL,
  `product_profit_margin` decimal(19,2) DEFAULT NULL,
  `product_price_sale` decimal(19,2) NOT NULL,
  `product_promotional_price` decimal(19,2) DEFAULT NULL,
  `product_length` float NOT NULL,
  `product_width` float NOT NULL,
  `product_heigth` float NOT NULL,
  `product_weight` float NOT NULL,
  `product_img_relative_url` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `product_status` tinyint(1) DEFAULT NULL,
  `brands_brand_id` int(11) NOT NULL,
  `departaments_departament_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_model`, `product_code`, `product_description`, `product_specification`, `product_purchase_price`, `product_profit_margin`, `product_price_sale`, `product_promotional_price`, `product_length`, `product_width`, `product_heigth`, `product_weight`, `product_img_relative_url`, `product_status`, `brands_brand_id`, `departaments_departament_id`) VALUES
(10, 'Camiseta Homem Aranha', 'Manga curta', 123, '', 'Lorem Ipsum é simplesmente uma simulação de texto ', 10.00, 0.00, 20.20, 0.00, 1, 1, 1, 0, 'sdsds', 1, 1, 1),
(217, 'Camiseta Capitão América', 'Manga curta', 456, '', 'Lorem Ipsum é simplesmente uma simulação de texto ', 15.50, 0.00, 55.50, 45.45, 30, 20, 10, 0, 'urls teste', 1, 1, 2),
(218, 'Camiseta Homem aranha', 'Manga longa', 20, '', 'Espec', 50.00, 10.00, 0.00, 0.00, 50, 50, 50, 0, 'http://tzne.kwcraft.com.br/images/produtos/1.jpg', 1, 1, 1),
(219, 'Camiseta Capitao America', 'Manga curta', 21, '', 'Camiseta Capitao America', 69.00, 10.00, 0.00, 0.00, 50, 50, 50, 0, 'http://tzne.kwcraft.com.br/images/produtos/2.jpg', 1, 1, 1),
(220, 'Camiseta Batman', 'Manga longa', 22, '', 'Camiseta Batman', 79.00, 10.00, 0.00, 0.00, 50, 50, 50, 0, 'http://tzne.kwcraft.com.br/images/produtos/3.jpg', 1, 1, 1),
(221, 'Camiseta Super-Homem', 'Manga curta', 23, '', 'Camiseta Super-Homem', 50.00, 10.00, 0.00, 0.00, 50, 50, 50, 0, 'http://tzne.kwcraft.com.br/images/produtos/4.jpg', 1, 1, 1),
(222, 'Camiseta Capitão América', 'Manga curta', 24, '', 'Camiseta Capitão América Feminina', 50.00, 10.00, 0.00, 0.00, 50, 50, 50, 0, 'http://tzne.kwcraft.com.br/images/produtos/5.jpg', 1, 1, 1),
(223, 'Camiseta Flesh ', 'Manga curta', 25, '', 'Camiseta Flesh Feminina', 50.00, 10.00, 0.00, 0.00, 50, 50, 50, 0, 'http://tzne.kwcraft.com.br/images/produtos/6.jpg', 1, 1, 1),
(224, 'Camiseta Super-homem', 'Manga curta', 26, '', 'Camiseta Feminina Super-homem', 50.00, 10.00, 0.00, 0.00, 50, 50, 50, 0, 'http://tzne.kwcraft.com.br/images/produtos/7.jpg', 1, 1, 1),
(225, 'Camiseta Thundercats', 'Manga curta', 27, '', 'Camiseta Feminina Thundercats', 50.00, 10.00, 0.00, 0.00, 50, 50, 50, 0, 'http://tzne.kwcraft.com.br/images/produtos/8.jpg', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `products_color`
--

CREATE TABLE `products_color` (
  `product_id_color` int(11) NOT NULL,
  `product_color` varchar(50) CHARACTER SET utf8 NOT NULL,
  `product_hexa` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `products_color`
--

INSERT INTO `products_color` (`product_id_color`, `product_color`, `product_hexa`) VALUES
(2, 'preto', NULL),
(3, 'branco', NULL),
(4, 'vermelho', NULL),
(5, 'cinza', NULL),
(6, 'verde', NULL),
(7, 'rosa', NULL),
(8, 'amarelo', NULL),
(9, 'azul', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `products_has_products_size_color_qtd`
--

CREATE TABLE `products_has_products_size_color_qtd` (
  `product_has_id` int(11) NOT NULL,
  `products_product_id` int(11) NOT NULL,
  `products_size_product_id_size` int(11) NOT NULL,
  `products_color_product_id_color` int(11) NOT NULL,
  `product_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `products_has_products_size_color_qtd`
--

INSERT INTO `products_has_products_size_color_qtd` (`product_has_id`, `products_product_id`, `products_size_product_id_size`, `products_color_product_id_color`, `product_quantity`) VALUES
(153, 10, 2, 2, 5),
(178, 217, 3, 4, 10),
(179, 218, 2, 2, 10),
(180, 219, 2, 2, 10),
(181, 221, 2, 2, 10),
(182, 222, 2, 2, 10),
(183, 223, 2, 2, 10),
(184, 224, 2, 2, 10),
(185, 225, 2, 2, 10);

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
-- Estrutura para tabela `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `client_client_id` int(11) NOT NULL,
  `total_partial` decimal(19,2) NOT NULL,
  `amount` decimal(19,2) NOT NULL,
  `discount` decimal(19,2) NOT NULL,
  `type_freight` varchar(20) NOT NULL,
  `value_freight` decimal(19,2) NOT NULL,
  `number_plots` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `sales`
--

INSERT INTO `sales` (`sale_id`, `client_client_id`, `total_partial`, `amount`, `discount`, `type_freight`, `value_freight`, `number_plots`) VALUES
(2, 1, 55.50, 55.50, 0.00, 'correios', 16.80, 2),
(5, 1, 55.00, 55.00, 0.00, 'correios', 15.00, 2),
(6, 1, 55.00, 55.00, 0.00, 'correios', 15.00, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `sale_has_order_status`
--

CREATE TABLE `sale_has_order_status` (
  `sale_has_order_status_id` int(11) NOT NULL,
  `sales_sale_id` int(11) DEFAULT NULL,
  `order_status_order_status_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `informed_cli` tinyint(1) DEFAULT NULL,
  `comment` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `sale_has_order_status`
--

INSERT INTO `sale_has_order_status` (`sale_has_order_status_id`, `sales_sale_id`, `order_status_order_status_id`, `date`, `informed_cli`, `comment`) VALUES
(2, 2, 1, '2017-11-07 21:40:25', 1, 'Pedido aguardando aprovação.'),
(5, 5, 3, '0000-00-00 00:00:00', 1, 'Pedido aguardando aprovação.'),
(6, 6, 1, '0000-00-00 00:00:00', 1, 'Pedido aguardando aprovação.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `users_roles_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `user_password` varchar(60) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `users`
--

INSERT INTO `users` (`user_id`, `users_roles_id`, `user_name`, `user_password`) VALUES
(3, 4, 'w', '$2y$10$Az2vVFsOoLwsIPJd5OfVT.Hp/MLJdjEmgk7BP4ACcGKQ22ehGpLdS');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users_roles`
--

CREATE TABLE `users_roles` (
  `user_role_id` int(11) NOT NULL,
  `name_role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `users_roles`
--

INSERT INTO `users_roles` (`user_role_id`, `name_role`) VALUES
(1, 'admin'),
(2, 'manager'),
(3, 'financial'),
(4, 'stockist');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `adresses`
--
ALTER TABLE `adresses`
  ADD PRIMARY KEY (`adress_id`);

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
-- Índices de tabela `client_has_adresses`
--
ALTER TABLE `client_has_adresses`
  ADD PRIMARY KEY (`cha_id`),
  ADD KEY `fk_cliente_has_adresses_client_idx` (`client_client_id`),
  ADD KEY `fk_client_has_adresses_adress_idx` (`adresses_adress_id`);

--
-- Índices de tabela `departaments`
--
ALTER TABLE `departaments`
  ADD PRIMARY KEY (`departament_id`);

--
-- Índices de tabela `helpdesk_protocols`
--
ALTER TABLE `helpdesk_protocols`
  ADD PRIMARY KEY (`id_protocol`),
  ADD KEY `fk_helpdesk_status` (`protocol_status`);

--
-- Índices de tabela `helpdesk_status`
--
ALTER TABLE `helpdesk_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Índices de tabela `item_for_sale`
--
ALTER TABLE `item_for_sale`
  ADD PRIMARY KEY (`item_for_sale_id`),
  ADD KEY `fk_ifs_sale_idx` (`sale_id_sale`),
  ADD KEY `fk_product_has_id_idx` (`product_product_has_id`);

--
-- Índices de tabela `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`newsletter_id`);

--
-- Índices de tabela `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`order_status_id`);

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
  ADD PRIMARY KEY (`product_id_color`),
  ADD UNIQUE KEY `product_id_color_UNIQUE` (`product_id_color`);

--
-- Índices de tabela `products_has_products_size_color_qtd`
--
ALTER TABLE `products_has_products_size_color_qtd`
  ADD PRIMARY KEY (`product_has_id`),
  ADD UNIQUE KEY `uq_product_size_color` (`products_product_id`,`products_size_product_id_size`,`products_color_product_id_color`),
  ADD KEY `fk_phpscq_product_idx` (`products_product_id`),
  ADD KEY `fk_phpscq_size_idx` (`products_size_product_id_size`),
  ADD KEY `fk_phpscq_color_idx` (`products_color_product_id_color`);

--
-- Índices de tabela `products_size`
--
ALTER TABLE `products_size`
  ADD PRIMARY KEY (`product_id_size`),
  ADD UNIQUE KEY `product_id_size_UNIQUE` (`product_id_size`);

--
-- Índices de tabela `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD UNIQUE KEY `sale_id_UNIQUE` (`sale_id`),
  ADD KEY `fk_sale_client_idx` (`client_client_id`);

--
-- Índices de tabela `sale_has_order_status`
--
ALTER TABLE `sale_has_order_status`
  ADD PRIMARY KEY (`sale_has_order_status_id`),
  ADD KEY `fk_shos_sale_idx` (`sales_sale_id`),
  ADD KEY `fk_shos_order_status_idx` (`order_status_order_status_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `fk_users_roles_id` (`users_roles_id`);

--
-- Índices de tabela `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`user_role_id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `adresses`
--
ALTER TABLE `adresses`
  MODIFY `adress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
-- AUTO_INCREMENT de tabela `client_has_adresses`
--
ALTER TABLE `client_has_adresses`
  MODIFY `cha_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de tabela `departaments`
--
ALTER TABLE `departaments`
  MODIFY `departament_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de tabela `helpdesk_protocols`
--
ALTER TABLE `helpdesk_protocols`
  MODIFY `id_protocol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de tabela `helpdesk_status`
--
ALTER TABLE `helpdesk_status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de tabela `item_for_sale`
--
ALTER TABLE `item_for_sale`
  MODIFY `item_for_sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de tabela `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `newsletter_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `order_status`
--
ALTER TABLE `order_status`
  MODIFY `order_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;
--
-- AUTO_INCREMENT de tabela `products_color`
--
ALTER TABLE `products_color`
  MODIFY `product_id_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de tabela `products_has_products_size_color_qtd`
--
ALTER TABLE `products_has_products_size_color_qtd`
  MODIFY `product_has_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;
--
-- AUTO_INCREMENT de tabela `products_size`
--
ALTER TABLE `products_size`
  MODIFY `product_id_size` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de tabela `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de tabela `sale_has_order_status`
--
ALTER TABLE `sale_has_order_status`
  MODIFY `sale_has_order_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de tabela `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `user_role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `client_has_adresses`
--
ALTER TABLE `client_has_adresses`
  ADD CONSTRAINT `fk_client_has_adresses_adress` FOREIGN KEY (`adresses_adress_id`) REFERENCES `adresses` (`adress_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_has_adresses_client` FOREIGN KEY (`client_client_id`) REFERENCES `client` (`client_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `helpdesk_protocols`
--
ALTER TABLE `helpdesk_protocols`
  ADD CONSTRAINT `fk_helpdesk_status` FOREIGN KEY (`protocol_status`) REFERENCES `helpdesk_status` (`id_status`);

--
-- Restrições para tabelas `item_for_sale`
--
ALTER TABLE `item_for_sale`
  ADD CONSTRAINT `fk_product_has_id` FOREIGN KEY (`product_product_has_id`) REFERENCES `products_has_products_size_color_qtd` (`product_has_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ifs_sale` FOREIGN KEY (`sale_id_sale`) REFERENCES `sales` (`sale_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_phpscq_product` FOREIGN KEY (`products_product_id`) REFERENCES `products` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_phpscq_size` FOREIGN KEY (`products_size_product_id_size`) REFERENCES `products_size` (`product_id_size`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_phpscq_color` FOREIGN KEY (`products_color_product_id_color`) REFERENCES `products_color` (`product_id_color`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `fk_sale_client` FOREIGN KEY (`client_client_id`) REFERENCES `client` (`client_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `sale_has_order_status`
--
ALTER TABLE `sale_has_order_status`
  ADD CONSTRAINT `fk_shos_order_status` FOREIGN KEY (`order_status_order_status_id`) REFERENCES `order_status` (`order_status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_shos_sale` FOREIGN KEY (`sales_sale_id`) REFERENCES `sales` (`sale_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_roles_id` FOREIGN KEY (`users_roles_id`) REFERENCES `users_roles` (`user_role_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
