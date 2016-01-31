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


class generatetest extends BaseClass
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
		$siteInfo = null;
		/*if(!$this->validateParam($siteID,$verificodeb))
		{
			return 'array()';
		}*/
		
		$siteStmt = new SiteClass($siteID);
		$snc = new SiteNavigateClass($siteID);

		if($site_type==1)
        {
            $siteInfo = $siteStmt->getStartPageInfoBySiteId($siteID,$language==0?-1:$language);		
        }
        else if($site_type==3)
        {
            $siteInfo = $siteStmt->getStartPageInfoWapBySiteId($siteID,$language==0?-1:$language); // 不存在时返回false
        }
            
        if((empty($siteInfo) || $siteInfo==null) && $site_type!=2)
        {//未设置站点起始页
			return 'array()';
        }
          	
        if($site_type==1)
        {
            $navi = $snc->select($siteInfo->navi_id); 
            $htmlUrl = GlobalClass::getPageUrl(GlobalClass::HTMLMODE, $siteInfo->language, $navi->navi_type_id, $navi->navi_id, $navi->navi_url, $navi->inner_link_id, $siteInfo->page_id);
        }
        else if($site_type==3)
        {
            $navi = $snc->select($siteInfo->navi_id);
            $htmlUrl = GlobalClass::getPageUrl(GlobalClass::WAPMODE, $siteInfo->language, $navi->navi_type_id, $navi->navi_id, $navi->navi_url, $navi->inner_link_id, $siteInfo->page_id);
        }
        else
        {
             $htmlUrl ="";
        }	
       
		$isHtml = GlobalClass::checkHasOpenMemberSys($siteID,$siteInfo->language)?0:1;
			               		
		return 'array(\'isHTML\'=>'.$isHtml.',\'htmlUrl\'=>\''.$htmlUrl.'\',\'dynamicUrl\'=>\'\')';	
	}
	
}
$g = new generatetest();
var_dump($g->reSite("",3999,44));
exit;
