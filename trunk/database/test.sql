/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50532
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50532
File Encoding         : 65001

Date: 2014-05-09 09:01:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for assign
-- ----------------------------
DROP TABLE IF EXISTS `assign`;
CREATE TABLE `assign` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` int(10) unsigned DEFAULT NULL,
  `resource` int(10) unsigned DEFAULT NULL,
  `action` text,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_assign_roles` (`role`),
  KEY `fk_assign_resources` (`resource`),
  CONSTRAINT `fk_assign_resources` FOREIGN KEY (`resource`) REFERENCES `resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_assign_roles` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of assign
-- ----------------------------

-- ----------------------------
-- Table structure for resources
-- ----------------------------
DROP TABLE IF EXISTS `resources`;
CREATE TABLE `resources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `parent` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE,
  KEY `fk_resources_parent` (`parent`),
  CONSTRAINT `fk_resources_parent` FOREIGN KEY (`parent`) REFERENCES `resources` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of resources
-- ----------------------------
INSERT INTO `resources` VALUES ('1', 'Users', 'Users', null);
INSERT INTO `resources` VALUES ('2', 'Permissions', 'Permissions', null);
INSERT INTO `resources` VALUES ('3', 'Show Users', 'Users:show', '1');
INSERT INTO `resources` VALUES ('4', 'a', 'a', null);
INSERT INTO `resources` VALUES ('5', 'b', 'b', null);
INSERT INTO `resources` VALUES ('6', 'c', 'c', null);
INSERT INTO `resources` VALUES ('7', 'd', 'd', null);
INSERT INTO `resources` VALUES ('8', 'e', 'e', null);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `parent` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE,
  KEY `fk_roles_parent` (`parent`),
  CONSTRAINT `fk_roles_parent` FOREIGN KEY (`parent`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'admin', '3');
INSERT INTO `roles` VALUES ('2', 'guest', null);
INSERT INTO `roles` VALUES ('3', 'member', '2');
INSERT INTO `roles` VALUES ('4', 'test', null);
INSERT INTO `roles` VALUES ('5', 'test2', null);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `age` int(4) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `role` int(10) unsigned DEFAULT NULL,
  `created_at` int(10) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_email` (`email`) USING BTREE,
  KEY `fk_users_roles` (`role`),
  CONSTRAINT `fk_users_roles` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'tung', 'tung@gmail.com', '123456', '18', '1989-10-25', '0902978665', '1', null, null, '2014', null, null);

-- ----------------------------
-- Procedure structure for test_multi_sets
-- ----------------------------
DROP PROCEDURE IF EXISTS `test_multi_sets`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `test_multi_sets`()
    DETERMINISTIC
begin
        select user() as first_col;
        select user() as first_col, now() as second_col;
        select user() as first_col, now() as second_col, now() as third_col;
        end
;;
DELIMITER ;
