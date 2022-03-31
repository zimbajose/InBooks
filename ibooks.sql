-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 13-Nov-2018 às 04:13
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ibooks`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `ibook`
--
CREATE DATABASE ibooks;
USE ibooks;
CREATE TABLE `ibook` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(75) DEFAULT NULL,
  `cover_path` varchar(100) DEFAULT NULL,
  `genre` varchar(150) DEFAULT NULL,
  `released` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



--
-- Acionadores `ibook`
--
DELIMITER $$
CREATE TRIGGER `ibook_AFTER_INSERT` AFTER INSERT ON `ibook` FOR EACH ROW BEGIN
DECLARE bookid INT;
DECLARE textid INT;
SET bookid = (SELECT MAX(id) FROM ibook);
INSERT INTO text(name,ibook_id) VALUES('Primeiro Texto',bookid);
SET textid = (SELECT MAX(id) FROM text ORDER BY(id) DESC LIMIT 1);
UPDATE text SET text_id = textid WHERE id = textid; 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `save`
--

CREATE TABLE `save` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `usertobook_idusertobook` int(11) NOT NULL,
  `text_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `save`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `text`
--

CREATE TABLE `text` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `ibook_id` int(11) NOT NULL,
  `text_id` int(11) DEFAULT NULL,
  `text` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `username` varchar(16) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(32) NOT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




-- --------------------------------------------------------

--
-- Estrutura da tabela `usertobook`
--

CREATE TABLE `usertobook` (
  `idusertobook` int(11) NOT NULL,
  `isfavorite` varchar(80) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `ibook_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




--
-- Indexes for dumped tables
--

--
-- Indexes for table `ibook`
--
ALTER TABLE `ibook`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ibook_user_idx` (`user_id`);

--
-- Indexes for table `save`
--
ALTER TABLE `save`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_save_usertobook1_idx` (`usertobook_idusertobook`),
  ADD KEY `fk_save_text1_idx` (`text_id`);

--
-- Indexes for table `text`
--
ALTER TABLE `text`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_text_ibook1_idx` (`ibook_id`),
  ADD KEY `fk_text_text1_idx` (`text_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usertobook`
--
ALTER TABLE `usertobook`
  ADD PRIMARY KEY (`idusertobook`),
  ADD KEY `fk_usertobook_user1_idx` (`user_id`),
  ADD KEY `fk_usertobook_ibook1_idx` (`ibook_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ibook`
--
ALTER TABLE `ibook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `save`
--
ALTER TABLE `save`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `text`
--
ALTER TABLE `text`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `usertobook`
--
ALTER TABLE `usertobook`
  MODIFY `idusertobook` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `ibook`
--
ALTER TABLE `ibook`
  ADD CONSTRAINT `fk_ibook_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `save`
--
ALTER TABLE `save`
  ADD CONSTRAINT `fk_save_text1` FOREIGN KEY (`text_id`) REFERENCES `text` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_save_usertobook1` FOREIGN KEY (`usertobook_idusertobook`) REFERENCES `usertobook` (`idusertobook`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `text`
--
ALTER TABLE `text`
  ADD CONSTRAINT `fk_text_ibook1` FOREIGN KEY (`ibook_id`) REFERENCES `ibook` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_text_text1` FOREIGN KEY (`text_id`) REFERENCES `text` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usertobook`
--
ALTER TABLE `usertobook`
  ADD CONSTRAINT `fk_usertobook_ibook1` FOREIGN KEY (`ibook_id`) REFERENCES `ibook` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usertobook_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
