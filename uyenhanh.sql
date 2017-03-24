/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : uyenhanh

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-03-24 08:01:29
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `customers`
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alias` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `note` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES ('1', 'Phuc', 'Phuc', '01644564404', 'hoangphuc.ag@gmail.com', 'HCM', 'Vip', null, null);
INSERT INTO `customers` VALUES ('3', 'Dung Dieu', 'Dung Dieu', '01677242650', 'hoangphuc.ag@gmail.com', 'Kien Giang', '', null, null);
INSERT INTO `customers` VALUES ('2', 'test delete', 'test delete', '0123456789', 'test@gmail.com', 'HCM', '', '1', '2017-03-13 12:31:51');

-- ----------------------------
-- Table structure for `orders`
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customers_id` int(10) unsigned NOT NULL,
  `order_date` date NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `note` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('1', '1', '2017-03-14', '1', '0', null, null, null);
INSERT INTO `orders` VALUES ('2', '1', '2017-03-18', '1', '0', 'test note', null, null);
INSERT INTO `orders` VALUES ('3', '3', '2017-03-18', '1', '0', '', '1', '2017-03-21 10:44:25');
INSERT INTO `orders` VALUES ('4', '3', '2017-03-20', '1', '0', 'Vui long thanh toan tien hang thang 02/2017', null, null);
INSERT INTO `orders` VALUES ('5', '3', '2017-03-21', '2', '0', 'Gui hang gap', null, null);
INSERT INTO `orders` VALUES ('6', '3', '2017-03-21', '1', '0', '', null, null);
INSERT INTO `orders` VALUES ('7', '1', '2017-03-23', '1', '0', '', null, null);
INSERT INTO `orders` VALUES ('8', '3', '2017-03-23', '2', '0', 'Chua thanh toan thang 08/2016', null, null);

-- ----------------------------
-- Table structure for `orders_has_products`
-- ----------------------------
DROP TABLE IF EXISTS `orders_has_products`;
CREATE TABLE `orders_has_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orders_id` int(10) unsigned NOT NULL,
  `products_id` int(10) unsigned NOT NULL,
  `quantity` float NOT NULL,
  `price` float NOT NULL,
  `ship` float DEFAULT NULL,
  `note` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of orders_has_products
