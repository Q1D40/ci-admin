<?php

/**
 * 用户控制器
 */
class User extends CI_Controller {

    public $userInfo;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('User_model', 'user');

        $this->userInfo = array(
            'uid'           => $this->session->userdata('uid'),
            'userName'      => $this->session->userdata('userName'),
            'permission'    => $this->session->userdata('permission'),
            'login'         => $this->session->userdata('login'),
        );
    }

    /**
     * 用户登陆
     */
    public function login()
    {
        $this->checkUserAgent();
        $this->checkLogout();

        if(is_array($this->input->post())){
            $code = $this->input->post('code');
            $scode = $this->session->userdata('code');
            $this->session->unset_userdata('code');
            if($code != $scode || trim($code) == ''){
                $data['error'] = '验证码错误';
            }else{
                $userName = strtolower(trim($this->input->post('userName')));
                $passWord = md5(strtolower(trim($this->input->post('passWord'))));
                $userInfo = $this->user->checkUser($userName, $passWord);
                $this->makeUserInfoPermission($userInfo['permission'], $this->makePermissionKeyMap($this->user->getPermissionList()));
                if($userInfo['uid'] > 0){
                    $userSession = array(
                        'uid'           => $userInfo['uid'],
                        'userName'      => $userInfo['userName'],
                        'permission'    => $userInfo['permission'],
                        'login'         => 'true',
                    );
                    $this->session->set_userdata($userSession);
                    redirect('/user/welcome/', 'refresh');
                }else{
                    $data['error'] = '用户名或密码错误！';
                }
            }
        }
        $this->load->view('user/login', $data);
    }

    /**
     * 用户注销
     */
    public function logout()
    {
        $userSession = array(
            'uid'           => '',
            'userName'      => '',
            'permission'    => '',
            'login'         => '',
        );
        $this->session->unset_userdata($userSession);
        redirect('/user/login/', 'refresh');
    }

    /**
     * 修改密码
     */
    public function changepwd()
    {
        $this->checkUserAgent();
        $this->checkLogin();

        if(is_array($this->input->post())){
            $this->load->model('User_model', 'user');
            $uid = $this->session->userdata('uid');
            $userName = $this->session->userdata('userName');
            $oldPassword = md5(strtolower(trim($this->input->post('oldPassword'))));
            $newPassword = md5(strtolower(trim($this->input->post('newPassword'))));
            $rnewPassword = md5(strtolower(trim($this->input->post('rnewPassword'))));

            $userInfo = $this->user->checkUser($userName, $oldPassword);
            if($userInfo['uid'] == ''){
                $data['info']['error'] = '密码错误！';
            }
            if($newPassword == 'd41d8cd98f00b204e9800998ecf8427e' && $rnewPassword == 'd41d8cd98f00b204e9800998ecf8427e'){
                $data['info']['error'] = '请填写新密码！';
            }
            if($newPassword != $rnewPassword){
                $data['info']['error'] = '两次密码不一致！';
            }

            if($data['info']['error'] == ''){
                $affectedRows = $this->user->changePassWord($uid, $oldPassword, $newPassword);
                if($affectedRows > 0)
                    $data['info']['success'] = '修改完成！';
                else
                    $data['info']['error'] = '密码没有变化！';
            }
        }

        $this->load->view('changepwd', $data);
    }

    /**
     * 生成验证码
     */
    public function create_captcha()
    {
        $this->load->library('Captchaclass');
        $this->captchaclass->create();
        $this->session->set_userdata(array('code' => $this->captchaclass->code));
    }

    /**
     * 检查登出
     */
    private function checkLogout()
    {
        if($this->userInfo['login'] === 'true')
            redirect('/user/welcome/', 'refresh');
    }

    /**
     * 检查登陆
     */
    private function checkLogin()
    {
        if($this->userInfo['login'] !== 'true')
            redirect('/user/login/', 'refresh');
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
     * 检查权限
     */
    private function checkPermission($permission, $key)
    {
        if(!in_array($key, $permission))
            die('no permission');
    }

    /**
     * 权限列表
     */
    public function permission_list()
    {
        $this->checkUserAgent();
        $this->checkLogin();
        $this->checkPermission($this->userInfo['permission'], 'user_permission_list');

        $data['permissionList'] = $this->user->getPermissionList();

        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'backstage';
        $data['menu'] = 'permission_list';
        $data['title'] = '权限管理';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('user/permission_list', $data);
        $this->load->view('general/footer');
    }

    /**
     * 权限添加
     */
    public function permission_add()
    {
        $this->checkUserAgent();
        $this->checkLogin();
        $this->checkPermission($this->userInfo['permission'], 'user_permission_add');

        if(is_array($this->input->post())){
            $name = trim($this->input->post('name'));
            $key = trim($this->input->post('key'));
            $permission = $this->user->getPermissionByKey($key);
            if($permission['id'] > 0){
                $data['error'] = 'key已存在！';
            }else{
                $this->user->addPermission($name, $key);
                redirect('/user/permission_list/', 'refresh');
            }
        }

        $data['act'] = 'add';

        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'backstage';
        $data['menu'] = 'permission_list';
        $data['title'] = '权限管理';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('user/permission_edit', $data);
        $this->load->view('general/footer');
    }

    /**
     * 权限编辑
     */
    public function permission_edit($id)
    {
        $this->checkUserAgent();
        $this->checkLogin();
        $this->checkPermission($this->userInfo['permission'], 'user_permission_edit');

        if(is_array($this->input->post())){
            $name = trim($this->input->post('name'));
            $key = trim($this->input->post('key'));
            $permission = $this->user->getPermissionByKey($key);
            if($permission['id'] > 0){
                $data['error'] = 'key已存在！';
            }else{
                $this->user->editPermission($name, $key, $id);
                redirect('/user/permission_list/', 'refresh');
            }
        }

        $permission = $this->user->getPermissionById($id);
        $data['permission'] = $permission;
        $data['act'] = 'edit';

        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'backstage';
        $data['menu'] = 'permission_list';
        $data['title'] = '权限管理';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('user/permission_edit', $data);
        $this->load->view('general/footer');
    }

    /**
     * 用户列表
     */
    public function user_list()
    {
        $this->checkUserAgent();
        $this->checkLogin();
        $this->checkPermission($this->userInfo['permission'], 'user_user_list');

        $permissionList = $this->user->getPermissionList();
        $permissionMap = $this->makePermissionMap($permissionList);
        $data['userList'] = $this->user->getUserList();
        $this->makeUserPermissionShow($data['userList'], $permissionMap);

        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'backstage';
        $data['menu'] = 'user_list';
        $data['title'] = '用户管理';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('user/user_list', $data);
        $this->load->view('general/footer');
    }

    /**
     * 用户添加
     */
    public function user_add()
    {
        $this->checkUserAgent();
        $this->checkLogin();
        $this->checkPermission($this->userInfo['permission'], 'user_user_add');

        if(is_array($this->input->post())){
            $permission = implode('|', $this->input->post('permission'));
            $userName = strtolower(trim($this->input->post('userName')));
            $passWord = trim($this->input->post('passWord'));
            $user = $this->user->getUserByUserName($userName);
            if($user['uid'] > 0){
                $data['error'] = '用户名已存在！';
            }else{
                $this->user->addUser($userName, md5($passWord), $permission);
                redirect('/user/user_list/', 'refresh');
            }
        }

        $data['permissionList'] = $this->user->getPermissionList();

        $data['act'] = 'add';

        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'backstage';
        $data['menu'] = 'user_list';
        $data['title'] = '用户管理';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('user/user_edit', $data);
        $this->load->view('general/footer');
    }

    /**
     * 用户编辑
     */
    public function user_edit($uid)
    {
        $this->checkUserAgent();
        $this->checkLogin();
        $this->checkPermission($this->userInfo['permission'], 'user_user_edit');

        $user = $this->user->getUserByUid($uid);

        if(is_array($this->input->post())){
            $permission = implode('|', $this->input->post('permission'));
            $userName = strtolower(trim($this->input->post('userName')));
            $passWord = trim($this->input->post('passWord'));
            if($userName != $user['userName'])
                $cuser = $this->user->getUserByUserName($userName);
            if($cuser['uid'] > 0){
                $data['error'] = '用户名已存在！';
            }else{
                if($passWord == '')
                    $passWord = $user['passWord'];
                else
                    $passWord = md5($passWord);
                $this->user->editUser($userName, $passWord, $permission, $uid);
                redirect('/user/user_list/', 'refresh');
            }
        }

        $data['permissionList'] = $this->user->getPermissionList();

        $data['userInfo'] = $this->userInfo;

        $user['permission'] = explode('|', $user['permission']);
        $data['user'] = $user;
        $data['act'] = 'edit';

        $data['group'] = 'backstage';
        $data['menu'] = 'user_list';
        $data['title'] = '用户管理';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('user/user_edit', $data);
        $this->load->view('general/footer');
    }

    /**
     * 修改密码
     */
    public function change_password()
    {
        $this->checkUserAgent();
        $this->checkLogin();
    }

    /**
     * 用户列表权限显示
     */
    private function makeUserPermissionShow(&$userList, $permissionMap)
    {
        foreach($userList as $key => $user){
            $permission = $user['permission'];
            $permission = explode('|', $permission);
            foreach($permission as $k => $v){
                $permission[$k] = $permissionMap[$v];
            }
            $permission = implode('--', $permission);
            $userList[$key]['permission'] = $permission;
        }
    }

    /**
     * 用户信息权限
     */
    private function makeUserInfoPermission(&$permission, $permissionKeyMap)
    {
        $permission = explode('|', $permission);
        foreach($permission as $k => $v){
            $permission[$k] = $permissionKeyMap[$v];
        }
    }

    /**
     * 整理权限字典
     */
    private function makePermissionMap($permissionList)
    {
        foreach($permissionList as $permission){
            $permissionMap[$permission['id']] = $permission['name'];
        }

        return $permissionMap;
    }

    /**
     * 整理权限key字典
     */
    private function makePermissionKeyMap($permissionList)
    {
        foreach($permissionList as $permission){
            $permissionKeyMap[$permission['id']] = $permission['key'];
        }

        return $permissionKeyMap;
    }

    /**
     * 欢迎页
     */
    public function welcome()
    {
        $this->checkUserAgent();
        $this->checkLogin();

        $data['userInfo'] = $this->userInfo;

        $data['title'] = '桔子';

        $hour = date("H", time());
            if($hour < 6)  $data["hello"] = "夜猫子，该睡觉了!!!";
        elseif($hour < 8)  $data["hello"] = "新的一天开始了哦!";
        elseif($hour < 9)  $data["hello"] = "早餐吃了吗?";
        elseif($hour < 10) $data["hello"] = "好心情 好运气!";
        elseif($hour < 11) $data["hello"] = "欢迎来到地球~";
        elseif($hour < 12) $data["hello"] = "工作辛苦了!";
        elseif($hour < 13) $data["hello"] = "别忘了吃午饭哦!";
        elseif($hour < 14) $data["hello"] = "没有午休的习惯啊?";
        elseif($hour < 15) $data["hello"] = "保持积极的心态!!";
        elseif($hour < 16) $data["hello"] = "相逢的人会再相逢!";
        elseif($hour < 18) $data["hello"] = "今天工作还顺利吧?!";
        elseif($hour < 20) $data["hello"] = "终于等到你了 ^_^";
        elseif($hour < 22) $data["hello"] = "晚上别玩得太晚了哦!";
        elseif($hour < 24) $data["hello"] = "夜深了!记得早点休息呀!";

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('user/welcome', $data);
        $this->load->view('general/footer');
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        // TODO
    }
}