/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : zhx

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-05-15 21:47:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for paper_dimension
-- ----------------------------
DROP TABLE IF EXISTS `paper_dimension`;
CREATE TABLE `paper_dimension` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `dimensioncode` varchar(16) DEFAULT NULL COMMENT '维度编码',
  `papercode` varchar(16) DEFAULT NULL COMMENT '试卷编码',
  `items` varchar(255) DEFAULT NULL,
  `scorematrix` varchar(255) DEFAULT NULL COMMENT '评分矩阵',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of paper_dimension
-- ----------------------------
INSERT INTO `paper_dimension` VALUES ('1', 'dms1', 'etzylcpxt', '[1,4,7,10,13]', '[[1,2,3,4,5,6],[2,1,3,4,6,5],[2,1,3,4,6,5],[2,1,3,4,6,5],[1,2,3,4,5,6]]');
INSERT INTO `paper_dimension` VALUES ('2', 'dms2', 'etzylcpxt', '[2,5,8,11,14]', '[[1,2,3,4,5,6],[2,1,3,4,6,5],[2,1,3,4,6,5],[2,1,3,4,6,5],[1,2,3,4,5,6]]');
INSERT INTO `paper_dimension` VALUES ('3', 'dms3', 'etzylcpxt', '[3,6,9,12,15]', '[[1,2,3,4,5,6],[2,1,3,4,6,5],[2,1,3,4,6,5],[2,1,3,4,6,5],[1,2,3,4,5,6]]');
INSERT INTO `paper_dimension` VALUES ('4', 'dms4', 'etzylcpxt', '[1,3,5,7,9]', '[[1,2,3,4,5,6],[2,1,3,4,6,5],[2,1,3,4,6,5],[2,1,3,4,6,5],[1,2,3,4,5,6]]');
INSERT INTO `paper_dimension` VALUES ('5', 'dms5', 'etzylcpxt', '[2,4,6,8,10]', '[[1,2,3,4,5,6],[2,1,3,4,6,5],[2,1,3,4,6,5],[2,1,3,4,6,5],[1,2,3,4,5,6]]');
INSERT INTO `paper_dimension` VALUES ('6', 'dms6', 'etzylcpxt', '[11,12,13,14,15]', '[[1,2,3,4,5,6],[2,1,3,4,6,5],[2,1,3,4,6,5],[2,1,3,4,6,5],[1,2,3,4,5,6]]');

-- ----------------------------
-- Table structure for paper_info
-- ----------------------------
DROP TABLE IF EXISTS `paper_info`;
CREATE TABLE `paper_info` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `papercode` varchar(16) DEFAULT NULL COMMENT '试卷编码',
  `papername` varchar(120) DEFAULT NULL COMMENT '试卷名称',
  `adduser` mediumint(8) DEFAULT NULL COMMENT '录入人',
  `addtime` int(12) unsigned DEFAULT NULL COMMENT '录入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of paper_info
-- ----------------------------
INSERT INTO `paper_info` VALUES ('1', 'etzylcpxt', '儿童注意力测评系统', '12', '1463241600');

