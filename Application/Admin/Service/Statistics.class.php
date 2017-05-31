<?php
namespace Admin\Service;

class Statistics{
    
    public function getExperienceUserByDate($startdate, $enddate){
        
        $myDao = D("UserMobile");
        $where['user.indate'] = array(array('gt',$startdate),array('lt',$enddate)) ;
        $join = 'LEFT JOIN user_cost ON user.userid = user_cost.userid';
        $group = "DATE_FORMAT(user.indate,'%Y-%m-%d')";
        $field = "COUNT(*) data_count, DATE_FORMAT(user.indate,'%Y-%m-%d') user_indate";
        $datas = $myDao->where($where)->join($join)->field($field)->group($group)->select();
        return $datas;
    }

}