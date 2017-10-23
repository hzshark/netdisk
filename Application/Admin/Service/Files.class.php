<?php
namespace Admin\Service;
use Admin\Model\FileModel;

class Files {

    function currentDate(){
        return date("Y-m-d H:i:s");
    }

    function queryFileById($tableName) {
        $model = new FileModel($tableName);
        return false;
    }

    function queryUserCountByDate($startdate, $enddate) {
        $condition['indate'] = array(array('gt',$startdate),array('lt',$enddate)) ;
        $myDao = D("UserMobile");
        return $myDao->where($condition)->count();
    }

    function isExistFile($tableName, $fileHash){
        $model = new FileModel($tableName);
        $data['hash'] = $fileHash;
        return $model->field("_id")->where($data)->count();
    }

    function queryFileByHash($tableName, $fileHash){
        $model = new FileModel($tableName);
        $data['hash'] = $fileHash;
        return $model->where($data)->find();
    }

    function setFile($tableName, $filehash, $fileData){
        $model = new FileModel($tableName);
        $data['hash'] = $filehash;
        $data['body'] = mb_convert_encoding($fileData,'utf-8','gbk');

//         $data['body'] = mb_strtolower("aaaaaaaa",'UTF-8');
        var_dump($data);
        return $model->add($data);
    }

}