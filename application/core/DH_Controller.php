<?php

/**
 * DarkHorse基础控制器
 */
class DH_Controller extends CI_Controller {

    public $userInfo;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper('url');

        $this->userInfo = array(
            'uid'           => $this->session->userdata('uid'),
            'userName'      => $this->session->userdata('userName'),
            'permission'    => $this->session->userdata('permission'),
            'login'         => $this->session->userdata('login'),
        );

        $this->checkUserAgent();
        $this->checkLogin();
    }

    /**
     * 检查UserAgent
     */
    private function checkUserAgent()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $pos = strpos($userAgent, 'juziwang');
        if ($pos === false) {
            header('HTTP/1.1 404 Not Found');
            header("status: 404 Not Found");
            exit('404 Not Found');
        }
    }

    /**
     * 检查登录
     */
    private function checkLogin()
    {
        if($this->userInfo['login'] !== 'true')
            redirect('/user/login/', 'refresh');
    }

    /**
     * 检查权限
     */
    protected function checkPermission($permission, $key)
    {
        if(!in_array($key, $permission))
            die('no permission');
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        // TODO
    }
}