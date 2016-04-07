<?php

/**
 * 崩溃信息控制器
 */
class Excpt extends DH_Controller {

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Excpt_model', 'excpt');
        $this->load->model('Log_model', 'log');
    }

	/**
     * 版本崩溃信息
	 */
	public function version_excpt_list()
	{
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');

        if($startDate == '' && $endDate == '')
            $endDate = date('Y-m-d', time());
        if($startDate > $endDate && $startDate != '' && $endDate != '')
            echo '<script>alertMsg.error("结束时间小于开始时间！")</script>';

        $versionExcptList = $this->excpt->getVersionExcptList($startDate, $endDate);

        $data['versionExcptList'] = $versionExcptList;
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
		$this->load->view('version_excpt_list', $data);
	}

    /**
     * IE版本崩溃信息
     */
    public function ie_version_excpt_list($appv)
    {
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $search = $this->input->post();

        if($startDate == '' && $endDate == ''){
            $endDate = date('Y-m-d', time());
            $search['endDate'] = $endDate;
        }
        if($startDate > $endDate && $startDate != '' && $endDate != '')
            echo '<script>alertMsg.error("结束时间小于开始时间！")</script>';

        $search['iev'] = urlencode($search['iev']);
        $search['osv'] = urlencode($search['osv']);
        $search['fv'] = urlencode($search['fv']);
        $search['appv'] = urlencode($search['appv']);
        $searchStr = http_build_query($search);
        $search['iev'] = urldecode($search['iev']);
        $search['osv'] = urldecode($search['osv']);
        $search['fv'] = urldecode($search['fv']);
        $search['appv'] = urldecode($search['appv']);
        $appv = explode('&', $appv);
        $appv = $appv[0];
        if($search['appv'] == '' && $appv != '') $search['appv'] = $appv;
        unset($search['startDate']);
        unset($search['endDate']);
        $search['iev'] = str_replace('，', ' ', str_replace('。', '.', $search['iev']));
        $search['osv'] = str_replace('，', ' ', str_replace('。', '.', $search['osv']));
        $search['fv'] = str_replace('，', ' ', str_replace('。', '.', $search['fv']));
        $search['appv'] = str_replace('，', ' ', str_replace('。', '.', $search['appv']));
        $ieVersionExcptList = $this->excpt->getIeVersionExcptList($startDate, $endDate, $search);

        $ievMap = $this->excpt->getIevMap();
        $osvMap = $this->excpt->getOsvMap();
        $fvMap = $this->excpt->getFvMap();
        $appvMap = $this->excpt->getAppvMap();
        $procTypeMap = $this->excpt->getProcTypeMap();
        $browserModeMap = $this->excpt->getBrowserModeMap();
        $threadStatusMap = $this->excpt->getThreadStatusMap();

        $data['search'] = $search;
        $data['searchStr'] = $searchStr;
        $data['ievMap'] = $ievMap;
        $data['osvMap'] = $osvMap;
        $data['fvMap'] = $fvMap;
        $data['appvMap'] = $appvMap;
        $data['procTypeMap'] = $procTypeMap;
        $data['browserModeMap'] = $browserModeMap;
        $data['threadStatusMap'] = $threadStatusMap;
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['ieVersionExcptList'] = $ieVersionExcptList;
        $this->load->view('ie_version_excpt_list', $data);
    }

    /**
     * dump列表
     */
    public function dump_list($iev, $searchStr)
    {
        parse_str($searchStr, $search);
        unset($search['_']);
        $search['iev'] = $iev;
        $search['osv'] = str_replace('，', ' ', str_replace('。', '.', $search['osv']));
        $search['fv'] = str_replace('，', ' ', str_replace('。', '.', $search['fv']));
        $search['appv'] = str_replace('，', ' ', str_replace('。', '.', $search['appv']));

        $data['dumpList'] = $this->excpt->getDumpList($search);

        $this->load->view('dump_list', $data);
    }

    /**
     * dump下载
     */
    public function down_dump($file)
    {
        $this->checkPermission($this->userInfo['permission'], 'excpt_down_dump');

        $dataPath = $this->config->item('dump_path');
        $file = $dataPath . 'dump/' . base64_decode($file);
        //$pathinfo = pathinfo($file);

        header("X-Sendfile: $file");
        header("Content-type: application/octet-stream");
        //header("Accept-Ranges: bytes");
        //header("Accept-Length: " . filesize($file));
        header("Content-Disposition: attachment; filename=" . basename($file));

        echo file_get_contents($file);
    }

    /**
     * 崩溃率
     */
    public function excpt_rate()
    {
        $this->checkPermission($this->userInfo['permission'], 'excpt_excpt_rate');

        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $ver = trim($this->input->post('ver'));
        $cid = trim($this->input->post('cid'));
        $act = trim($this->input->post('act'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '不区分渠道') $cid = 'group';
        if($vcid == '全部渠道') $cid = 'all';

        if($act == ''){
            $startDate = date('Y-m-d', time() - 86400*31);
            $endDate = date('Y-m-d', time() - 86400);
            $ver = 'group';
            $cid = 'group';
            $data['startDate'] = $endDate;
            $vcid = '不区分渠道';
        }else{
            $data['startDate'] = $startDate;
        }

        if($startDate == '' || $endDate == ''){
            $data['error'] = "起止日期都要填写！";
        }else{
            $data['excptRateList'] = $this->excpt->getExcptRate($startDate, $endDate, $ver, $cid);
        }

        $data['userInfo'] = $this->userInfo;

        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['endDate'] = $endDate;
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;

        $data['group'] = 'excpt';
        $data['menu'] = 'excpt_rate';
        $data['title'] = '崩溃率';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('excpt/excpt_rate', $data);
        $this->load->view('general/footer');
    }

    /**
     * 崩溃排名
     */
    public function excpt_rank()
    {
        $this->checkPermission($this->userInfo['permission'], 'excpt_excpt_rank');

        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $appv = trim($this->input->post('appv'));
        $cid = trim($this->input->post('cid'));
        $excptMD5 = trim($this->input->post('excptMD5'));
        $iev = trim($this->input->post('iev'));
        $osv = trim($this->input->post('osv'));
        $fv = trim($this->input->post('fv'));
        $viewType = trim($this->input->post('viewType'));
        $act = trim($this->input->post('act'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '不区分渠道') $cid = 'all';

        if($act == ''){
            $startDate = date('Y-m-d', time());
            $endDate = date('Y-m-d', time());
            $appv = 'all';
            $cid = 'all';
            $vcid = '不区分渠道';
            $viewType = 'excptMD5';
        }

        if($startDate == '' || $endDate == ''){
            $data['error'] = "起止日期都要填写！";
        }else{
            $data['excptRankList'] = $this->excpt->getExcptRank($startDate, $endDate, $appv, $cid, $excptMD5, $iev, $osv, $fv, $viewType);
        }

        $data['userInfo'] = $this->userInfo;

        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['appv'] = $appv;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;
        $data['excptMD5'] = $excptMD5;
        $data['iev'] = $iev;
        $data['osv'] = $osv;
        $data['fv'] = $fv;
        $data['viewType'] = $viewType;

        $data['group'] = 'excpt';
        $data['menu'] = 'excpt_rank';
        $data['title'] = '崩溃排名';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('excpt/excpt_rank', $data);
        $this->load->view('general/footer');
    }

    /**
     * 崩溃详情
     */
    public function excpt_detail()
    {
        $this->checkPermission($this->userInfo['permission'], 'excpt_excpt_detail');

        $search = $this->input->post();
        $startDate = trim($search['startDate']);
        $endDate = trim($search['endDate']);
        $act = trim($search['act']);
        $vcid = trim($search['cid']);
        unset($search['startDate']);
        unset($search['endDate']);
        unset($search['act']);

        if($search['cid'] == '不区分渠道') {
            $search['cid'] = 'all';
        }
        if($vcid == 'all') {
            $vcid = '不区分渠道';
        }

        if($act == ''){
            $startDate = date('Y-m-d', time());
            $endDate = date('Y-m-d', time());
            $search['appv'] = 'all';
            $cid = 'all';
            $search['cid'] = 'all';
            $vcid = '不区分渠道';
        }

        if($startDate == '' || $endDate == ''){
            $data['error'] = "起止日期都要填写！";
        }else{
            $data['excptLogList'] = $this->excpt->getExcptLog($startDate, $endDate, $search);
        }

        $data['userInfo'] = $this->userInfo;

        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['search'] = $search;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;

        $data['group'] = 'excpt';
        $data['menu'] = 'excpt_detail';
        $data['title'] = '崩溃详情';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('excpt/excpt_detail', $data);
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