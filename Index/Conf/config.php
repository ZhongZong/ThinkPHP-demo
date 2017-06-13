<?php
return array(
	//'配置项'=>'配置值'

	//开启应用分组
    'APP_GROUP_LIST' =>'Index,Admin',
    'DEFAULT_GROUP'=> 'Index',   //默认分组
    'DEFAULT_FILTER' =>'htmlspecialchars,trim',  //过滤函数
    //指定错误页面模版路径
    'TMPL_EXCEPTION_FILE' => './Public/Tpl/error.html',

    //数据库配置
	'DB_TYPE'               => 'mysql',     // 数据库类型
    'DB_HOST'               => '127.0.0.1', // 服务器地址
    'DB_NAME'               => 'cafuc',          // 数据库名
    'DB_USER'               => 'root',      // 用户名
    'DB_PWD'                => '',          // 密码
    'DB_PORT'               => '3306',        // 端口
    'DB_PREFIX'             => 'web_',    // 数据库表前缀
    'DB_FIELDTYPE_CHECK'    => false,       // 是否进行字段类型检查
    'DB_FIELDS_CACHE'       => true,        // 启用字段缓存
    'DB_CHARSET'            => 'utf8',      // 数据库编码默认采用utf8

    'upload_max_size'      =>999999999999,   //允许服务器上传文件的最大值

    //点语法默认解析
    'TMPL_VAR_IDENTIFY'  =>'array',
    //模版路径
    'TMPL_FILE_DEPR'     =>'_',
);
?>