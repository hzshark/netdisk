<?php
namespace Admin\Controller;

use Think\Controller;

class FilesController extends Controller
{
    public function index()
    {
        $this->show('THIS file','utf-8');
    }
}