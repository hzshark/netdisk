<?php
namespace Admin\Controller;

use Think\Controller;

class ApiController extends Controller
{
    public function index()
    {
//         header("Content-Type:text/html; charset=utf-8");
        header("Content-type: application/octet-stream");
        header("Accept-Ranges: bytes");
        $this->redirect("netdisk/nd1101video/aaabbcss.mp4");
    }
}