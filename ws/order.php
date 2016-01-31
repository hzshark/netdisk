<?php
/**
 * 管理后台调用发布网站
 * @copyright Esite 3.0
 * @author TWJ
 * @version 2010-6-24 11:24:59
 */

//备注：在建站后台/action/generatesite.php中也有一份发布网站的程序，
//如果此处做了修改，相应的那里也应该进行修改。

$timezone = "PRC";
if (PHP_VERSION >= '5.1' && !empty($timezone))
{
    date_default_timezone_set($timezone);
}
require_once __DIR__.'/../class/BaseClass.php';
require_once __DIR__.'/../class/SiteClass.php';
require_once __DIR__.'/../class/SiteNavigateClass.php';


class generate extends BaseClass
{
	public function __construct(){}

    public function reSite($verificodea,$siteID,$template_id = 0)
    {
    	$_GET['siteID'] = $siteID;
    	//return 999999;
		parent::__construct();
        /*if(!$this->validateParam($siteID,$verificodea))
    	    return 0;*/

    	require_once __DIR__.'/../class/GenerateHtmlClass.php';

    	$_POST["publishType"]="publishAll";
    	$obj = new GenerateHtmlClass($siteID);
//     	if($obj->countReleaseFile() > 10000){
//     		return 2;
//     	}
// 		else{
			return $obj->releaseFile($template_id);
// 		}
    }

	public function getPubSiteInfo($verificodeb,$siteID,$language,$site_type)
	{


		return 'array(\'isHTML\'=>'.$isHtml.',\'htmlUrl\'=>\''.$htmlUrl.'\',\'dynamicUrl\'=>\'\')';
	}

}
// /*$g = new generate();
// echo $g->reSite('',28);*/

$buildDomain = '10.155.30.170:8880';
$server=new SoapServer(file_get_contents('order.wsdl'),array('soap_version' => SOAP_1_2));
$server->setClass("generate");
$server->handle();
