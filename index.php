<?php
/**
 * Created by PhpStorm.
 * User: ydz
 * Date: 17/3/9
 * Time: 下午4:56
 */
//if (version_compare(PHP_VERSION,'5.3.0','<')) die('require PHP >5.3.0 !');
//header("content_type:text/html;charset=utf-8");
//define('BUILD_DIR_SECURE', false);
define('APP_DEBUG',true);

define('BASE_URL','http://localhost/');
//定义css等常量
define('BASE_CSS',BASE_URL.'/project/FirstDemo/Public/css/');
define('BASE_JS',BASE_URL.'/project/FirstDemo/Public/js/');
define('BASE_IMG',BASE_URL.'/project/FirstDemo/Public/img/');
include "./ThinkPHP/ThinkPHP.php";