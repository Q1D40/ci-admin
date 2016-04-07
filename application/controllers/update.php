<?php

/**
 * 升级控制器
 */
class Update extends DH_Controller {

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Update_model', 'update');
        $this->load->model('Other_model','other');
    }

    /**
     * 提交前先判断当前服务器是否存在该文件
     */
    public function judge_file()
    {
        $this->checkPermission($this->userInfo['permission'], 'update_conf_list');
        $dataPath = $this->config->item('data_path');
        $confPath = dirname(__FILE__) . $dataPath . 'update/install/';
        $code = trim($_POST['conf']);
        $pot = "/return\s'(.+)'/";
        $file = preg_match_all($pot,$code,$matches);
        $arrFile = array();
        foreach($matches[1] as $value){
            $reFile = explode('&',$value);
            $arrFile[] = $reFile[0];
        }
        $response['result'] = 1;
        foreach($arrFile as $value){
            $tfile = $value . '.exe';
            if(!is_file($confPath . $tfile)){
                $response['result'] = 0;
                if(!in_array($tfile,$response['file']))
                      $response['file'][] = $tfile;
            }
        }
        echo json_encode($response);
    }

    /**
     * 配置文件列表
     */
    public function conf_list()
    {
        $this->checkPermission($this->userInfo['permission'], 'update_conf_list');

        $dataPath = $this->config->item('data_path');
        $confPath = dirname(__FILE__) . $dataPath . 'update/conf/';

        if(isset($_POST['conf'])){
            $this->checkPermission($this->userInfo['permission'], 'update_conf_add');

            $code = trim($_POST['conf']);
			if(eval($code) !== false){
				$conf = file_get_contents($confPath . 'default_conf.inc');
				$conf = str_replace('code_rep', $code, $conf);
				$id = $this->update->addConf($code);
				file_put_contents($confPath . 'conf' . $id . '.inc', $conf);
				@chmod($confPath . 'conf' . $id . '.inc', 0777);
				$data['sucMsg'] = "提交成功！";
			}else{
				$data['errMsg'] = "此段程序代码有错误，请检查！";
			}
        }
        $data['userInfo'] = $this->userInfo;

        $data['confList'] = $this->getConfFiles($confPath);
        krsort($data['confList']);
        $data['currentConf'] = current($data['confList']);

        $data['group'] = 'update';
        $data['menu'] = 'update_install';
        $data['title'] = '安装包配置';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('update/conf_list', $data);
        $this->load->view('general/footer');
    }

    /**
     * 配置文件添加
     */
    public function conf_add()
    {
        $lastConf = $this->update->getLastConf();
        $data['preConf'] = $lastConf['code'];

        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'update';
        $data['menu'] = 'update_install';
        $data['title'] = '安装包配置修改';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('update/conf_add', $data);
        $this->load->view('general/footer');
    }

    /**
     * 配置文件查看
     */
    public function conf_view($fileName)
    {
        $dataPath = $this->config->item('data_path');
        $confPath = dirname(__FILE__) . $dataPath . 'update/conf/';
        header("Content-type:text/html;charset=utf-8");
        highlight_file($confPath . base64_decode($fileName));
    }

    /**
     * 升级条件查看
     */
    public function code_view($fileName)
    {
        $fileName = base64_decode($fileName);
        $baseName = basename($fileName, '.inc');
        $id = str_replace('conf', '', $baseName);
        $conf = $this->update->getConfById($id);
        header("Content-type:text/html;charset=utf-8");
        highlight_string($conf['code']);
    }

    /**
     * md5查看
     */
    public function md5_view($fileName)
    {
        $fileName = base64_decode($fileName);
        $baseName = basename($fileName, ".exe");
        $dataPath = $this->config->item('data_path');
        $md5Path = dirname(__FILE__) . $dataPath . 'update/md5/';
        echo file_get_contents($md5Path . $baseName . '.md5');
    }

    /**
     * 安装包上传
     */
    public function upload()
    {
        $dataPath = $this->config->item('data_path');
        $updatePath = dirname(__FILE__) . $dataPath . 'update/install/';
        $md5Path = dirname(__FILE__) . $dataPath . 'update/md5/';

        if($this->input->post('submit') == '上传'){
        $this->checkPermission($this->userInfo['permission'], 'update_upload');
        if ($_FILES["file"]["error"] > 0){
            $data['error'] = "上传失败！错误代码" . $_FILES["file"]["error"];
        }else{
            move_uploaded_file($_FILES["file"]["tmp_name"], $updatePath . $_FILES["file"]["name"]);
            @chmod($updatePath . $_FILES["file"]["name"] ,0777);
            $md5 = md5_file($updatePath . $_FILES["file"]["name"]);
            $baseName = basename($_FILES["file"]["name"], ".exe");
            file_put_contents($md5Path . $baseName . '.md5', $md5);
            @chmod($md5Path . $baseName . '.md5', 0777);
            $data['error'] = $_FILES["file"]["name"] . "上传完成！下载地址 " . $this->config->item('download_install_url') . $_FILES["file"]["name"];
        }}

        $data['userInfo'] = $this->userInfo;

        $data['updateList'] = $this->getInstallFiles($updatePath);
        rsort($data['updateList'], SORT_STRING);

        $data['download_install_url'] = $this->config->item('download_install_url');

        $data['group'] = 'update';
        $data['menu'] = 'update_install';
        $data['title'] = '安装包上传';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('update/upload', $data);
        $this->load->view('general/footer');
    }

    /**
     * 跳转页配置
     */
    public function go_page()
    {
        $this->checkPermission($this->userInfo['permission'], 'update_go_page');

        if(is_array($this->input->post())){
            $code = $this->input->post('code');
            if(eval($code) !== false){
                $this->setGoPage($code);
                $data['sucMsg'] = "提交成功！配置将在一小时后生效~";
            }else{
                $data['errMsg'] = "此段程序代码有错误，请检查！";
            }
        }
        $data['code'] = $this->getGoPage();
        $data['userInfo'] = $this->userInfo;
        $data['group'] = 'update';
        $data['menu'] = 'go_page';
        $data['title'] = '跳转页配置';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('update/gopage_add', $data);
        $this->load->view('general/footer');
    }

    /**
     * 设置跳转配置
     */
    private function setGoPage($code)
    {
        $data['f1'] = mysql_real_escape_string($code);
        $data['timeStamp'] = time();
        $this->other->setGeneralConf($data,6);
    }

    /**
     * 获取跳转设置
     */
    private function getGoPage()
    {
        $data = $this->other->getGeneralConf(6);
        return $data['f1'];
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
     * 获取安装包目录所有文件
     */
    private function getInstallFiles($path)
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