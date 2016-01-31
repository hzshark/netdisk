<?php
namespace Admin\Controller;

use Think\Controller;

class TwsController extends Controller
{
    public function index(){
        $host = $_SERVER['HTTP_HOST'];
        $module = MODULE_NAME;
        $action = ACTION_NAME;
        $server="";
        $wsdl="";
        $soaparray=array("uri"=>"http://10.155.30.170:8880/ws/order.php?wsdl",'soap_version' => SOAP_1_2);
        $soaparray=array("location"=>"http://".$host."/".$module."/".$action,"uri"=>$action.".html");
        $server= new \SoapServer(null,$soaparray);
        $server->setClass(get_class($this));
        $server->handle();
    }
    public  function Add($a,$b)
    {
        return $a+$b;
    }
    public function testsoap(){
//         $soaparray=array("uri"=>"http://10.155.30.170:8880/ws/order.php?wsdl",'soap_version' => SOAP_1_2);
        $soap = new \SoapClient(null,array( "location" => "http://10.155.30.170:8880/Tws/index","uri"=> "index.html", "style"    => SOAP_RPC, "use" => SOAP_ENCODED));
        echo $soap->Add(1,2);
        unset($soap);
    }
}