
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `doc_api` (
  `id` int(10) NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目接口表';

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


CREATE TABLE `doc_config` (
  `id` int(10) NOT NULL,
  `type` varchar(10) NOT NULL COMMENT '配置类型',
  `content` text NOT NULL COMMENT '配置内容',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配置表';

INSERT INTO `doc_config` (`id`, `type`, `content`, `created_at`, `updated_at`) VALUES
(1, 'app', '{\"name\":\"PHPRAP接口文档管理系统\",\"keywords\":\"phprap,apidoc,api文档管理\",\"description\":\"PHPRAP，是一个PHP轻量级开源API接口文档管理系统，致力于减少前后端沟通成本，提高团队协作开发效率，打造PHP版的RAP。\",\"copyright\":\"Copyright ©2019-2029 PHPRAP版权所有\",\"email\":\"245629560@qq.com\",\"is_push\":\"0\",\"push_time\":\"10\"}', '2018-05-15 14:08:31', '2019-07-20 08:49:53'),
(3, 'email', '', '2018-05-15 14:08:35', '2018-05-15 06:08:38'),
(4, 'safe', '{\"ip_white_list\":\"\",\"ip_black_list\":\"\",\"email_white_list\":\"\",\"email_black_list\":\"\",\"register_token\":\"68823095\",\"register_captcha\":\"1\",\"login_captcha\":\"1\",\"login_keep_time\":\"24\"}', '2018-05-15 14:08:39', '2019-07-23 08:24:20');

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
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `doc_member` (
  `id` int(10) NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目成员表';

CREATE TABLE `doc_module` (
  `id` int(10) NOT NULL,
  `encode_id` varchar(50) NOT NULL COMMENT '加密id',
  `project_id` int(10) NOT NULL COMMENT '项目id',
  `title` varchar(50) NOT NULL COMMENT '模块名称',
  `remark` varchar(250) NOT NULL DEFAULT '' COMMENT '项目描述',
  `status` tinyint(3) NOT NULL COMMENT '模块状态 ',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '模块排序',
  `creater_id` int(10) NOT NULL COMMENT '创建者id',
  `updater_id` int(10) NOT NULL COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目模块表';

--
-- 转存表中的数据 `doc_module`
--

INSERT INTO `doc_module` (`id`, `encode_id`, `project_id`, `title`, `remark`, `status`, `sort`, `creater_id`, `updater_id`, `created_at`, `updated_at`) VALUES
(1, '2518025742', 1, '商品模块', '', 10, 20, 1, 0, '2018-06-25 02:57:42', '2018-06-24 19:07:54'),
(3, '0941447730464324', 4, '88', '22222', 30, 99, 2, 2, '2019-07-06 09:41:44', '2019-07-21 22:45:04'),
(4, '0948107769018976', 4, '55', '55', 30, 0, 2, 2, '2019-07-06 09:48:10', '2019-07-21 15:11:34'),
(5, '0949517779182526', 4, '77', '77', 20, 0, 2, 0, '2019-07-06 09:49:51', '2019-07-07 05:47:38'),
(6, '0951477790794206', 1, '99', '99', 10, 0, 2, 0, '2019-07-06 09:51:47', '2019-07-06 01:51:47'),
(7, '1021367969625742', 8, '测试模块1', '测试模块1', 10, 14, 3, 3, '2019-07-06 10:21:36', '2019-07-07 09:56:08'),
(8, '1024357987569975', 8, '测试模块2', '测试模块2', 10, 13, 3, 3, '2019-07-06 10:24:35', '2019-07-09 13:21:53'),
(9, '0514519089129081', 8, '统计模块', '人信担保数据统计', 10, 14, 3, 3, '2019-07-07 17:14:51', '2019-07-24 12:46:06'),
(12, '20196909885131', 11, '测试模块', '8888', 10, 0, 2, 2, '2019-07-22 12:18:18', '2019-07-22 13:19:05'),
(13, '20198032524205', 12, '1111', '1111', 20, 0, 2, 2, '2019-07-22 15:25:25', '2019-07-22 07:29:55'),
(14, '20198098862720', 4, '测试模块1', '测试项目11', 10, 0, 2, 2, '2019-07-22 15:36:28', '2019-07-27 09:29:10'),
(15, '20190268107630', 6, '测试模块7', '999', 10, 0, 2, 2, '2019-07-22 21:38:01', '2019-07-23 13:35:24'),
(16, '20196048270713', 8, '测试模块3', '', 10, 0, 3, 3, '2019-07-23 13:41:22', '2019-07-23 05:50:49'),
(17, '20198891248531', 6, '测试模块8', '', 10, 0, 2, 0, '2019-07-23 21:35:12', '2019-07-23 13:35:12'),
(18, '20191976215122', 4, '测试模块2', '', 10, 0, 2, 2, '2019-07-27 17:29:22', '2019-07-31 02:34:53');

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
  `creater_id` int(10) NOT NULL COMMENT '创建者id',
  `updater_id` int(10) NOT NULL COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目表';

--
-- 转存表中的数据 `doc_project`
--

INSERT INTO `doc_project` (`id`, `encode_id`, `title`, `remark`, `sort`, `status`, `type`, `creater_id`, `updater_id`, `created_at`, `updated_at`) VALUES
(4, '4548173321', '测试项目', '测试项目', 40, 10, 10, 2, 2, '2019-07-03 17:33:21', '2019-07-31 02:25:30'),
(5, '0712625016', '测试项目222演示项目', '22222', 0, 20, 10, 2, 2, '2019-07-03 18:13:00', '2019-07-05 16:54:03'),
(6, '1235084450835265', '测试项目1', '测试项目', 100, 10, 10, 2, 2, '2019-07-06 00:35:08', '2019-07-31 02:23:29'),
(7, '0736396979952489', '测试项目44', '11111', 0, 20, 30, 2, 2, '2019-07-06 07:36:39', '2019-07-20 07:12:04'),
(8, '0956377819705529', '测试项目', '测试项目', 0, 10, 30, 3, 2, '2019-07-06 09:56:37', '2019-07-30 14:18:23'),
(9, '20190214294383', '测试2', '测试2', 0, 30, 10, 3, 2, '2019-07-20 13:55:42', '2019-07-30 14:03:55'),
(10, '20190226953715', '555', '7777', 0, 20, 30, 3, 3, '2019-07-20 13:57:49', '2019-07-21 09:37:19'),
(11, '20194935881469', '测试删除项目', '测试项目2', 0, 10, 10, 2, 2, '2019-07-22 06:49:18', '2019-07-30 14:18:37'),
(12, '20197796544965', '测试项目3', '测试项目3', 0, 30, 30, 2, 2, '2019-07-22 14:46:05', '2019-07-30 13:57:07'),
(13, '20197797770934', '测试项目4', '测试项目3', 101, 30, 30, 2, 2, '2019-07-22 14:46:17', '2019-07-22 07:07:30'),
(14, '20199005797200', '11111', '111111', 0, 30, 30, 2, 2, '2019-07-23 21:54:17', '2019-07-23 13:55:00'),
(15, '20199011150856', '9999', '9999', 0, 30, 30, 2, 2, '2019-07-23 21:55:11', '2019-07-23 14:01:37');

-- --------------------------------------------------------

--
-- 表的结构 `doc_project_log`
--

CREATE TABLE `doc_project_log` (
  `id` int(1) NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='项目日志表';

-- --------------------------------------------------------

--
-- 表的结构 `doc_template`
--

CREATE TABLE `doc_template` (
  `id` int(10) NOT NULL,
  `encode_id` varchar(10) NOT NULL COMMENT '加密id',
  `project_id` int(10) NOT NULL COMMENT '项目id',
  `header_field` text NOT NULL COMMENT 'header参数，json格式',
  `request_field` text NOT NULL COMMENT '请求参数，json格式',
  `response_field` text NOT NULL COMMENT '响应参数，json格式',
  `status` tinyint(3) NOT NULL COMMENT '模板状态',
  `creater_id` int(10) NOT NULL COMMENT '创建者id',
  `updater_id` int(10) NOT NULL COMMENT '更新者id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员表';

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
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间'
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `object_id` (`object_id`),
  ADD KEY `project_id` (`project_id`) USING BTREE,
  ADD KEY `version_id` (`version_id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `api_id` (`api_id`);

--
-- Indexes for table `doc_template`
--
ALTER TABLE `doc_template`
  ADD PRIMARY KEY (`id`,`encode_id`),
  ADD UNIQUE KEY `project_id` (`project_id`),
  ADD UNIQUE KEY `encode_id` (`encode_id`),
  ADD KEY `creater_id` (`creater_id`);

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- 使用表AUTO_INCREMENT `doc_apply`
--
ALTER TABLE `doc_apply`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- 使用表AUTO_INCREMENT `doc_config`
--
ALTER TABLE `doc_config`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `doc_env`
--
ALTER TABLE `doc_env`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- 使用表AUTO_INCREMENT `doc_login_log`
--
ALTER TABLE `doc_login_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- 使用表AUTO_INCREMENT `doc_member`
--
ALTER TABLE `doc_member`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- 使用表AUTO_INCREMENT `doc_module`
--
ALTER TABLE `doc_module`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用表AUTO_INCREMENT `doc_project`
--
ALTER TABLE `doc_project`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用表AUTO_INCREMENT `doc_project_log`
--
ALTER TABLE `doc_project_log`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=298;

--
-- 使用表AUTO_INCREMENT `doc_template`
--
ALTER TABLE `doc_template`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `doc_user`
--
ALTER TABLE `doc_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `doc_version`
--
ALTER TABLE `doc_version`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;
