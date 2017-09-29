# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.14)
# Database: cloudstore
# Generation Time: 2017-09-27 02:16:45 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table address
# ------------------------------------------------------------

DROP TABLE IF EXISTS `address`;

CREATE TABLE `address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '收件人',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '收件地址',
  `phone` int(20) NOT NULL COMMENT '收件人联系电话',
  `is_default` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否默认收件地址，1-是，0-否',
  `is_delete` tinyint(3) NOT NULL DEFAULT '0' COMMENT '软删除，1-是，0-否',
  `create_time` int(10) DEFAULT NULL,
  `update_time` int(10) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table attr_option
# ------------------------------------------------------------

DROP TABLE IF EXISTS `attr_option`;

CREATE TABLE `attr_option` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `option` varchar(50) NOT NULL DEFAULT '' COMMENT '属性选项',
  `attr_id` int(11) NOT NULL COMMENT '属性id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table attributes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `attributes`;

CREATE TABLE `attributes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品属性',
  `cate_id` int(11) NOT NULL COMMENT '分类id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table commodity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `commodity`;

CREATE TABLE `commodity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) NOT NULL COMMENT '分类id',
  `goods_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品名称',
  `cover_path` varchar(255) DEFAULT NULL COMMENT '商品封面图片路径',
  `single_price` float(10,2) NOT NULL COMMENT '商品单价',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '商品标题',
  `content` text COMMENT '商品详细',
  `service` varchar(30) DEFAULT NULL COMMENT '存储字符串， 1-7天无理由退货，2-15天无忧换货，3-满119包邮，4-顺丰发货5-云音乐自营',
  `in_stock` int(5) NOT NULL DEFAULT '0' COMMENT '库存量',
  `is_hot_sale` tinyint(3) NOT NULL DEFAULT '0' COMMENT '热销商品，1-是，0-否',
  `is_recommd` tinyint(3) NOT NULL DEFAULT '0' COMMENT '编辑推荐，1-是，0-否',
  `is_delete` tinyint(3) NOT NULL DEFAULT '0' COMMENT '软删除',
  `create_time` int(10) DEFAULT NULL,
  `update_time` int(10) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL COMMENT '0-未审核，1-已通过，2-未通过',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table commodity_attr
# ------------------------------------------------------------

DROP TABLE IF EXISTS `commodity_attr`;

CREATE TABLE `commodity_attr` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `commodity_id` int(11) NOT NULL COMMENT '商品id',
  `attr_id` int(11) NOT NULL COMMENT '属性id',
  `attr_option_id` int(11) NOT NULL COMMENT '属性选项id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table commodity_cate
# ------------------------------------------------------------

DROP TABLE IF EXISTS `commodity_cate`;

CREATE TABLE `commodity_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '当pid=0时，该分类为顶级分类',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0-未审核，1-已通过，2-未通过',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table media
# ------------------------------------------------------------

DROP TABLE IF EXISTS `media`;

CREATE TABLE `media` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `commodity_id` int(11) DEFAULT NULL COMMENT '商品id',
  `path` varchar(255) DEFAULT NULL COMMENT '图片在服务器的绝对路径',
  `url_path` varchar(255) DEFAULT NULL COMMENT '图片的url地址',
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '1-普通图片，2-轮播图，默认为1',
  `create_time` int(10) DEFAULT NULL,
  `update_time` int(10) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL COMMENT '待定',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_num` int(11) NOT NULL COMMENT '订单编号（按照日期时间等生成格式）',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `commodity_id` int(11) NOT NULL COMMENT '商品id',
  `commodity_num` int(11) NOT NULL COMMENT '商品数量',
  `oid` int(11) NOT NULL COMMENT '商品选项id，commodity_attr表的id',
  `is_delete` tinyint(3) NOT NULL DEFAULT '0' COMMENT '软删除，1-是，0-否',
  `create_time` int(10) DEFAULT NULL,
  `update_time` int(10) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL COMMENT '0-已下单未完成，1-下单已完成已确定，2-完成未确定，3-已取消',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `phone` int(11) NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(50) NOT NULL DEFAULT '',
  `is_delete` tinyint(3) NOT NULL DEFAULT '0' COMMENT '软删除',
  `create_time` int(10) DEFAULT NULL,
  `update_time` int(10) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0-未审核，1-已通过，2-未通过',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_detail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_detail`;

CREATE TABLE `user_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `email` varchar(30) DEFAULT NULL,
  `avatar_path` varchar(255) DEFAULT NULL COMMENT '用户头像图片路径',
  `is_delete` tinyint(3) NOT NULL DEFAULT '0' COMMENT '1-是，0-否',
  `create_time` int(10) DEFAULT NULL,
  `update_time` int(10) DEFAULT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0-未审核，1-已通过，2-未通过',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
