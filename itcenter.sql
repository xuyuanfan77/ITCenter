/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : itcenter

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-12-17 22:08:58
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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of allocation
-- ----------------------------
INSERT INTO `allocation` VALUES ('7', '1', '182', '2017-12-17 22:04:53', '', '2017-12-17 22:04:58');
INSERT INTO `allocation` VALUES ('4', '2', '6', '2017-12-15 21:44:54', '我备注一下', '2017-12-17 22:04:23');

-- ----------------------------
-- Table structure for asset
-- ----------------------------
DROP TABLE IF EXISTS `asset`;
CREATE TABLE `asset` (
  `id` int(10) unsigned NOT NULL,
  `type` varchar(10) DEFAULT NULL,
  `brand` varchar(10) DEFAULT NULL,
  `model` varchar(25) DEFAULT NULL,
  `number` varchar(25) DEFAULT NULL,
  `network` varchar(10) DEFAULT NULL,
  `source` varchar(10) DEFAULT NULL,
  `purchase_date` datetime DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `state` varchar(10) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of asset
-- ----------------------------
INSERT INTO `asset` VALUES ('2', '2', '12', 'LT2223WA', '1S60E8HCR5CAU55DH467', '34', '42', '2017-12-15 16:28:32', '', '97', '2017-12-17 20:46:09');
INSERT INTO `asset` VALUES ('1', '1', '10', 'LT2223WA', '0M05833712N1636', '34', '42', '2017-12-15 16:24:11', '损坏', '37', '2017-12-17 20:46:00');

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
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of log
-- ----------------------------
INSERT INTO `log` VALUES ('1', '3', '添加【人员（冯浦）】', '2017-12-12 14:49:12');
INSERT INTO `log` VALUES ('2', '3', '添加【人员（黄廉团）】', '2017-12-12 14:51:00');
INSERT INTO `log` VALUES ('3', '3', '添加【人员（钟刚）】', '2017-12-12 14:51:25');
INSERT INTO `log` VALUES ('4', '3', '添加【人员（郑小波）】', '2017-12-12 14:52:19');
INSERT INTO `log` VALUES ('5', '3', '添加【人员（许远帆）】', '2017-12-12 14:53:02');
INSERT INTO `log` VALUES ('6', '3', '添加【人员（张麦龙）】', '2017-12-12 14:53:51');
INSERT INTO `log` VALUES ('7', '3', '添加【人员（何燕群）】', '2017-12-12 14:54:21');
INSERT INTO `log` VALUES ('8', '3', '添加【人员（黄守超）】', '2017-12-12 14:54:48');
INSERT INTO `log` VALUES ('9', '1', '添加【（许远帆）占用资产（编号：1）】', '2017-12-15 21:44:27');
INSERT INTO `log` VALUES ('10', '1', '添加【（赵士劲）占用资产（编号：2）】', '2017-12-15 21:45:06');
INSERT INTO `log` VALUES ('11', '1', '删除【（赵士劲）占用资产（编号：2）】', '2017-12-15 23:06:05');
INSERT INTO `log` VALUES ('12', '1', '删除【（赵士劲）占用资产（编号：2）】', '2017-12-15 23:06:46');
INSERT INTO `log` VALUES ('13', '3', '删除【人员（赵士劲）】', '2017-12-15 23:07:00');
INSERT INTO `log` VALUES ('14', '3', '删除【人员（许远帆）】', '2017-12-15 23:07:34');
INSERT INTO `log` VALUES ('15', '1', '删除【（）占用资产（编号：1）】', '2017-12-15 23:07:52');
INSERT INTO `log` VALUES ('16', '2', '删除【资产（编号：1）】', '2017-12-15 23:08:03');
INSERT INTO `log` VALUES ('17', '2', '修改【资产（编号：）】为【类型：；品牌：；型号：LT2223WA；序列号：1S60E8HCR5CAU55DH467；接入网络：；设备来源：；设备状态：；购置时间：2017-12-15 16:28:32】', '2017-12-17 19:24:10');
INSERT INTO `log` VALUES ('18', '2', '修改【资产（编号：）】为【类型：；品牌：；型号：LT2223WA；序列号：0M05833712N1636；接入网络：；设备来源：；设备状态：；购置时间：2017-12-15 16:24:11】', '2017-12-17 19:24:32');
INSERT INTO `log` VALUES ('19', '2', '修改【资产（编号：）】为【类型：；品牌：；型号：LT2223WA；序列号：0M05833712N1636；接入网络：；设备来源：；设备状态：；购置时间：2017-12-15 16:24:11】', '2017-12-17 19:59:39');
INSERT INTO `log` VALUES ('20', '2', '修改【资产（编号：）】为【类型：；品牌：；型号：LT2223WA；序列号：0M05833712N1636；接入网络：；设备来源：；设备状态：；购置时间：2017-12-15 16:24:11】', '2017-12-17 20:08:41');
INSERT INTO `log` VALUES ('21', '2', '修改【资产（编号：）】为【类型：；品牌：；型号：LT2223WA；序列号：0M05833712N1636；接入网络：；设备来源：；设备状态：；购置时间：2017-12-15 16:24:11】', '2017-12-17 20:12:47');
INSERT INTO `log` VALUES ('22', '2', '修改【资产（编号：）】为【类型：；品牌：；型号：LT2223WA；序列号：0M05833712N1636；接入网络：；设备来源：；设备状态：；购置时间：2017-12-15 16:24:11】', '2017-12-17 20:18:38');
INSERT INTO `log` VALUES ('23', '2', '修改【资产（编号：1）】为【类型：主机；品牌：联想LENOVO；型号：LT2223WA；序列号：0M05833712N1636；接入网络：内网；设备来源：本级采购；设备状态：在用；购置时间：2017-12-15 16:24:11】', '2017-12-17 20:40:07');
INSERT INTO `log` VALUES ('24', '2', '修改【资产（编号：1）】为【类型：主机；品牌：联想LENOVO；型号：LT2223WA；序列号：0M05833712N1636；接入网络：内网；设备来源：本级采购；设备状态：报废；购置时间：2017-12-15 16:24:11】', '2017-12-17 20:46:00');
INSERT INTO `log` VALUES ('25', '2', '修改【资产（编号：2）】为【类型：显示器；品牌：清华同方；型号：LT2223WA；序列号：1S60E8HCR5CAU55DH467；接入网络：内网；设备来源：本级采购；设备状态：在用；购置时间：2017-12-15 16:28:32】', '2017-12-17 20:46:09');
INSERT INTO `log` VALUES ('26', '1', '删除【（许远帆）占用资产（编号：1）】', '2017-12-17 21:07:48');
INSERT INTO `log` VALUES ('27', '1', '添加【（叶增潮）占用资产（编号：1）】', '2017-12-17 21:45:33');
INSERT INTO `log` VALUES ('28', '1', '修改【（赵士劲）占用资产（编号：2）】为【（赵士劲）占用资产（编号：2）】', '2017-12-17 22:04:08');
INSERT INTO `log` VALUES ('29', '1', '修改【（赵士劲）占用资产（编号：2）】为【（黄廉团）占用资产（编号：2）】', '2017-12-17 22:04:23');
INSERT INTO `log` VALUES ('30', '1', '删除【（叶增潮）占用资产（编号：1）】', '2017-12-17 22:04:42');
INSERT INTO `log` VALUES ('31', '1', '添加【（许远帆）占用资产（编号：1）】', '2017-12-17 22:04:58');

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
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

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
INSERT INTO `option` VALUES ('41', '4', '6', '其他', '0', '2017-09-26 15:00:19');
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
INSERT INTO `option` VALUES ('97', '4', '5', '报废', '1', '2017-12-17 19:21:17');

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
) ENGINE=MyISAM AUTO_INCREMENT=183 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('181', '赵士劲', '45', '71', '6680808', '13828211678', '2017-12-15 23:07:14');
INSERT INTO `user` VALUES ('2', '叶增潮', '45', '72', '6686808', '13809737038', '2017-11-02 16:52:30');
INSERT INTO `user` VALUES ('3', '黄晓风', '45', '72', '6682668', '13822513388', '2017-11-02 16:52:56');
INSERT INTO `user` VALUES ('4', '何泉章', '45', '72', '6686088', '13702686118', '2017-11-02 16:53:19');
INSERT INTO `user` VALUES ('5', '冯浦', '45', '94', '6681321', '13828282628', '2017-12-12 14:49:12');
INSERT INTO `user` VALUES ('6', '黄廉团', '46', '75', '6684701', '18820698123', '2017-12-12 14:51:00');
INSERT INTO `user` VALUES ('7', '钟刚', '46', '76', '6684701', '13827133799', '2017-12-12 14:51:25');
INSERT INTO `user` VALUES ('8', '郑小波', '46', '84', '6684701', '13822597929', '2017-12-12 14:52:19');
INSERT INTO `user` VALUES ('182', '许远帆', '46', '84', '6684701', '17875190125', '2017-12-15 23:08:18');
INSERT INTO `user` VALUES ('10', '张麦龙', '60', '75', '6689863', '13822539007', '2017-12-12 14:53:51');
INSERT INTO `user` VALUES ('11', '何燕群', '60', '76', '6689863', '13922066228', '2017-12-12 14:54:21');
INSERT INTO `user` VALUES ('12', '黄守超', '60', '84', '6689863', '15768848297', '2017-12-12 14:54:48');