-- ----------------------------
-- Table structure for paper_result
-- ----------------------------
DROP TABLE IF EXISTS `paper_result`;
CREATE TABLE `paper_result` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `mid` mediumint(8) DEFAULT NULL COMMENT '被测用户id',
  `papercode` varchar(16) DEFAULT NULL COMMENT '试卷编码',
  `resultmatrix` varchar(255) DEFAULT NULL,
  `score` varchar(30) DEFAULT NULL,
  `addtime` int(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of paper_result
-- ----------------------------

-- ----------------------------
-- Table structure for paper_test_item
-- ----------------------------
DROP TABLE IF EXISTS `paper_test_item`;
CREATE TABLE `paper_test_item` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `papercode` varchar(16) DEFAULT NULL COMMENT '试卷编码',
  `testcode` varchar(16) DEFAULT NULL COMMENT '题号',
  `testname` varchar(255) DEFAULT NULL COMMENT '试题内容',
  `testitema` varchar(255) DEFAULT NULL COMMENT '试题答案a',
  `testitemb` varchar(255) DEFAULT NULL COMMENT '试题答案b',
  `testitemc` varchar(255) DEFAULT NULL COMMENT '试题答案c',
  `testitemd` varchar(255) DEFAULT NULL COMMENT '试题答案d',
  `testiteme` varchar(255) DEFAULT NULL COMMENT '试题答案e',
  `testitemf` varchar(255) DEFAULT NULL COMMENT '试题答案f',
  `testdesc` varchar(255) DEFAULT '' COMMENT '测评结果说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of paper_test_item
-- ----------------------------
INSERT INTO `paper_test_item` VALUES ('1', 'etzylcpxt', 't1', '做作业时，你喜欢开着电视吗？', '总是', '从不', '偶尔', '经常', '不确定', '其他', '');
INSERT INTO `paper_test_item` VALUES ('2', 'etzylcpxt', 't2', '听别人讲话时，你会常常想着另外一件事吗？', '总是', '从不', '偶尔', '经常', '不确定', '其他', '');
INSERT INTO `paper_test_item` VALUES ('3', 'etzylcpxt', 't3', '你常常在做作业的时候还能耳听八方吗？', '总是', '从不', '偶尔', '经常', '不确定', '其他', '');
INSERT INTO `paper_test_item` VALUES ('4', 'etzylcpxt', 't4', '做暑假作业时，你花几天的时间就能将所有的作业做完？', '总是', '从不', '偶尔', '经常', '不确定', '其他', '');
INSERT INTO `paper_test_item` VALUES ('5', 'etzylcpxt', 't5', '每天能保证长时间看书吗？', '总是', '从不', '偶尔', '经常', '不确定', '其他', '');
INSERT INTO `paper_test_item` VALUES ('6', 'etzylcpxt', 't6', '你经常在看完一页书后却不知书上讲的是什么吗？', '总是', '从不', '偶尔', '经常', '不确定', '其他', '');
INSERT INTO `paper_test_item` VALUES ('7', 'etzylcpxt', 't7', '做试卷时，你会经常漏掉题目吗？', '总是', '从不', '偶尔', '经常', '不确定', '其他', '');
INSERT INTO `paper_test_item` VALUES ('8', 'etzylcpxt', 't8', '学习时，你是否经常想起昨天发生的事情？', '总是', '从不', '偶尔', '经常', '不确定', '其他', '');
INSERT INTO `paper_test_item` VALUES ('9', 'etzylcpxt', 't9', '家人叫你拿碗筷，你却常常拿一些其他的东西吗？', '总是', '从不', '偶尔', '经常', '不确定', '其他', '');
INSERT INTO `paper_test_item` VALUES ('10', 'etzylcpxt', 't10', '你放的东西经常会找不着吗？', '总是', '从不', '偶尔', '经常', '不确定', '其他', '');
INSERT INTO `paper_test_item` VALUES ('11', 'etzylcpxt', 't11', '上课时如果外面下雨，你会分心吗？', '总是', '从不', '偶尔', '经常', '不确定', '其他', '');
INSERT INTO `paper_test_item` VALUES ('12', 'etzylcpxt', 't12', '心里一有事，你就会在上课时坐不住吗？', '总是', '从不', '偶尔', '经常', '不确定', '其他', '');
INSERT INTO `paper_test_item` VALUES ('13', 'etzylcpxt', 't13', '班上来了新老师，你会将注意力放在老师的穿着上吗？', '总是', '从不', '偶尔', '经常', '不确定', '其他', '');
INSERT INTO `paper_test_item` VALUES ('14', 'etzylcpxt', 't14', '当家里来了客人，你会取消做作业的计划吗？', '总是', '从不', '偶尔', '经常', '不确定', '其他', '');
INSERT INTO `paper_test_item` VALUES ('15', 'etzylcpxt', 't15', '一旦身体不舒服，你会请假不上学吗？', '总是', '从不', '偶尔', '经常', '不确定', '其他', '');
