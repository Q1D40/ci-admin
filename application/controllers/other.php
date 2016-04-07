<?php

/**
 * 杂项控制器
 */
class Other extends DH_Controller {

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Other_model', 'other');
        $this->load->model('Log_model', 'log');
        $this->load->helper('markdown');
    }

    /**
     * 设置TN
     */
    public function set_tn_map()
    {
        $this->checkPermission($this->userInfo['permission'], 'other_set_tn_map');

        $content = trim($this->input->post('content'));
        if(isset($_POST['content'])){
            $arr = explode("\n", $content);
            foreach($arr as $row){
                $tarr = explode("\t", $row);
                $data['cid']            = str_replace("\r", "", trim($tarr[0]));
                $data['tn']             = str_replace("\r", "", trim($tarr[1]));
                $data['purpose']        = str_replace("\r", "", trim($tarr[2]));
                $data['canalUserName']  = str_replace("\r", "", trim($tarr[3]));
                $data['edition']        = str_replace("\r", "", trim($tarr[4]));
                $data['url']            = str_replace("\r", "", trim($tarr[5]));
                $data['status']         = 0;
                $data['timeStamp']      = time();
                if($data['cid'] != '' && $data['tn'] != '')
                    $this->other->insertTnList($data);
            }
        }

        if(isset($_POST['cid'])){
            $data['cid']            = trim($this->input->post('cid'));
            $data['tn']             = trim($this->input->post('tn'));
            $data['purpose']        = trim($this->input->post('purpose'));
            $data['canalUserName']  = trim($this->input->post('canalUserName'));
            $data['edition']        = trim($this->input->post('edition'));
            $data['url']            = trim($this->input->post('url'));
            $data['timeStamp']      = time();
            if($this->input->post('status') == 'on')
            $data['status']         = 1;
            else
            $data['status']         = 0;
            if($this->input->post('netbarv') == 'on')
                $data['netbarv'] = 1;
            else
                $data['netbarv'] = 0;

            if($data['cid'] != '' && $data['tn'] != '')
                $this->other->insertTnList($data);
        }

        $data['userInfo'] = $this->userInfo;

        $data['tnList'] = $this->other->getTnList();

        $data['group'] = 'backstage';
        $data['menu'] = 'set_tn_map';
        $data['title'] = '设置TN对照表';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('other/set_tn_map', $data);
        $this->load->view('general/footer');
    }

    /**
     * 设置TN
     */
    public function set_tn_status($status, $cid)
    {
        $this->other->setTnStatus($status, $cid);
    }

    /**
     * 设置TN网吧版
     * @param $netbarv
     * @param $cid
     */
    public function set_tn_netbarv($netbarv, $cid)
    {
        $this->other->setTnNetvarv($netbarv, $cid);
    }

    /**
     * 删除TN
     */
    public function del_tn($cid)
    {
        $this->other->delTn($cid);
    }

    /**
     * 查看TN
     */
    public function show_tn_map()
    {
        $this->checkPermission($this->userInfo['permission'], 'other_show_tn_map');

        $tnList = $this->other->getTnList();
        $str = '渠道id|tn|用途|渠道用户名|使用版本|下载地址|添加时间';
        $str .= "\n";
        $str .= '-|-|-|-|-|-';
        $str .= "\n";
        foreach($tnList as $tn){
            $str .= $tn['cid'] . '|' . $tn['tn'] . '|' . $tn['purpose'] . '|' . $tn['canalUserName'] . '|' . $tn['edition'] . '|' . $tn['url'] . '|' . date("Y-m-d H:i:s", $tn['timeStamp']);
            $str .= "\n";
        }

        header("Content-type: text/html; charset=utf-8");

        echo '<style type="text/css">table{border-collapse: collapse; border: none;} td{border: solid #000 1px;}</style>';

        echo Markdown($str);
    }

    /**
     * 设置渠道控制
     */
    public function set_canal_control()
    {
        $this->checkPermission($this->userInfo['permission'], 'other_set_canal_control');

        $content = trim($this->input->post('content'));

        if(isset($_POST['content'])){
            $this->other->setCanalControl($content);
        }

        $data['userInfo'] = $this->userInfo;

        $tnMap = $this->other->getCanalControl();
        $data['content'] = $tnMap['content'];

        $data['group'] = 'backstage';
        $data['menu'] = 'set_canal_control';
        $data['title'] = '设置渠道控制';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('other/set_canal_control', $data);
        $this->load->view('general/footer');
    }

    /**
     * 获取升级
     */
    public function get_update()
    {
        $this->checkPermission($this->userInfo['permission'], 'other_get_update');

        if(is_array($this->input->post())){
            $data['f3'] = $this->input->post('f3');
            $data['timeStamp'] = time();
            $try = json_decode($data['f3'], true);
            if(is_array($try)){
                $this->other->setGeneralConf($data, 4);
                $data['success'] = '保存成功！配置将在一小时后生效~';
            }else{
                $data['error'] = 'JSON格式错误！！！';
            }
        }

        $data['conf4'] = $this->other->getGeneralConf(4);
        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'update';
        $data['menu'] = 'get_update';
        $data['title'] = '获取升级';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('other/get_update', $data);
        $this->load->view('general/footer');
    }

    /**
     * 通用日志类型
     */
    public function glog_type()
    {
        $this->checkPermission($this->userInfo['permission'], 'other_glog_type');

        if(is_array($this->input->post())){
            $data['f1'] = $this->input->post('f1');
            $data['timeStamp'] = time();
            $this->other->setGeneralConf($data, 2);
            $this->log->createTodayAndNextDayTable();
        }

        $data['conf'] = $this->other->getGeneralConf(2);
        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'cron';
        $data['menu'] = 'glog_type';
        $data['title'] = '日志类型';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('other/glog_type', $data);
        $this->load->view('general/footer');
    }

    /**
     * phpinfo()
     */
    public function phpinfo()
    {
        phpinfo();
    }

    /**
     * 新标签页Logo
     */
    public function newtab_logo()
    {
        $this->checkPermission($this->userInfo['permission'], 'other_newtab_logo');

        $dataPath = $this->config->item('data_path');
        $logPath = dirname(__FILE__) . $dataPath . 'update/install/newtabico/';

        $si = 0;
        $fi = 0;
        if(is_array($this->input->post())){
            if($this->input->post('search') != 'do'){
                $logoData = $this->getLogoData();
                $n = $this->input->post('n');
                for($i=0; $i<$n; $i++){
                    $furlName = "url" . ($i+1);
                    $flogoName = "logo" . ($i+1);
                    $fccu = "ccu" . ($i+1);
                    $url = $this->input->post($furlName);
                    $url = trim($url);
                    $ccu = $this->input->post($fccu);
                    if($ccu == 'on') $ccu = 1; else $ccu = 0;
                    if($url != ''){
                        if ($_FILES[$flogoName]["error"] > 0){
                            $fi++;
                        }else{
                            $fileName = php_uname('n') . time() . $i;
                            $pathinfo = pathinfo($_FILES[$flogoName]["name"]);
                            move_uploaded_file($_FILES[$flogoName]["tmp_name"], $logPath . $fileName . '.' . $pathinfo['extension']);
                            @chmod($logPath . $fileName ,0777);
                            $si++;
                            $logoData[$url]['logo'] = $fileName . '.' . $pathinfo['extension'];
                            $logoData[$url]['ccu'] = $ccu;
                        }
                    }
                }
            }
        }

        if($si > 0 || $fi > 0){
            $data['error'] = $si . "成功！" . $fi . "失败！";
            $this->setLogoData($logoData);
        }

        if($this->input->post('search') == 'do'){
            $searchUrl = $this->input->post('searchUrl');
            $data['logoData'] = $this->matchNewTabLogo($searchUrl);
            $data['searchUrl'] = $searchUrl;
        }else if($this->input->post('searchM') == 'do'){
            $searchUrl = $this->input->post('searchUrl');
            $data['logoData'] = $this->searchNewTabLogo($searchUrl);
            $data['searchUrl'] = $searchUrl;
        }else{
            $data['logoData'] = $this->getLogoData();
        }

        $data['userInfo'] = $this->userInfo;

        $data['icon_url'] = $this->config->item('download_install_url') . 'newtabico/';

        $data['group'] = 'update';
        $data['menu'] = 'newtab_logo';
        $data['title'] = '新标签页图标';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('other/newtab_logo', $data);
        $this->load->view('general/footer');
    }

    /**
     * 删除新标签页Logo
     */
    public function del_newtab_logo($url)
    {
        $url = base64_decode($url);
        $logoData = $this->getLogoData();
        unset($logoData[$url]);
        $this->setLogoData($logoData);
    }

    /**
     * 获取新标签页logo数据
     *
     * @return mixed
     */
    private function getLogoData()
    {
        $data = $this->other->getGeneralConf(3);
        return json_decode($data['f1'], true);
    }

    /**
     * 设置新标签页logo数据
     */
    private function setLogoData($logoData)
    {
        $data['f1'] = json_encode($logoData);
        $data['timeStamp'] = time();
        $this->other->setGeneralConf($data, 3);
    }

    /**
     * 匹配新标签页Logo
     */
    private function matchNewTabLogo($searchUrl)
    {
        $searchUrl = str_replace('http://', '', $searchUrl);
        $searchUrl = str_replace('https://', '', $searchUrl);
        $urlArr = explode('/', $searchUrl);
        $domain = $urlArr[0];
        $domainArr = explode('.', $domain);
        if($domainArr[0] == 'www')
            array_shift($domainArr);
        unset($urlArr[0]);
        $pathArr = $urlArr;

        $logoData = $this->getLogoData();
        foreach($logoData as $key => $row){
            $url = explode('/', $key);
            $logoDataP[$url[0]][$key] = $row;
        }

        $logo = '';
        $tDomainArr = $domainArr;
        for($i=0; $i<count($domainArr); $i++){
            if($i > 0)
                unset($tDomainArr[$i-1]);
            $findMe = implode('.', $tDomainArr);
            if($i > 0){
                if($logoDataP[$findMe][$findMe]['ccu'] == 1){
                    $ccu = 1;
                }else{
                    $ccu = 0;
                }
            }else{
                $ccu = 1;
            }
            if(array_key_exists($findMe, $logoDataP) && $ccu == 1){
                $rootDomain = $logoDataP[$findMe];
                if(array_key_exists($findMe, $rootDomain)){
                    $logo = array($findMe => $rootDomain[$findMe]);
                }
                foreach($pathArr as $subPath){
                    $findMe .= '/' . $subPath;
                    if(array_key_exists($findMe, $rootDomain)){
                        $logo = array($findMe => $rootDomain[$findMe]);
                    }
                }
                if($logo != '') break 1;
            }
        }
        return $logo;
    }

    /**
     * 搜索新标签页Logo
     */
    private function searchNewTabLogo($keyword)
    {
        $keyword = trim($keyword);
        $logoData = $this->getLogoData();
        foreach($logoData as $key => $row){
            $pos = strpos($key, $keyword);
            if ($pos === false) {
                unset($logoData[$key]);
            }
        }
        return $logoData;
    }

    /**
     * 新标签页广告
     */
    public function newtab_ads()
    {
        $this->checkPermission($this->userInfo['permission'], 'other_newtab_ads');

        $dataPath = $this->config->item('data_path');
        $picPath = dirname(__FILE__) . $dataPath . 'update/install/newtabads/';
        $picUrl = $this->config->item('download_install_url') . 'newtabads/';
        $type = trim($this->input->post('type')) + 0;
        if($type == 0) $type = 1;

        if($this->input->post('logo') == '1'){
            if($type == 1){
                $url = trim($this->input->post('url'));
                $title = trim($this->input->post('title'));
                $life = trim($this->input->post('life'));
                if($url != '' && $title != '' && $life != ''){
                    if ($_FILES["img"]["error"] > 0){
                        $data['error'] = "图片上传失败！";
                    }else{
                        $adData = $this->getAdData();
                        $lastId = $adData['f2'];
                        $adList = json_decode($adData['f1'], true);
                        $id = $lastId + 1;
                        $fileName = php_uname('n') . time();
                        $pathinfo = pathinfo($_FILES["img"]["name"]);
                        move_uploaded_file($_FILES["img"]["tmp_name"], $picPath . $fileName . '.' . $pathinfo['extension']);
                        @chmod($picPath . $fileName ,0777);
                        $adList[$id]['url'] = $url;
                        $adList[$id]['title'] = $title;
                        $adList[$id]['life'] = (int)$life;
                        $adList[$id]['id'] = (int)$id;
                        $adList[$id]['img'] = $picUrl . $fileName . '.' . $pathinfo['extension'];
                        $adList[$id]['type'] = (int)$type;
                        $adData['f1'] = $adList;
                        $adData['f2'] = $id;
                        $this->setAdData($adData);
                        $data['success'] = "添加成功！数据一小时后生效~~";
                    }
                }else{
                    $data['error'] = '添加失败！字段填写不完整！';
                }
            }
            if($type == 2){
                $url = trim($this->input->post('url'));
                $title = trim($this->input->post('title'));
                if($url != '' && $title != ''){
                    $adData = $this->getAdData();
                    $lastId = $adData['f2'];
                    $adList = json_decode($adData['f1'], true);
                    $id = $lastId + 1;
                    $adList[$id]['url'] = $url;
                    $adList[$id]['title'] = $title;
                    $adList[$id]['id'] = (int)$id;
                    $adList[$id]['type'] = (int)$type;
                    $adData['f1'] = $adList;
                    $adData['f2'] = $id;
                    $this->setAdData($adData);
                    $data['success'] = "添加成功！数据一小时后生效~~";
                }else{
                    $data['error'] = '添加失败！字段填写不完整！';
                }
            }
            if($type == 3){
                $pos = trim($this->input->post('pos'));
                if($pos != ''){
                    if ($_FILES["img"]["error"] > 0){
                        $data['error'] = "图片上传失败！";
                    }else{
                        $adData = $this->getAdData();
                        $lastId = $adData['f2'];
                        $adList = json_decode($adData['f1'], true);
                        $id = $lastId + 1;
                        $fileName = php_uname('n') . time();
                        $pathinfo = pathinfo($_FILES["img"]["name"]);
                        move_uploaded_file($_FILES["img"]["tmp_name"], $picPath . $fileName . '.' . $pathinfo['extension']);
                        @chmod($picPath . $fileName ,0777);
                        $adList[$id]['pos'] = (int)$pos;
                        $adList[$id]['id'] = (int)$id;
                        $adList[$id]['img'] = $picUrl . $fileName . '.' . $pathinfo['extension'];
                        $adList[$id]['type'] = (int)$type;
                        $adData['f1'] = $adList;
                        $adData['f2'] = $id;
                        $this->setAdData($adData);
                        $data['success'] = "添加成功！数据一小时后生效~~";
                    }
                }else{
                    $data['error'] = '添加失败！字段填写不完整！';
                }
            }
            if($type == 4){
                $url = trim($this->input->post('url'));
                $pos = trim($this->input->post('pos'));
                $x1 = trim($this->input->post('x1'));
                $y1 = trim($this->input->post('y1'));
                $x2 = trim($this->input->post('x2'));
                $y2 = trim($this->input->post('y2'));
                if($url != '' && $pos != '' && $x1 != '' && $y1 != '' && $x2 != '' && $y2 != ''){
                    if ($_FILES["img"]["error"] > 0){
                        $data['error'] = "图片上传失败！";
                    }else{
                        $adData = $this->getAdData();
                        $lastId = $adData['f2'];
                        $adList = json_decode($adData['f1'], true);
                        $id = $lastId + 1;
                        $fileName = php_uname('n') . time();
                        $pathinfo = pathinfo($_FILES["img"]["name"]);
                        move_uploaded_file($_FILES["img"]["tmp_name"], $picPath . $fileName . '.' . $pathinfo['extension']);
                        @chmod($picPath . $fileName ,0777);
                        $adList[$id]['url'] = $url;
                        $adList[$id]['pos'] = (int)$pos;
                        $adList[$id]['x1'] = (int)$x1;
                        $adList[$id]['y1'] = (int)$y1;
                        $adList[$id]['x2'] = (int)$x2;
                        $adList[$id]['y2'] = (int)$y2;
                        $adList[$id]['id'] = (int)$id;
                        $adList[$id]['img'] = $picUrl . $fileName . '.' . $pathinfo['extension'];
                        $adList[$id]['type'] = (int)$type;
                        $adData['f1'] = $adList;
                        $adData['f2'] = $id;
                        $this->setAdData($adData);
                        $data['success'] = "添加成功！数据一小时后生效~~";
                    }
                }else{
                    $data['error'] = '添加失败！字段填写不完整！';
                }
            }
        }

        if($this->input->post('setting') == '1'){
            $f3 = $this->input->post('f3');
            if(eval($f3) === false){
                $data['error'] = "保存失败！配置中有语法错误！！！";
            }else{
                $this->setAdData(array('f3' => $f3));
                $data['success'] = "配置成功！数据一小时后生效~~";
            }
        }

        $adData = $this->getAdData();
        $data['adList'] = json_decode($adData['f1'], true);
        $data['adSetting'] = $adData['f3'];

        $data['type'] = $type;

        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'update';
        $data['menu'] = 'newtab_ads';
        $data['title'] = '新标签页广告';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('other/newtab_ads', $data);
        $this->load->view('general/footer');
    }

    /**
     * 获取新标签页广告数据
     *
     * @return mixed
     */
    private function getAdData()
    {
        $data = $this->other->getGeneralConf(5);
        return $data;
    }

    /**
     * 设置新标签页广告数据
     */
    private function setAdData($adData)
    {
        if(isset($adData['f1']))
            $adData['f1'] = mysql_real_escape_string(json_encode($adData['f1']));
        if(isset($adData['f3']))
            $adData['f3'] = mysql_real_escape_string($adData['f3']);
        $adData['timeStamp'] = time();
        $this->other->setGeneralConf($adData, 5);
    }

    /**
     * 设置渠道过滤
     */
    public function set_canal_filter()
    {
        $this->checkPermission($this->userInfo['permission'], 'other_set_canal_filter');
        if(is_array($this->input->post())){
            $data['f1'] = mysql_real_escape_string($this->input->post('content'));
            $data['timeStamp'] = time();
            $this->other->setGeneralConf($data, 11);
            $data['success'] = "保存成功！";
        }
        $data['conf11'] = $this->other->getGeneralConf(11);
        $data['userInfo'] = $this->userInfo;
        $data['group'] = 'backstage';
        $data['menu'] = '';
        $data['title'] = '渠道过滤';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('other/set_canal_filter', $data);
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