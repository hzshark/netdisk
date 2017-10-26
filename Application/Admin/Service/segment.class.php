<?php
namespace Service;
require __DIR__.'/../Model/Segment.model.php';
use SegmentModel;

class SegmentService
{

    public function getTaoBaoSegment($mobile){
        $url = 'https://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel='.$mobile;
        $proxy = "http://182.92.97.3:13128";
        $Result = get_ssl_proxy($url, $proxy);
        $GetZoneResult = iconv("GBK//IGNORE", "UTF-8", $Result);
        // echo $GetZoneResult;
        preg_match_all("/(\w+):'([^']+)/", $GetZoneResult, $match);
        // var_dump($match);
        $res = array_combine($match[1],  $match[2]);
        return $res;
    }

    public function appendSegment(array $seg){
        $segDao = new \SegmentModel();
        $condition['mts'] = $seg['mts'];
        $ret = $segDao->where($condition)->find();
        if ($ret == null || count($ret) == 0) {
            unset($seg['telString']);
            $ret = $segDao->add($seg);
        }
    }

    public function querySegment($mobile){
        $mobileSegment = substr($mobile, 0, 7);
        $condition['mts'] = $mobileSegment;
        $segDao = new \SegmentModel();
        $ret = $segDao->where($condition)->find();
        if ($ret == null || count($ret) == 0) {
            return false;
        }else if ($ret['province'] == '新疆' && strpos($ret["catName"],"联通")){
            return TRUE;
        }
        return false;
    }

    public function checkMobileSegment($mobile){
        if (self::querySegment($mobile)){
            return TRUE;
        }else{
            $seg = self::getTaoBaoSegment($mobile);
            self::appendSegment($seg);
            if ($seg['province'] == '新疆' && strpos($seg["catName"],"联通")){
                return TRUE;
            }
        }
        return FALSE;
    }
}