-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29-Dez-2022 às 13:35
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `financeiro`
--
CREATE DATABASE IF NOT EXISTS `financeiro` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `financeiro`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'Periféricos'),
(3, 'Hardware');

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `telefone` varchar(12) NOT NULL,
  `observacao` text DEFAULT NULL,
  `datacadastro` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `cpf`, `telefone`, `observacao`, `datacadastro`) VALUES
(1, 'Guilherme', '12312312312', '44999999999', NULL, '2022-12-17'),
(2, 'Luiz Freitas', '78861090079', '44999999999', '', '2022-12-17'),
(4, 'Jubiscréia', '83860588036', '44999999999', '', '2022-12-18');

-- --------------------------------------------------------

--
-- Estrutura da tabela `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `marcas`
--

INSERT INTO `marcas` (`id`, `nome`) VALUES
(2, 'Corsair'),
(3, 'AMD'),
(6, 'Redragon'),
(7, 'Biostar'),
(9, 'Mancer');

-- --------------------------------------------------------

--
-- Estrutura da tabela `niveis`
--

CREATE TABLE `niveis` (
  `id` int(11) NOT NULL,
  `nivel` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `niveis`
--

INSERT INTO `niveis` (`id`, `nivel`) VALUES
(4, 'Administrador'),
(5, 'Comum'),
(16, 'Tesoureiro'),
(18, 'Root');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `categoria` int(11) NOT NULL,
  `marca` int(11) NOT NULL,
  `valor` decimal(7,2) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `categoria`, `marca`, `valor`, `descricao`) VALUES
(2, 'PLACA MÃE H610MH', 3, 7, '550.44', 'Suporte para processadores Intel Core™ i9/i7/i5/i3 de 12ª geração.'),
(3, 'MICROFONE GM300', 1, 6, '350.00', 'Belissimo Design patenteado, totalmente em metal.'),
(4, 'TECLADO GAMER KARURA', 1, 6, '100.00', 'Teclado full size slim, com apoio de pulso integrado para maior conforto.'),
(5, 'FONTE VS SERIES 500W', 3, 2, '389.50', 'São uma excelente opção para montagens básicas do sistema e atualizações.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `nivel`) VALUES
(8, 'Lazaro Henrique', 'lazaro@gmail.com', '$2y$10$i5wAKogzu4s6AoOKqaSCreCbXgGJ/mB5mkBGEgJbXiCq9TUzh4XAW', 18),
(9, 'Rusbévaldo Silva', 'adwoki@gmail.com', '$2y$10$i5wAKogzu4s6AoOKqaSCreCbXgGJ/mB5mkBGEgJbXiCq9TUzh4XAW', 4),
(10, 'Jubiscreito Silva', 'jub@gmail.com', '$2y$10$3WG7ZVyOo5a42iavT0miy.uUI9.pQqQFL8AVZhH7CpEgZM1MKsPxy', 5),
(11, 'Cleito Rasta', 'cleito@gmail.com', '$2y$10$JYL4UBroCXLDL6aS5odXbuav1XW0AV/2h5hDuhRtUhsy8yVwLhlw6', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `venda`
--

CREATE TABLE `venda` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `forma_pagamento` int(11) NOT NULL,
  `total` decimal(7,2) NOT NULL,
  `datacadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `venda`
--

INSERT INTO `venda` (`id`, `status`, `id_cliente`, `forma_pagamento`, `total`, `datacadastro`) VALUES
(28, 1, 2, 4, '1389.94', '2022-12-27 13:54:45'),
(29, 1, 4, 2, '779.00', '2022-12-27 13:56:26'),
(30, 1, 4, 1, '1100.88', '2022-12-28 10:07:35'),
(32, 1, 4, 4, '1039.94', '2022-12-28 13:24:44'),
(35, 1, 1, 3, '700.00', '2022-12-28 15:40:32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendaprodutos`
--

CREATE TABLE `vendaprodutos` (
  `id` int(11) NOT NULL,
  `id_venda` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valorunitario` decimal(7,2) NOT NULL,
  `datacadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `vendaprodutos`
--

INSERT INTO `vendaprodutos` (`id`, `id_venda`, `id_produto`, `quantidade`, `valorunitario`, `datacadastro`) VALUES
(35, 28, 2, 1, '550.44', '2022-12-27 13:54:45'),
(36, 28, 5, 1, '389.50', '2022-12-27 13:54:45'),
(37, 28, 4, 1, '100.00', '2022-12-27 13:54:45'),
(38, 28, 3, 1, '350.00', '2022-12-27 13:54:45'),
(39, 29, 5, 2, '389.50', '2022-12-27 13:56:26'),
(40, 30, 2, 2, '550.44', '2022-12-28 10:07:35'),
(57, 32, 2, 1, '550.44', '2022-12-28 13:25:53'),
(58, 32, 4, 1, '100.00', '2022-12-28 13:25:53'),
(59, 32, 5, 1, '389.50', '2022-12-28 13:25:53'),
(67, 35, 3, 2, '350.00', '2022-12-28 15:41:07');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `niveis`
--
ALTER TABLE `niveis`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produtos_fk_categorias` (`categoria`),
  ADD KEY `produtos_fk_marcas` (`marca`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarios_fk_niveis` (`nivel`);

--
-- Índices para tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venda_fk_cliente` (`id_cliente`);

--
-- Índices para tabela `vendaprodutos`
--
ALTER TABLE `vendaprodutos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendasprodutos_fk_produtos` (`id_produto`),
  ADD KEY `vendasprodutos_fk_venda` (`id_venda`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `niveis`
--
ALTER TABLE `niveis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `vendaprodutos`
--
ALTER TABLE `vendaprodutos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_fk_categorias` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `produtos_fk_marcas` FOREIGN KEY (`marca`) REFERENCES `marcas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_fk_niveis` FOREIGN KEY (`nivel`) REFERENCES `niveis` (`id`);

--
-- Limitadores para a tabela `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `venda_fk_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`);

--
-- Limitadores para a tabela `vendaprodutos`
--
ALTER TABLE `vendaprodutos`
  ADD CONSTRAINT `vendasprodutos_fk_produtos` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `vendasprodutos_fk_venda` FOREIGN KEY (`id_venda`) REFERENCES `venda` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
