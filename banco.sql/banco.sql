-- Banco de dados: loja
-- Projeto: Crimson Otaku
-- Este arquivo cria as tabelas principais do projeto e insere dados iniciais.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `pedidos`;
DROP TABLE IF EXISTS `camiseta_tags`;
DROP TABLE IF EXISTS `tags`;
DROP TABLE IF EXISTS `camisetas`;
DROP TABLE IF EXISTS `categorias`;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `camisetas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `imagem2` varchar(255) DEFAULT NULL,
  `tamanho` varchar(20) DEFAULT 'P, M, G, GG',
  `estoque` int(11) NOT NULL DEFAULT 10,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_camisetas_categoria` (`categoria_id`),
  CONSTRAINT `fk_camisetas_categorias`
    FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `camiseta_id` int(11) NOT NULL,
  `cliente` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `tamanho` varchar(5) NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Pendente',
  `data_pedido` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_pedidos_camiseta` (`camiseta_id`),
  CONSTRAINT `fk_pedidos_camisetas`
    FOREIGN KEY (`camiseta_id`) REFERENCES `camisetas` (`id`)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `camiseta_tags` (
  `camiseta_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`camiseta_id`, `tag_id`),
  KEY `idx_camiseta_tags_tag` (`tag_id`),
  CONSTRAINT `fk_camiseta_tags_camisetas`
    FOREIGN KEY (`camiseta_id`) REFERENCES `camisetas` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT `fk_camiseta_tags_tags`
    FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categorias` (`id`, `nome`, `descricao`) VALUES
(1, 'Anime', 'Camisetas inspiradas em animes e mangás.'),
(2, 'Games', 'Camisetas inspiradas em jogos e cultura gamer.'),
(3, 'Geek', 'Camisetas inspiradas em filmes, séries e cultura pop.');

INSERT INTO `camisetas` (`id`, `categoria_id`, `nome`, `descricao`, `preco`, `imagem`, `imagem2`, `tamanho`, `estoque`, `ativo`) VALUES
(1, 1, 'Camiseta Naruto', 'Camiseta com estampa Naruto, ideal para fãs de anime e cultura otaku.', 59.90, 'naruto.jpg', 'naruto costas.jpg', 'P, M, G, GG', 12, 1),
(2, 1, 'Camiseta One Piece', 'Camiseta com estampa Luffy, perfeita para quem acompanha aventuras piratas.', 69.90, 'one piece frente.jpg', 'one piece costas.jpg', 'P, M, G, GG', 10, 1),
(3, 1, 'Camiseta Akatsuki', 'Camiseta preta com visual inspirado na Akatsuki.', 79.90, 'akatsuki frente.jpg', 'akatsuki costas.jpg', 'P, M, G, GG', 8, 1),
(4, 1, 'Camiseta Dragon Ball', 'Camiseta com estampa Goku Ultra Instinto para fãs de Dragon Ball.', 74.90, 'goku frente.jpeg', 'goku costas.jpeg', 'P, M, G, GG', 9, 1),
(5, 1, 'Camiseta Solo Leveling', 'Camiseta inspirada em Sung Jin-Woo com estampa de alto contraste.', 84.90, 'sung.png', 'sung costas.png', 'P, M, G, GG', 7, 1),
(6, 3, 'Camiseta Luffy Gear', 'Camiseta geek com visual marcante inspirada no universo One Piece.', 89.90, 'luffy.jpg', NULL, 'P, M, G, GG', 6, 1);

INSERT INTO `pedidos` (`id`, `camiseta_id`, `cliente`, `email`, `telefone`, `quantidade`, `tamanho`, `valor_total`, `status`, `data_pedido`) VALUES
(1, 1, 'Cliente Exemplo', 'cliente@email.com', '(44) 99999-9999', 1, 'M', 59.90, 'Pendente', '2026-06-25 10:00:00'),
(2, 2, 'Maria Silva', 'maria@email.com', '(44) 98888-8888', 2, 'G', 139.80, 'Confirmado', '2026-06-25 11:30:00');

INSERT INTO `tags` (`id`, `nome`) VALUES
(1, 'Anime'),
(2, 'Otaku'),
(3, 'Ação'),
(4, 'Clássico'),
(5, 'Lançamento');

INSERT INTO `camiseta_tags` (`camiseta_id`, `tag_id`) VALUES
(1, 1),
(1, 2),
(1, 4),
(2, 1),
(2, 2),
(2, 5),
(3, 1),
(3, 3),
(4, 1),
(4, 4),
(5, 1),
(5, 3),
(5, 5),
(6, 1),
(6, 2);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
