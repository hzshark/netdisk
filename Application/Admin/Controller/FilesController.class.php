<?php
namespace Admin\Controller;

use Think\Controller;
use Admin\Service\Files;


class FilesController extends Controller
{
    //http://www.cnblogs.com/CHEUNGKAMING/p/5619493.html
    public function index()
    {
    header("Content-Type:text/html; charset=utf-8");
    $data_list = [];
    if (IS_POST){
    
        
        
    }
    
    
    $files = new Files();
    
    $filePath = __DIR__.'/s.php';
    

    $md5file = md5_file($filePath);
    
    $flag = $files->isExistFile($md5file);
    var_dump($flag);
    if ($flag == 0){
        $ret = $files->setFile($md5file, file_get_contents($filePath));
        var_dump($ret);
    }
    
    $filedata = $files->queryFileByHash($md5file);
    var_dump($filedata);
    $this->display();
    
    
    }
}