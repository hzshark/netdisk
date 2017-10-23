<?php
namespace Admin\Service;


class Files {
    
    function currentDate(){
        return date("Y-m-d H:i:s");
    }
    
    function queryFileById($startdate, $enddate) {
        
        return false;
    }
    
    function queryUserCountByDate($startdate, $enddate) {
        $condition['indate'] = array(array('gt',$startdate),array('lt',$enddate)) ;
        $myDao = D("UserMobile");
        return $myDao->where($condition)->count();
    }
    
    function isExistFile($fileHash){
        $model = D('File');
        $data['hash'] = $fileHash;
        return $model->field("_id")->where($data)->count();
    }
    
    function queryFileByHash($fileHash){
        $model = D('File');
        $data['hash'] = $fileHash;
        return $model->where($data)->find();
    }
    
    function setFile($filehash, $fileData){
        $model = D('File');
        $data['hash'] = $filehash;
        $data['body'] = $fileData;
        return $model->add($data);
    }

}