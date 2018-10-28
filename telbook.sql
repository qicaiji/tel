/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : telbook

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2017-05-24 17:57:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `telbook_company`
-- ----------------------------
DROP TABLE IF EXISTS `telbook_company`;
CREATE TABLE `telbook_company` (
  `cid` int(5) NOT NULL AUTO_INCREMENT COMMENT '企业ID',
  `cname` char(100) NOT NULL COMMENT '企业名称',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '是否禁用',
  `sort` int(2) NOT NULL DEFAULT '1' COMMENT '排序',
  `createtime` int(20) NOT NULL COMMENT '更新日期',
  `days` int(20) NOT NULL COMMENT '有效期（天）',
  `money` float(6,0) DEFAULT '0',
  `price` float(6,0) DEFAULT '0',
  `message` int(6) DEFAULT '0',
  PRIMARY KEY (`cid`),
  UNIQUE KEY `title` (`cname`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=gb2312 COMMENT='企业名称列表';

-- ----------------------------
-- Records of telbook_company
-- ----------------------------
INSERT INTO `telbook_company` VALUES ('1', '隆昌二中', '1', '2', '1463908072', '365', '0', '0', '9');
INSERT INTO `telbook_company` VALUES ('20', '隆昌一中', '1', '1', '1463910552', '366', '0', '0', '0');
INSERT INTO `telbook_company` VALUES ('22', '隆昌3中', '1', '3', '1463975531', '365', '0', '0', '0');
INSERT INTO `telbook_company` VALUES ('23', '隆昌七中', '1', '7', '1491996719', '365', '0', '0', '0');

-- ----------------------------
-- Table structure for `telbook_department`
-- ----------------------------
DROP TABLE IF EXISTS `telbook_department`;
CREATE TABLE `telbook_department` (
  `did` int(5) NOT NULL AUTO_INCREMENT COMMENT '部门ID',
  `dname` char(100) NOT NULL COMMENT '部门名称',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '部门状态',
  `sort` int(3) NOT NULL DEFAULT '1' COMMENT '部门排序',
  `cid` int(4) NOT NULL COMMENT '所属企业ID',
  PRIMARY KEY (`did`)
) ENGINE=InnoDB AUTO_INCREMENT=10012 DEFAULT CHARSET=gb2312 COMMENT='部门列表';

-- ----------------------------
-- Records of telbook_department
-- ----------------------------
INSERT INTO `telbook_department` VALUES ('10001', '行政办', '1', '2', '1');
INSERT INTO `telbook_department` VALUES ('10002', '教务处', '1', '1', '1');
INSERT INTO `telbook_department` VALUES ('10003', '总务处', '1', '1', '1');
INSERT INTO `telbook_department` VALUES ('10004', '教科室', '1', '1', '1');
INSERT INTO `telbook_department` VALUES ('10005', '政教处', '1', '1', '1');
INSERT INTO `telbook_department` VALUES ('10006', '高2017级', '1', '1', '1');
INSERT INTO `telbook_department` VALUES ('10007', '高2018级', '1', '1', '1');
INSERT INTO `telbook_department` VALUES ('10008', '高2019级', '1', '1', '1');
INSERT INTO `telbook_department` VALUES ('10009', '初2017', '1', '1', '1');
INSERT INTO `telbook_department` VALUES ('10010', '初2018', '1', '1', '1');
INSERT INTO `telbook_department` VALUES ('10011', '初2019', '1', '1', '1');

-- ----------------------------
-- Table structure for `telbook_group`
-- ----------------------------
DROP TABLE IF EXISTS `telbook_group`;
CREATE TABLE `telbook_group` (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT '组ID',
  `title` char(50) NOT NULL COMMENT '组名称',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `rules` varchar(200) NOT NULL COMMENT '权限',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=gb2312 COMMENT='用户组';

-- ----------------------------
-- Records of telbook_group
-- ----------------------------
INSERT INTO `telbook_group` VALUES ('1', '超级管理员', '1', '');
INSERT INTO `telbook_group` VALUES ('2', '企业管理员', '1', '26,28,27,25,42,41,58,39,45,47,46,44,34,36,53,49,38,35,52,33,48,54,51,56,57,40,55');
INSERT INTO `telbook_group` VALUES ('3', '部门管理员', '1', '58,39,34,36,53,38,35,52,33,48,54,51,56,57,40,55');
INSERT INTO `telbook_group` VALUES ('5', '部门成员', '1', '58,39,38,35,33,48,40');

-- ----------------------------
-- Table structure for `telbook_job`
-- ----------------------------
DROP TABLE IF EXISTS `telbook_job`;
CREATE TABLE `telbook_job` (
  `jid` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `jname` char(100) NOT NULL COMMENT '职务名称',
  `cid` int(5) DEFAULT NULL,
  `sort` int(2) DEFAULT '1',
  `status` int(1) DEFAULT '1',
  PRIMARY KEY (`jid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of telbook_job
-- ----------------------------
INSERT INTO `telbook_job` VALUES ('1', '校长', '1', '1', '1');
INSERT INTO `telbook_job` VALUES ('2', '副校长', '1', '1', '1');
INSERT INTO `telbook_job` VALUES ('4', '科室主任', '1', '1', '1');
INSERT INTO `telbook_job` VALUES ('5', '科室副主任', '1', '1', '1');
INSERT INTO `telbook_job` VALUES ('6', '年级主任', '1', '1', '1');
INSERT INTO `telbook_job` VALUES ('7', '年级书记', '1', '1', '1');
INSERT INTO `telbook_job` VALUES ('8', '教研组长', '1', '1', '1');
INSERT INTO `telbook_job` VALUES ('9', '工会主席', '1', '1', '1');
INSERT INTO `telbook_job` VALUES ('10', '备课组长', '1', '1', '1');
INSERT INTO `telbook_job` VALUES ('11', '团委', '1', '1', '1');

-- ----------------------------
-- Table structure for `telbook_messagelog`
-- ----------------------------
DROP TABLE IF EXISTS `telbook_messagelog`;
CREATE TABLE `telbook_messagelog` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `cid` int(6) DEFAULT NULL,
  `uid` int(6) DEFAULT NULL,
  `realname` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sendtime` char(50) DEFAULT NULL,
  `ip` char(20) DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `tellist` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `sendallcount` int(4) DEFAULT NULL,
  `sendtrue` int(4) DEFAULT NULL,
  `sendfalse` int(4) DEFAULT NULL,
  `errlist` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of telbook_messagelog
-- ----------------------------
INSERT INTO `telbook_messagelog` VALUES ('1', null, '10', '陈晨', '1495457160', '0.0.0.0', '今天下午不上班！', '13629001634,13568012566,13990522877,13458876269,13990522888,13458899304,13890589629,13678321207,15883272588', '9', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('2', null, '10', '陈晨', '1495457886', '0.0.0.0', '明天不上班啦！', '13629001634,13568012566,13990522877,13458876269,13990522888,13458899304,13890589629,13678321207,15883272588', '9', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('3', null, '10', '陈晨', '1495458047', '0.0.0.0', '明天不上班！', '13629001634,13568012566,13990522877,13458876269,13990522888,13458899304,13890589629,13678321207,15883272588', '9', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('4', null, '10', '陈晨', '1495458062', '0.0.0.0', '明天不上班2！', '13629001634,13568012566,13990522877,13458876269,13990522888,13458899304,13890589629,13678321207,15883272588', '9', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('5', null, '142', '郭坚', '1495506682', '0.0.0.0', '123123123123', '13990522877,13458876269,13990522888,13458899304,13890589629,13678321207,15883272588,13629001634,13568012566,15908358226', '10', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('6', '1', '142', '郭坚', '1495506903', '0.0.0.0', '啊撒旦发射点法 ', '13990522877,13458876269,13990522888,13458899304,13890589629,13678321207,15883272588,13629001634,13568012566,15908358226', '10', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('7', '1', '142', '郭坚', '1495508236', '0.0.0.0', 'aaaaaaaaaa', '13990522877,13458876269,13990522888,13458899304,13890589629,13678321207,15883272588,13629001634,13568012566,15908358226', '10', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('8', '0', '10', '陈晨', '1495526413', '0.0.0.0', '123321', '13890520679', '1', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('9', '0', '10', '陈晨', '1495526613', '0.0.0.0', '', '13890520679', '1', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('10', '0', '10', '陈晨', '1495526637', '0.0.0.0', '123123', '13890520679', '1', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('11', '0', '10', '陈晨', '1495526680', '0.0.0.0', '123123', '13890520679', '1', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('12', '0', '10', '陈晨', '1495526724', '0.0.0.0', '123123', '13890520679', '1', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('13', '0', '10', '陈晨', '1495526798', '0.0.0.0', '123123', '13890520679', '1', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('14', '0', '10', '陈晨', '1495526836', '0.0.0.0', '123123', '13890520679', '1', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('15', '0', '10', '陈晨', '1495526878', '0.0.0.0', '123123', '13890520679', '1', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('16', '0', '10', '陈晨', '1495526902', '0.0.0.0', '123123', '13890520679', '1', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('17', '0', '10', '陈晨', '1495527177', '0.0.0.0', '【雾色船城】{办公室}通知：{今天下午不上班！}。请相互转告！ 请勿回复！', '13890520679', '1', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('18', '0', '10', '陈晨', '1495529318', '0.0.0.0', '123321。', '13890520679', '1', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('19', null, '10', '陈晨', '1495537774', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近【内容】日内查收。', '13890520679', '1', '1', '0', null);
INSERT INTO `telbook_messagelog` VALUES ('20', null, '10', '陈晨', '1495537944', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近【内容】日内查收。', '13890520679', '1', '1', '0', null);
INSERT INTO `telbook_messagelog` VALUES ('21', null, '10', '陈晨', '1495538119', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近【内容】日内查收。', '13890520679,11111111111', '2', '1', '1', null);
INSERT INTO `telbook_messagelog` VALUES ('22', null, '10', '陈晨', '1495539538', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近【内容】日内查收。', '13890520679,11122233344', '2', '1', '1', null);
INSERT INTO `telbook_messagelog` VALUES ('23', null, '10', '陈晨', '1495539628', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近【内容】日内查收。', '13890520679,11111111111', '2', '1', '1', null);
INSERT INTO `telbook_messagelog` VALUES ('24', null, '10', '陈晨', '1495539696', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近【内容】日内查收。', '13890520679,11111111111', '2', '1', '1', null);
INSERT INTO `telbook_messagelog` VALUES ('25', null, '10', '陈晨', '1495544020', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近【内容】日内查收。', '15984283875,13890520679,11122233344', '3', '2', '1', null);
INSERT INTO `telbook_messagelog` VALUES ('26', null, '10', '陈晨', '1495544503', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近下班啦！日内查收。', '18990525075,11122233344', '2', '1', '1', null);
INSERT INTO `telbook_messagelog` VALUES ('27', null, '10', '陈晨', '1495544736', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近下班啦！日内查收。', '18990525075,11122233344', '2', '1', '1', null);
INSERT INTO `telbook_messagelog` VALUES ('28', null, '10', '陈晨', '1495544822', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近下班啦！日内查收。', '18990525075,11122233344', '2', '1', '1', null);
INSERT INTO `telbook_messagelog` VALUES ('29', null, '10', '陈晨', '1495546944', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近【内容123】日内查收。', '13890520679,15984283875,18990525075,11122233344', '4', '3', '1', null);
INSERT INTO `telbook_messagelog` VALUES ('30', null, '10', '陈晨', '1495547745', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近【内容123】日内查收。', '18990525075,11122233344', '2', '1', '1', '');
INSERT INTO `telbook_messagelog` VALUES ('31', null, '10', '陈晨', '1495547892', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近【内容333】日内查收。', '18990525075,11122233344', '2', '1', '1', '');
INSERT INTO `telbook_messagelog` VALUES ('32', null, '10', '陈晨', '1495548033', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近内容111日内查收。', '18990525075,11122233344,12233344455', '3', '1', '2', '');
INSERT INTO `telbook_messagelog` VALUES ('33', null, '10', '陈晨', '1495548059', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近内容111日内查收。', '18990525075,11122233344,12233344455', '3', '1', '2', '');
INSERT INTO `telbook_messagelog` VALUES ('34', null, '10', '陈晨', '1495548147', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近内容111日内查收。', '18990525075,11122233344,12233344455', '3', '1', '2', '');
INSERT INTO `telbook_messagelog` VALUES ('35', null, '10', '陈晨', '1495548243', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近内容222日内查收。', '18990525075,11122233344,12233344455', '3', '1', '2', ' ');
INSERT INTO `telbook_messagelog` VALUES ('36', null, '10', '陈晨', '1495548353', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近内容333日内查收。', '18990525075,11122233344,12233344455', '3', '1', '2', ' ');
INSERT INTO `telbook_messagelog` VALUES ('37', null, '10', '陈晨', '1495548455', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近内容444日内查收。', '18990525075,11122233344,12233344455', '3', '1', '2', ' 错误电话:11122233344,错误代码:00025;错误电话:12233344455,错误代码:00025');
INSERT INTO `telbook_messagelog` VALUES ('38', null, '10', '陈晨', '1495548557', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近内容666日内查收。', '18990525075,11122233344,12233344455', '3', '1', '2', '错误电话:11122233344,错误代码:00025;错误电话:12233344455,错误代码:00025');
INSERT INTO `telbook_messagelog` VALUES ('39', '1', '10', '陈晨', '1495588811', '0.0.0.0', '++增加短信', null, '1', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('40', '1', '10', '陈晨', '1495590251', '0.0.0.0', '++增加短信', null, '-12', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('41', null, '10', '陈晨', '1495590645', '0.0.0.0', '【雾色船城】您的订单【前缀】已经处理完成，货物即将发出，请于近【内容】日内查收。', '13890520679,11111111111', '2', '1', '1', '错误电话:11111111111,错误代码:00025');
INSERT INTO `telbook_messagelog` VALUES ('42', '1', '10', '陈晨', '1495590743', '0.0.0.0', '++增加短信', null, '11', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('43', '1', '142', '郭坚', '1495592515', '0.0.0.0', '【雾色船城】您的订单【教务处】已经处理完成，货物即将发出，请于近【内容】日内查收。', '13890520679,13890589629', '2', '2', '0', null);

-- ----------------------------
-- Table structure for `telbook_middle`
-- ----------------------------
DROP TABLE IF EXISTS `telbook_middle`;
CREATE TABLE `telbook_middle` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of telbook_middle
-- ----------------------------
INSERT INTO `telbook_middle` VALUES ('215', '2');
INSERT INTO `telbook_middle` VALUES ('216', '3');
INSERT INTO `telbook_middle` VALUES ('217', '5');

-- ----------------------------
-- Table structure for `telbook_rule`
-- ----------------------------
DROP TABLE IF EXISTS `telbook_rule`;
CREATE TABLE `telbook_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of telbook_rule
-- ----------------------------
INSERT INTO `telbook_rule` VALUES ('21', 'Home/Company/index', '企业列表管理首页', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('22', 'Home/Company/add', '添加企业', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('23', 'Home/Company/edit', '修改企业', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('24', 'Home/Company/del', '删除企业', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('25', 'Home/Department/index', '部门列表管理首页', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('26', 'Home/Department/add', '添加部门', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('27', 'Home/Department/edit', '修改部门', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('28', 'Home/Department/del', '删除部门', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('29', 'Home/Group/index', '用户组管理首页', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('30', 'Home/Group/add', '添加用户组', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('31', 'Home/Group/edit', '修改用户组', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('32', 'Home/Group/del', '删除用户组', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('33', 'Home/User/index', '用户管理首页', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('34', 'Home/User/add', '添加用户', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('35', 'Home/User/edit', '修改用户', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('36', 'Home/User/del', '删除用户', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('37', 'Home/Importrules/index', '导入权限节点', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('38', 'Home/User/department', '设置用户所属部门', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('39', 'Home/Index/index', '登陆后台首页', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('40', 'Home/User/showlist', '通讯录', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('41', 'Home/Excel/writeexcel', '导入excel数据', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('42', 'Home/Excel/readexcel', '导出excel数据', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('43', 'Home/Department/setMaster', '设置部门管理员', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('44', 'Home/Job/index', '职务管理首页', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('45', 'Home/Job/add', '添加职务', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('46', 'Home/Job/edit', '修改职务', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('47', 'Home/Job/del', '删除职务', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('48', 'Home/User/job', '设置用户所属职位', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('49', 'Home/User/delpage', '删除本页', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('50', 'Home/User/delall', '全部删除', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('51', 'Home/User/savelist', '保存发送列表', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('52', 'Home/User/getlist', '准备发送短信', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('53', 'Home/User/dellist', '删除发送列表', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('54', 'Home/User/messagelog', '短信发送日志', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('55', 'Home/User/showmessagelog', '显示日志列表', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('56', 'Home/User/sendmessage', '发送短信', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('57', 'Home/User/sendpost', '发送post', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('58', 'Home/Index/delruntime', '清除缓存', '1', '1', '');

-- ----------------------------
-- Table structure for `telbook_tel`
-- ----------------------------
DROP TABLE IF EXISTS `telbook_tel`;
CREATE TABLE `telbook_tel` (
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT '电话ID',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `vtel` char(20) DEFAULT NULL COMMENT 'V网号',
  `fulltel` char(20) DEFAULT NULL COMMENT '长号',
  `otel` char(20) DEFAULT NULL COMMENT '办公室号码',
  `hometel` char(20) DEFAULT NULL COMMENT '家庭电话',
  `familytel` char(20) DEFAULT NULL COMMENT '亲戚电话',
  `mail` char(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `uptime` char(20) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`tid`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=196 DEFAULT CHARSET=gb2312 COMMENT='用户电话表';

-- ----------------------------
-- Records of telbook_tel
-- ----------------------------
INSERT INTO `telbook_tel` VALUES ('193', '215', '66069', '13890520679', '', '', '', null, '1495619449');
INSERT INTO `telbook_tel` VALUES ('194', '216', '66068', '18990525075', '', '', '', null, '1495619499');
INSERT INTO `telbook_tel` VALUES ('195', '217', '63875', '15984283875', '', '', '', null, '1495619532');

-- ----------------------------
-- Table structure for `telbook_user`
-- ----------------------------
DROP TABLE IF EXISTS `telbook_user`;
CREATE TABLE `telbook_user` (
  `uid` int(6) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `realname` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '真实姓名',
  `card` char(20) NOT NULL COMMENT '身份证',
  `pwd` char(100) NOT NULL COMMENT '密码',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `uptime` char(20) NOT NULL COMMENT '更新时间',
  `cid` char(100) DEFAULT NULL COMMENT '所属企业ID',
  `dids` char(100) DEFAULT NULL COMMENT '所属部门ID',
  `jids` char(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `gids` char(100) NOT NULL COMMENT '所属用户组ID',
  `creater` char(20) NOT NULL COMMENT '创建者',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `card` (`card`)
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=gb2312 COMMENT='用户列表';

-- ----------------------------
-- Records of telbook_user
-- ----------------------------
INSERT INTO `telbook_user` VALUES ('10', '陈晨', '13890520679', '21232f297a57a5a743894a0e4a801fc3', '1', '1495537127', '', null, null, '1', '');
INSERT INTO `telbook_user` VALUES ('215', '陈晨2', '66069', 'c70f6b25d708ccc79f5a0a0adbd6ad6e', '1', '1495619449', '1', '.10008.,.10004.', '.6.,.7.', '2', '陈晨');
INSERT INTO `telbook_user` VALUES ('216', '陈晨3', '66068', '70f3d0c806f885844bce94603ccb8019', '1', '1495619499', '1', '.10007.,.10003.', null, '3', '陈晨');
INSERT INTO `telbook_user` VALUES ('217', '周翠英', '63875', '17b8be16da7f54156a14daa215f0d1d8', '1', '1495619532', '1', '.10011.,.10001.', '.4.,.5.', '5', '陈晨');
