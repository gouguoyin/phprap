SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `doc_api`
-- ----------------------------
DROP TABLE IF EXISTS `doc_api`;
CREATE TABLE `doc_api` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `encode_id` varchar(50) NOT NULL COMMENT '加密id',
  `project_id` int(10) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `module_id` int(10) NOT NULL DEFAULT '0' COMMENT '模块id',
  `title` varchar(250) NOT NULL COMMENT '接口名',
  `request_method` varchar(20) NOT NULL COMMENT '请求方式',
  `response_format` varchar(20) NOT NULL COMMENT '响应格式',
  `uri` varchar(250) NOT NULL COMMENT '接口地址',
  `header_field` text COMMENT 'header字段，json格式',
  `request_field` text COMMENT '请求字段，json格式',
  `response_field` text COMMENT '响应字段，json格式',
  `success_example` text COMMENT '成功示例',
  `error_example` text COMMENT '失败示例',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '接口简介',
  `status` tinyint(3) NOT NULL COMMENT '接口状态',
  `sort` int(10) NOT NULL COMMENT '接口排序',
  `creater_id` int(10) NOT NULL DEFAULT '0' COMMENT '创建者id',
  `updater_id` int(10) NOT NULL DEFAULT '0' COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`,`encode_id`),
  UNIQUE KEY `encode_id` (`encode_id`),
  KEY `creater_id` (`creater_id`),
  KEY `module_id` (`module_id`),
  KEY `project_id` (`project_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='项目接口表';

