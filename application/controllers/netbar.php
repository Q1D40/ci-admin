<?php

class Netbar extends DH_Controller{

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Other_model', 'other');
        $this->load->model('Log_model', 'log');
    }

    /**
     *网吧EXE文件配置
     */
    public function exe_download_conf()
    {
        $this->checkPermission($this->userInfo['permission'], 'netbar_exe_download');

        if(is_array($this->input->post())){
            $data['f1'] = $this->input->post('f1');
            $data['timeStamp'] = time();
            $conf = json_decode($data['f1'], true);
            if(is_array($conf)){
                $this->other->setGeneralConf($data, 8);
                $data['success'] = '保存成功！配置将在一小时后生效~';
            }else{
                $data['error'] = 'JSON格式错误！！！';
            }
        }

        $data['conf8'] = $this->other->getGeneralConf(8);
        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'update';
        $data['menu'] = '';
        $data['title'] = '网吧EXE下载';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('netbar/exe_download_conf', $data);
        $this->load->view('general/footer');
    }

    /**
     * 网吧DLL文件配置
     */
    public function dll_download_conf()
    {
        $this->checkPermission($this->userInfo['permission'], 'netbar_dll_download');

        if(is_array($this->input->post())){
            $data['f1'] = $this->input->post('f1');
            $data['timeStamp'] = time();
            $conf = json_decode($data['f1'], true);
            if(is_array($conf)){
                $this->other->setGeneralConf($data, 9);
                $data['success'] = '保存成功！配置将在一小时后生效~';
            }else{
                $data['error'] = 'JSON格式错误！！！';
            }
        }

        $data['conf9'] = $this->other->getGeneralConf(9);
        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'update';
        $data['menu'] = '';
        $data['title'] = '网吧DLL下载';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('netbar/dll_download_conf', $data);
        $this->load->view('general/footer');
    }

    /**
     * 网吧接口列表配置
     */
    public function api_url_conf()
    {
        $this->checkPermission($this->userInfo['permission'], 'netbar_interface_list');

        if(is_array($this->input->post())){
            $data['f1'] = $this->input->post('f1');
            $data['timeStamp'] = time();
            $conf = json_decode($data['f1'], true);
            if(is_array($conf)){
                $this->other->setGeneralConf($data, 10);
                $data['success'] = '保存成功！配置将在一小时后生效~';
            }else{
                $data['error'] = 'JSON格式错误！！！';
            }
        }

        $data['conf10'] = $this->other->getGeneralConf(10);
        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'update';
        $data['menu'] = '';
        $data['title'] = '网吧接口列表';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('netbar/api_url_conf', $data);
        $this->load->view('general/footer');
    }

    /**
     * 网吧云控配置
     */
    public function cloud_control_conf()
    {
        $this->checkPermission($this->userInfo['permission'], 'netbar_interface_list');

        if(is_array($this->input->post())){
            $data['timeStamp'] = time();
            $code = $this->input->post('f1');
            if(eval($code) !== false){
                $data['f1'] = mysql_real_escape_string($this->input->post('f1'));
                $data['timeStamp'] = time();
                $this->other->setGeneralConf($data, 14);
                $data['success'] = '保存成功！配置将在一小时后生效~';
            }else{
                $data['error'] = '语法错误，请检查！';
            }
        }

        $data['conf'] = $this->other->getGeneralConf(14);
        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'update';
        $data['menu'] = '';
        $data['title'] = '网吧云控';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('netbar/cloud_control_conf', $data);
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