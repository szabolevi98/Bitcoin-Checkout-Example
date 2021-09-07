/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50562
Source Host           : 192.168.0.110:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50562
File Encoding         : 65001

Date: 2021-09-07 10:01:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `bitcoin_log`
-- ----------------------------
DROP TABLE IF EXISTS `bitcoin_log`;
CREATE TABLE `bitcoin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction` varchar(100) COLLATE latin2_hungarian_ci NOT NULL,
  `username` varchar(100) COLLATE latin2_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin2 COLLATE=latin2_hungarian_ci;
