<?php

/**
 * CT模型
 */
class Cron_model extends CI_Model {

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    /**
     * 获取cron日志
     */
    public function getCronLog($date, $type, $status, $start, $limit)
    {
        $where = " WHERE `date` = '$date' ";
        if($type !== '') $where .= ' AND ' . "`type` LIKE '%$type%'";
        if($status == 'done') $where .= ' AND ' . "`endTime` > 0";
        if($status == 'doing') $where .= ' AND ' . "`endTime` = 0";

        $limit = " LIMIT $start, $limit";

        $sql = "SELECT * FROM " . $this->db->mydbprefix . "cron.cronLog $where ORDER BY `id` DESC $limit";
        $query = $this->db->query($sql);
        $cronLogList = array();
        foreach ($query->result_array() as $row)
        {
            $cronLogList[] = $row;
        }

        return $cronLogList;
    }

    /**
     * 日志总数
     */
    public function getCronLogCount($date, $type, $status)
    {
        $where = " WHERE `date` = '$date' ";
        if($type !== '') $where .= ' AND ' . "`type` LIKE '%$type%'";
        if($status == 'done') $where .= ' AND ' . "`endTime` > 0";
        if($status == 'doing') $where .= ' AND ' . "`endTime` = 0";

        $sql = "SELECT COUNT(*) AS `num` FROM " . $this->db->mydbprefix . "cron.cronLog $where";
        $query = $this->db->query($sql);
        $data =  $query->row_array();
        return $data['num'];
    }

    /**
     * 获取日志入库日志
     */
    public function getInsertFileLog($date, $fileType, $status, $start, $limit)
    {
        $where = " WHERE `date` = '$date' ";
        if($fileType !== '') $where .= ' AND ' . "`fileType` LIKE '%$fileType%'";
        if($status == 'done') $where .= ' AND ' . "`endTime` > 0";
        if($status == 'doing') $where .= ' AND ' . "`endTime` = 0";

        $limit = " LIMIT $start, $limit";

        $sql = "SELECT * FROM " . $this->db->mydbprefix . "cron.insertFileLog $where ORDER BY `id` DESC $limit";
        $query = $this->db->query($sql);
        $insertFileLogList = array();
        foreach ($query->result_array() as $row)
        {
            $insertFileLogList[] = $row;
        }

        return $insertFileLogList;
    }

    /**
     * 日志入库日志总数
     */
    public function getInsertFileLogCount($date, $fileType, $status)
    {
        $where = " WHERE `date` = '$date' ";
        if($fileType !== '') $where .= ' AND ' . "`fileType` LIKE '%$fileType%'";
        if($status == 'done') $where .= ' AND ' . "`endTime` > 0";
        if($status == 'doing') $where .= ' AND ' . "`endTime` = 0";

        $sql = "SELECT COUNT(*) AS `num` FROM " . $this->db->mydbprefix . "cron.insertFileLog $where";
        $query = $this->db->query($sql);
        $data =  $query->row_array();
        return $data['num'];
    }

    /**
     * 获取磁盘使用日志
     */
    public function getDiskUsageLog($date, $start, $limit)
    {
        $where = " WHERE `date` = '$date' ";

        $limit = " LIMIT $start, $limit";

        $sql = "SELECT * FROM " . $this->db->mydbprefix . "cron.diskUsageLog $where ORDER BY `id` DESC $limit";
        $query = $this->db->query($sql);
        $dataList = array();
        foreach ($query->result_array() as $row)
        {
            $dataList[] = $row;
        }

        return $dataList;
    }

    /**
     * 磁盘使用日志总数
     */
    public function getDiskUsageLogCount($date)
    {
        $where = " WHERE `date` = '$date' ";

        $sql = "SELECT COUNT(*) AS `num` FROM " . $this->db->mydbprefix . "cron.diskUsageLog $where";
        $query = $this->db->query($sql);
        $data =  $query->row_array();
        return $data['num'];
    }

    /**
     * 获取DB使用日志
     */
    public function getDbUsageLog($date, $start, $limit)
    {
        $where = " WHERE `date` = '$date' ";

        $limit = " LIMIT $start, $limit";

        $sql = "SELECT * FROM " . $this->db->mydbprefix . "cron.dbUsageLog $where ORDER BY `id` DESC $limit";
        $query = $this->db->query($sql);
        $dataList = array();
        foreach ($query->result_array() as $row)
        {
            $dataList[] = $row;
        }

        return $dataList;
    }

    /**
     * DB使用日志总数
     */
    public function getDbUsageLogCount($date)
    {
        $where = " WHERE `date` = '$date' ";

        $sql = "SELECT COUNT(*) AS `num` FROM " . $this->db->mydbprefix . "cron.dbUsageLog $where";
        $query = $this->db->query($sql);
        $data =  $query->row_array();
        return $data['num'];
    }

    /**
     * 获取磁盘使用日志
     */
    public function getWarningLog()
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "cron.warningLog ORDER BY `id` DESC";
        $query = $this->db->query($sql);
        $dataList = array();
        foreach ($query->result_array() as $row)
        {
            $dataList[] = $row;
        }

        return $dataList;
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        // TODO
    }
}