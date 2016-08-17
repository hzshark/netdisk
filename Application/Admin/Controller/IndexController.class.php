<?php
namespace Admin\Controller;

use Think\Controller;
use Admin\Service\Authenticator;
use Admin\Service\Apps;

class IndexController extends Controller
{
    public function index()
    {
        header("Content-Type:text/html; charset=utf-8");
        $this->display();
    }
    public function login()
    {
        header("Content-Type:text/html; charset=utf-8");
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $sqlAuth = new Authenticator();
        if ($SQLRet = $sqlAuth->authenticate($username, $password)) {
            $this->success('登入成功', '/User/index', 1);
//             $apps = new Apps();
//             $applist = $apps->showAll();
//             $this->assign("applist", $applist);
//             $this->display('applist','utf-8');
        }else{
            $this->error($message = 'login error!');
        }
    }
    
}