-- ----------------------------
--  Records of `doc_api`
-- ----------------------------
BEGIN;
INSERT INTO `doc_api` VALUES ('1', '20199824700701', '1', '2', '获取会员列表', 'post', 'json', '/user/getUsers.json', '[{\"name\":\"token\",\"title\":\"登录令牌\",\"value\":\"\",\"remark\":\"由登录接口返回\",\"level\":\"0\",\"type\":\"string\",\"required\":\"10\"},{\"name\":\"version\",\"title\":\"版本号\",\"value\":\"1.0\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\",\"required\":\"10\"}]', '[{\"name\":\"page_no\",\"title\":\"当前页码\",\"example_value\":\"1\",\"remark\":\"默认1\",\"level\":\"0\",\"type\":\"integer\",\"required\":\"20\"},{\"name\":\"page_size\",\"title\":\"每页条数\",\"example_value\":\"20\",\"remark\":\"默认20\",\"level\":\"0\",\"type\":\"integer\",\"required\":\"20\"}]', '[{\"name\":\"code\",\"title\":\"状态码\",\"example_value\":\"200\",\"remark\":\"200代表成功\",\"level\":\"0\",\"type\":\"integer\"},{\"name\":\"status\",\"title\":\"请求状态\",\"example_value\":\"success\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\"},{\"name\":\"message\",\"title\":\"返回信息\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\"},{\"name\":\"data\",\"title\":\"数据实体\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"0\",\"type\":\"array\"},{\"name\":\"avatar\",\"title\":\"用户头像\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"1\",\"type\":\"string\"},{\"name\":\"id\",\"title\":\"用户id\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"1\",\"type\":\"integer\"},{\"name\":\"email\",\"title\":\"邮箱\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"1\",\"type\":\"string\"},{\"name\":\"sex\",\"title\":\"姓别\",\"example_value\":\"\",\"remark\":\"1:男 2:女\",\"level\":\"1\",\"type\":\"integer\"},{\"name\":\"nick_name\",\"title\":\"用户昵称\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"1\",\"type\":\"string\"},{\"name\":\"avatar\",\"title\":\"用户头像\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"1\",\"type\":\"string\"}]', '{\"status\":\"success\",\"code\":200,\"message\":\"请求成功\",\"data\":[[{\"id\":1,\"nick_name\":\"勾国印\",\"email\":\"245629560@qq.com\",\"sex\":1},{\"id\":2,\"nick_name\":\"勾国磊\",\"email\":\"314418388@qq.com\",\"sex\":2}]]}', '{\"status\":\"error\",\"code\":401,\"message\":\"缺少必要参数token\",\"data\":[]}', '基于JWT机制，token由登录接口返回，有效时长24小时', '10', '20', '1', '1', '2019-08-04 23:19:28', '2019-08-07 10:40:48'), ('2', '20198034757209', '1', '2', '用户登录', 'post', 'json', '/user/login.json', '[{\"name\":\"version\",\"title\":\"版本号\",\"value\":\"1.0\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\",\"required\":\"10\"}]', '[{\"name\":\"name\",\"title\":\"登录账号\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\",\"required\":\"10\"},{\"name\":\"password\",\"title\":\"登录密码\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\",\"required\":\"10\"},{\"name\":\"captcha\",\"title\":\"验证码\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\",\"required\":\"10\"}]', '[{\"name\":\"status\",\"title\":\"请求状态\",\"example_value\":\"success\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\"},{\"name\":\"code\",\"title\":\"状态码\",\"example_value\":\"200\",\"remark\":\"\",\"level\":\"0\",\"type\":\"integer\"},{\"name\":\"message\",\"title\":\"返回信息\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\"},{\"name\":\"data\",\"title\":\"数据实体\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"0\",\"type\":\"array\"},{\"name\":\"token\",\"title\":\"令牌\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"1\",\"type\":\"string\"}]', '', '', '用户登录接口', '10', '10', '1', '1', '2019-08-06 16:32:27', '2019-08-07 10:20:17'), ('3', '20198136702189', '1', '2', '用户注册', 'post', 'json', '/user/register.json', '[{\"name\":\"version\",\"title\":\"版本号\",\"value\":\"1.0\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\",\"required\":\"10\"}]', '[{\"name\":\"name\",\"title\":\"注册名\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\",\"required\":\"10\"},{\"name\":\"password\",\"title\":\"密码\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\",\"required\":\"10\"},{\"name\":\"repassword\",\"title\":\"重复密码\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\",\"required\":\"10\"},{\"name\":\"captcha\",\"title\":\"验证码\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\",\"required\":\"10\"}]', '[{\"name\":\"status\",\"title\":\"请求状态\",\"example_value\":\"success\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\"},{\"name\":\"code\",\"title\":\"状态码\",\"example_value\":\"200\",\"remark\":\"\",\"level\":\"0\",\"type\":\"integer\"},{\"name\":\"message\",\"title\":\"返回信息\",\"example_value\":\"注册成功\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\"}]', '', '', '用户注册接口', '10', '15', '1', '1', '2019-08-06 16:49:27', '2019-08-07 10:15:11'), ('4', '20194429182922', '1', '2', '获取用户信息', 'post', 'json', '/user/getUser.json', '[{\"name\":\"version\",\"title\":\"版本号\",\"value\":\"1.0\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\",\"required\":\"10\"},{\"name\":\"token\",\"title\":\"登录令牌\",\"value\":\"\",\"remark\":\"由登录接口返回\",\"level\":\"0\",\"type\":\"string\",\"required\":\"10\"}]', '', '[{\"name\":\"code\",\"title\":\"状态码\",\"example_value\":\"200\",\"remark\":\"200代表成功\",\"level\":\"0\",\"type\":\"integer\"},{\"name\":\"status\",\"title\":\"请求状态\",\"example_value\":\"success\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\"},{\"name\":\"message\",\"title\":\"返回信息\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\"},{\"name\":\"data\",\"title\":\"数据实体\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"0\",\"type\":\"array\"},{\"name\":\"id\",\"title\":\"用户id\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"1\",\"type\":\"integer\"},{\"name\":\"email\",\"title\":\"邮箱\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"1\",\"type\":\"string\"},{\"name\":\"sex\",\"title\":\"姓别\",\"example_value\":\"\",\"remark\":\"1:男 2:女\",\"level\":\"1\",\"type\":\"integer\"},{\"name\":\"nick_name\",\"title\":\"用户昵称\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"1\",\"type\":\"string\"},{\"name\":\"avatar\",\"title\":\"用户头像\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"1\",\"type\":\"string\"}]', '', '', '根据token获取用户信息', '10', '0', '1', '1', '2019-08-07 10:18:11', '2019-08-07 10:37:07'), ('5', '20194455132989', '1', '1', '获取我的订单', 'post', 'json', '/order/getOrders.json', '[{\"name\":\"version\",\"title\":\"版本号\",\"value\":\"1.0\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\",\"required\":\"10\"},{\"name\":\"token\",\"title\":\"登录令牌\",\"value\":\"\",\"remark\":\"由登录接口返回\",\"level\":\"0\",\"type\":\"string\",\"required\":\"10\"}]', '[{\"name\":\"order_status\",\"title\":\"订单状态\",\"example_value\":\"\",\"remark\":\"10:待付款 20:已付款 30:已退款\",\"level\":\"0\",\"type\":\"integer\",\"required\":\"20\"},{\"name\":\"send_status\",\"title\":\"发货状态\",\"example_value\":\"\",\"remark\":\"10:待发货 20:已发货 30:已退货\",\"level\":\"0\",\"type\":\"integer\",\"required\":\"20\"},{\"name\":\"page_no\",\"title\":\"当前页面\",\"example_value\":\"\",\"remark\":\"默认1\",\"level\":\"0\",\"type\":\"integer\",\"required\":\"10\"},{\"name\":\"page_size\",\"title\":\"每页条数\",\"example_value\":\"\",\"remark\":\"默认20条\",\"level\":\"0\",\"type\":\"integer\",\"required\":\"10\"}]', '[{\"name\":\"code\",\"title\":\"状态码\",\"example_value\":\"200\",\"remark\":\"200代表成功\",\"level\":\"0\",\"type\":\"integer\"},{\"name\":\"status\",\"title\":\"请求状态\",\"example_value\":\"success\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\"},{\"name\":\"message\",\"title\":\"返回信息\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"0\",\"type\":\"string\"},{\"name\":\"data\",\"title\":\"数据实体\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"0\",\"type\":\"array\"},{\"name\":\"total_page\",\"title\":\"总页数\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"1\",\"type\":\"integer\"},{\"name\":\"total_price\",\"title\":\"订单总价\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"1\",\"type\":\"float\"},{\"name\":\"total_count\",\"title\":\"商品总数\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"1\",\"type\":\"integer\"},{\"name\":\"goods\",\"title\":\"订单商品\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"1\",\"type\":\"array\"},{\"name\":\"thumb\",\"title\":\"商品缩略图\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"2\",\"type\":\"string\"},{\"name\":\"price\",\"title\":\"商品价格\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"2\",\"type\":\"string\"},{\"name\":\"title\",\"title\":\"商品标题\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"2\",\"type\":\"string\"},{\"name\":\"id\",\"title\":\"商品ID\",\"example_value\":\"\",\"remark\":\"\",\"level\":\"2\",\"type\":\"integer\"}]', '', '', '根据token获取我的订单列表', '10', '0', '1', '1', '2019-08-07 10:22:31', '2019-08-07 10:44:54');
COMMIT;

