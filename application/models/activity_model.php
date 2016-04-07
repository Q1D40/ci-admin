<?php

/**
 * 活动页模型
 */
class Activity_model extends CI_Model{

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    /**
     * 根据手机号获取一条记录
     * @param $mobile
     * @return mixed
     */
    public function getActivityXiaoyuanJuiceByMobile($mobile)
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "update.`activity_xiaoyuan_juice` WHERE `mobile` = '$mobile' LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * 设置校园桔汁活动开关
     * @param $mobile
     * @param $status
     */
    public function setActivityXiaoyuanJuiceStatus($mobile, $status)
    {
        $sql = "UPDATE " . $this->db->mydbprefix . "update .`activity_xiaoyuan_juice` SET `status` = $status WHERE `mobile` = '$mobile' LIMIT 1";
        $this->db->query($sql);
    }
}