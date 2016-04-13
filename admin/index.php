<?php


// 定义ThinkPHP框架路径
define('THINK_PATH', '../ThinkPHP');
//生成静态页面的文件位置
//define('HTML_PATH', './htm');
//定义项目名称和路径
define('APP_NAME', 'admin');
define('APP_PATH', '.');
// 加载框架入口文件
require(THINK_PATH."/ThinkPHP.php");
//实例化一个网站应用实例
App::run();
?>