-- ----------------------------
--  Table structure for `doc_apply`
-- ----------------------------
DROP TABLE IF EXISTS `doc_apply`;
CREATE TABLE `doc_apply` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `project_id` int(10) NOT NULL COMMENT '项目id',
  `user_id` int(10) NOT NULL COMMENT '申请用户id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态',
  `ip` varchar(250) NOT NULL COMMENT 'IP',
  `location` varchar(250) NOT NULL COMMENT 'ip定位地址',
  `created_at` datetime DEFAULT NULL COMMENT '申请日期',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `checked_at` datetime DEFAULT NULL COMMENT '处理日期',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='申请加入项目表';

-- ----------------------------
--  Table structure for `doc_config`
-- ----------------------------
DROP TABLE IF EXISTS `doc_config`;
CREATE TABLE `doc_config` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL COMMENT '配置类型',
  `content` text NOT NULL COMMENT '配置内容',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='配置表';

-- ----------------------------
--  Records of `doc_config`
-- ----------------------------
BEGIN;
INSERT INTO `doc_config` VALUES ('1', 'app', '{\"name\":\"PHPRAP接口文档管理系统\",\"keywords\":\"phprap,apidoc,api文档管理\",\"description\":\"PHPRAP，是一个PHP轻量级开源API接口文档管理系统，致力于减少前后端沟通成本，提高团队协作开发效率，打造PHP版的RAP。\",\"copyright\":\"Copyright ©2019-2029 PHPRAP版权所有\",\"email\":\"245629560@qq.com\",\"is_push\":\"1\",\"push_time\":\"20\"}', '2018-05-15 14:08:31', '2019-07-20 16:49:53'), ('3', 'email', '', '2018-05-15 14:08:35', '2018-05-15 14:08:38'), ('4', 'safe', '{\"ip_white_list\":\"\",\"ip_black_list\":\"\",\"email_white_list\":\"\",\"email_black_list\":\"\",\"register_token\":\"\",\"register_captcha\":\"1\",\"login_captcha\":\"1\",\"login_keep_time\":\"24\"}', '2018-05-15 14:08:39', '2019-07-23 16:24:20');
COMMIT;

