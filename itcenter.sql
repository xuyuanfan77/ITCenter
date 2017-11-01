/*
Navicat MySQL Data Transfer

Source Server         : 愤怒的IT男
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : itcenter

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-11-01 17:17:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for allocation
-- ----------------------------
DROP TABLE IF EXISTS `allocation`;
CREATE TABLE `allocation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `use_date` datetime DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of allocation
-- ----------------------------
INSERT INTO `allocation` VALUES ('2', '10', '1', '2017-10-26 08:14:34', '111111111111111111', '2017-11-01 11:07:29');
INSERT INTO `allocation` VALUES ('3', '11', '1', '2017-10-18 08:14:50', '', '2017-11-01 11:07:36');
INSERT INTO `allocation` VALUES ('7', '13', '1', '2017-10-27 08:31:38', '', '2017-11-01 11:07:41');
INSERT INTO `allocation` VALUES ('11', '15', '1', '2017-09-30 10:50:48', '', '2017-11-01 11:07:57');
INSERT INTO `allocation` VALUES ('14', '16', '15', '2017-10-26 10:27:22', '', '2017-11-01 11:08:00');
INSERT INTO `allocation` VALUES ('16', '16', '21', '2017-10-26 10:35:42', '', '2017-10-26 10:35:47');

-- ----------------------------
-- Table structure for asset
-- ----------------------------
DROP TABLE IF EXISTS `asset`;
CREATE TABLE `asset` (
  `id` int(10) unsigned NOT NULL,
  `type` varchar(10) DEFAULT NULL,
  `brand` varchar(10) DEFAULT NULL,
  `model` varchar(10) DEFAULT NULL,
  `number` varchar(10) DEFAULT NULL,
  `network` varchar(10) DEFAULT NULL,
  `source` varchar(10) DEFAULT NULL,
  `purchase_date` datetime DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `state` varchar(10) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of asset
-- ----------------------------
INSERT INTO `asset` VALUES ('21', '3', '10', '1', '123', '35', '42', '2017-09-28 15:35:02', '', '38', '2017-10-17 08:06:22');
INSERT INTO `asset` VALUES ('987654', '1', '', '', '', '', '', '2017-10-17 08:06:34', '', '', '2017-10-17 08:06:37');
INSERT INTO `asset` VALUES ('9', '1', '10', '555', '555', '35', '43', '2017-09-27 10:55:29', '555', '38', '2017-09-27 10:55:48');
INSERT INTO `asset` VALUES ('10', '2', '11', '666', '666', '35', '43', '2017-09-27 11:04:30', '666', '38', '2017-09-27 11:04:49');
INSERT INTO `asset` VALUES ('11', '3', '11', '777', '777', '36', '43', '2017-09-01 15:01:04', '备注备注', '39', '2017-10-13 14:54:49');
INSERT INTO `asset` VALUES ('13', '2', '11', '888', '888', '35', '43', '2017-09-27 15:04:37', '已经拿回来了', '38', '2017-09-27 15:05:11');
INSERT INTO `asset` VALUES ('14', '2', '11', '999', '999', '35', '43', '2017-09-27 15:09:54', '学习了', '38', '2017-09-27 15:10:20');
INSERT INTO `asset` VALUES ('15', '2', '12', '1221', '1221', '36', '43', '2017-09-21 15:11:22', '不管了', '38', '2017-09-27 15:11:36');
INSERT INTO `asset` VALUES ('16', '2', '13', '4545', '4545', '36', '43', '2017-09-27 15:27:18', '刷新界面', '39', '2017-09-27 15:27:47');
INSERT INTO `asset` VALUES ('23', '2', '12', '44444', '44444', '35', '43', '2017-09-28 15:49:09', '55555555555555555555', '38', '2017-09-28 15:49:34');
INSERT INTO `asset` VALUES ('24', '1', '11', '0', 'aaaaaa', '35', '42', '2017-09-28 16:00:06', '可以吗？', '37', '2017-10-13 17:17:21');
INSERT INTO `asset` VALUES ('25', '6', '12', '0', 'djfh142122', '35', '43', '2017-09-28 16:05:33', '绝对可以了', '40', '2017-09-28 16:06:09');
INSERT INTO `asset` VALUES ('26', '8', '17', '999999', '22222', '35', '43', '2017-09-28 16:08:55', '绝对可以了', '38', '2017-09-28 16:09:30');
INSERT INTO `asset` VALUES ('30', '3', '11', '999', '999', '35', '42', '2017-09-30 10:50:51', '999', '38', '2017-09-30 10:50:55');
INSERT INTO `asset` VALUES ('111', '2', '11', '111', '111', '36', '44', '2017-10-10 15:21:33', '111', '41', '2017-10-10 15:21:41');
INSERT INTO `asset` VALUES ('654', '1', '', '', '', '', '', '2017-10-17 10:08:19', '', '37', '2017-10-17 10:08:23');

-- ----------------------------
-- Table structure for log
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` set('3','2','1') DEFAULT NULL,
  `text` text,
  `create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of log
-- ----------------------------
INSERT INTO `log` VALUES ('5', '1', '6', '2017-09-28 16:00:31');
INSERT INTO `log` VALUES ('6', '2', '7', '2017-09-28 16:06:09');
INSERT INTO `log` VALUES ('9', '3', '10', '2017-09-30 08:44:28');
INSERT INTO `log` VALUES ('8', '1', '9', '2017-09-30 08:42:42');
INSERT INTO `log` VALUES ('13', '2', '14', '2017-09-30 11:24:29');
INSERT INTO `log` VALUES ('14', '', '固定资产（编号：12654852）由（黄廉团）占有修改为（许远帆）占有', '2017-10-31 08:47:17');
INSERT INTO `log` VALUES ('15', '1', '解除（许远帆）对资源（编号：9）的占用', '2017-11-01 11:09:31');
INSERT INTO `log` VALUES ('16', '1', '解除（许远帆）对资源（编号：16）的占用', '2017-11-01 11:21:17');

-- ----------------------------
-- Table structure for manager
-- ----------------------------
DROP TABLE IF EXISTS `manager`;
CREATE TABLE `manager` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of manager
-- ----------------------------
INSERT INTO `manager` VALUES ('1', 'xuyuanfan', '123', '2017-09-19 14:54:53');

-- ----------------------------
-- Table structure for option
-- ----------------------------
DROP TABLE IF EXISTS `option`;
CREATE TABLE `option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `index` int(11) DEFAULT NULL,
  `option_name` varchar(255) DEFAULT NULL,
  `flag` set('1','2','0') DEFAULT '1',
  `create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of option
-- ----------------------------
INSERT INTO `option` VALUES ('1', '1', '1', '主机', '2', '2017-09-26 09:56:57');
INSERT INTO `option` VALUES ('2', '1', '2', '显示器', '1', '2017-09-26 09:58:43');
INSERT INTO `option` VALUES ('3', '1', '3', '笔记本', '1', '2017-09-26 09:59:53');
INSERT INTO `option` VALUES ('4', '1', '4', '打印机', '1', '2017-09-26 10:00:21');
INSERT INTO `option` VALUES ('5', '1', '5', '扫描仪', '1', '2017-09-26 10:00:38');
INSERT INTO `option` VALUES ('6', '1', '6', '投影仪', '1', '2017-09-26 10:01:29');
INSERT INTO `option` VALUES ('7', '1', '7', '路由器', '1', '2017-09-26 10:01:57');
INSERT INTO `option` VALUES ('8', '1', '8', '交换机', '1', '2017-09-26 10:02:12');
INSERT INTO `option` VALUES ('9', '1', '9', '其他', '0', '2017-09-26 10:02:32');
INSERT INTO `option` VALUES ('10', '2', '1', '联想LENOVO', '2', '2017-09-26 14:41:29');
INSERT INTO `option` VALUES ('11', '2', '2', '华硕', '1', '2017-09-26 14:42:51');
INSERT INTO `option` VALUES ('12', '2', '3', '清华同方', '1', '2017-09-26 14:43:12');
INSERT INTO `option` VALUES ('13', '2', '4', '惠普HP', '1', '2017-09-26 14:43:34');
INSERT INTO `option` VALUES ('14', '2', '5', '海尔', '1', '2017-09-26 14:45:10');
INSERT INTO `option` VALUES ('15', '2', '6', '三星Samsung', '1', '2017-09-26 14:46:03');
INSERT INTO `option` VALUES ('16', '2', '7', '富士通', '1', '2017-09-26 14:46:21');
INSERT INTO `option` VALUES ('17', '2', '8', '富士施乐', '1', '2017-09-26 14:46:55');
INSERT INTO `option` VALUES ('18', '2', '9', 'OKI', '1', '2017-09-26 14:47:17');
INSERT INTO `option` VALUES ('19', '2', '10', '得实', '1', '2017-09-26 14:48:18');
INSERT INTO `option` VALUES ('20', '2', '11', '虹光', '1', '2017-09-26 14:48:23');
INSERT INTO `option` VALUES ('21', '2', '12', 'CISCO', '1', '2017-09-26 14:48:59');
INSERT INTO `option` VALUES ('22', '2', '13', 'EPSON', '1', '2017-09-26 14:54:14');
INSERT INTO `option` VALUES ('23', '2', '14', 'PHILIPS', '1', '2017-09-26 14:54:18');
INSERT INTO `option` VALUES ('24', '2', '15', 'NETGSEAR', '1', '2017-09-26 14:54:21');
INSERT INTO `option` VALUES ('25', '2', '16', 'STAR', '1', '2017-09-26 14:54:24');
INSERT INTO `option` VALUES ('26', '2', '17', '华为', '1', '2017-09-26 14:54:26');
INSERT INTO `option` VALUES ('27', '2', '18', 'H3C', '1', '2017-09-26 14:54:30');
INSERT INTO `option` VALUES ('28', '2', '19', '日立', '1', '2017-09-26 14:54:33');
INSERT INTO `option` VALUES ('29', '2', '20', '松下', '1', '2017-09-26 14:54:37');
INSERT INTO `option` VALUES ('30', '2', '21', '中兴', '1', '2017-09-26 14:54:40');
INSERT INTO `option` VALUES ('31', '2', '22', '东芝', '1', '2017-09-26 14:54:44');
INSERT INTO `option` VALUES ('32', '2', '23', '海康威视', '1', '2017-09-26 14:54:47');
INSERT INTO `option` VALUES ('33', '2', '24', '其他', '0', '2017-09-26 14:54:49');
INSERT INTO `option` VALUES ('34', '3', '1', '内网', '2', '2017-09-26 14:58:00');
INSERT INTO `option` VALUES ('35', '3', '2', '外网', '1', '2017-09-26 14:58:05');
INSERT INTO `option` VALUES ('36', '3', '3', '其他', '0', '2017-09-26 14:58:07');
INSERT INTO `option` VALUES ('37', '4', '1', '在用', '2', '2017-09-26 15:00:05');
INSERT INTO `option` VALUES ('38', '4', '2', '备用', '1', '2017-09-26 15:00:09');
INSERT INTO `option` VALUES ('39', '4', '3', '借用', '1', '2017-09-26 15:00:13');
INSERT INTO `option` VALUES ('40', '4', '4', '损坏', '1', '2017-09-26 15:00:16');
INSERT INTO `option` VALUES ('41', '4', '5', '其他', '0', '2017-09-26 15:00:19');
INSERT INTO `option` VALUES ('42', '5', '1', '本级采购', '2', '2017-09-26 15:01:48');
INSERT INTO `option` VALUES ('43', '5', '2', '上级采购', '1', '2017-09-26 15:01:52');
INSERT INTO `option` VALUES ('44', '5', '3', '其他', '0', '2017-09-26 15:01:55');
INSERT INTO `option` VALUES ('45', '6', '1', '局长室', '1', '2017-09-28 15:06:42');
INSERT INTO `option` VALUES ('46', '6', '2', '信息中心', '1', '2017-09-28 15:14:06');
INSERT INTO `option` VALUES ('47', '6', '3', '人事教育科', '1', '2017-09-28 15:14:09');
INSERT INTO `option` VALUES ('48', '6', '4', '办公室', '1', '2017-09-28 15:14:12');
INSERT INTO `option` VALUES ('49', '6', '5', '监察室', '1', '2017-09-28 15:14:14');
INSERT INTO `option` VALUES ('50', '6', '6', '工会', '1', '2017-09-28 15:14:18');
INSERT INTO `option` VALUES ('51', '6', '7', '收入核算科', '1', '2017-09-28 15:14:22');
INSERT INTO `option` VALUES ('52', '6', '8', '政策法规科', '1', '2017-09-28 15:14:25');
INSERT INTO `option` VALUES ('53', '6', '9', '征收管理科', '1', '2017-09-28 15:14:29');
INSERT INTO `option` VALUES ('54', '6', '10', '纳税服务科', '1', '2017-09-28 15:14:32');
INSERT INTO `option` VALUES ('55', '6', '11', '办税服务厅', '1', '2017-09-28 15:14:46');
INSERT INTO `option` VALUES ('56', '6', '12', '稽查局', '1', '2017-09-28 15:14:49');
INSERT INTO `option` VALUES ('57', '6', '13', '税源管理一科', '1', '2017-09-28 15:14:52');
INSERT INTO `option` VALUES ('58', '6', '14', '税源管理二科', '1', '2017-09-28 15:14:55');
INSERT INTO `option` VALUES ('59', '6', '15', '税源管理三科', '1', '2017-09-28 15:14:58');
INSERT INTO `option` VALUES ('60', '6', '16', '党委办公室', '1', '2017-09-28 15:15:00');
INSERT INTO `option` VALUES ('61', '6', '17', '安铺税务分局', '1', '2017-09-28 15:15:03');
INSERT INTO `option` VALUES ('62', '6', '18', '石岭税务分局', '1', '2017-09-28 15:15:06');
INSERT INTO `option` VALUES ('63', '6', '19', '青平税务分局', '1', '2017-09-28 15:15:09');
INSERT INTO `option` VALUES ('64', '6', '20', '塘蓬税务分局', '1', '2017-09-28 15:15:11');
INSERT INTO `option` VALUES ('65', '6', '21', '良垌税务分局', '1', '2017-09-28 15:14:34');
INSERT INTO `option` VALUES ('66', '6', '22', '饭堂', '1', '2017-09-28 15:14:37');
INSERT INTO `option` VALUES ('67', '6', '23', '培训室', '1', '2017-09-28 15:14:39');
INSERT INTO `option` VALUES ('68', '6', '24', '机房', '1', '2017-09-28 15:14:41');
INSERT INTO `option` VALUES ('69', '6', '25', '仓库', '1', '2017-09-28 15:14:44');
INSERT INTO `option` VALUES ('70', '6', '26', '其他', '0', '2017-09-28 15:41:42');
INSERT INTO `option` VALUES ('71', '7', '1', '局长', '1', '2017-10-20 16:02:43');
INSERT INTO `option` VALUES ('72', '7', '2', '副局长', '1', '2017-10-20 16:02:46');
INSERT INTO `option` VALUES ('73', '7', '3', '分局长', '1', '2017-10-20 16:02:50');
INSERT INTO `option` VALUES ('74', '7', '4', '副分局长', '1', '2017-10-20 16:02:52');
INSERT INTO `option` VALUES ('75', '7', '5', '主任', '1', '2017-10-20 16:02:55');
INSERT INTO `option` VALUES ('76', '7', '6', '副主任', '1', '2017-10-20 16:02:58');
INSERT INTO `option` VALUES ('77', '7', '7', '副主任科员', '1', '2017-10-20 16:03:01');
INSERT INTO `option` VALUES ('78', '7', '8', '科长', '1', '2017-10-20 16:03:04');
INSERT INTO `option` VALUES ('96', '7', '18', '其他', '0', '2017-10-20 16:03:32');
INSERT INTO `option` VALUES ('83', '7', '9', '副科长', '1', '2017-10-20 16:03:08');
INSERT INTO `option` VALUES ('84', '7', '10', '科员', '1', '2017-10-20 16:03:11');
INSERT INTO `option` VALUES ('85', '7', '11', '主席', '1', '2017-10-20 16:03:13');
INSERT INTO `option` VALUES ('95', '7', '17', '后勤服务', '1', '2017-10-20 16:03:29');
INSERT INTO `option` VALUES ('90', '7', '12', '副主席', '1', '2017-10-20 16:03:16');
INSERT INTO `option` VALUES ('91', '7', '13', '股长', '1', '2017-10-20 16:03:18');
INSERT INTO `option` VALUES ('92', '7', '14', '副股长', '1', '2017-10-20 16:03:21');
INSERT INTO `option` VALUES ('93', '7', '15', '监察员', '1', '2017-10-20 16:03:24');
INSERT INTO `option` VALUES ('94', '7', '16', '纪检组长', '1', '2017-10-20 16:03:26');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `job` varchar(255) DEFAULT NULL,
  `office_phone` varchar(255) DEFAULT NULL,
  `mobile_phone` varchar(255) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '许远帆', '46', '84', '123456', '1234567890', '2017-11-01 11:07:10');
