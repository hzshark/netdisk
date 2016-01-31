<?php
namespace Admin\Controller;

use Think\Controller;

class WsController extends Controller
{

    public function order()
    {
        echo 'aaa';
    }
    public function handshake($ver){
        return 'it is ok';
    }

    public function doOrder($service_id, $product_id, $product_id, $type, $comments){

    }
}