-- ----------------------------
--  Table structure for `doc_env`
-- ----------------------------
DROP TABLE IF EXISTS `doc_env`;
CREATE TABLE `doc_env` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `encode_id` varchar(50) NOT NULL COMMENT '加密id',
  `project_id` int(10) NOT NULL COMMENT '项目id',
  `title` varchar(50) NOT NULL COMMENT '环境名称',
  `name` varchar(10) NOT NULL COMMENT '环境标识',
  `base_url` varchar(250) NOT NULL COMMENT '环境根路径',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '环境排序',
  `status` tinyint(3) NOT NULL DEFAULT '10' COMMENT '环境状态',
  `creater_id` int(10) NOT NULL DEFAULT '0' COMMENT '创建者id',
  `updater_id` int(10) NOT NULL DEFAULT '0' COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`,`encode_id`),
  UNIQUE KEY `encode_id` (`encode_id`),
  KEY `project_id` (`project_id`),
  KEY `name` (`name`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `doc_env`
-- ----------------------------
BEGIN;
INSERT INTO `doc_env` VALUES ('1', '20199826895162', '1', '生产环境', 'product', 'http://api.phprap.com/rest', '0', '10', '1', '1', '2019-08-04 13:57:48', '2019-08-04 21:55:41'), ('2', '20199828034819', '1', '开发环境', 'develop', 'http://dev.api.phprap.com/rest', '0', '10', '1', '1', '2019-08-04 13:58:00', '2019-08-04 23:30:13'), ('3', '20194388416427', '1', '测试环境', 'test', 'http://test.api.phprap.com/rest', '0', '10', '1', '0', '2019-08-07 10:11:24', null);
COMMIT;

-- ----------------------------
--  Table structure for `doc_login_log`
-- ----------------------------
DROP TABLE IF EXISTS `doc_login_log`;
CREATE TABLE `doc_login_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `user_name` varchar(50) NOT NULL COMMENT '用户名称',
  `user_email` varchar(50) NOT NULL COMMENT '用户邮箱',
  `ip` varchar(50) NOT NULL COMMENT '登录ip',
  `location` varchar(255) NOT NULL DEFAULT '' COMMENT '登录地址',
  `browser` varchar(250) DEFAULT NULL COMMENT '浏览器',
  `os` varchar(250) DEFAULT NULL COMMENT '操作系统',
  `created_at` datetime DEFAULT NULL COMMENT '登录时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='登录日志表';

