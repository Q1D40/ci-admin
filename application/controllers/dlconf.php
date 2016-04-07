<?php

/**
 * 下载配置控制器
 */
class Dlconf extends DH_Controller {

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Update_model', 'update');
    }

    /**
     * 提交前先检验本台服务器上是否存在文件
     */
    public function judge_file()
    {
        $this->checkPermission($this->userInfo['permission'], 'dlconf_conf_list');
        $conf = trim($_POST['conf']);
        $arrConf = json_decode($conf,true);
        $dataPath = $this->config->item('data_path');
        $confPath = dirname(__FILE__) . $dataPath . 'update/install/';
        $response['result'] = 1;
        foreach($arrConf as $value){
            $tfile = $value['file'];
            $tbfile = $value['backup']['file'];
            if(!is_file($confPath . $tfile)){
                $response['result'] = 0;
                if(!in_array($tfile, $response['file']))
                    $response['file'][] = $tfile;
            }
            if(!is_file($confPath . $tbfile) && isset($value['backup'])){
                $response['result'] = 0;
                if(!in_array($tbfile, $response['file']))
                    $response['file'][] = $tbfile;
            }
            if(is_array($value['cid'])){
                foreach($value['cid'] as $v){
                    $tfile = $v['file'];
                    $tbfile = $v['backup']['file'];
                    if(!is_file($confPath . $tfile)){
                        $response['result'] = 0;
                        if(!in_array($tfile, $response['file']))
                            $response['file'][] = $tfile;
                    }
                    if(!is_file($confPath . $tbfile) && isset($v['backup'])){
                        $response['result'] = 0;
                        if(!in_array($tbfile, $response['file']))
                            $response['file'][] = $tbfile;
                    }
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
        $this->checkPermission($this->userInfo['permission'], 'dlconf_conf_list');

        $dataPath = $this->config->item('data_path');
        $confPath = dirname(__FILE__) . $dataPath . 'update/dlconf/';
        if(isset($_POST['conf'])){
            $this->checkPermission($this->userInfo['permission'], 'dlconf_conf_add');
            $code = trim($_POST['conf']);
			if(!is_array(json_decode($code,true))){
				$data['errMsg'] ="数据不是json格式，不能提交";
			}else{
            $id = $this->update->addDlConf($code);
            file_put_contents($confPath . 'conf' . $id . '.inc', $code);
            @chmod($confPath . 'conf' . $id . '.inc', 0777);
			$data['sucMsg'] = "提交成功！";
			}
        }
        $data['userInfo'] = $this->userInfo;

        $data['confList'] = $this->getConfFiles($confPath);
        krsort($data['confList']);
        $data['currentConf'] = current($data['confList']);

        $data['group'] = 'update';
        $data['menu'] = 'update_dlconf';
        $data['title'] = '下载配置';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('dlconf/conf_list', $data);
        $this->load->view('general/footer');
    }

    /**
     * 配置文件添加
     */
    public function conf_add()
    {
        $lastConf = $this->update->getLastDlConf();
        $data['preConf'] = $lastConf['code'];

        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'update';
        $data['menu'] = 'update_dlconf';
        $data['title'] = '下载配置';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('dlconf/conf_add', $data);
        $this->load->view('general/footer');
    }

    /**
     * 配置文件查看
     */
    public function conf_view($fileName)
    {
        $dataPath = $this->config->item('data_path');
        $confPath = dirname(__FILE__) . $dataPath . 'update/dlconf/';
        highlight_file($confPath . base64_decode($fileName));
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