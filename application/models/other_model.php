<?php

/**
 * 杂项模型
 */
class Other_model extends CI_Model {

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    /**
     * 设置TN对照表
     */
    public function setTnMap($content)
    {
        $timeStamp = time();
        $sql = "UPDATE " . $this->db->mydbprefix . "backstage.tnMap SET `content` = '$content', `timeStamp` = '$timeStamp' WHERE `id` = 1 LIMIT 1";
        $this->db->query($sql);
    }

    /**
     * 获取TN对照表
     */
    public function getTnMap()
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "backstage.tnMap WHERE id = 1 LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * 设置渠道控制
     */
    public function setCanalControl($content)
    {
        $timeStamp = time();
        $sql = "UPDATE " . $this->db->mydbprefix . "backstage.canalControl SET `content` = '$content', `timeStamp` = '$timeStamp' WHERE `id` = 1 LIMIT 1";
        $this->db->query($sql);
    }

    /**
     * 获取渠道控制
     */
    public function getCanalControl()
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "backstage.canalControl WHERE id = 1 LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * 插入TN列表
     */
    public function insertTnList($data)
    {
        foreach ($data as $field => $value) {
            $fieldArray[] = '`' . $field . '`';
            $valueArray[] = "'" . $value . "'";
        }
        $fieldStr = implode(',', $fieldArray);
        $valueStr = implode(',', $valueArray);
        $sql = "INSERT IGNORE INTO " . $this->db->mydbprefix . "backstage.tnList ($fieldStr) VALUES ($valueStr)";
        $this->db->query($sql);
    }

    /**
     * 获取TN列表
     */
    public function getTnList()
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "backstage.tnList ORDER BY cid ASC";
        $query = $this->db->query($sql);
        $data = array();
        foreach ($query->result_array() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    /**
     * 设置tn状态
     */
    public function setTnStatus($status, $cid)
    {
        $sql = "UPDATE " . $this->db->mydbprefix . "backstage.tnList SET `status` = '$status' WHERE `cid` = '$cid' LIMIT 1";
        $this->db->query($sql);
    }

    /**
     * 设置是否为网吧版
     * @param $netbarv
     * @param $cid
     */
    public function setTnNetbarv($netbarv, $cid)
    {
        $sql = "UPDATE " . $this->db->mydbprefix . "backstage.tnList SET `status` = '$netbarv' WHERE `cid` = '$cid' LIMIT 1";
        $this->db->query($sql);
    }

    /**
     * 删除tn
     */
    public function delTn($cid)
    {
        $sql = "DELETE FROM " . $this->db->mydbprefix . "backstage.tnList WHERE `cid` = '$cid' LIMIT 1";
        $this->db->query($sql);
    }

    /**
     * 更新通用设置
     */
    public function setGeneralConf($data, $id)
    {
        foreach ($data as $field => $value) {
            $fieldAndValueArray[] = "`$field` = '$value'";
        }
        $fieldAndValueStr = implode(',', $fieldAndValueArray);
        $sql = "UPDATE " . $this->db->mydbprefix . "update.generalConf SET $fieldAndValueStr WHERE `id` = '$id' LIMIT 1";
        $this->db->query($sql);
    }

    /**
     * 获取通用设置
     */
    public function getGeneralConf($id)
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "update.generalConf WHERE id = '$id' LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * 获取通用设置数据
     */
    public function getCidRegex()
    {
        $content = $this->getGeneralConf(11);
        $arr = explode("\n", $content['f1']);
        foreach($arr as $i => $row){
            $arr[$i] = trim($row);
            $arr[$i] = str_replace("\r", '', $arr[$i]);
            if($arr[$i] == '') unset($arr[$i]);
        }
        return $arr;
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        // TODO
    }
}