-- ----------------------------
--  Table structure for `doc_member`
-- ----------------------------
DROP TABLE IF EXISTS `doc_member`;
CREATE TABLE `doc_member` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `encode_id` varchar(50) NOT NULL COMMENT '加密id',
  `project_id` int(10) NOT NULL COMMENT '项目id',
  `user_id` int(10) NOT NULL COMMENT '用户id',
  `join_type` tinyint(3) NOT NULL COMMENT '加入方式',
  `project_rule` varchar(100) NOT NULL DEFAULT '' COMMENT '项目权限',
  `env_rule` varchar(100) NOT NULL COMMENT '环境权限',
  `module_rule` varchar(100) NOT NULL DEFAULT '' COMMENT '模块权限',
  `api_rule` varchar(100) NOT NULL DEFAULT '' COMMENT '接口权限',
  `member_rule` varchar(100) NOT NULL DEFAULT '' COMMENT '成员权限',
  `creater_id` int(10) NOT NULL DEFAULT '0' COMMENT '创建者id',
  `created_at` datetime DEFAULT NULL  COMMENT '创建时间',
  `updater_id` int(10) DEFAULT NULL DEFAULT '0' COMMENT '更新者id',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`,`encode_id`),
  UNIQUE KEY `encode_id` (`encode_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `project_id` (`project_id`) USING BTREE,
  KEY `creater_id` (`updater_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目成员表';

-- ----------------------------
--  Table structure for `doc_module`
-- ----------------------------
DROP TABLE IF EXISTS `doc_module`;
CREATE TABLE `doc_module` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `encode_id` varchar(50) NOT NULL COMMENT '加密id',
  `project_id` int(10) NOT NULL COMMENT '项目id',
  `title` varchar(50) NOT NULL COMMENT '模块名称',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '项目描述',
  `status` tinyint(3) NOT NULL COMMENT '模块状态 ',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '模块排序',
  `creater_id` int(10) NOT NULL DEFAULT '0' COMMENT '创建者id',
  `updater_id` int(10) NOT NULL DEFAULT '0' COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`,`encode_id`),
  UNIQUE KEY `encode_id` (`encode_id`),
  KEY `project_id` (`project_id`) USING BTREE,
  KEY `user_id` (`creater_id`) USING BTREE,
  KEY `creater_id` (`creater_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目模块表';

-- ----------------------------
--  Records of `doc_module`
-- ----------------------------
BEGIN;
INSERT INTO `doc_module` VALUES ('1', '20199819280518', '1', '订单模块', '', '10', '0', '1', '1', '2019-08-04 13:56:32', '2019-08-07 10:24:03'), ('2', '20199820567005', '1', '会员模块', '', '10', '0', '1', '0', '2019-08-04 13:56:45', '2019-08-07 10:09:11');
COMMIT;

-- ----------------------------
--  Table structure for `doc_project`
-- ----------------------------
DROP TABLE IF EXISTS `doc_project`;
CREATE TABLE `doc_project` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `encode_id` varchar(50) NOT NULL COMMENT '加密id',
  `title` varchar(250) NOT NULL COMMENT '项目名称',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '项目描述',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '项目排序',
  `status` tinyint(3) NOT NULL COMMENT '项目状态',
  `type` tinyint(3) NOT NULL COMMENT '项目类型',
  `creater_id` int(10) NOT NULL DEFAULT '0' COMMENT '创建者id',
  `updater_id` int(10) NOT NULL DEFAULT '0' COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`,`encode_id`),
  UNIQUE KEY `encode_id` (`encode_id`),
  KEY `creater_id` (`creater_id`),
  KEY `type` (`type`),
  KEY `status` (`status`) USING BTREE,
  KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='项目表';

-- ----------------------------
--  Records of `doc_project`
-- ----------------------------
BEGIN;
INSERT INTO `doc_project` VALUES ('1', '20192100118327', '官方测试项目', '这是一个官方测试项目', '0', '10', '10', '1', '1', '2019-08-03 16:30:01', '2019-08-05 15:07:58');
COMMIT;