-- ----------------------------
INSERT INTO `orders_has_products` VALUES ('8', '4', '2', '120', '45000', '50000', 'Gap', null, null);
INSERT INTO `orders_has_products` VALUES ('9', '4', '3', '50', '56000', '25000', '', null, null);
INSERT INTO `orders_has_products` VALUES ('10', '4', '1', '250', '42000', '100000', 'tang gia', null, null);
INSERT INTO `orders_has_products` VALUES ('11', '4', '2', '50', '40000', '100000', '', null, null);
INSERT INTO `orders_has_products` VALUES ('12', '4', '1', '2.5', '65000', '10000', '', '1', '2017-03-21 10:00:54');
INSERT INTO `orders_has_products` VALUES ('13', '4', '2', '26.5', '55000', '80000', '', null, null);
INSERT INTO `orders_has_products` VALUES ('14', '4', '3', '50', '65000', '10000', 'test edit', null, null);
INSERT INTO `orders_has_products` VALUES ('15', '5', '1', '10000', '20000', '2000', '', null, null);
INSERT INTO `orders_has_products` VALUES ('16', '4', '2', '200', '40000', '0', '', null, null);
INSERT INTO `orders_has_products` VALUES ('17', '4', '3', '50', '55000', '20000', '', null, null);
INSERT INTO `orders_has_products` VALUES ('18', '4', '1', '100', '20000', '50000', '', null, null);
INSERT INTO `orders_has_products` VALUES ('19', '4', '2', '20', '50000', '25000', '', null, null);
INSERT INTO `orders_has_products` VALUES ('20', '4', '2', '100', '40000', '30000', '', null, null);
INSERT INTO `orders_has_products` VALUES ('21', '4', '3', '55', '55555', '55000', '', null, null);
INSERT INTO `orders_has_products` VALUES ('22', '4', '3', '20', '20000', '15000', 'test 0', null, null);
INSERT INTO `orders_has_products` VALUES ('23', '4', '3', '20', '20000', '15000', 'test 1', null, null);
INSERT INTO `orders_has_products` VALUES ('24', '4', '3', '20', '20000', '15000', 'test 2', null, null);
INSERT INTO `orders_has_products` VALUES ('25', '4', '3', '20', '20000', '15000', 'test 3', null, null);
INSERT INTO `orders_has_products` VALUES ('26', '4', '3', '20', '20000', '15000', 'test 4', null, null);
INSERT INTO `orders_has_products` VALUES ('27', '4', '3', '20', '20000', '15000', 'test 5', null, null);
INSERT INTO `orders_has_products` VALUES ('28', '4', '3', '20', '20000', '15000', 'test 6', null, null);
INSERT INTO `orders_has_products` VALUES ('29', '4', '3', '20', '20000', '15000', 'test 7', null, null);
INSERT INTO `orders_has_products` VALUES ('30', '4', '3', '20', '20000', '15000', 'test 8', null, null);
INSERT INTO `orders_has_products` VALUES ('31', '4', '3', '20', '20000', '15000', 'test 9', null, null);
INSERT INTO `orders_has_products` VALUES ('32', '4', '3', '20', '20000', '15000', 'test 10', null, null);
INSERT INTO `orders_has_products` VALUES ('33', '4', '3', '20', '20000', '15000', 'test 11', null, null);
INSERT INTO `orders_has_products` VALUES ('34', '4', '3', '20', '20000', '15000', 'test 12', null, null);
INSERT INTO `orders_has_products` VALUES ('35', '4', '3', '20', '20000', '15000', 'test 13', null, null);
INSERT INTO `orders_has_products` VALUES ('36', '4', '3', '20', '20000', '15000', 'test 14', null, null);
INSERT INTO `orders_has_products` VALUES ('37', '4', '3', '20', '20000', '15000', 'test 15', null, null);
INSERT INTO `orders_has_products` VALUES ('38', '4', '3', '20', '20000', '15000', 'test 16', null, null);
INSERT INTO `orders_has_products` VALUES ('39', '4', '3', '20', '20000', '15000', 'test 17', null, null);
INSERT INTO `orders_has_products` VALUES ('40', '4', '3', '20', '20000', '15000', 'test 18', null, null);
INSERT INTO `orders_has_products` VALUES ('41', '4', '3', '20', '20000', '15000', 'test 19', null, null);
INSERT INTO `orders_has_products` VALUES ('42', '4', '3', '20', '20000', '15000', 'test 20', null, null);
INSERT INTO `orders_has_products` VALUES ('43', '7', '3', '20', '55000', '25000', '', null, null);
INSERT INTO `orders_has_products` VALUES ('44', '7', '2', '50', '30000', '55000', '', null, null);
INSERT INTO `orders_has_products` VALUES ('45', '7', '2', '15', '50000', '25000', '', null, null);
INSERT INTO `orders_has_products` VALUES ('46', '7', '3', '40', '50000', '0', '', null, null);
INSERT INTO `orders_has_products` VALUES ('47', '7', '1', '20', '30000', '25000', '', null, null);
INSERT INTO `orders_has_products` VALUES ('48', '7', '2', '20', '25000', '0', '', null, null);
INSERT INTO `orders_has_products` VALUES ('49', '7', '3', '44', '44444', '0', '', null, null);
INSERT INTO `orders_has_products` VALUES ('50', '7', '3', '100', '5000', '0', '', null, null);
INSERT INTO `orders_has_products` VALUES ('51', '7', '1', '50', '25000', '50000', '', null, null);
INSERT INTO `orders_has_products` VALUES ('52', '7', '3', '10', '50000', '0', '', null, null);
INSERT INTO `orders_has_products` VALUES ('53', '7', '1', '30', '10000', '25000', '', null, null);
INSERT INTO `orders_has_products` VALUES ('54', '7', '3', '20', '40000', '0', '', null, null);
INSERT INTO `orders_has_products` VALUES ('55', '7', '2', '12', '54321', '34567', '', null, null);
INSERT INTO `orders_has_products` VALUES ('56', '8', '2', '100', '45000', '50000', 'Loai dac biet (350gr/cay)', null, null);

-- ----------------------------
-- Table structure for `products`
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `spec` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('1', 'Xà lách mỡ', 'Xa lach mo', '250gr/cây', 'Cuốc chặc, không bị dập lá, không bị chấm ruồi', null, null);
INSERT INTO `products` VALUES ('2', 'Iceberg', 'Iceberg', '350gr/cây', 'Cuốc chặc, không bị dập lá', null, null);
INSERT INTO `products` VALUES ('3', 'Salanova Green Butter', 'Salanova Green Butter', '200gr/cay', 'Không chấm ruồi', null, null);

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', '955d86d8e834e2a4e2ad2c747988d788f15149e5', 'Phuc Nguyen', null, '1');
