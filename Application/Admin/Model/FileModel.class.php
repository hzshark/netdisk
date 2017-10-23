<?php
namespace Admin\Model;

use Think\Model\MongoModel;

class FileModel extends MongoModel
{

    public function __construct($name, $tablePrefix, $connection)
    {
        parent::__construct($name, $tablePrefix, $connection);
        $this->trueTableName = $name; // 要连接的那个集合（表）控制器里传过来
    }

    protected $dbName = 'name';
 // （要连接的数据库名称）
//     protected $connection = array(
//         'db_type' => 'mongo',
//         'db_user' => 'admin', // 用户名(没有留空)
//         'db_pwd' => 'admin', // 密码（没有留空）
//         'db_host' => '127.0.0.1', // 数据库地址
//         'db_port' => '27017'
//     ) // 数据库端口 默认27017
// ;
    protected $connection = 'MONGODB_CONFIG';

    protected $_idType = self::TYPE_INT;
    Protected $pk = 'id';
 // 参考手册
    protected $_autoinc = true; // 参考手册
    /*
     * public function getall()
     * {
     * return $this->select();
     * }
     */
}