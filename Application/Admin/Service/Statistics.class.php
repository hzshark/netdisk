<?php
namespace Admin\Service;

class Statistics{

    public function getExperienceUserByDate($startdate, $enddate){
        $myDao = D("User");
        $where['user.indate'] = array(array('gt',$startdate),array('lt',$enddate)) ;
        $join = 'LEFT JOIN user_cost ON user.userid = user_cost.userid';
        $group = "DATE_FORMAT(user.indate,'%Y-%m-%d')";
        $field = "COUNT(*) data_count, DATE_FORMAT(user.indate,'%Y-%m-%d') user_indate";
        $datas = $myDao->where($where)->join($join)->field($field)->group($group)->select();
        return $datas;
    }

    public function getMmslogCountByDate($startdate, $enddate){
        $myDao = D("Mmslog");
        $where['indate'] = array(array('gt',$startdate),array('lt',$enddate)) ;
        $group = "DATE_FORMAT(indate,'%Y-%m-%d')";
        $field = "COUNT(*) data_count, DATE_FORMAT(indate,'%Y-%m-%d') indate";
        $datas = $myDao->where($where)->field($field)->group($group)->select();
        return $datas;
    }

    public function getLoginUserCountByDate($startdate, $enddate){
        $myDao = D("User");
        $where['indate'] = array(array('gt',$startdate),array('lt',$enddate)) ;
        $where['lastlogin'] = array(array('gt',$startdate),array('lt',$enddate)) ;
        $group = "DATE_FORMAT(indate,'%Y-%m-%d')";
        $field = "COUNT(*) data_count, DATE_FORMAT(indate,'%Y-%m-%d') indate";
        $datas = $myDao->where($where)->field($field)->group($group)->select();
        return $datas;
    }

}
