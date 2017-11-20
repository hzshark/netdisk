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
    $this->display('uploadFile', 'UTF-8');


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


    }


    function paseExcelFile($file_name){
//         $file_name = __DIR__.'/test.xlsx';

        $extension = strtolower( pathinfo($file_name, PATHINFO_EXTENSION) );

        ini_set('max_execution_time', '0');
//         Vendor('PHPExcel.PHPExcel');
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
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        } else if ($extension =='xls') {
            $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        } else if ($extension=='csv') {
            $PHPReader = \PHPExcel_IOFactory::createReader('CSV');
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

        $body=array();
        //从第1行开始读取数据
        $header= $objPHPExcel->getActiveSheet()->getCell("A1")->getValue();
        //从第2行开始读取数据
        for($j=2;$j<=$highestRow;$j++){
            //从A列读取数据
            // 读取单元格
            $body[$j]['id']=$j-1;
            $body[$j]['mobile']=$objPHPExcel->getActiveSheet()->getCell("A$j")->getValue();
        }
        $data = array('header'=>$header, 'body'=>$body);

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
            $filename = $files[0];
            $data = $this->paseExcelFile($filename);

            if ('mobile' != strtolower($data['header']) && '手机号' != strtolower($data['header']) ){
                exit(1);
                $this->error("文件內容格式错误，请重新上传",'/Files/index');
            }
            session("add_users", $data['body']);
            session("user_count", count($data['body']));
            $this->assign("user_list", $data['body']);
            $this->assign("user_count", count($data['body']));
            $this->display('userlist','utf-8');
        }else{
            $this->error("文件上传失败，请重新上传",'/Files/index');
        }
    }

    public function createUser(){
        header("Content-Type:text/html; charset=utf-8");
        $users = session('add_users');
        //用户鉴权operationType = 1;
        $operationType = 1;
        $f = new Files();
        $result = array();
        foreach ($users as $user){
            $mobile = $user['mobile'];
            $ret = $f->createUserByVac($mobile, $operationType);
            $user['status'] = $ret['status'];
            $user['msg'] = $ret['msg'];
            $result [] = $user;
        }
        $this->assign("user_list", $result);
        $this->assign("user_count", count($result));
        $this->display('createlist','utf-8');
    }

}