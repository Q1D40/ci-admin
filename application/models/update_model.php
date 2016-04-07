<?php

/**
 * 升级模型
 */
class Update_model extends CI_Model {

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    /**
     * 获取最后一个配置
     */
    public function getLastConf()
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "update.conf ORDER BY `id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * 获取一个配置
     */
    public function getConfById($id)
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "update.conf WHERE `id` = '$id' LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * 插入一个配置
     */
    public function addConf($code)
    {
        $code = mysql_real_escape_string($code);
        $timsStamp = time();
        $sql = "INSERT INTO " . $this->db->mydbprefix . "update.conf (`code`, `timeStamp`) VALUES ('$code', '$timsStamp')";
        $this->db->query($sql);
        return $this->db->insert_id();
    }

    /**
     * 获取最后一个配置列表
     */
    public function getLastConfList()
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "update.confList ORDER BY `id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * 获取一个配置列表
     */
    public function getConfListById($id)
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "update.confList WHERE `id` = '$id' LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * 插入一个配置列表
     */
    public function addConfList($code)
    {
        $code = mysql_real_escape_string($code);
        $timsStamp = time();
        $sql = "INSERT INTO " . $this->db->mydbprefix . "update.confList (`code`, `timeStamp`) VALUES ('$code', '$timsStamp')";
        $this->db->query($sql);
        return $this->db->insert_id();
    }

    /**
     * 添加一个adblock版本
     */
    public function addAdblockVersion()
    {
        $sql = "INSERT INTO " . $this->db->mydbprefix . "update.`adblockVersion` (`version`)VALUES('" . date("YmdHi", time()) . "')";
        $this->db->query($sql);
    }

    /**
     * 获取adblock最后一个版本
     */
    public function getAdblockLastVersion()
    {
        $sql = "SELECT `id` FROM " . $this->db->mydbprefix . "update.adblockVersion ORDER BY `id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data['id'];
    }

    /**
     * 获取adblock自动开关
     */
    public function getAdblockAutoSwitch()
    {
        $sql = "SELECT `switch` FROM " . $this->db->mydbprefix . "update.adblockSwitch WHERE `id` = 1 LIMIT 1";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data['switch'];
    }

    /**
     * 设置adblock自动开关
     */
    public function setAdblockAutoSwitch($switch)
    {
        $sql = "UPDATE " . $this->db->mydbprefix . "update.adblockSwitch SET `switch` = '$switch' WHERE `id` = 1 LIMIT 1";
        $this->db->query($sql);
    }

    /**
     * 获取最后一个配置列表
     */
    public function getLastDlConf()
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "update.dlConf ORDER BY `id` DESC LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * 获取一个配置列表
     */
    public function getDlConfById($id)
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "update.dlConf WHERE `id` = '$id' LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * 插入一个配置列表
     */
    public function addDlConf($code)
    {
        $code = mysql_real_escape_string($code);
        $timsStamp = time();
        $sql = "INSERT INTO " . $this->db->mydbprefix . "update.dlConf (`code`, `timeStamp`) VALUES ('$code', '$timsStamp')";
        $this->db->query($sql);
        return $this->db->insert_id();
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        // TODO
    }
}