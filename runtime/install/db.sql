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
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`,`encode_id`),
  UNIQUE KEY `encode_id` (`encode_id`),
  KEY `creater_id` (`creater_id`),
  KEY `module_id` (`module_id`),
  KEY `project_id` (`project_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目接口表';

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
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='配置表';

-- ----------------------------
--  Records of `doc_config`
-- ----------------------------
BEGIN;
INSERT INTO `doc_config` VALUES ('1', 'app', '{\"name\":\"PHPRAP接口文档管理系统\",\"keywords\":\"phprap,apidoc,api文档管理\",\"description\":\"PHPRAP，是一个PHP轻量级开源API接口文档管理系统，致力于减少前后端沟通成本，提高团队协作开发效率，打造PHP版的RAP。\",\"copyright\":\"Copyright ©2019-2029 PHPRAP版权所有\",\"email\":\"245629560@qq.com\",\"is_push\":\"0\",\"push_time\":\"10\"}', '2018-05-15 14:08:31', '2019-07-20 16:49:53'), ('3', 'email', '', '2018-05-15 14:08:35', '2018-05-15 14:08:38'), ('4', 'safe', '{\"ip_white_list\":\"\",\"ip_black_list\":\"\",\"email_white_list\":\"\",\"email_black_list\":\"\",\"register_token\":\"68823095\",\"register_captcha\":\"1\",\"login_captcha\":\"1\",\"login_keep_time\":\"24\"}', '2018-05-15 14:08:39', '2019-07-23 16:24:20');
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
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`,`encode_id`),
  UNIQUE KEY `encode_id` (`encode_id`),
  KEY `project_id` (`project_id`),
  KEY `name` (`name`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `creater_id` int(10) NOT NULL COMMENT '创建者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updater_id` int(10) NOT NULL COMMENT '更新者id',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`,`encode_id`),
  UNIQUE KEY `encode_id` (`encode_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `project_id` (`project_id`) USING BTREE,
  KEY `creater_id` (`updater_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='项目成员表';

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
  `creater_id` int(10) NOT NULL COMMENT '创建者id',
  `updater_id` int(10) NOT NULL COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`,`encode_id`),
  UNIQUE KEY `encode_id` (`encode_id`),
  KEY `project_id` (`project_id`) USING BTREE,
  KEY `user_id` (`creater_id`) USING BTREE,
  KEY `creater_id` (`creater_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目模块表';

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
  `creater_id` int(10) NOT NULL COMMENT '创建者id',
  `updater_id` int(10) NOT NULL COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`,`encode_id`),
  UNIQUE KEY `encode_id` (`encode_id`),
  KEY `creater_id` (`creater_id`),
  KEY `type` (`type`),
  KEY `status` (`status`) USING BTREE,
  KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='项目表';

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='项目日志表';

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
  `creater_id` int(10) NOT NULL COMMENT '创建者id',
  `updater_id` int(10) NOT NULL COMMENT '更新者id',
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
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `name` (`name`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员表';

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
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`,`encode_id`),
  UNIQUE KEY `encode_id` (`encode_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目版本表';

SET FOREIGN_KEY_CHECKS = 1;
