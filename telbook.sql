/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : telbook

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2018-10-28 15:44:20
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=gb2312 COMMENT='企业名称列表';

-- ----------------------------
-- Records of telbook_company
-- ----------------------------
INSERT INTO `telbook_company` VALUES ('1', '隆昌二中', '1', '2', '1463908072', '365', '0', '0', '19');
INSERT INTO `telbook_company` VALUES ('20', '隆昌一中', '1', '1', '1463910552', '366', '0', '0', '0');

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
INSERT INTO `telbook_department` VALUES ('10002', '教务处', '1', '3', '1');
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
  `cid` int(6) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=gb2312 COMMENT='用户组';

-- ----------------------------
-- Records of telbook_group
-- ----------------------------
INSERT INTO `telbook_group` VALUES ('1', '超级管理员', '1', '', '0');
INSERT INTO `telbook_group` VALUES ('2', '企业管理员', '1', '23,21,26,28,27,25,42,41,30,32,31,29,58,39,45,47,46,44,65,64,63,67,66,34,36,50,53,49,38,35,33,48,40,55', '0');
INSERT INTO `telbook_group` VALUES ('3', '部门管理员', '1', '58,39,65,64,63,67,66,34,36,38,35,33,48,40', '0');
INSERT INTO `telbook_group` VALUES ('5', '部门成员', '1', '58,39,38,35,33,48,40', '0');
INSERT INTO `telbook_group` VALUES ('7', '主任', '1', '26,28,27,25', '1');
INSERT INTO `telbook_group` VALUES ('8', '副主任', '1', '27', '20');

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
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of telbook_messagelog
-- ----------------------------
INSERT INTO `telbook_messagelog` VALUES ('46', '1', '10', '陈晨', '1498489750', '0.0.0.0', '++增加短信', null, '16', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('47', '1', '10', '陈晨', '1498489856', '0.0.0.0', '++增加短信', null, '1', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('48', '1', '10', '陈晨', '1498489872', '0.0.0.0', '++增加短信', null, '-11', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('50', '1', '10', '陈晨', '1498489914', '0.0.0.0', '++增加短信', null, '17', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('51', '1', '10', '陈晨', '1498489949', '0.0.0.0', '++增加短信', null, '1', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('52', '1', '10', '陈晨', '1498490000', '0.0.0.0', '++增加短信', null, '2', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('54', '1', '10', '陈晨', '1498490166', '0.0.0.0', '++增加短信', null, '2', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('56', '20', '10', '陈晨', '1498490467', '0.0.0.0', '++增加短信', null, '-18', null, null, null);
INSERT INTO `telbook_messagelog` VALUES ('57', null, '10', '陈晨', '1499065968', '0.0.0.0', '【雾色船城】您的订单123123已经处理完成，货物即将发出，请于近3日内查收。', '13890520679,15884283875,13890520679,13628131668,13458876269,13990522888,13458899304,13890589629,13678321207,15883272588,13629001634,13568012566,15908358226,13990522751,13981430565,13568027815,18783280573,15828827465,15283276937,15983261941,13696031461,18040422157,15984281790,18181606570,15908250990,13730787361,13438645137,15884851927,18280911761,18990590280,13890503939,15828845141,13890503175,13989104789,15808320601,13628130275,13548327478', '37', '37', null, null);

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
INSERT INTO `telbook_middle` VALUES ('10', '1');
INSERT INTO `telbook_middle` VALUES ('221', '2');
INSERT INTO `telbook_middle` VALUES ('222', '5');
INSERT INTO `telbook_middle` VALUES ('223', '5');
INSERT INTO `telbook_middle` VALUES ('224', '5');
INSERT INTO `telbook_middle` VALUES ('225', '5');
INSERT INTO `telbook_middle` VALUES ('226', '5');
INSERT INTO `telbook_middle` VALUES ('227', '5');
INSERT INTO `telbook_middle` VALUES ('228', '5');
INSERT INTO `telbook_middle` VALUES ('229', '5');
INSERT INTO `telbook_middle` VALUES ('230', '5');
INSERT INTO `telbook_middle` VALUES ('231', '5');
INSERT INTO `telbook_middle` VALUES ('232', '5');
INSERT INTO `telbook_middle` VALUES ('233', '5');
INSERT INTO `telbook_middle` VALUES ('234', '5');
INSERT INTO `telbook_middle` VALUES ('235', '5');
INSERT INTO `telbook_middle` VALUES ('236', '5');
INSERT INTO `telbook_middle` VALUES ('237', '5');
INSERT INTO `telbook_middle` VALUES ('238', '5');
INSERT INTO `telbook_middle` VALUES ('239', '5');
INSERT INTO `telbook_middle` VALUES ('240', '5');
INSERT INTO `telbook_middle` VALUES ('241', '5');
INSERT INTO `telbook_middle` VALUES ('242', '5');
INSERT INTO `telbook_middle` VALUES ('243', '5');
INSERT INTO `telbook_middle` VALUES ('244', '5');
INSERT INTO `telbook_middle` VALUES ('245', '5');
INSERT INTO `telbook_middle` VALUES ('246', '5');
INSERT INTO `telbook_middle` VALUES ('247', '5');
INSERT INTO `telbook_middle` VALUES ('248', '5');
INSERT INTO `telbook_middle` VALUES ('249', '5');
INSERT INTO `telbook_middle` VALUES ('250', '5');
INSERT INTO `telbook_middle` VALUES ('251', '5');
INSERT INTO `telbook_middle` VALUES ('252', '5');
INSERT INTO `telbook_middle` VALUES ('253', '5');
INSERT INTO `telbook_middle` VALUES ('254', '5');
INSERT INTO `telbook_middle` VALUES ('255', '5');
INSERT INTO `telbook_middle` VALUES ('256', '5');
INSERT INTO `telbook_middle` VALUES ('257', '2');
INSERT INTO `telbook_middle` VALUES ('258', '3');
INSERT INTO `telbook_middle` VALUES ('259', '5');

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
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of telbook_rule
-- ----------------------------
INSERT INTO `telbook_rule` VALUES ('21', 'Home/Company/index', '企业列表管理首页', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('22', 'Home/Company/add', '添加企业', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('23', 'Home/Company/edit', '修改企业', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('24', 'Home/Company/del', '删除企业', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('25', 'Home/Department/index', '部门列表首页', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('26', 'Home/Department/add', '添加部门', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('27', 'Home/Department/edit', '修改部门', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('28', 'Home/Department/del', '删除部门', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('29', 'Home/Group/index', '用户组首页', '1', '1', '');
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
INSERT INTO `telbook_rule` VALUES ('62', 'Home/Company/message', '添加短信', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('44', 'Home/Job/index', '职务列表首页', '1', '1', '');
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
INSERT INTO `telbook_rule` VALUES ('63', 'Home/Message/savelist', '保存发送列表', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('64', 'Home/Message/getlist', '准备发送短信', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('65', 'Home/Message/dellist', '删除发送列表', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('66', 'Home/Message/showmessagelog', '显示日志列表', '1', '1', '');
INSERT INTO `telbook_rule` VALUES ('67', 'Home/Message/sendmessage', '发送短信', '1', '1', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=238 DEFAULT CHARSET=gb2312 COMMENT='用户电话表';

-- ----------------------------
-- Records of telbook_tel
-- ----------------------------
INSERT INTO `telbook_tel` VALUES ('199', '221', '111', '111', '111', '111', '111', '111', '1498702120');
INSERT INTO `telbook_tel` VALUES ('200', '222', '666666', null, null, null, null, null, '1498702844');
INSERT INTO `telbook_tel` VALUES ('201', '223', '612269', '13458876269', '3990992', null, null, null, '1498702844');
INSERT INTO `telbook_tel` VALUES ('202', '224', '612888', '13990522888', '3942753', null, null, null, '1498702844');
INSERT INTO `telbook_tel` VALUES ('203', '225', null, '13458899304', null, null, null, null, '1498702844');
INSERT INTO `telbook_tel` VALUES ('204', '226', '640629', '13890589629', null, null, null, null, '1498702844');
INSERT INTO `telbook_tel` VALUES ('205', '227', null, '13678321207', '3942911', null, null, null, '1498702844');
INSERT INTO `telbook_tel` VALUES ('206', '228', '612588', '15883272588', '3916198', null, null, '2918479846', '1498702844');
INSERT INTO `telbook_tel` VALUES ('207', '229', '612634', '13629001634', null, null, null, '1598309217', '1498702844');
INSERT INTO `telbook_tel` VALUES ('208', '230', '612566', '13568012566', null, null, null, null, '1498702844');
INSERT INTO `telbook_tel` VALUES ('209', '231', '612266', '15908358226', '3942341', null, null, null, '1498702844');
INSERT INTO `telbook_tel` VALUES ('210', '232', '612222', '13990522751', null, null, null, '261014450', '1498702844');
INSERT INTO `telbook_tel` VALUES ('211', '233', '612565', '13981430565', null, null, null, '843656540', '1498702844');
INSERT INTO `telbook_tel` VALUES ('212', '234', '612815', '13568027815', null, null, null, '1312919247', '1498702844');
INSERT INTO `telbook_tel` VALUES ('213', '235', '670573', '18783280573', null, null, null, '1150472507', '1498702844');
INSERT INTO `telbook_tel` VALUES ('214', '236', '612465', '15828827465', null, null, null, '1106589882', '1498702844');
INSERT INTO `telbook_tel` VALUES ('215', '237', '612937', '15283276937', null, null, null, '314982167', '1498702844');
INSERT INTO `telbook_tel` VALUES ('216', '238', '612941', '15983261941', null, null, null, '674605210', '1498702844');
INSERT INTO `telbook_tel` VALUES ('217', '239', '612461', '13696031461', null, null, null, '569828243', '1498702844');
INSERT INTO `telbook_tel` VALUES ('218', '240', null, '18040422157', null, null, null, '523582190', '1498702844');
INSERT INTO `telbook_tel` VALUES ('219', '241', '612790', '15984281790', null, null, null, '395053432', '1498702844');
INSERT INTO `telbook_tel` VALUES ('220', '242', null, '18181606570', null, null, null, '1670319775', '1498702844');
INSERT INTO `telbook_tel` VALUES ('221', '243', '670990', '15908250990', null, null, null, '294112970', '1498702844');
INSERT INTO `telbook_tel` VALUES ('222', '244', null, '13730787361', null, null, null, '503358453', '1498702844');
INSERT INTO `telbook_tel` VALUES ('223', '245', '642137', '13438645137', null, null, null, '654060824', '1498702844');
INSERT INTO `telbook_tel` VALUES ('224', '246', '622227', '15884851927', null, null, null, '278064586', '1498702844');
INSERT INTO `telbook_tel` VALUES ('225', '247', '612761', '18280911761', null, null, null, '417511655', '1498702844');
INSERT INTO `telbook_tel` VALUES ('226', '248', '670550', '18990590280', null, null, null, '176160413', '1498702844');
INSERT INTO `telbook_tel` VALUES ('227', '249', '612939', '13890503939', null, null, null, '1760925317', '1498702844');
INSERT INTO `telbook_tel` VALUES ('228', '250', '612141', '15828845141', null, null, null, '819151771', '1498702844');
INSERT INTO `telbook_tel` VALUES ('229', '251', '612175', '13890503175', null, null, null, '1397633084', '1498702844');
INSERT INTO `telbook_tel` VALUES ('230', '252', '612189', '13989104789', null, null, null, '284584909', '1498702844');
INSERT INTO `telbook_tel` VALUES ('231', '253', '620601', '15808320601', null, null, null, '954599086', '1498702844');
INSERT INTO `telbook_tel` VALUES ('232', '254', '612275', '13628130275', null, null, null, '369949674', '1498702844');
INSERT INTO `telbook_tel` VALUES ('233', '255', '66778', '13548327478', null, null, null, '37008321', '1498702844');
INSERT INTO `telbook_tel` VALUES ('234', '256', '612333', '13628131668', '3945535', null, null, '36140659', '1498702844');
INSERT INTO `telbook_tel` VALUES ('235', '257', '13890520679', '13890520679', '13890520679', '13890520679', '13890520679', '13890520679', '1499003411');
INSERT INTO `telbook_tel` VALUES ('236', '258', '15884283875', '15884283875', '15884283875', '15884283875', '15884283875', '15884283875', '1499003451');
INSERT INTO `telbook_tel` VALUES ('237', '259', '13890520679', '13890520679', '13890520679', '111', '111', '111', '1499003515');

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
) ENGINE=InnoDB AUTO_INCREMENT=260 DEFAULT CHARSET=gb2312 COMMENT='用户列表';

-- ----------------------------
-- Records of telbook_user
-- ----------------------------
INSERT INTO `telbook_user` VALUES ('10', 'admin', '66069', '21232f297a57a5a743894a0e4a801fc3', '1', '1540712437', '1', null, null, '1', '');
