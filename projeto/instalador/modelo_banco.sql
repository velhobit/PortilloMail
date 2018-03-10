-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 30-Set-2016 às 20:44
-- Versão do servidor: 5.5.51-38.2
-- versão do PHP: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `porti750_mail`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliques`
--

CREATE TABLE IF NOT EXISTS `cliques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contato` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `mensagem` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `data_hora` datetime NOT NULL,
  `link` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `url` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `pasta` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nome_empresa` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `smtp` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `porta` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `seguranca` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `autenticacao` tinyint(1) NOT NULL,
  `email_resposta` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `nome_email_resposta` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `emails_por_hora` int(11) NOT NULL,
  `emails_por_hora_nao_comercial` int(11) NOT NULL,
  `horario_comercial_ini` int(11) NOT NULL,
  `horario_comercial_fin` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contatos`
--

CREATE TABLE IF NOT EXISTS `contatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) COLLATE utf8_bin NOT NULL,
  `nome` varchar(60) COLLATE utf8_bin NOT NULL,
  `telefone` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `grupo` varchar(200) COLLATE utf8_bin NOT NULL,
  `aut` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=650 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE IF NOT EXISTS `mensagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupos` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `emails_adicionais` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `mensagem` text COLLATE utf8_unicode_ci NOT NULL,
  `assunto` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email_envio` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `data_envio_ini` datetime NOT NULL,
  `data_envio_fin` datetime NOT NULL,
  `data_atualizacao` datetime NOT NULL,
  `obs` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `restantes`
--

CREATE TABLE IF NOT EXISTS `restantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mensagem` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `enviado` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `setores`
--

CREATE TABLE IF NOT EXISTS `setores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(240) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(240) COLLATE utf8_unicode_ci NOT NULL,
  `obs` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `setores` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `senha_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `views`
--

CREATE TABLE IF NOT EXISTS `views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contato` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `mensagem` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `data_hora` datetime NOT NULL,
  `link` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=492 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
