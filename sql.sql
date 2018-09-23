-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-09-23 18:22:24
-- 服务器版本： 5.6.37-log
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app`
--

-- --------------------------------------------------------

--
-- 表的结构 `dorm_house`
--

CREATE TABLE `dorm_house` (
  `id` int(11) NOT NULL COMMENT '系统ID',
  `name` varchar(20) NOT NULL COMMENT '姓名',
  `ybuid` varchar(10) NOT NULL COMMENT '易班UID',
  `room` varchar(10) NOT NULL COMMENT '房间号',
  `floor` varchar(4) NOT NULL COMMENT '楼栋'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `dorm_order`
--

CREATE TABLE `dorm_order` (
  `id` int(6) NOT NULL COMMENT '系统ID',
  `uid` varchar(10) NOT NULL COMMENT '用户易班ID',
  `type` text NOT NULL COMMENT '故障类型',
  `desc` text NOT NULL COMMENT '具体问题描述',
  `floor` char(2) NOT NULL COMMENT '楼栋',
  `room` varchar(14) NOT NULL COMMENT '房间号',
  `tel` varchar(11) NOT NULL COMMENT '联系电话',
  `SubmitTime` datetime NOT NULL COMMENT '订单提交时间',
  `access` int(1) NOT NULL DEFAULT '1' COMMENT '允许无人时维修 ',
  `state` int(1) NOT NULL DEFAULT '0' COMMENT '维修状态',
  `RepairPerson` varchar(10) DEFAULT NULL COMMENT '维修人',
  `RepairTime` datetime DEFAULT NULL COMMENT '维修时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `dorm_person`
--

CREATE TABLE `dorm_person` (
  `id` int(5) NOT NULL COMMENT '系统编号',
  `name` varchar(10) NOT NULL COMMENT '维修人员姓名',
  `area` char(2) NOT NULL COMMENT '负责的区域',
  `sex` varchar(2) NOT NULL DEFAULT '男' COMMENT '维修人员性别',
  `tel` char(11) NOT NULL COMMENT '维修人员手机号码',
  `score` float NOT NULL DEFAULT '0' COMMENT '综合评分'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dorm_house`
--
ALTER TABLE `dorm_house`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ybuid` (`ybuid`);

--
-- Indexes for table `dorm_order`
--
ALTER TABLE `dorm_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dorm_person`
--
ALTER TABLE `dorm_person`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `dorm_house`
--
ALTER TABLE `dorm_house`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '系统ID', AUTO_INCREMENT=710;

--
-- 使用表AUTO_INCREMENT `dorm_order`
--
ALTER TABLE `dorm_order`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT COMMENT '系统ID', AUTO_INCREMENT=434;

--
-- 使用表AUTO_INCREMENT `dorm_person`
--
ALTER TABLE `dorm_person`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT COMMENT '系统编号', AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
