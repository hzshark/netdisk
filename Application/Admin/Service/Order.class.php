<?php
namespace Admin\Service;

class Order{
    public function serviceOrder($service_id, $product_id, $product_id, $type, $comments){
        $deskey = '';
        $trans_id = time();
        $xmls = "<request>";
        $xmls .= "<service_id>" . service_id . "</service_id>";
        $xmls .= "<product_id>" . product_id . "</product_id>";
        $xmls .= "<fee_mobile>" . mobile . "</fee_mobile>";
        $xmls .= "<mobile>" . mobile . "</mobile>";
        $xmls .= "<type>" . type . "</type>";
        $xmls .= "<comments>" . $comments . "</comments>";
        $xmls .= "</request>";
        $apiName = "order";
    }

    private function getreqstr($spId, $transId, $apiName, $signKey, $deskey){

    }

}