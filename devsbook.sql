-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19-Jul-2022 às 03:56
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `devsbook`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `postcomments`
--

CREATE TABLE `postcomments` (
  `id` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `postcomments`
--

INSERT INTO `postcomments` (`id`, `id_post`, `id_user`, `created_at`, `body`) VALUES
(1, 11, 13, '2022-06-29 20:19:46', 'Que bacana Iran!'),
(3, 10, 14, '2022-06-29 20:52:40', 'Funcionou!'),
(4, 11, 14, '2022-06-29 20:53:05', 'Ufa.'),
(8, 11, 13, '2022-06-29 21:45:14', 'teste'),
(13, 10, 13, '2022-07-01 03:03:25', 'opa'),
(14, 10, 13, '2022-07-01 03:05:15', 'legal');

-- --------------------------------------------------------

--
-- Estrutura da tabela `postlikes`
--

CREATE TABLE `postlikes` (
  `id` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `postlikes`
--

INSERT INTO `postlikes` (`id`, `id_post`, `id_user`, `created_at`) VALUES
(5, 10, 13, '2022-06-29 14:51:05'),
(6, 10, 14, '2022-06-29 14:51:15'),
(12, 11, 13, '2022-06-29 16:45:12');

-- --------------------------------------------------------

--
-- Estrutura da tabela `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `posts`
--

INSERT INTO `posts` (`id`, `id_user`, `type`, `created_at`, `body`) VALUES
(1, 13, 'text', '2022-06-15 01:49:36', 'Primeiro post no Devsbook!'),
(2, 14, 'text', '2022-06-15 01:50:54', 'Segundo post no Devsbook!'),
(8, 13, 'text', '2022-06-15 03:05:06', 'Pessoal, tudo bem! Busco parceiros para empreender comigo em meu software.\r\n\r\nAcabei de aprová-lo na Appstore. É um sistema de atendimento via WhatsApp multi-atendentes para auxiliar empresas.\r\n\r\nEste sistema permite que vários funcionários/colaboradores da empresa atendam um mesmo número de WhatsApp, mesmo que estejam trabalhando remotamente, sendo que cada um acessa com um login e senha particular....'),
(9, 17, 'text', '2022-06-15 21:16:33', 'Aqui é o Gabriel'),
(10, 13, 'text', '2022-06-17 22:07:52', 'teste'),
(11, 14, 'text', '2022-06-23 22:37:23', 'Bitcoin subiu galera'),
(27, 13, 'photo', '2022-07-19 02:03:54', 'd454f9632b4e7a6922551a4a9ba29c36'),
(28, 13, 'photo', '2022-07-19 03:53:43', '02c6d34e380a2899737de970bd34aadf');

-- --------------------------------------------------------

--
-- Estrutura da tabela `userrelations`
--

CREATE TABLE `userrelations` (
  `id` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `user_to` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `userrelations`
--

INSERT INTO `userrelations` (`id`, `user_from`, `user_to`) VALUES
(1, 14, 13),
(32, 13, 14);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `city` varchar(100) NOT NULL,
  `work` varchar(100) NOT NULL,
  `avatar` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `cover` varchar(100) NOT NULL DEFAULT 'cover.jpg',
  `token` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `birthdate`, `city`, `work`, `avatar`, `cover`, `token`) VALUES
(13, 'darqueboost@gmail.com', '$2y$10$FG9E3UkD9NlNdXKrIFvC4eHpRYocNFL81/KxGKQzcuLDkLAbdLi4S', 'Daniel Alves', '2004-10-20', 'São Paulo', 'SESI', 'cb280b1253c527a06aa2f0fe6f943e5d', '93e661f97d256832c0e2dd7add37d558', 'e7cccc73744eaeab293a52d2dbbb7b56'),
(14, 'iran@gmail.com', '$2y$10$HRk.ce9QYXTQ1RNw8vX5iugiUxFdGxmV1oVwcAB7v0./SJCqFAtCm', 'George Robson', '1990-02-15', '', '', '8291815bd3ed44b8409cddf2fdfe4875', '797d3cd15a74fc912f69616d525e8370', '31a6bbf4bb421c00c5cf7b15240ce87d'),
(17, 'gabriel@gmail.com', '$2y$10$ZAHlT2sidqr5Jfv/DIndZuhZHHls0kYGLLV6F4uWe2WJ2h5C8zcS6', 'Gabriel', '2000-04-08', 'São Sebastião', '', 'default.jpg', 'cover.jpg', '5529ac30e80b4aa7710a53b9621da708');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `postcomments`
--
ALTER TABLE `postcomments`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `postlikes`
--
ALTER TABLE `postlikes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `userrelations`
--
ALTER TABLE `userrelations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `postcomments`
--
ALTER TABLE `postcomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `postlikes`
--
ALTER TABLE `postlikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `userrelations`
--
ALTER TABLE `userrelations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
