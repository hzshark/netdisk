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
    
    public function Webuploader()
    {
        $uploadconfig = array(
            'maxSize' => C('UPLOAD_MAX_SIZE'), // 设置附件上传大小
            'rootPath' => C('UPLOAD_PATH'), // 设置附件上传根目录
            'savePath' => '', // 设置附件上传（子）目录
            'saveName' => array(
                'uniqid',
                ''
            ),
            'exts' => array(
                'xlsx',
                'xls',
                'csv',
                'xlsm'
            ), // 设置附件上传类型,
            'autoSub' => true,
            'subName' => array(
                'date',
                'Ymd'
            )
        );
        $upload = new \Think\Upload($uploadconfig); // 实例化上传类
        // 上传文件
        $info = $upload->upload();
        if (! $info) { // 上传错误提示错误信息
            return array(
                "status" => 1,
                "msg" => $upload->getError()
            );
        } else { // 上传成功 获取上传文件信息
            $pathArr = array();
            foreach ($info as $file) {
                array_push($pathArr, C('UPLOAD_PATH') . $file['savepath'] . $file['savename']);
            }
            return array(
                "status" => 0,
                "msg" => $pathArr
            );
        }
    }

}