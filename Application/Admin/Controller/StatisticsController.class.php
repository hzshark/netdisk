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
                $startTime = I('post.start_time');
                $endTime = I('post.end_time');
                $statistics = new Statistics();
                $user_data = $statistics->getExperienceUserByDate($startTime, $endTime);
            }
            $this->assign("data_list", $data_list);
            $this->display('activityStatistics', 'utf-8');
        
    }
}