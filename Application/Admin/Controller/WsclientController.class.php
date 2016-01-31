<?php
namespace Admin\Controller;

use Think\Controller;

class WsController extends Controller
{

    public function index()
    {
        $host = $_SERVER['HTTP_HOST'];
        $module = MODULE_NAME;
        $action = ACTION_NAME;
        $server="";
        $wsdl="";
        $soaparray=array('soap_version' => SOAP_1_2);
        $server= new \SoapServer(file_get_contents(__DIR__.'/ws/order.wsdl'),$soaparray);
        $server->setClass(get_class($this));
        $server->handle();
    }
    public function handshake($ver){
        return 'it is ok';
    }

    public function order($service_id, $product_id, $product_id, $type, $comments){

    }
}