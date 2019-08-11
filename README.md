[PHPRAP，是一个PHP轻量级开源API接口文档管理系统，致力于减少前后端沟通成本，提高团队协作开发效率，打造PHP版的RAP。](http://www.phprap.com)

 >版本说明
 - master：稳定版本，建议下载安装，下载[源码](https://gitee.com/gouguoyin/phprap/repository/archive/master.zip)
 - develop：开发版本，功能最新，但不稳定，不建议下载安装 
 
## 相关
 - 官方网站：[www.phprap.com](http://www.phprap.com)
 - 演示网站：[demo.phprap.com](http://demo.phprap.com)
 - 使用文档：[www.phprap.com/doc](http://www.phprap.com/doc/index.html)
 
## 特性

 - 部署简单，提供在线安装程序，只需填写少量信息即可完成安装部署，开箱即用；
 - 操作简单，和阿里RAP高度一致的操作流程，给力的用户体验，让您一分钟上手；
 - 基于bootstrap搭建，完美适配PC、平板和移动端；
 - 项目申请时时推送，方便项目创建者及时处理申请，申请加入者及时获取审核结果；
 - 完整的项目操作日志，整个项目的操作流程一目了然；
 - 完善的权限控制系统，可以分别控制项目、模块、接口和成员的操作权限；
 - 支持在线对接口进行调试，默认填充已定义好的header和请求参数，再也不用在postman中手动添加参数来调试接口;
 - 提供MOCK服务，根据接口文档自动生成模拟数据，支持复杂的生成逻辑，支持请求协议、请求方式和请求参数格式校验;
 - MOCK数据类型丰富，支持生成随机的文本、数字、布尔值、日期、邮箱、链接、图片、颜色、中文名、手机号、价格、邮箱、网址等;
 - 支持项目接口一键导出，方便离线查看；
 - 产品开源免费，并将持续提供免费的社区技术支持；

## 依赖

 - PHP >= 5.4.0
 - MySQL >= 5.1.0
 - PDO 拓展
 - GD 拓展
 - CURL 拓展
 - OPENSSL 拓展
 
## 安装

- 下载程序

  [**GITHUB**]
    ```php
    git clone https://github.com/gouguoyin/phprap.git
    ```
    
  [**GITEE**]
    ```php
    git clone https://gitee.com/gouguoyin/phprap.git
    ```
    
  [**源码**]
  
  下载[源码](https://github.com/gouguoyin/phprap/archive/stable.zip)，上传到服务器上后解压
    

- 设置目录权限

    `runtime`目录及子目录给予可读可写权限
    `configs/db.php`文件给予可读可写权限
    
    
- 隐藏入口文件index.php

  [**IIS**]
  
    如果你的服务器环境支持ISAPI_Rewrite的话，可以配置httpd.ini文件，添加下面的内容：
    
    
    ```php
    RewriteRule (.*)$ /index\.php\?r=$1 [I]
    ```
   
    在IIS的高版本下面可以配置web.Config，在中间添加rewrite节点：
    
    
    ```php
    <rewrite>
    <rules>
    <rule name="OrgPage" stopProcessing="true">
    <match url="^(.*)$" />
    <conditions logicalGrouping="MatchAll">
    <add input="{HTTP_HOST}" pattern="^(.*)$" />
    <add input="{REQUEST_FILENAME}" matchType="IsFile" negate="true" />
    <add input="{REQUEST_FILENAME}" matchType="IsDirectory" negate="true" />
    </conditions>
    <action type="Rewrite" url="index.php?r=/{R:1}" />
    </rule>
    </rules>
    </rewrite>
    ```
   
  [**Apache**]
  
    `httpd.conf`配置文件中加载`mod_rewrite.so`模块
    
    将`AllowOverride None` 改为 `AllowOverride All`
    
    把下面的内容保存为`.htaccess`文件放到应用入口文件的同级目录下，默认放在`public`目录下
    
    ```php
    <IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php?r=/$1 [QSA,PT,L]
    </IfModule>
    ```

  [**Nginx**]
  
    如果是部署在根目录下，在`Nginx.conf`中配置转发规则  
  
    ```php
    location / { 
       try_files $uri $uri/ /index.php?r=$uri&$args;
    }
    ```
    
- 打开浏览器，访问域名，会自动跳转到安装界面运行安装程序

    - 安装步骤一：环境检测
    ![](http://www.phprap.com/static/images/wiki/step1.png?v=1.1)
    
    - 安装步骤二：数据库配置
    ![](http://www.phprap.com/static/images/wiki/step2.png?v=1.1)

    - 安装步骤三：管理员配置
    ![](http://www.phprap.com/static/images/wiki/step3.png?v=1.1)

    - 安装步骤四：安装完成
    ![](http://www.phprap.com/static/images/wiki/step4.png?v=1.1)

    
## 使用

- 注册
![](http://www.phprap.com/static/images/wiki/register.png)

- 登录
![](http://www.phprap.com/static/images/wiki/login.png)

- 修改资料
![](http://gouguoyin.qiniudn.com/profile_edit.png)

- 消息通知
![](http://gouguoyin.qiniudn.com/notify.png)

- 登录历史
![](http://gouguoyin.qiniudn.com/login_history.png)

- 项目

    - 新建项目
    ![](http://gouguoyin.qiniudn.com/project_creat.png)
    
    - 编辑项目
    ![](http://gouguoyin.qiniudn.com/project_edit.png)
    
    - 转让项目
    ![](http://gouguoyin.qiniudn.com/project_transfer.png)
    
    - 搜索项目
    ![](http://gouguoyin.qiniudn.com/project_search.png)
    
    - 切换项目
    ![](http://gouguoyin.qiniudn.com/project_select.png)
    
    - 项目主页
    ![](http://gouguoyin.qiniudn.com/project_home.png)
    
    - 项目成员
    ![](http://gouguoyin.qiniudn.com/project_member.png)
    
    - 成员权限
    ![](http://gouguoyin.qiniudn.com/member_rule.png)
    
    - 项目动态
    ![](http://gouguoyin.qiniudn.com/project_history.png)
    
    - 删除项目
    ![](http://gouguoyin.qiniudn.com/project_delete.png)
    
- 模块
    - 新建模块
    ![](http://gouguoyin.qiniudn.com/module_creat.png)
    
    - 编辑模块
    ![](http://gouguoyin.qiniudn.com/module_edit.png)
    
    - 删除模块
    ![](http://gouguoyin.qiniudn.com/module_delete.png)
    
- 接口

    - 添加接口
    ![](http://gouguoyin.qiniudn.com/api_creat.png)
    
    - 编辑接口
    ![](http://gouguoyin.qiniudn.com/api_edit.png)
    
    - 接口主页
    ![](http://gouguoyin.qiniudn.com/api_home.png)
    
    - 删除接口
    ![](http://gouguoyin.qiniudn.com/api_delete.png)
    
    - 添加字段
    ![](http://gouguoyin.qiniudn.com/field_creat.png)
    
    - 编辑字段
    ![](http://gouguoyin.qiniudn.com/field_edit.png)
    
    - 删除字段
    ![](http://gouguoyin.qiniudn.com/field_delete.png)
    
- 后台

    - 管理主页
    ![](http://gouguoyin.qiniudn.com/admin_home.png)

    - 项目管理
    ![](http://gouguoyin.qiniudn.com/admin_project.png)
    
    - 用户管理
    ![](http://gouguoyin.qiniudn.com/admin_user.png)
    ![](http://gouguoyin.qiniudn.com/user_disable.png)
    ![](http://gouguoyin.qiniudn.com/reset_password.png)
    
    - 登录历史
    ![](http://gouguoyin.qiniudn.com/admin_login_history.png)
    
    - 系统设置
    ![](http://gouguoyin.qiniudn.com/admin_setting.png)
    
## 联系

- 如果您在使用过程中有任何疑问，或有好的意见和想法，请通过以下途径联系我或者新建 [Issue](https://github.com/gouguoyin/phprap/issues)  讨论新特性或者变更。
- 官方网站：[www.phprap.com](http://www.phprap.com)
- 演示网站：[demo.phprap.com](http://demo.phprap.com)
- 官方QQ群：421537504 <a style="margin-left:10px" target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=d49826b55d1759513ce5d68253b3f0589b227587edf87059aa08125e620b73c0"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="GoPHP官方交流群" title="GoPHP官方交流群"></a>

## 捐献
- 如果觉得还不错，请作者喝杯咖啡吧，开源不易，您的支持是我前进的动力！

![微信](http://www.phprap.com/static/images/site/wxpay.jpg)
![支付宝](http://www.phprap.com/static/images/site/alipay.jpg)