-- ----------------------------
--  Table structure for `doc_project_log`
-- ----------------------------
DROP TABLE IF EXISTS `doc_project_log`;
CREATE TABLE `doc_project_log` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `project_id` int(10) NOT NULL COMMENT '项目id',
  `module_id` int(10) NOT NULL DEFAULT '0' COMMENT '模块id',
  `api_id` int(10) NOT NULL DEFAULT '0' COMMENT '接口id',
  `user_id` int(10) NOT NULL COMMENT '操作人id',
  `user_name` varchar(50) NOT NULL COMMENT '操作人昵称',
  `user_email` varchar(50) NOT NULL COMMENT '操作人邮箱',
  `version_id` int(10) NOT NULL DEFAULT '0' COMMENT '操作版本id',
  `version_name` varchar(255) NOT NULL DEFAULT '' COMMENT '操作版本号',
  `method` varchar(10) NOT NULL COMMENT '操作方式',
  `object_name` varchar(20) NOT NULL COMMENT '操作对象',
  `object_id` int(10) NOT NULL COMMENT '操作对象id',
  `content` text NOT NULL COMMENT '操作内容',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `object_id` (`object_id`),
  KEY `project_id` (`project_id`) USING BTREE,
  KEY `version_id` (`version_id`),
  KEY `module_id` (`module_id`),
  KEY `api_id` (`api_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目日志表';

-- ----------------------------
--  Table structure for `doc_template`
-- ----------------------------
DROP TABLE IF EXISTS `doc_template`;
CREATE TABLE `doc_template` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `encode_id` varchar(10) NOT NULL COMMENT '加密id',
  `project_id` int(10) NOT NULL COMMENT '项目id',
  `header_field` text NOT NULL COMMENT 'header参数，json格式',
  `request_field` text NOT NULL COMMENT '请求参数，json格式',
  `response_field` text NOT NULL COMMENT '响应参数，json格式',
  `status` tinyint(3) NOT NULL COMMENT '模板状态',
  `creater_id` int(10) NOT NULL DEFAULT '0' COMMENT '创建者id',
  `updater_id` int(10) NOT NULL DEFAULT '0' COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`,`encode_id`),
  UNIQUE KEY `project_id` (`project_id`),
  UNIQUE KEY `encode_id` (`encode_id`),
  KEY `creater_id` (`creater_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `doc_user`
-- ----------------------------
DROP TABLE IF EXISTS `doc_user`;
CREATE TABLE `doc_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `password_hash` varchar(250) NOT NULL DEFAULT '' COMMENT '密码',
  `auth_key` varchar(250) NOT NULL,
  `type` tinyint(3) NOT NULL DEFAULT '10' COMMENT '用户类型，10:普通用户 20:管理员',
  `status` tinyint(3) NOT NULL COMMENT '会员状态',
  `ip` varchar(250) NOT NULL DEFAULT '' COMMENT '注册ip',
  `location` varchar(255) NOT NULL DEFAULT '' COMMENT 'IP地址',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `name` (`name`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
--  Records of `doc_user`
-- ----------------------------
BEGIN;
INSERT INTO `doc_user` VALUES ('1', 'admin@phprap.com', 'phprap', '$2y$13$YxEX7alh2DmANipc4lnh4./vxB/JGuzSm2tCshfT0rtSRU1DDOrHW', '8RYphKjzLwE-HAo9Wmp3riEGCLauwOAk', '10', '10', '61.50.125.102', '中国 北京 北京', '2019-08-03 12:12:08', '2019-08-05 14:32:25');
COMMIT;

-- ----------------------------
--  Table structure for `doc_version`
-- ----------------------------
DROP TABLE IF EXISTS `doc_version`;
CREATE TABLE `doc_version` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `encode_id` varchar(10) NOT NULL COMMENT '加密id',
  `project_id` int(10) NOT NULL DEFAULT '0' COMMENT '项目id',
  `parent_id` int(10) NOT NULL DEFAULT '0' COMMENT '父级版本id',
  `name` varchar(10) NOT NULL COMMENT '版本号',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '备注信息',
  `status` tinyint(3) NOT NULL COMMENT '版本状态',
  `creater_id` int(10) NOT NULL DEFAULT '0' COMMENT '版本创建者id',
  `updater_id` int(10) NOT NULL DEFAULT '0' COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`,`encode_id`),
  UNIQUE KEY `encode_id` (`encode_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目版本表';

SET FOREIGN_KEY_CHECKS = 1;
