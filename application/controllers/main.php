<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 主框架控制器
 */
class Main extends DH_Controller {


    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper('url');
    }

	/**
	 * 首页
	 */
	public function index()
	{
        $userInfo = array(
            'uid'       => $this->session->userdata('uid'),
            'userName'  => $this->session->userdata('userName'),
            'login'     => $this->session->userdata('login'),
        );

        $data['userInfo'] = $userInfo;
		$this->load->view('main', $data);
	}

    /**
     * 析构函数
     */
    public function __destruct()
    {
        // TODO
    }
}
