<?php

/**
 * 配置列表控制器
 */
class Conflist extends DH_Controller {

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Update_model', 'update');
    }

    /**
     * 提交前先判断当前服务器是否存在该文件
     */
    public function judge_file()
    {
        $this->checkPermission($this->userInfo['permission'], 'conflist_conf_list');
        $condition = trim($_POST['condition']);
        $code = trim($_POST['code']);
        $conf = json_decode($code,true);
        $dataPath = $this->config->item('data_path');
        $confPath = dirname(__FILE__) . $dataPath . 'update/install/conflist/';
        $response['result'] = 1;
        if(is_array($conf)){
        foreach($conf as $value){
            $reFile = explode('/',$value['url']);
            $file = $reFile[count($reFile) - 1];
            $file = trim($file);
            if(!is_file($confPath . $file)){
                $response['result'] = 0;
                $response['file'][] = $file;
            }
        }
        $fileKey = preg_match_all('/return\[\](.+);/',$condition,$matches);
        $arrKey = array();
        foreach($matches[1] as $row){
            $temp = str_replace('=', '', $row);
            $temp = str_replace(' ', '', $temp);
            $temp = str_replace("'", '', $temp);
            $temp = str_replace('"', '', $temp);
            $arrKey[] = $temp;
        }
        foreach($arrKey as $row){
            if(!array_key_exists($row,$conf)){
                $response['result'] = 2;
                $response['key'][] = $row;
            }
        }
        }
        echo json_encode($response);
    }

    /**
     * 配置文件列表
     */
    public function conf_list()
    {
        $this->checkPermission($this->userInfo['permission'], 'conflist_conf_list');

        $dataPath = $this->config->item('data_path');
        $confPath = dirname(__FILE__) . $dataPath . 'update/conflist/';

        if(isset($_POST['code'])&&isset($_POST['condition'])){
            $this->checkPermission($this->userInfo['permission'], 'conflist_conf_add');
            $condition = trim($_POST['condition']);
            $code = trim($_POST['code']);
            $code = json_decode($code,true);
            $code['condition'] = $condition;
            if(eval($condition) === false){
                $data['errMsg'] = "条件语法错误，请查看代码";
            }else{
                if(!is_array($code) || count($code) < 2){
                    $data['errMsg'] ="数据不是json格式，不能提交";
                }else{
                    $conf = json_encode($code);
                    $this->update->addAdblockVersion();
                    $id = $this->update->addConfList($conf);
                    file_put_contents($confPath . 'conf' . $id . '.inc',$conf);
                    @chmod($confPath . 'conf' . $id . '.inc', 0777);
                    $data['sucMsg'] = "提交成功！";
                }
            }
        }
        $data['userInfo'] = $this->userInfo;

        $data['confList'] = $this->getConfFiles($confPath);
        krsort($data['confList']);
        $data['currentConf'] = current($data['confList']);

        $data['adblockLastVersion'] = $this->update->getAdblockLastVersion();
        $data['adblockAutoSwitch'] = $this->update->getAdblockAutoSwitch();

        $data['group'] = 'update';
        $data['menu'] = 'update_conflist';
        $data['title'] = '配置文件配置';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('conflist/conf_list', $data);
        $this->load->view('general/footer');
    }

    /**
     * 配置文件添加
     */
    public function conf_add()
    {
        $lastConf = $this->update->getLastConfList();
        $data['preConf'] = $lastConf['code'];
        $dataArray = json_decode($data['preConf'],true);
        if(in_array($dataArray['condition'],$dataArray)){
            $data['condition'] = $dataArray['condition'];
            unset($dataArray['condition']);
        }
        $data['content'] = json_encode($dataArray);
        $data['adblockLastVersion'] = $this->update->getAdblockLastVersion();

        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'update';
        $data['menu'] = 'update_conflist';
        $data['title'] = '配置文件配置修改';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('conflist/conf_add', $data);
        $this->load->view('general/footer');
    }

    /**
     * 配置文件添加
     */
    public function set_adblock_auto_switch($switch)
    {
        $this->checkPermission($this->userInfo['permission'], 'conflist_conf_add');

        if($switch == 1)
            $this->update->setAdblockAutoSwitch(1);
        else
            $this->update->setAdblockAutoSwitch(0);
    }

    /**
     * 配置文件查看
     */
    public function conf_view($fileName)
    {
        $dataPath = $this->config->item('data_path');
        $confPath = dirname(__FILE__) . $dataPath . 'update/conflist/';
        highlight_file($confPath . base64_decode($fileName));
    }

    /**
     * 配置压缩包上传
     */
    public function upload()
    {
        $dataPath = $this->config->item('data_path');
        $updatePath = dirname(__FILE__) . $dataPath . 'update/install/conflist/';

        if($this->input->post('submit') == '上传'){
        $this->checkPermission($this->userInfo['permission'], 'conflist_upload');

        if ($_FILES["file"]["error"] > 0){
            $data['error'] = "上传失败！错误代码" . $_FILES["file"]["error"];
        }else{
            move_uploaded_file($_FILES["file"]["tmp_name"], $updatePath . $_FILES["file"]["name"]);
            @chmod($updatePath . $_FILES["file"]["name"] ,0777);
            $data['error'] = $_FILES["file"]["name"] . "上传完成！下载地址 " . $this->config->item('download_install_url') . 'conflist/' . $_FILES["file"]["name"];
        }}

        $data['userInfo'] = $this->userInfo;

        $data['updateList'] = $this->getConfListFiles($updatePath);
        rsort($data['updateList'], SORT_STRING);

        $data['download_install_url'] = $this->config->item('download_install_url'). 'conflist/';

        $data['adblockLastVersion'] = $this->update->getAdblockLastVersion();

        $data['group'] = 'update';
        $data['menu'] = 'update_conflist';
        $data['title'] = '配置文件上传';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('conflist/upload', $data);
        $this->load->view('general/footer');
    }

    /**
     * 获取目录所有文件
     */
    private function getPathFiles($path)
    {
        if(!is_dir($path)) return;

        $fileArray = array();
        $handle  = opendir($path);
        while( false !== ($file = readdir($handle))){
            if($file != '.' && $file != '..'){
                $ctime = filectime($path . $file);
                $fileArray[] = array('file' => $file, 'ctime' => $ctime);
            }
        }

        return $fileArray;
    }

    /**
     * 获取配置目录所有文件
     */
    private function getConfFiles($path)
    {
        $return = array();
        $fileArray = $this->getPathFiles($path);
        foreach($fileArray as $file){
            $baseName = basename($file['file'], '.inc');
            $ver = str_replace('conf', '', $baseName);
            $ver += 0;
            $return[$ver] = $file;
        }

        return $return;
    }

    /**
     * 获取配置压缩包目录所有文件
     */
    private function getConfListFiles($path)
    {
        return $this->getPathFiles($path);
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        // TODO
    }
}