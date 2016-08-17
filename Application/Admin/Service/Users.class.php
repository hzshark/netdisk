<?php
namespace Admin\Service;

class Users {
    
    function currentDate(){
        return date("Y-m-d H:i:s");
    }
    
    function queryUserByDate($startdate, $enddate) {
        $condition['indate'] = array(array('gt',$startdate),array('lt',$enddate)) ;
        $myDao = D("UserMobile");
        $user = $myDao->where($condition)->select();
        if ($user == null || count($user) == 0) {
            return false;
        }
        return $user;
    }
    
    function queryUserCountByDate($startdate, $enddate) {
        $condition['indate'] = array(array('gt',$startdate),array('lt',$enddate)) ;
        $myDao = D("UserMobile");
        return $myDao->where($condition)->count();
    }

}