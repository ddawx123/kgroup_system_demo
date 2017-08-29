# 全民K歌家族线上系统(Demo)
## 系统功能
1. 支持发布线上宣传页
2. 线上成员注册以及引导用户自动加入审核专用QQ群
3. 成员审核
4. MV视频发布
5. 热门作品显示

## 关于后台
1. 后台使用bootstrap3.0架构，管理登录使用SSO机制单点链接登录请求至自主开发的passport系统。
2. 后台暂未使用全局ajax，但线上成员注册页面已经全面应用ajax表单提交技术提升用户体验。

## 配置文件详解（config.php）
1. mysql_host：MySQL数据库服务器地址；
2. mysql_user：MySQL数据库登录用户名；
3. mysql_pwd：MySQL数据库登录密码；
4. mysql_db：MySQL数据库库名；
5. trust_uri：信任的AJAX发起源（用于防范CSRF跨站攻击，不过该功能暂未开发完成）
6. passport_srv：后台登录时所使用的passport统一认证服务器域名；
7. passport_ssl：统一认证服务器是否使用SSL全站加密重定向。

## 注意事项
本系统如运行在类似阿里云虚拟主机等环境时，请编辑config.php去除数据库连接地址中的默认3306端口。（具体原因我也不清楚）如果你的数据库不是3306那么此注意事项与你无关~
自建的服务器环境如LAMP、LNMP、WAMP、WIMP等无需关注。
