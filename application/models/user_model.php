<?php

/**
 * 用户模型
 */
class User_model extends CI_Model {

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    /**
     * 验证用户名密码
     */
    public function checkUser($userName, $passWord)
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "backstage.user WHERE `userName` = '$userName' AND `passWord` = '$passWord' LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * 修改密码
     */
    public function changePassWord($uid, $oldPassword, $newPassword)
    {
        $sql = "UPDATE " . $this->db->mydbprefix . "backstage.user SET `passWord` = '$newPassword' WHERE `uid` = '$uid' AND `passWord` ='$oldPassword' LIMIT 1";
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    /**
     * 获取用户列表
     */
    public function getUserList()
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "backstage.user ORDER BY `uid` DESC";
        $query = $this->db->query($sql);
        $dataList = array();
        foreach ($query->result_array() as $row)
        {
            $dataList[] = $row;
        }

        return $dataList;
    }

    /**
     * 添加用户
     */
    public function addUser($userName, $passWord, $permission)
    {
        $sql = "INSERT INTO " . $this->db->mydbprefix . "backstage.user (`userName`, `passWord`, `permission`)
                VALUES
                ('$userName', '$passWord', '$permission')";
        $this->db->query($sql);
    }

    /**
     * 编辑用户
     */
    public function editUser($userName, $passWord, $permission, $uid)
    {
        $sql = "UPDATE " . $this->db->mydbprefix . "backstage.user SET `userName` = '$userName', `passWord` = '$passWord', `permission` = '$permission' WHERE uid = '$uid' LIMIT 1";
        $this->db->query($sql);
    }

    /**
     * 用户名获取用户
     */
    public function getUserByUserName($userName)
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "backstage.user WHERE `userName` = '$userName' LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * uid获取用户
     */
    public function getUserByUid($uid)
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "backstage.user WHERE `uid` = '$uid' LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * 获取权限列表
     */
    public function getPermissionList()
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "backstage.permission ORDER BY `id` DESC";
        $query = $this->db->query($sql);
        $dataList = array();
        foreach ($query->result_array() as $row)
        {
            $dataList[] = $row;
        }

        return $dataList;
    }

    /**
     * 添加权限
     */
    public function addPermission($name, $key)
    {
        $sql = "INSERT INTO " . $this->db->mydbprefix . "backstage.permission (`name`, `key`)
                VALUES
                ('$name', '$key')";
        $this->db->query($sql);
    }

    /**
     * 编辑权限
     */
    public function editPermission($name, $key, $id)
    {
        $sql = "UPDATE " . $this->db->mydbprefix . "backstage.permission SET `name` = '$name', `key` = '$key' WHERE id = '$id' LIMIT 1";
        $this->db->query($sql);
    }

    /**
     * key获取权限
     */
    public function getPermissionByKey($key)
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "backstage.permission WHERE `key` = '$key' LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * id获取权限
     */
    public function getPermissionById($id)
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "backstage.permission WHERE `id` = '$id' LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        // TODO
    }
}