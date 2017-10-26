<?php
namespace Admin\Controller;

use Think\Controller;
use Admin\Service\Files;
use PHPExcel_IOFactory;

class FilesController extends Controller
{
    //http://www.cnblogs.com/CHEUNGKAMING/p/5619493.html
    public function index()
    {
    header("Content-Type:text/html; charset=utf-8");
    $data_list = [];
    if (IS_POST){



    }


    
//     $md5file = md5_file($file_name);

//     $tableName = 'excl_file';

//     $flag = $files->isExistFile($tableName,$md5file);
//     var_dump($flag);
//     if ($flag == 0){
//         $ret = $files->setFile($tableName, $md5file, file_get_contents($file_name));
//         var_dump($ret);
//     }

//     $filedata = $files->queryFileByHash($tableName, $md5file);
//     $fileBody ='';
    $this->show("aaaa");


    }
    
    public function createUser(){
        header("Content-Type:text/html; charset=utf-8");
        $data_list = [];
        if (IS_POST){
        
        
        
        }
        $this->display('uploadFile', 'UTF-8');
    }
    
    function paseExcelFile($file_name){
//         $file_name = __DIR__.'/test.xlsx';
        
        $extension = strtolower( pathinfo($file_name, PATHINFO_EXTENSION) );
        
        ini_set('max_execution_time', '0');
        Vendor('PHPExcel.PHPExcel');
        /**
         * $inputFileType = 'Excel5';
         $inputFileType = 'Excel2007';
         $inputFileType = 'Excel2003XML';
         $inputFileType = 'OOCalc';
         $inputFileType = 'SYLK';
         $inputFileType = 'Gnumeric';
         $inputFileType = 'CSV';
        */
        if ($extension =='xlsx') {
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        } else if ($extension =='xls') {
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
        } else if ($extension=='csv') {
            $PHPReader = PHPExcel_IOFactory::createReader('CSV');
            //默认输入字符集
            $PHPReader->setInputEncoding('GBK');
            //默认的分隔符
            $PHPReader->setDelimiter(',');
        }
        
        // 判断使用哪种格式
        $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
        $sheet = $objPHPExcel->getSheet(0);
        // 取得总行数
        $highestRow = $sheet->getHighestRow();
        // 取得总列数
        $highestColumn = $sheet->getHighestColumn();
//         var_dump($highestRow);
//         var_dump($highestColumn);
        //循环读取excel文件,读取一条,插入一条
        $data=array();
        //从第2行开始读取数据
        for($j=2;$j<=$highestRow;$j++){
            //从A列读取数据
            for($k='A';$k<=$highestColumn;$k++){
                // 读取单元格
                $data[$j][]=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
            }
        }
        
        return $data;
    }
    
    public function uploadFile()
    {
        header("Content-Type:text/html; charset=utf-8");
        $uploader = new Files();
        $info = $uploader->Webuploader();
        $excel_data = array();
        if (0 == $info["status"]) {
            $files = $info['msg'];
            foreach ($files as $filename){
                echo $filename;
                echo '<br />';
                $file_data = $this->paseExcelFile($filename);
                $excel_data = array_merge($file_data, $excel_data);
            }
            $capacity = 8 * 1024 * 1024 * 1024;
            $reg_ret = $user->RegistUser($umobile, $password, $capacity);
            echo "====================";
            $this->show($excel_data);
        }else{
            $this->error("文件上传失败，请重新上传",'Files/index');
        }
    }
    
}