<?php
namespace Admin\Controller;

use Think\Controller;
use Admin\Service\Statistics;

class StatisticsController extends Controller
{

    public function Index()
    {
            header("Content-Type:text/html; charset=utf-8");
            $data_list = [];
            if (IS_POST){
                $startTime = I('post.starttime');
                $endTime = I('post.endtime');
                $statistics = new Statistics();
                $user_data = $statistics->getExperienceUserByDate($startTime, $endTime);
                $mmslog_data = $statistics->getMmslogCountByDate($startTime, $endTime);
                $login_data = $statistics->getLoginUserCountByDate($startTime, $endTime);
                foreach ($user_data as $data){
                    $data_list[$data['user_indate']]['indate'] = $data['user_indate'];
                    $data_list[$data['user_indate']]['user_count'] = $data['data_count'];
                }
                foreach ($mmslog_data as $mms_data){
                        $data_list[$mms_data['indate']]['mms_count'] = $mms_data['data_count'];
                }
                foreach ($login_data as $l_data){
                        $data_list[$l_data['indate']]['login_count'] = $l_data['data_count'];

                }
// var_dump($data_list);
            }
            $cur_date = date("Y-m-d H:i:s");
            $starttime = date("Y-m-d  H:i:s" ,mktime(0,0,0,date("m"),date("d")-7,date("Y")));
            $this->assign("endtime", $cur_date);
            $this->assign("starttime", $starttime);
            $this->assign("data_list", $data_list);
            $this->display('activityStatistics', 'utf-8');

    }
}
