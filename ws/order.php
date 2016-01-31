<?php
/**
 * VAC定制接口
 * @author hshao
 * @version 2015-12-24 11:24:59
 */

$timezone = "PRC";
if (PHP_VERSION >= '5.1' && !empty($timezone))
{
    date_default_timezone_set($timezone);
}
class order{
    public function __construct(){}

    public function orderRelationUpdateNotify($orderRelationUpdateNotifyRequest){
        echo "test  <br />";
        echo $orderRelationUpdateNotifyRequest;
    }u
}

$buildDomain = '10.155.30.170:8880';
$soaparray=array('soap_version' => SOAP_1_2);
$server= new \SoapServer("http://10.155.30.170:8880/ws/order.wsdl",$soaparray);
// $server=new SoapServer(file_get_contents('order.wsdl'),array('soap_version' => SOAP_1_2));
$server->setClass("order");
$server->handle();
