<?php
namespace Admin\Controller;

use Think\Controller;

class AppsController extends Controller
{
    public function index()
    {
        $this->show('THIS file','utf-8');
    }
}