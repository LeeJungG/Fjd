<?php
return array(
	//'配置项'=>'配置值'
	'SHOW_PAGE_TRACE' => 'true',

	   /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'jd',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'jd_',    // 数据库表前缀

    //上传文件设置
    
    'maxSize'       =>  '3M', //上传的文件大小限制 (0-不做限制)
    'exts'          =>  array('jpg','pjpeg','bmp', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
    'rootPath'      =>     './Uploads/', //保存根路径
    'rootPath2'      =>     '/Uploads/',

    //I()函数配置
    
    'DEFAULT_FILTER'        =>  'trim,removeXSS', // 默认参数过滤方法 用于I函数...

    /*******md5加密时的复杂化*********/

    'MD5_KEY' => 'fdsa#@90#_jsjk123455!dsfsf',
    /*************** 发邮箱的配置 ******************/
    'MAIL_ADDRESS' => '779491301@qq.com', // 发货人的email
    'MAIL_FROM' => 'jd_fjd',        //发货人姓名
    'MAIL_SMTP' => 'smtp.qq.com',   //邮箱服务器的地址
    'MAIL_LOGINNAME' =>'种花家的兔子',
    'MAIL_PASSWORD' => 'LeeJung77949130.',
);