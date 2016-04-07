<?php

class Activity extends DH_Controller{

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Activity_model', 'activity');
    }

    /**
     * hao123校园活动
     */
    public function xiaoyuan()
    {
        $this->checkPermission($this->userInfo['permission'], 'activity_xiaoyuan');
        $mobile = trim($this->input->post('mobile'));
        if($mobile !='')
            $data['juice'] = $this->activity->getActivityXiaoyuanJuiceByMobile($mobile);

        $data['mobile'] = $mobile;
        $data['userInfo'] = $this->userInfo;
        $data['group'] = 'activity';
        $data['menu'] = 'xiaoyuan';
        $data['title'] = '校园活动';
        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('activity/xiaoyuan', $data);
        $this->load->view('general/footer');
    }

    /**
     * 校园活动状态设置
     */
    public function set_xiaoyuan_juice_status()
    {
        $this->checkPermission($this->userInfo['permission'], 'activity_xiaoyuan');
        $mobile = trim($_POST['mobile']);
        $status = trim($_POST['status']);
        $this->activity->setActivityXiaoyuanJuiceStatus($mobile, $status);
    }
}