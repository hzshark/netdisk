<?php
namespace Admin\Controller;

use Think\Controller;
use Admin\Service\Users;

class UserController extends Controller
{
    public function index()
    {
        header("Content-Type:text/html; charset=utf-8");
        $cur_date = date("Y-m-d H:i:s");
        $starttime = date("Y-m-d  H:i:s" ,mktime(0,0,0,date("m"),date("d")-7,date("Y")));
        $this->assign("endtime", $cur_date);
        $this->assign("starttime", $starttime);
        $this->display('userlist','utf-8');
    }
    
    public function queryUser(){
        header("Content-Type:text/html; charset=utf-8");
        $starttime = isset($_POST['starttime']) ? $_POST['starttime'] : '';
        $endtime = isset($_POST['endtime']) ? $_POST['endtime'] : date("Y-m-d H:i:s");
        $user = new Users();
        $user_count = $user->queryUserCountByDate($starttime, $endtime);
        $user_list = $user->queryUserByDate($starttime, $endtime);
//         var_dump($user_list);
        $this->assign("endtime", $endtime);
        $this->assign("starttime", $starttime);
        $this->assign("user_count", $user_count);
        $this->assign("user_list", $user_list);
        $this->display('userlist','utf-8');
    }
}