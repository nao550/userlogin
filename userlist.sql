-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- ホスト: localhost
-- 生成日時: 2015 年 10 月 27 日 17:04
-- サーバのバージョン: 5.6.24-log
-- PHP のバージョン: 5.6.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- データベース: `userlist`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `levels`
--

CREATE TABLE IF NOT EXISTS `levels` (
  `cd` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'CD',
  `name` varchar(100) NOT NULL COMMENT 'レベル名',
  PRIMARY KEY (`cd`),
  UNIQUE KEY `cd` (`cd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `cd` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'CD',
  `id` varchar(255) NOT NULL COMMENT 'アカウント名',
  `pass` varchar(255) NOT NULL COMMENT 'ハッシュドパスワード',
  `name` varchar(255) NOT NULL COMMENT '表示名',
  `level` int(11) NOT NULL COMMENT '権限レベル',
  `mail` varchar(255) NOT NULL COMMENT 'メールアドレス',
  `regdate` date NOT NULL COMMENT '登録日',
  `moddate` date NOT NULL COMMENT '変更日',
  `passch` date NOT NULL COMMENT 'パスワード変更日',
  PRIMARY KEY (`cd`),
  UNIQUE KEY `cd` (`cd`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
