SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- 表的结构 `doc_api`
--

CREATE TABLE `doc_api` (
  `id` int(10) NOT NULL,
  `encode_id` varchar(50) NOT NULL COMMENT '加密id',
  `project_id` int(10) NOT NULL DEFAULT '0' COMMENT '项目ID',
  `module_id` int(10) NOT NULL DEFAULT '0' COMMENT '模块id',
  `title` varchar(250) NOT NULL COMMENT '接口名',
  `request_method` varchar(20) NOT NULL COMMENT '请求方式',
  `response_format` varchar(20) NOT NULL COMMENT '响应格式',
  `uri` varchar(250) NOT NULL COMMENT '接口地址',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '接口简介',
  `status` tinyint(3) NOT NULL COMMENT '接口状态',
  `sort` int(10) NOT NULL COMMENT '接口排序',
  `creater_id` int(10) NOT NULL DEFAULT '0' COMMENT '创建者id',
  `updater_id` int(10) NOT NULL DEFAULT '0' COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目接口表';

--
-- 转存表中的数据 `doc_api`
--

INSERT INTO `doc_api` (`id`, `encode_id`, `project_id`, `module_id`, `title`, `request_method`, `response_format`, `uri`, `remark`, `status`, `sort`, `creater_id`, `updater_id`, `created_at`, `updated_at`) VALUES
(1, '20198062957335', 1, 1, '用户注册', 'post', 'json', '/user/register.json', '用户注册接口', 10, 30, 1, 0, '2019-08-30 23:57:09', '2019-08-31 09:34:38'),
(2, '20198196192530', 1, 1, '用户登录', 'post', 'json', '/user/login.json', '用户登录接口', 10, 20, 1, 0, '2019-08-31 00:19:21', '2019-08-31 09:34:43'),
(3, '20198251327666', 1, 1, '获取会员信息', 'post', 'json', '/user/getUser.json', '获取会员信息', 10, 10, 1, 0, '2019-08-31 00:28:33', '2019-08-31 09:34:45'),
(4, '20198334570253', 1, 1, '获取会员列表', 'post', 'json', '/user/getUsers.json', '基于JWT机制，token由登录接口返回，有效时长24小时', 10, 0, 1, 0, '2019-08-31 00:42:25', '2019-08-31 09:34:49');

-- --------------------------------------------------------

--
-- 表的结构 `doc_apply`
--

CREATE TABLE `doc_apply` (
  `id` int(10) NOT NULL,
  `project_id` int(10) NOT NULL COMMENT '项目id',
  `user_id` int(10) NOT NULL COMMENT '申请用户id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态',
  `ip` varchar(250) NOT NULL COMMENT 'IP',
  `location` varchar(250) NOT NULL COMMENT 'ip定位地址',
  `created_at` datetime DEFAULT NULL COMMENT '申请日期',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `checked_at` datetime DEFAULT NULL COMMENT '处理日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='申请加入项目表';

-- --------------------------------------------------------

--
-- 表的结构 `doc_config`
--

CREATE TABLE `doc_config` (
  `id` int(10) NOT NULL,
  `type` varchar(10) NOT NULL COMMENT '配置类型',
  `content` text NOT NULL COMMENT '配置内容',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配置表';

--
-- 转存表中的数据 `doc_config`
--

INSERT INTO `doc_config` (`id`, `type`, `content`, `created_at`, `updated_at`) VALUES
(1, 'app', '{\"name\":\"PHPRAP接口文档管理系统\",\"keywords\":\"phprap,apidoc,api文档管理\",\"description\":\"PHPRAP，是一个PHP轻量级开源API接口文档管理系统，致力于减少前后端沟通成本，提高团队协作开发效率，打造PHP版的RAP。\",\"copyright\":\"Copyright ©2018-2028 PHPRAP版权所有\",\"email\":\"245629560@qq.com\",\"export_time\":\"60\",\"is_push\":\"0\",\"push_time\":\"20\"}', '2018-05-15 14:08:31', '2019-08-30 16:12:03'),
(2, 'email', '', '2018-05-15 14:08:35', '2019-08-31 09:35:17'),
(3, 'safe', '{\"ip_white_list\":\"\",\"ip_black_list\":\"\",\"email_white_list\":\"\",\"email_black_list\":\"\",\"register_token\":\"\",\"register_captcha\":\"1\",\"login_captcha\":\"1\",\"login_keep_time\":\"24\"}', '2018-05-15 14:08:39', '2019-08-31 09:35:23');

-- --------------------------------------------------------

--
-- 表的结构 `doc_env`
--

CREATE TABLE `doc_env` (
  `id` int(10) NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `doc_env`
--

INSERT INTO `doc_env` (`id`, `encode_id`, `project_id`, `title`, `name`, `base_url`, `sort`, `status`, `creater_id`, `updater_id`, `created_at`, `updated_at`) VALUES
(1, '20197974781980', 1, '生产环境', 'product', 'http://api.phprap.com/rest', 0, 10, 1, 0, '2019-08-30 23:42:27', '2019-08-30 15:44:44'),
(2, '20197976030919', 1, '开发环境', 'develop', 'http://dev.api.phprap.com/rest', 0, 10, 1, 0, '2019-08-30 23:42:40', '2019-08-30 15:44:49'),
(3, '20197977260782', 1, '测试环境', 'test', 'http://test.api.phprap.com/rest', 0, 10, 1, 0, '2019-08-30 23:42:52', '2019-08-30 15:44:51');

-- --------------------------------------------------------

--
-- 表的结构 `doc_field`
--

CREATE TABLE `doc_field` (
  `id` int(10) NOT NULL,
  `encode_id` varchar(50) NOT NULL COMMENT '加密ID',
  `api_id` int(10) DEFAULT '0' COMMENT '接口ID',
  `post_method` tinyint(3) DEFAULT '0' COMMENT 'post请求方式',
  `header_fields` text COMMENT 'header字段',
  `request_fields` text COMMENT '请求字段',
  `response_fields` text COMMENT '响应字段',
  `creater_id` int(10) NOT NULL DEFAULT '0' COMMENT '创建者id',
  `updater_id` int(10) NOT NULL DEFAULT '0' COMMENT '更新者id',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='接口字段表';

--
-- 转存表中的数据 `doc_field`
--

INSERT INTO `doc_field` (`id`, `encode_id`, `api_id`, `post_method`, `header_fields`, `request_fields`, `response_fields`, `creater_id`, `updater_id`, `created_at`, `updated_at`) VALUES
(1, '20198062958156', 1, 10 , NULL, '[{\"id\":\"2\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"name\",\"title\":\"登录名\",\"type\":\"string\",\"required\":\"10\",\"example_value\":\"\",\"remark\":\"\"},{\"id\":\"3\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"password\",\"title\":\"登录密码\",\"type\":\"integer\",\"required\":\"10\",\"example_value\":\"\",\"remark\":\"\"},{\"id\":\"4\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"repassword\",\"title\":\"重复密码\",\"type\":\"string\",\"required\":\"10\",\"example_value\":\"\",\"remark\":\"\"},{\"id\":\"5\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"captcha\",\"title\":\"验证码\",\"type\":\"string\",\"required\":\"10\",\"example_value\":\"\",\"remark\":\"\"}]', '[{\"id\":\"3\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"status\",\"title\":\"请求状态\",\"type\":\"string\",\"example_value\":\"success\",\"remark\":\"success代表请求成功,error代表请求失败\"},{\"id\":\"4\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"code\",\"title\":\"状态码\",\"type\":\"string\",\"example_value\":\"200\",\"remark\":\"200代表成功\"},{\"id\":\"5\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"message\",\"title\":\"返回信息\",\"type\":\"string\",\"example_value\":\"注册成功\",\"remark\":\"\"}]', 1, 1, '2019-08-30 23:57:09', '2019-08-31 09:35:48'),
(2, '20198196193369', 2, 10, '', '[{\"id\":\"2\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"name\",\"title\":\"登录账号\",\"example_value\":\"\",\"remark\":\"\",\"type\":\"string\",\"required\":\"10\"},{\"id\":\"3\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"password\",\"title\":\"登录密码\",\"example_value\":\"\",\"remark\":\"\",\"type\":\"string\",\"required\":\"10\"},{\"id\":\"4\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"captcha\",\"title\":\"验证码\",\"example_value\":\"\",\"remark\":\"\",\"type\":\"string\",\"required\":\"10\"}]', '[{\"id\":\"2\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"status\",\"title\":\"请求状态\",\"example_value\":\"success\",\"remark\":\"success代表请求成功,error代表请求失败\",\"type\":\"string\"},{\"id\":\"3\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"code\",\"title\":\"状态码\",\"example_value\":\"200\",\"remark\":\"200代表成功\",\"type\":\"integer\"},{\"id\":\"4\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"message\",\"title\":\"返回信息\",\"example_value\":\"登录成功\",\"remark\":\"\",\"type\":\"string\"},{\"id\":\"5\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"data\",\"title\":\"数据实体\",\"example_value\":\"{}\",\"remark\":\"\",\"type\":\"object\"},{\"id\":\"6\",\"parent_id\":\"5\",\"level\":\"1\",\"name\":\"token\",\"title\":\"登录令牌\",\"example_value\":\"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9\",\"remark\":\"\",\"type\":\"string\"}]', 1, 1, '2019-08-31 00:19:21', '2019-08-31 09:35:52'),
(3, '20198251328497', 3, 10,  '[{\"id\":\"2\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"version\",\"title\":\"版本号\",\"value\":\"1.0\",\"remark\":\"\",\"type\":\"string\",\"required\":\"10\"},{\"id\":\"3\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"token\",\"title\":\"登录令牌\",\"value\":\"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9\",\"remark\":\"\",\"type\":\"string\",\"required\":\"10\"}]', '', '[{\"id\":\"2\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"status\",\"title\":\"请求状态\",\"example_value\":\"success\",\"remark\":\"success代表请求成功,error代表请求失败\",\"type\":\"string\"},{\"id\":\"3\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"code\",\"title\":\"状态码\",\"example_value\":\"200\",\"remark\":\"200代表成功\",\"type\":\"string\"},{\"id\":\"4\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"message\",\"title\":\"返回信息\",\"example_value\":\"获取成功\",\"remark\":\"\",\"type\":\"string\"},{\"id\":\"5\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"user\",\"title\":\"会员实体\",\"example_value\":\"{}\",\"remark\":\"\",\"type\":\"object\"},{\"id\":\"8\",\"parent_id\":\"5\",\"level\":\"1\",\"name\":\"level\",\"title\":\"用户等级\",\"example_value\":\"10\",\"remark\":\"\",\"type\":\"integer\"},{\"id\":\"7\",\"parent_id\":\"5\",\"level\":\"1\",\"name\":\"nick_name\",\"title\":\"用户昵称\",\"example_value\":\"phprap\",\"remark\":\"\",\"type\":\"string\"},{\"id\":\"6\",\"parent_id\":\"5\",\"level\":\"1\",\"name\":\"login_name\",\"title\":\"登录名\",\"example_value\":\"demo@phprap.com\",\"remark\":\"\",\"type\":\"string\"}]', 1, 1, '2019-08-31 00:28:33', '2019-08-31 09:35:55'),
(4, '20198334571089', 4, 10,  '[{\"id\":\"2\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"version\",\"title\":\"版本号\",\"value\":\"1.0\",\"remark\":\"\",\"type\":\"string\",\"required\":\"10\"},{\"id\":\"3\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"token\",\"title\":\"登录令牌\",\"value\":\"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9\",\"remark\":\"由登录接口返回\",\"type\":\"string\",\"required\":\"10\"}]', '[{\"id\":\"2\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"page_no\",\"title\":\"当前页码\",\"example_value\":\"1\",\"remark\":\"默认1\",\"type\":\"integer\",\"required\":\"10\"},{\"id\":\"3\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"page_size\",\"title\":\"每页条数\",\"example_value\":\"20\",\"remark\":\"默认20\",\"type\":\"string\",\"required\":\"10\"}]', '[{\"id\":\"2\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"status\",\"title\":\"请求状态\",\"example_value\":\"success\",\"remark\":\"success代表请求成功,error代表请求失败\",\"type\":\"string\"},{\"id\":\"3\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"code\",\"title\":\"状态码\",\"example_value\":\"200\",\"remark\":\"200代表成功\",\"type\":\"string\"},{\"id\":\"4\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"message\",\"title\":\"返回信息\",\"example_value\":\"获取成功\",\"remark\":\"\",\"type\":\"string\"},{\"id\":\"5\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"user\",\"title\":\"会员实体\",\"example_value\":\"[{},{}]\",\"remark\":\"\",\"type\":\"array\"},{\"id\":\"8\",\"parent_id\":\"5\",\"level\":\"1\",\"name\":\"level\",\"title\":\"用户等级\",\"example_value\":\"10\",\"remark\":\"\",\"type\":\"integer\"},{\"id\":\"7\",\"parent_id\":\"5\",\"level\":\"1\",\"name\":\"nick_name\",\"title\":\"用户昵称\",\"example_value\":\"phprap\",\"remark\":\"\",\"type\":\"string\"},{\"id\":\"6\",\"parent_id\":\"5\",\"level\":\"1\",\"name\":\"login_name\",\"title\":\"登录名\",\"example_value\":\"demo@phprap.com\",\"remark\":\"\",\"type\":\"string\"}]', 1, 1, '2019-08-31 00:42:25', '2019-08-31 09:36:15');

-- --------------------------------------------------------

--
-- 表的结构 `doc_login_log`
--

CREATE TABLE `doc_login_log` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `user_name` varchar(50) NOT NULL COMMENT '用户名称',
  `user_email` varchar(50) NOT NULL COMMENT '用户邮箱',
  `ip` varchar(50) NOT NULL COMMENT '登录ip',
  `location` varchar(255) NOT NULL DEFAULT '' COMMENT '登录地址',
  `browser` varchar(250) DEFAULT NULL COMMENT '浏览器',
  `os` varchar(250) DEFAULT NULL COMMENT '操作系统',
  `created_at` datetime DEFAULT NULL COMMENT '登录时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='登录日志表';

-- --------------------------------------------------------

--
-- 表的结构 `doc_member`
--

CREATE TABLE `doc_member` (
  `id` int(10) NOT NULL,
  `encode_id` varchar(50) NOT NULL COMMENT '加密id',
  `project_id` int(10) NOT NULL COMMENT '项目id',
  `user_id` int(10) NOT NULL COMMENT '用户id',
  `join_type` tinyint(3) NOT NULL COMMENT '加入方式',
  `project_rule` varchar(100) NOT NULL DEFAULT '' COMMENT '项目权限',
  `env_rule` varchar(100) NOT NULL COMMENT '环境权限',
  `template_rule` varchar(100) NOT NULL COMMENT '模板权限',
  `module_rule` varchar(100) NOT NULL DEFAULT '' COMMENT '模块权限',
  `api_rule` varchar(100) NOT NULL DEFAULT '' COMMENT '接口权限',
  `member_rule` varchar(100) NOT NULL DEFAULT '' COMMENT '成员权限',
  `creater_id` int(10) NOT NULL DEFAULT '0' COMMENT '创建者id',
  `updater_id` int(10) DEFAULT '0' COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目成员表';

-- --------------------------------------------------------

--
-- 表的结构 `doc_module`
--

CREATE TABLE `doc_module` (
  `id` int(10) NOT NULL,
  `encode_id` varchar(50) NOT NULL COMMENT '加密id',
  `project_id` int(10) NOT NULL COMMENT '项目id',
  `title` varchar(50) NOT NULL COMMENT '模块名称',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '项目描述',
  `status` tinyint(3) NOT NULL COMMENT '模块状态 ',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '模块排序',
  `creater_id` int(10) NOT NULL DEFAULT '0' COMMENT '创建者id',
  `updater_id` int(10) NOT NULL DEFAULT '0' COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目模块表';

--
-- 转存表中的数据 `doc_module`
--

INSERT INTO `doc_module` (`id`, `encode_id`, `project_id`, `title`, `remark`, `status`, `sort`, `creater_id`, `updater_id`, `created_at`, `updated_at`) VALUES
(1, '20198044134590', 1, '会员模块', '会员相关接口', 10, 10, 1, 0, '2019-08-30 23:54:01', '2019-08-30 15:54:01');

-- --------------------------------------------------------

--
-- 表的结构 `doc_project`
--

CREATE TABLE `doc_project` (
  `id` int(10) NOT NULL,
  `encode_id` varchar(50) NOT NULL COMMENT '加密id',
  `title` varchar(250) NOT NULL COMMENT '项目名称',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '项目描述',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '项目排序',
  `status` tinyint(3) NOT NULL COMMENT '项目状态',
  `type` tinyint(3) NOT NULL COMMENT '项目类型',
  `creater_id` int(10) NOT NULL DEFAULT '0' COMMENT '创建者id',
  `updater_id` int(10) NOT NULL DEFAULT '0' COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目表';

--
-- 转存表中的数据 `doc_project`
--

INSERT INTO `doc_project` (`id`, `encode_id`, `title`, `remark`, `sort`, `status`, `type`, `creater_id`, `updater_id`, `created_at`, `updated_at`) VALUES
(1, '20197971102589', '官方示例项目', '这是一个官方示例项目', 0, 10, 10, 1, 0, '2019-08-30 23:41:51', '2019-08-30 15:43:36');

-- --------------------------------------------------------

--
-- 表的结构 `doc_project_log`
--

CREATE TABLE `doc_project_log` (
  `id` int(1) NOT NULL,
  `project_id` int(10) NOT NULL DEFAULT '0' COMMENT '项目id',
  `object_name` varchar(10) NOT NULL COMMENT '操作对象',
  `object_id` int(10) NOT NULL DEFAULT '0'  COMMENT '操作对象id',
  `user_id` int(10) NOT NULL DEFAULT '0'  COMMENT '操作人id',
  `type` varchar(10) NOT NULL DEFAULT '0' COMMENT '操作类型',
  `content` text NOT NULL COMMENT '操作内容',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目日志表';

--
-- 转存表中的数据 `doc_project_log`
--

INSERT INTO `doc_project_log` (`id`, `project_id`, `object_name`, `object_id`, `user_id`, `type`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 'project', 1, 1, 'create', '创建了 项目 <code>官方示例项目</code>', '2019-08-30 23:41:51', '2019-08-30 15:44:20'),
(2, 1, 'env', 1, 1, 'create', '添加了 环境 <code>生产环境(product)</code>', '2019-08-30 23:42:27', '2019-08-30 15:44:02'),
(3, 1, 'env', 2, 1, 'create', '添加了 环境 <code>开发环境(develop)</code>', '2019-08-30 23:42:40', '2019-08-30 15:44:05'),
(4, 1, 'env', 3, 1, 'create', '添加了 环境 <code>测试环境(test)</code>', '2019-08-30 23:42:52', '2019-08-30 15:44:06'),
(5, 1, 'module', 1, 1, 'create', '添加了 模块 <code>会员模块</code>', '2019-08-30 23:54:01', '2019-08-30 15:54:01'),
(6, 1, 'api', 1, 1, 'create', '创建了 接口 <code>用户注册</code>', '2019-08-30 23:57:09', '2019-08-30 15:57:09'),
(7, 1, 'api', 1, 1, 'update', '添加了  <strong>请求字段</strong>,添加了  <strong>响应字段</strong>', '2019-08-31 00:14:56', '2019-08-30 16:14:56'),
(8, 1, 'api', 2, 1, 'create', '创建了 接口 <code>用户登录</code>', '2019-08-31 00:19:21', '2019-08-30 16:19:21'),
(9, 1, 'api', 2, 1, 'update', '添加了  <strong>请求字段</strong>,添加了  <strong>响应字段</strong>', '2019-08-31 00:23:24', '2019-08-30 16:23:24'),
(10, 1, 'api', 3, 1, 'create', '创建了 接口 <code>获取会员信息</code>', '2019-08-31 00:28:33', '2019-08-30 16:28:33'),
(11, 1, 'api', 3, 1, 'update', '添加了  <strong>header字段</strong>,添加了  <strong>响应字段</strong>', '2019-08-31 00:33:40', '2019-08-30 16:33:40'),
(12, 1, 'api', 4, 1, 'create', '创建了 接口 <code>获取会员列表</code>', '2019-08-31 00:42:25', '2019-08-30 16:42:25'),
(13, 1, 'api', 4, 1, 'update', '添加了  <strong>header字段</strong>,添加了  <strong>请求字段</strong>,添加了  <strong>响应字段</strong>', '2019-08-31 00:52:41', '2019-08-30 16:52:41');

-- --------------------------------------------------------

--
-- 表的结构 `doc_template`
--

CREATE TABLE `doc_template` (
  `id` int(10) NOT NULL,
  `encode_id` varchar(10) NOT NULL COMMENT '加密id',
  `project_id` int(10) NOT NULL COMMENT '项目id',
  `post_method` tinyint(3) DEFAULT '0' COMMENT 'post请求方式',
  `header_fields` text COMMENT 'header参数，json格式',
  `request_fields` text COMMENT '请求参数，json格式',
  `response_fields` text NOT NULL COMMENT '响应参数，json格式',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '模板状态',
  `creater_id` int(10) NOT NULL DEFAULT '0' COMMENT '创建者id',
  `updater_id` int(10) NOT NULL DEFAULT '0' COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `doc_template`
--

INSERT INTO `doc_template` (`id`, `encode_id`, `project_id`, `post_method`, `header_fields`, `request_fields`, `response_fields`, `status`, `creater_id`, `updater_id`, `created_at`, `updated_at`) VALUES
(1, '2019064870', 1, 10, '[{\"id\":\"2\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"Content-Type\",\"title\":\"\",\"type\":\"string\",\"required\":\"10\",\"value\":\"application\\/json\",\"remark\":\"\"}]', NULL, '[{\"id\":\"2\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"status\",\"title\":\"请求状态\",\"type\":\"string\",\"example_value\":\"success\",\"remark\":\"success代表请求成功,error代表请求失败\"},{\"id\":\"3\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"code\",\"title\":\"状态码\",\"type\":\"integer\",\"example_value\":\"200\",\"remark\":\"200代表成功\"},{\"id\":\"4\",\"parent_id\":\"0\",\"level\":\"0\",\"name\":\"message\",\"title\":\"返回信息\",\"type\":\"string\",\"example_value\":\"\",\"remark\":\"\"}]', 10, 2, 2, '2019-09-19 23:21:27', '2019-09-20 03:42:01');

-- --------------------------------------------------------

--
-- 表的结构 `doc_user`
--

-- --------------------------------------------------------

--
-- 表的结构 `doc_user`
--

CREATE TABLE `doc_user` (
  `id` int(10) NOT NULL,
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `password_hash` varchar(250) NOT NULL DEFAULT '' COMMENT '密码',
  `auth_key` varchar(250) NOT NULL,
  `type` tinyint(3) NOT NULL DEFAULT '10' COMMENT '用户类型，10:普通用户 20:管理员',
  `status` tinyint(3) NOT NULL COMMENT '会员状态',
  `ip` varchar(250) NOT NULL DEFAULT '' COMMENT '注册ip',
  `location` varchar(255) NOT NULL DEFAULT '' COMMENT 'IP地址',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员表';

--
-- 转存表中的数据 `doc_user`
--

INSERT INTO `doc_user` (`id`, `email`, `name`, `password_hash`, `auth_key`, `type`, `status`, `ip`, `location`, `created_at`, `updated_at`) VALUES
(1, 'admin@phprap.com', 'phprap', '$2y$13$YxEX7alh2DmANipc4lnh4./vxB/JGuzSm2tCshfT0rtSRU1DDOrHW', '8RYphKjzLwE-HAo9Wmp3riEGCLauwOAk', 10, 10, '61.50.125.102', '中国 北京 北京', '2019-08-03 12:12:08', '2019-08-31 09:37:20');

-- --------------------------------------------------------

--
-- 表的结构 `doc_version`
--

CREATE TABLE `doc_version` (
  `id` int(10) NOT NULL,
  `encode_id` varchar(10) NOT NULL COMMENT '加密id',
  `project_id` int(10) NOT NULL DEFAULT '0' COMMENT '项目id',
  `parent_id` int(10) NOT NULL DEFAULT '0' COMMENT '父级版本id',
  `name` varchar(10) NOT NULL COMMENT '版本号',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '备注信息',
  `status` tinyint(3) NOT NULL COMMENT '版本状态',
  `creater_id` int(10) NOT NULL DEFAULT '0' COMMENT '版本创建者id',
  `updater_id` int(10) NOT NULL DEFAULT '0' COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目版本表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doc_api`
--
ALTER TABLE `doc_api`
  ADD PRIMARY KEY (`id`,`encode_id`),
  ADD UNIQUE KEY `encode_id` (`encode_id`),
  ADD KEY `creater_id` (`creater_id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `doc_apply`
--
ALTER TABLE `doc_apply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `doc_config`
--
ALTER TABLE `doc_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`);

--
-- Indexes for table `doc_env`
--
ALTER TABLE `doc_env`
  ADD PRIMARY KEY (`id`,`encode_id`),
  ADD UNIQUE KEY `encode_id` (`encode_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `name` (`name`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `doc_field`
--
ALTER TABLE `doc_field`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_id` (`id`),
  ADD KEY `creater_id` (`id`);

--
-- Indexes for table `doc_login_log`
--
ALTER TABLE `doc_login_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `doc_member`
--
ALTER TABLE `doc_member`
  ADD PRIMARY KEY (`id`,`encode_id`),
  ADD UNIQUE KEY `encode_id` (`encode_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `project_id` (`project_id`) USING BTREE,
  ADD KEY `creater_id` (`updater_id`);

--
-- Indexes for table `doc_module`
--
ALTER TABLE `doc_module`
  ADD PRIMARY KEY (`id`,`encode_id`),
  ADD UNIQUE KEY `encode_id` (`encode_id`),
  ADD KEY `project_id` (`project_id`) USING BTREE,
  ADD KEY `user_id` (`creater_id`) USING BTREE,
  ADD KEY `creater_id` (`creater_id`);

--
-- Indexes for table `doc_project`
--
ALTER TABLE `doc_project`
  ADD PRIMARY KEY (`id`,`encode_id`),
  ADD UNIQUE KEY `encode_id` (`encode_id`),
  ADD KEY `creater_id` (`creater_id`),
  ADD KEY `type` (`type`),
  ADD KEY `status` (`status`) USING BTREE,
  ADD KEY `title` (`title`);

--
-- Indexes for table `doc_project_log`
--
ALTER TABLE `doc_project_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doc_template`
--
ALTER TABLE `doc_template`
  ADD PRIMARY KEY (`id`,`encode_id`),
  ADD UNIQUE KEY `encode_id` (`encode_id`),
  ADD UNIQUE KEY `project_id` (`project_id`) USING BTREE,
  ADD KEY `creater_id` (`creater_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `doc_user`
--
ALTER TABLE `doc_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `status` (`status`),
  ADD KEY `name` (`name`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `doc_version`
--
ALTER TABLE `doc_version`
  ADD PRIMARY KEY (`id`,`encode_id`),
  ADD UNIQUE KEY `encode_id` (`encode_id`),
  ADD KEY `project_id` (`project_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `doc_api`
--
ALTER TABLE `doc_api`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `doc_apply`
--
ALTER TABLE `doc_apply`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `doc_config`
--
ALTER TABLE `doc_config`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `doc_env`
--
ALTER TABLE `doc_env`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `doc_field`
--
ALTER TABLE `doc_field`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `doc_login_log`
--
ALTER TABLE `doc_login_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `doc_member`
--
ALTER TABLE `doc_member`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `doc_module`
--
ALTER TABLE `doc_module`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `doc_project`
--
ALTER TABLE `doc_project`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `doc_project_log`
--
ALTER TABLE `doc_project_log`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用表AUTO_INCREMENT `doc_template`
--
ALTER TABLE `doc_template`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `doc_user`
--
ALTER TABLE `doc_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `doc_version`
--
ALTER TABLE `doc_version`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;
