-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- 생성 시간: 25-05-27 00:37
-- 서버 버전: 5.7.33-0ubuntu0.16.04.1
-- PHP 버전: 5.6.30-12~ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `bass`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `page`
--

CREATE TABLE `page` (
  `no` int(21) NOT NULL,
  `sheet_no` int(21) NOT NULL,
  `beat` int(21) NOT NULL,
  `delay` int(21) NOT NULL,
  `image_url` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 테이블 구조 `sheet`
--

CREATE TABLE `sheet` (
  `no` int(21) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `artist` varchar(255) COLLATE utf8_bin NOT NULL,
  `source` varchar(255) COLLATE utf8_bin NOT NULL,
  `audio_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `beat` int(21) NOT NULL,
  `beat_speed` int(21) NOT NULL,
  `start_delay` int(21) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`no`),
  ADD KEY `sheet_no` (`sheet_no`);

--
-- 테이블의 인덱스 `sheet`
--
ALTER TABLE `sheet`
  ADD PRIMARY KEY (`no`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `page`
--
ALTER TABLE `page`
  MODIFY `no` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=378;
--
-- 테이블의 AUTO_INCREMENT `sheet`
--
ALTER TABLE `sheet`
  MODIFY `no` int(21) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
