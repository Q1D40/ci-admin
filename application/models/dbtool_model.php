<?php

/**
 * DB工具模型
 */
class Dbtool_model extends CI_Model {

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    /**
     * 执行sql语句
     */
    public function runSQL($database, $sql)
    {
        $this->db->database = $database;
        $this->db->db_select();
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * 获取db列表
     */
    public function showDatabases()
    {
        $query = $this->db->query('show databases');
        return $query->result_array();
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        // TODO
    }
}