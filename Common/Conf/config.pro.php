<?php
return array(
	//'配置项'=>'配置值'
    'DB_TYPE'           =>  'mysql',     	// 数据库类型
    'DB_HOST'           =>  '192.168.150.22', 	// 服务器地址
    'DB_NAME'           =>  'netdisk',        // 数据库名
    'DB_USER'           =>  'netdisk',     	// 用户名
    'DB_PWD'            =>  'aerohive',     	// 密码
    'DB_PORT'           =>  '3306',     	// 端口
    'DB_PREFIX'         =>  '',      	// 数据库表前缀
    'DB_DEBUG'  		=>  true, 			// 数据库调试模式 开启后可以记录SQL日志
    'DB_CHARSET'        => 'utf8',
    'MONGODB_CONFIG'    =>array(
        'database' =>'netdisk',
        'db_type' => 'mongo',
        'db_user' => 'netdisk',//用户名(没有留空)
        'db_pwd' => 'netdisk_123',//密码（没有留空）
        'db_host' => '192.168.150.21',//数据库地址
        'db_port' => '27017',//数据库端口 默认27017
        'db_charset'=>    'utf8',
    ),
    'MONGODB_NAME' => 'netdisk',

    'SHOW_PAGE_TRACE'   =>	false,   		// 显示页面Trace信息
    'DEFAULT_MODULE'     => 'Index', //默认模块
    'MODULE_ALLOW_LIST'    =>    array('Admin'),
//     'DEFAULT_MODULE'       =>    'Admin',
    // 设置禁止访问的模块列表
    'MODULE_DENY_LIST'      =>  array('Common','Runtime','Api'),
    'SESSION_AUTO_START' => true, //是否开启session
    'APP_DEBUG' => true, //调试模式开关
    'TOKEN_ON' => true, //是否开启令牌验证
    'URL_MODEL' => 2, //URL模式：0 普通模式 1 PATHINFO 2 REWRITE 3 兼容模式
    'URL_ROUTER_ON' => true,
    'URL_PATHINFO_DEPR' => '/', //PATHINFO URL 模式下，各参数之间的分割符号
    'URL_CASE_INSENSITIVE'  =>  true, //设置为true的时候表示URL地址不区分大小写
    'DEFAULT_THEME' => '', //默认模板主题
    'URL_HTML_SUFFIX' => '.html|.mp4', //URL伪静态后缀设置
    'DEFAULT_CHARSET' => 'utf-8', // 默认输出编码
    'DEFAULT_TIMEZONE' => 'PRC', // 默认时区
    'DEFAULT_AJAX_RETURN' => 'JSON', // 默认AJAX 数据返回格式,可选JSON XML ...
    //'APP_GROUP_LIST' => 'Index,Home,Admin', //项目分组
    //'DEFAULT_GROUP' => 'Home', //默认分组
    'DEFAULT_PageSize' => 15,
    /* Cookie设置 */
    'COOKIE_EXPIRE' => 3600, // Coodie有效期
    'COOKIE_DOMAIN' => '', // Cookie有效域名
    'COOKIE_PATH' => '/', // Cookie路径
    'COOKIE_PREFIX' => '', // Cookie前缀 避免冲突

    /* 静态缓存设置 */
    'HTML_CACHE_ON' => false, //默认关闭静态缓存
    'HTML_CACHE_TIME' => 60, //静态缓存有效期
    'HTML_READ_TYPE' => 0, //静态缓存读取方式 0 readfile 1 redirect
    'HTML_FILE_SUFFIX' => '.shtml', //默认静态文件后缀

    /* 错误设置 */
    'ERROR_MESSAGE' => '您浏览的页面暂时发生了错误！请稍后再试～', //错误显示信息,非调试模式有效
    'ERROR_PAGE' => 'Tpl/Public/error.html', // 错误定向页面
    //    'TMPL_EXCEPTION_FILE'=>'./App/Tpl/Public/error.html', // 定义公共错误模板

    /* 网站设置 */
    'SITE_TITLE' => 'NetDisk', //网站title

    'IOS_DOWNLOAD_URL' => '#',
    'ANDROID_DOWNLOAD_URL' =>'http://t.cn/Rq8E6QI',
    
    'UPLOAD_PATH' => '/Uploads/',
    'UPLOAD_MAX_SIZE' => '52428800',
    'IOS_DOWNLOAD_URL' => '#',

    /* 网站日志设置 */
    'WEB_LOG_RECORD' => false, // 默认不记录日志
    'LOG_FILE_SIZE' => 2097152, // 日志文件大小限制
    'LOG_RECORD_LEVEL' => array('EMERG', 'ALERT', 'CRIT', 'ERR', 'WARN', 'NOTIC', 'INFO', 'DEBUG', 'SQL'), // 允许记录的日志级别

);
