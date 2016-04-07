<?php

/**
 * 日志控制器
 */
class Log extends DH_Controller {

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Log_model', 'log');
        $this->load->model('Other_model', 'other');
        $this->load->library('Pageclass');
        $this->load->library('Utilityclass');
    }

    /**
     * 用户量
     */
    public function users()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_users');

        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $ver = trim($this->input->post('ver'));
        $cid = trim($this->input->post('cid'));
        $act = trim($this->input->post('act'));
        $sel = trim($this->input->post('sel'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '不区分渠道') $cid = 'group';
        if($vcid == '全部渠道') $cid = 'all';

        if($act == ''){
            $startDate = date('Y-m-d', time() - 86400*31);
            $endDate = date('Y-m-d', time() - 86400);
            $ver = 'group';
            $cid = 'group';
            $sel = 'gtTen';
            $data['startDate'] = $endDate;
            $vcid = '不区分渠道';
        }else{
            $data['startDate'] = $startDate;
        }

        if($startDate == '' || $endDate == ''){
            $data['error'] = "起止日期都要填写！";
        }else{
            $data['usersList'] = $this->log->getUsersList($startDate, $endDate, $ver, $cid);
            if($this->input->post('act') == 'export')
                $this->usersExport($data['usersList'], $ver, $cid);
        }

        $data['userInfo'] = $this->userInfo;

        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['endDate'] = $endDate;
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;
        $data['sel'] = $sel;

        $data['group'] = 'user';
        $data['menu'] = 'users';
        $data['title'] = '用户量';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/users', $data);
        $this->load->view('general/footer');
    }

    /**
     *  用户量(umid)
     */
    public function umid_users()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_umid_users');

        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $ver = trim($this->input->post('ver'));
        $cid = trim($this->input->post('cid'));
        $act = trim($this->input->post('act'));
        $sel = trim($this->input->post('sel'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '不区分渠道') $cid = 'group';
        if($vcid == '全部渠道') $cid = 'all';

        if($act == ''){
            $startDate = date('Y-m-d', time() - 86400*31);
            $endDate = date('Y-m-d', time() - 86400);
            $ver = 'group';
            $cid = 'group';
            $sel = 'gtTen';
            $data['startDate'] = $endDate;
            $vcid = '不区分渠道';
        }else{
            $data['startDate'] = $startDate;
        }

        if($startDate == '' || $endDate == ''){
            $data['error'] = "起止日期都要填写！";
        }else{
            $data['usersList'] = $this->log->getUmidUsersList($startDate, $endDate, $ver, $cid);
            if($this->input->post('act') == 'export')
                $this->usersExport($data['usersList'], $ver, $cid);
        }

        $data['userInfo'] = $this->userInfo;

        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['endDate'] = $endDate;
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;
        $data['sel'] = $sel;

        $data['group'] = 'user';
        $data['menu'] = 'users';
        $data['title'] = '用户量(umid)';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/umid_users', $data);
        $this->load->view('general/footer');
    }

    /**
     * 用户量导出
     *
     * @param array $data 原数据
     * @param string $ver 版本选择
     * @param string $cid 渠道选择
     */
    private function usersExport($data, $ver, $cid)
    {
        $outData['title'][] = "日期";
        if($ver != 'group')
        $outData['title'][] = "版本号";
        if($cid != 'group')
        $outData['title'][] = "渠道";
        $outData['title'][] = "安装量";
        $outData['title'][] = "新安装量";
        $outData['title'][] = "累计新安装量";
        $outData['title'][] = "卸载量";
        $outData['title'][] = "累计卸载量";
        $outData['title'][] = "卸载率";
        $outData['title'][] = "流失率";
        $outData['title'][] = "自动升级";
        $outData['title'][] = "覆盖安装";
        $outData['title'][] = "累计留存";
        $outData['title'][] = "日活跃用户";
        $outData['title'][] = "首次激活用户";
        $outData['title'][] = "周活跃用户";
        $outData['title'][] = "日报活次数";
        $outData['title'][] = "激活率";
        $outData['title'][] = "默认率";
        $outData['title'][] = "增长率";
        foreach($data as $row){
            $trow = array();
            $trow[] = $row['date'];
            if($ver != 'group')
            $trow[] = $row['ver'];
            if($cid != 'group')
            $trow[] = $row['cid'];
            $trow[] = $row['install'];
            $trow[] = $row['newInstall'];
            $trow[] = $row['allNewInstall'];
            $trow[] = $row['unInstall'];
            $trow[] = $row['allUnInstall'];
            $trow[] = round($row['unInstall']/$row['dayActiveUser'], 4)*100 . '%';
            $trow[] = round($row['unInstall']/$row['newInstall'], 4)*100 . '%';
            $trow[] = $row['autoUpdate'];
            $trow[] = $row['coverInstall'];
            $trow[] = $row['allKeep'];
            $trow[] = $row['dayActiveUser'];
            $trow[] = $row['firstActiveUser'];
            $trow[] = $row['weekActiveUser'];
            $trow[] = $row['dayPostActive'];
            $trow[] = round($row['weekActiveUser']/$row['allKeep'], 4)*100 . '%';
            $trow[] = round($row['defaultBrowser']/$row['dayPostActive'], 4)*100 . '%';
            $trow[] = round(($row['dayActiveUser'] - $row['yesterdayActiveUser'])/$row['yesterdayActiveUser'], 4)*100 . '%';
            $outData['list'][] = $trow;
        }
        Utilityclass::exportExcel($outData);
    }

    /**
     * 留存率
     */
    public function keep_rate()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_keep_rate');

        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $cid = trim($this->input->post('cid'));
        $act = trim($this->input->post('act'));
        $sel = trim($this->input->post('sel'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '不区分渠道') $cid = 'group';
        if($vcid == '全部渠道') $cid = 'all';

        if($act == ''){
            $startDate = date('Y-m-d', time() - 86400*32);
            $endDate = date('Y-m-d', time() - 86400);
            $cid = 'group';
            $sel = 'gtTen';
            $vcid = '不区分渠道';
        }

        if($startDate == '' || $endDate == ''){
            $data['error'] = "起止日期都要填写！";
        }else{
            $data['keepRateList'] = $this->log->getKeepRateList($startDate, $endDate, $cid, $sel);
            if($this->input->post('act') == 'export')
                $this->keepRateExport($data['keepRateList'], $cid);
        }

        $data['userInfo'] = $this->userInfo;

        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['cid'] = $cid;
        $data['sel'] = $sel;
        $data['vcid'] = $vcid;

        $data['group'] = 'user';
        $data['menu'] = 'keep_rate';
        $data['title'] = '留存率';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/keep_rate', $data);
        $this->load->view('general/footer');
    }

    /**
     * 留存率(umid)
     */
    public function umid_keep_rate()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_umid_keep_rate');

        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $cid = trim($this->input->post('cid'));
        $act = trim($this->input->post('act'));
        $sel = trim($this->input->post('sel'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '不区分渠道') $cid = 'group';
        if($vcid == '全部渠道') $cid = 'all';

        if($act == ''){
            $startDate = date('Y-m-d', time() - 86400*32);
            $endDate = date('Y-m-d', time() - 86400);
            $cid = 'group';
            $sel = 'gtTen';
            $vcid = '不区分渠道';
        }

        if($startDate == '' || $endDate == ''){
            $data['error'] = "起止日期都要填写！";
        }else{
            $data['keepRateList'] = $this->log->getUmidKeepRateList($startDate, $endDate, $cid);
            if($this->input->post('act') == 'export')
                $this->keepRateExport($data['keepRateList'], $cid);
        }

        $data['userInfo'] = $this->userInfo;

        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['cid'] = $cid;
        $data['sel'] = $sel;
        $data['vcid'] = $vcid;

        $data['group'] = 'user';
        $data['menu'] = 'keep_rate';
        $data['title'] = '留存率(umid)';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/umid_keep_rate', $data);
        $this->load->view('general/footer');
    }

    /**
     * 留存率导出
     *
     * @param array $data 原数据
     * @param string $cid 渠道选择
     */
    private function keepRateExport($data, $cid)
    {
        $outData['title'][] = "日期";
        if($cid != 'group')
            $outData['title'][] = "渠道";
        for($i=1; $i<=31; $i++){
            $outData['title'][] = "day$i";
        }

        foreach($data as $row){
            $trow = array();
            $trow[] = $row['date'];
            if($cid != 'group')
                $trow[] = $row['cid'];
            for($i=1; $i<=31; $i++){
                $trow[] = round($row['day' . $i . 'Keep']/$row['newInstall'], 4)*100 . '%';
            }
            $outData['list'][] = $trow;
        }
        Utilityclass::exportExcel($outData);
    }

    /**
     * 成功率
     */
    public function success_rate()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_success_rate');

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
            $data['successRateList'] = $this->log->getSuccessRateList($startDate, $endDate, $ver, $cid);
            if($this->input->post('act') == 'export')
                $this->successRateExport($data['successRateList'], $ver, $cid);
        }

        $data['userInfo'] = $this->userInfo;

        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['endDate'] = $endDate;
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;

        $data['group'] = 'install';
        $data['menu'] = 'success_rate';
        $data['title'] = '成功率';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/success_rate', $data);
        $this->load->view('general/footer');
    }

    /**
     * 成功率导出
     *
     * @param array $data 原数据
     * @param string $ver 版本选择
     * @param string $cid 渠道选择
     */
    private function successRateExport($data, $ver, $cid)
    {
        $outData['title'][] = "日期";
        if($ver != 'group')
            $outData['title'][] = "版本号";
        if($cid != 'group')
            $outData['title'][] = "渠道";
        $outData['title'][] = "新安装成功";
        $outData['title'][] = "新安装失败";
        $outData['title'][] = "新安装成功率";
        $outData['title'][] = "覆盖安装成功";
        $outData['title'][] = "覆盖安装失败";
        $outData['title'][] = "覆盖安装成功率";
        $outData['title'][] = "升级成功";
        $outData['title'][] = "升级失败";
        $outData['title'][] = "升级成功率";
        $outData['title'][] = "卸载成功";
        $outData['title'][] = "卸载失败";
        $outData['title'][] = "卸载成功率";
        foreach($data as $row){
            $trow = array();
            $trow[] = $row['date'];
            if($ver != 'group')
                $trow[] = $row['ver'];
            if($cid != 'group')
                $trow[] = $row['cid'];
            $trow[] = $row['newInstallSuccess'];
            $trow[] = $row['newInstallFailed'];
            $trow[] = round($row['newInstallSuccess']/($row['newInstallSuccess'] + $row['newInstallFailed']), 4)*100 . '%';
            $trow[] = $row['coverInstallSuccess'];
            $trow[] = $row['coverInstallFailed'];
            $trow[] = round($row['coverInstallSuccess']/($row['coverInstallSuccess'] + $row['coverInstallFailed']), 4)*100 . '%';
            $trow[] = $row['updateSuccess'];
            $trow[] = $row['updateFailed'];
            $trow[] = round($row['updateSuccess']/($row['updateSuccess'] + $row['updateFailed']), 4)*100 . '%';
            $trow[] = $row['unInstallSuccess'];
            $trow[] = $row['unInstallFailed'];
            $trow[] = round($row['unInstallSuccess']/($row['unInstallSuccess'] + $row['unInstallFailed']), 4)*100 . '%';
            $outData['list'][] = $trow;
        }
        Utilityclass::exportExcel($outData);
    }

    /**
     * 错误码
     */
    public function error_code()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_error');

        $date = trim($this->input->post('date'));
        $cid = trim($this->input->post('cid'));
        $ver = trim($this->input->post('ver'));
        $type = trim($this->input->post('type'));
        $result = trim($this->input->post('result'));
        $errorCode = trim($this->input->post('errorCode'));
        $act = trim($this->input->post('act'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '不区分渠道') $cid = 'group';
        if($vcid == '全部渠道') $cid = 'all';

        if($act == ''){
            $date = date('Y-m-d', time() - 86400);
            $cid = 'group';
            $ver = 'group';
            $type = 'group';
            $result = 'group';
            $vcid = '不区分渠道';
        }

        $errorCodeList = $this->log->getErrorCodeList(strval($date), strval($cid), strval($ver), strval($type), strval($result), strval($errorCode));
        $data['errorCodeList'] = $errorCodeList['data'];
        $data['allNumber'] = $errorCodeList['allNumber'];

        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();

        $data['typeMap'] = array('newInstall' => '全新安装', 'coverInstall' => '覆盖安装', 'update' => '升级', 'unInstall' => '卸载');
        $data['resultMap'] = array('0' => '失败', '1' => '成功');

        if($this->input->post('act') == 'export')
            $this->errorCodeExport($errorCodeList, $ver, $cid, $type, $result, $data['typeMap'], $data['resultMap']);

        $data['date'] = $date;
        $data['cid'] = $cid;
        $data['ver'] = $ver;
        $data['type'] = $type;
        $data['result'] = $result;
        $data['errorCode'] = $errorCode;
        $data['vcid'] = $vcid;

        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'install';
        $data['menu'] = 'error';
        $data['title'] = '错误码';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/error_code', $data);
        $this->load->view('general/footer');
    }

    /**
     * 成功率导出
     *
     * @param array $data 原数据
     * @param string $ver 版本选择
     * @param string $cid 渠道选择
     * @param string $type 类型
     * @param string $result 结果
     * @param array $typeMap 类型字典
     * @param array $resultMap 结果字典
     */
    private function errorCodeExport($data, $ver, $cid, $type, $result, $typeMap, $resultMap)
    {
        $outData['title'][] = "日期";
        if($cid != 'group')
            $outData['title'][] = "渠道";
        if($ver != 'group')
            $outData['title'][] = "版本号";
        if($type != 'group')
            $outData['title'][] = "类型";
        if(strval($result) != 'group')
            $outData['title'][] = "结果";
        $outData['title'][] = "新安装成功";
        $outData['title'][] = "新安装失败";
        $outData['title'][] = "新安装成功率";
        foreach($data['data'] as $row){
            $trow = array();
            $trow[] = $row['date'];
            if($cid != 'group')
                $trow[] = $row['cid'];
            if($ver != 'group')
                $trow[] = $row['ver'];
            if($type != 'group')
                $trow[] = $typeMap[$row['type']];
            if(strval($result) != 'group')
                $trow[] = $resultMap[$row['result']];
            $trow[] = $row['errorCode'];
            $trow[] = $row['number'];
            $trow[] = round(($row['number']/$data['allNumber']), 4)*100 . '%';
            $outData['list'][] = $trow;
        }
        Utilityclass::exportExcel($outData);
    }

    /**
     * 卸载原因
     */
    public function uninstall_reason()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_uninstall_reason');

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
            $data['uninstallReasonList'] = $this->log->getUninstallReason($startDate, $endDate, $ver, $cid);
            if($this->input->post('act') == 'export')
                $this->uninstallReasonExport($data['uninstallReasonList'], $ver, $cid);
        }

        $data['userInfo'] = $this->userInfo;

        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['endDate'] = $endDate;
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;

        $data['group'] = 'uninstall';
        $data['menu'] = 'uninstall_reason';
        $data['title'] = '卸载原因';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/uninstall_reason', $data);
        $this->load->view('general/footer');
    }

    /**
     * 卸载原因导出
     *
     * @param array $data 原数据
     * @param string $ver 版本选择
     * @param string $cid 渠道选择
     */
    private function uninstallReasonExport($data, $ver, $cid)
    {
        $outData['title'][] = "日期";
        if($ver != 'group')
            $outData['title'][] = "版本号";
        if($cid != 'group')
            $outData['title'][] = "渠道";
        $outData['title'][] = "原因1数量(经常崩溃、卡住或网页无法显示)";
        $outData['title'][] = "占比";
        $outData['title'][] = "原因2数量(经常显示错乱或白屏，操作一下就好了)";
        $outData['title'][] = "占比";
        $outData['title'][] = "原因3数量(某些网页始终错乱或功能不正常)";
        $outData['title'][] = "占比";
        $outData['title'][] = "原因4数量(浏览器反应慢，用起来不流畅)";
        $outData['title'][] = "占比";
        $outData['title'][] = "原因5数量(缺少我要的功能)";
        $outData['title'][] = "占比";
        $outData['title'][] = "原因6数量(外观用着不习惯)";
        $outData['title'][] = "占比";
        $outData['title'][] = "原因7数量(打开网页慢)";
        $outData['title'][] = "占比";
        $outData['title'][] = "原因8数量(其他)";
        $outData['title'][] = "占比";
        foreach($data as $row){
            $trow = array();
            $trow[] = $row['date'];
            if($ver != 'group')
                $trow[] = $row['ver'];
            if($cid != 'group')
                $trow[] = $row['cid'];
            $trow[] = $row['r1'];
            $trow[] = round($row['r1']/$row['all'], 4)*100 . '%';
            $trow[] = $row['r2'];
            $trow[] = round($row['r2']/$row['all'], 4)*100 . '%';
            $trow[] = $row['r3'];
            $trow[] = round($row['r3']/$row['all'], 4)*100 . '%';
            $trow[] = $row['r4'];
            $trow[] = round($row['r4']/$row['all'], 4)*100 . '%';
            $trow[] = $row['r5'];
            $trow[] = round($row['r5']/$row['all'], 4)*100 . '%';
            $trow[] = $row['r6'];
            $trow[] = round($row['r6']/$row['all'], 4)*100 . '%';
            $trow[] = $row['r7'];
            $trow[] = round($row['r7']/$row['all'], 4)*100 . '%';
            $trow[] = $row['r8'];
            $trow[] = round($row['r8']/$row['all'], 4)*100 . '%';
            $outData['list'][] = $trow;
        }
        Utilityclass::exportExcel($outData);
    }

    /**
     * 卸载详情
     */
    public function uninstall_detail()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_uninstall_detail');

        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $ver = trim($this->input->post('ver'));
        $cid = trim($this->input->post('cid'));
        $ud = trim($this->input->post('ud'));
        $act = trim($this->input->post('act'));
        $page = trim($this->input->post('page'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '不区分渠道') $cid = 'all';

        if($act == ''){
            $startDate = date('Y-m-d', time() - 86400*15);
            $endDate = date('Y-m-d', time() - 86400);
            $ver = 'all';
            $cid = 'all';
            $vcid = '不区分渠道';
        }

        if($startDate == '' || $endDate == ''){
            $data['error'] = "起止日期都要填写！";
        }else{
            $count = $this->log->getUninstallDetailCount($startDate, $endDate, $ver, $cid, $ud);
            $perPage = 100;
            $allPage = ceil($count / $perPage);
            if($page > $allPage) $page = $allPage;
            if($page <= 0) $page = 1;
            $start = $perPage * ($page - 1);

            $data['page'] = $this->pageclass->getPage($page, $allPage);
            $data['uninstallDetailList'] = $this->log->getUninstallDetail($startDate, $endDate, $ver, $cid, $ud, $start, $perPage);
            $data['count'] = $count;
            $data['allPage'] = $allPage;

            if($this->input->post('act') == 'export')
                $this->uninstallDetailExport($this->log->getUninstallDetailNoPage($startDate, $endDate, $ver, $cid, $ud));
        }

        $data['userInfo'] = $this->userInfo;

        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;
        $data['ud'] = $ud;

        $data['group'] = 'uninstall';
        $data['menu'] = 'uninstall_detail';
        $data['title'] = '卸载详情';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/uninstall_detail', $data);
        $this->load->view('general/footer');
    }

    /**
     * 卸载详情导出
     *
     * @param array $data 原数据
     */
    private function uninstallDetailExport($data)
    {
        $outData['title'][] = "日期";
        $outData['title'][] = "版本号";
        $outData['title'][] = "渠道";
        $outData['title'][] = "卸载详情";
        $outData['title'][] = "联系方式";
        foreach($data as $row){
            $trow = array();
            $trow[] = date('Y-m-d H:i:s', $row['timeStamp']);
            $trow[] = $row['ver'];
            $trow[] = $row['cid'];
            $trow[] = $row['ud'];
            $trow[] = $row['uc'];
            $outData['list'][] = $trow;
        }
        Utilityclass::exportExcel($outData);
    }

    /**
     * 卸载详情源数据
     */
    public function uninstall_detail_sdata($date, $sid)
    {
        $this->checkPermission($this->userInfo['permission'], 'log_uninstall_detail');

        $data = $this->log->getUninstallDetailSdata($date, $sid);

        header("Content-type: text/html; charset=utf-8");

        foreach($data as $key => $row){
            echo $key . '&nbsp;&nbsp;=>&nbsp;&nbsp;' . $row . '<br/>';
        }
    }

    /**
     * 意见反馈
     */
    public function feedback_detail()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_feedback_detail');

        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $ver = trim($this->input->post('ver'));
        $cid = trim($this->input->post('cid'));
        $ud = trim($this->input->post('ud'));
        $act = trim($this->input->post('act'));
        $page = trim($this->input->post('page'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '不区分渠道') $cid = 'all';

        if($act == ''){
            $startDate = date('Y-m-d', time() - 86400*15);
            $endDate = date('Y-m-d', time() - 86400);
            $ver = 'all';
            $cid = 'all';
            $vcid = '不区分渠道';
        }

        if($startDate == '' || $endDate == ''){
            $data['error'] = "起止日期都要填写！";
        }else{
            $count = $this->log->getFeedbackDetailCount($startDate, $endDate, $ver, $cid, $ud);
            $perPage = 100;
            $allPage = ceil($count / $perPage);
            if($page > $allPage) $page = $allPage;
            if($page <= 0) $page = 1;
            $start = $perPage * ($page - 1);

            $data['page'] = $this->pageclass->getPage($page, $allPage);
            $data['feedbackDetailList'] = $this->log->getFeedbackDetail($startDate, $endDate, $ver, $cid, $ud, $start, $perPage);
            $data['count'] = $count;
            $data['allPage'] = $allPage;

            if($this->input->post('act') == 'export')
                $this->feedbackDetailExport($this->log->getFeedbackDetailNoPage($startDate, $endDate, $ver, $cid, $ud));
        }

        $data['userInfo'] = $this->userInfo;

        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;
        $data['ud'] = $ud;

        $data['group'] = 'uninstall';
        $data['menu'] = 'uninstall_detail';
        $data['title'] = '意见反馈';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/feedback_detail', $data);
        $this->load->view('general/footer');
    }

    /**
     * 意见反馈导出
     *
     * @param array $data 原数据
     */
    private function feedbackDetailExport($data)
    {
        $outData['title'][] = "日期";
        $outData['title'][] = "版本号";
        $outData['title'][] = "渠道";
        $outData['title'][] = "详情";
        $outData['title'][] = "联系方式";
        foreach($data as $row){
            $trow = array();
            $trow[] = date('Y-m-d H:i:s', $row['timeStamp']);
            $trow[] = $row['ver'];
            $trow[] = $row['cid'];
            $trow[] = $row['ud'];
            $trow[] = $row['uc'];
            $outData['list'][] = $trow;
        }
        Utilityclass::exportExcel($outData);
    }

    /**
     * 意见反馈源数据
     */
    public function feedback_detail_sdata($date, $sid)
    {
        $this->checkPermission($this->userInfo['permission'], 'log_uninstall_detail');

        $data = $this->log->getFeedbackDetailSdata($date, $sid);

        header("Content-type: text/html; charset=utf-8");

        foreach($data as $key => $row){
            echo $key . '&nbsp;&nbsp;=>&nbsp;&nbsp;' . $row . '<br/>';
        }
    }

    /**
     * 实时日活跃用户
     */
    /*
    public function now_day_active()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_now_day_active');

        $data['nowDayActive'] = $this->log->getNowDayActive();

        $data['title'] = '实时日活跃用户';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/now_day_active', $data);
        $this->load->view('general/footer');
    }
    */

    /**
     * 渠道数据
     */
    public function canal_data()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_canal_data');

        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $cid = trim($this->input->post('cid'));
        $vcid = trim($this->input->post('cid'));
        $act = trim($this->input->post('act'));

        if($vcid == '不区分渠道') $cid = 'all';

        if($act == ''){
            $startDate = date('Y-m-d', time() - 86400);
            $endDate = date("Y-m-d", time() - 86400);
            $cid = 'all';
            $vcid = '不区分渠道';
        }
        if($startDate == '' || $endDate == ''){
            $data['error'] = "起止日期都要填写！";
        }else{
            $data['canalDataList'] = $this->log->getCanalDataList($startDate, $endDate, $cid);
        }
        if($this->input->post('act') == 'export')
            $this->canalDataExport($data['canalDataList']);

        $data['userInfo'] = $this->userInfo;
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;
        $data['group'] = 'user';
        $data['menu'] = 'canal_data';
        $data['title'] = '渠道数据';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/canal_data', $data);
        $this->load->view('general/footer');
    }

    /**
     * 渠道数据导出
     *
     * @param array $data 原数据
     */
    private function canalDataExport($data)
    {
        $outData['title'][] = "日期";
        $outData['title'][] = "渠道号";
        $outData['title'][] = "安装量";
        $outData['title'][] = "日活量";
        $outData['title'][] = "周留存";
        $outData['title'][] = "月留存";

        foreach($data as $row){
            $trow = array();
            $trow[] = $row['date'];
            $trow[] = $row['cid'];
            $trow[] = $row['install'];
            $trow[] = $row['dayActive'];
            $trow[] = $row['weekKeep'];
            $trow[] = $row['monthKeep'];
            $outData['list'][] = $trow;
        }
        Utilityclass::exportExcel($outData);
    }

    /**
     * 视频快进
     */
    public function video_ff()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_video_ff');

        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $ver = trim($this->input->post('ver'));
        $cid = trim($this->input->post('cid'));
        $act = trim($this->input->post('act'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '不区分渠道') $cid = 'group';
        if($vcid == '全部渠道') $cid = 'all';

        $data['rule'] = trim($this->input->post('rule'));
        if($data['rule'] == '')$data['rule'] = 'u';

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
            $data['dataList'] = $this->log->getVideoFFList($startDate, $endDate, $ver, $cid);
            $data['usersList'] = $this->log->getUmidUsersList($startDate, $endDate, $ver, $cid);
            if($this->input->post('act') == 'export'){
                $this->getVideoFFExport($data['dataList'],$data['usersList'], $ver, $cid, $data['rule']);
            }
        }

        $data['userInfo'] = $this->userInfo;

        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['endDate'] = $endDate;
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;

        $data['group'] = 'user';
        $data['menu'] = 'video_ff';
        $data['title'] = '视频快进';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/video_ff', $data);
        $this->load->view('general/footer');
    }

    /**
     * 视频加速导出
     *
     * @param array $data 原数据
     * @param string $ver 版本选择
     * @param string $cid 渠道选择
     * @param string $rule 统计规则
     */
    private function getVideoFFExport($data1, $data2, $ver, $cid, $rule)
    {
        $outData['title'][] = "日期";
        if($ver != 'group')
            $outData['title'][] = "版本号";
        if($cid != 'group')
            $outData['title'][] = "渠道";
        $outData['title'][] = "日活跃";

        $outData['title'][] = "总加速按钮展现";
        $outData['title'][] = "总加速实际加速";

        $outData['title'][] = "导给hao123按钮展现";
        $outData['title'][] = "导给hao123黄条展现";
        $outData['title'][] = "导给hao123实际导量";

        $outData['title'][] = "导给其他源按钮展现";
        $outData['title'][] = "导给其他源黄条展现";
        $outData['title'][] = "导给其他源实际导量";

        $outData['title'][] = "优酷加速";
        $outData['title'][] = "优酷导给hao123";
        $outData['title'][] = "优酷导给其他源";

        $outData['title'][] = "土豆加速";
        $outData['title'][] = "土豆导给hao123";
        $outData['title'][] = "土豆导给其他源";

        $outData['title'][] = "搜狐加速";
        $outData['title'][] = "搜狐导给hao123";
        $outData['title'][] = "搜狐导给其他源";

        $outData['title'][] = "奇艺加速";
        $outData['title'][] = "奇艺导给hao123";
        $outData['title'][] = "奇艺导给其他源";

        $outData['title'][] = "腾讯加速";
        $outData['title'][] = "腾讯导给hao123";
        $outData['title'][] = "腾讯导给其他源";

        $outData['title'][] = "乐视加速";
        $outData['title'][] = "乐视导给hao123";
        $outData['title'][] = "乐视导给其他源";

        $outData['title'][] = "风行加速";
        $outData['title'][] = "风行导给hao123";
        $outData['title'][] = "风行导给其他源";

        $outData['title'][] = "迅雷加速";
        $outData['title'][] = "迅雷导给hao123";
        $outData['title'][] = "迅雷导给其他源";

        $outData['title'][] = "暴风加速";
        $outData['title'][] = "暴风导给hao123";
        $outData['title'][] = "暴风导给其他源";

        $outData['title'][] = "PPTV加速";
        $outData['title'][] = "PPTV导给hao123";
        $outData['title'][] = "PPTV导给其他源";

        $outData['title'][] = "其他源导给优酷";
        $outData['title'][] = "其他源导给土豆";
        $outData['title'][] = "其他源导给搜狐";
        $outData['title'][] = "其他源导给奇艺";
        $outData['title'][] = "其他源导给腾讯";
        $outData['title'][] = "其他源导给乐视";
        $outData['title'][] = "其他源导给风行";
        $outData['title'][] = "其他源导给迅雷";
        $outData['title'][] = "其他源导给暴风";
        $outData['title'][] = "其他源导给PPTV";

        foreach($data1 as $key=>$row){
            $trow = array();
            $trow[] = $row['date'];
            if($ver != 'group')
                $trow[] = $row['ver'];
            if($cid != 'group')
                $trow[] = $row['cid'];
            $trow[] = $data2[$key]['dayActiveUser']+0;

            for($i=0; $i<8; $i++){
                $trow[] = $row['a' . ($i+1) . '-' . $rule];
            }
            for($i=0; $i<10; $i++){
                $trow[] = $row['b' . ($i+1) . '-' . $rule];
            }
            for($i=0; $i<10; $i++){
                $trow[] = $row['c' . ($i+1) . '-' . $rule];
            }
            for($i=0; $i<10; $i++){
                $trow[] = $row['d' . ($i+1) . '-' . $rule];
            }
            for($i=0; $i<10; $i++){
                $trow[] = $row['e' . ($i+1) . '-' . $rule];
            }

            $outData['list'][] = $trow;
        }
        Utilityclass::exportExcel($outData);
    }

    /**
     * 新标签页广告点击
     */
    public function ntads_click()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_ntads_click');

        $startDate = trim($this->input->post('startDate'));
        $act = trim($this->input->post('act'));

        if($act == ''){
            $startDate = date('Y-m-d', time());
        }

        $data['dataList'] = $this->log->getNtadsClick($startDate);

        $adData = $this->getAdData();
        $data['adList'] = json_decode($adData['f1'], true);

        $data['startDate'] = $startDate;
        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'user';
        $data['menu'] = 'ntads_click';
        $data['title'] = '新标签页广告点击';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/ntads_click', $data);
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
     * 通用日志列表
     */
    public function glog_list()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_glog_list');

        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $ver = trim($this->input->post('ver'));
        $cid = trim($this->input->post('cid'));
        $act = trim($this->input->post('act'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '不区分渠道') $cid = 'group';
        if($vcid == '全部渠道') $cid = 'all';

        $data['rule'] = trim($this->input->post('rule'));
        $data['type'] = trim($this->input->post('type'));
        if($data['rule'] == '')$data['rule'] = 'u';
        if($data['type'] == '')$data['type'] = 'speedup';

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
            $data['dataList'] = $this->log->getGlogList($startDate, $endDate, $ver, $cid, $data['type']);
            $data['usersList'] = $this->log->getUmidUsersList($startDate, $endDate, $ver, $cid);
        }

        $data['glogTitle'] = $this->getGlogTitle();
        $data['userInfo'] = $this->userInfo;

        $data['typeList'] = $this->getGlogTypeList();

        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['endDate'] = $endDate;
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;

        $data['group'] = 'user';
        $data['menu'] = 'glog_list';
        $data['title'] = '通用日志';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/glog_list', $data);
        $this->load->view('general/footer');
    }

    /**
     * 添加通用日志标题
     */
    public function glog_title_add()
    {
        $this->checkPermission($this->userInfo['permission'],'log_glog_title_add');
        if(is_array($this->input->post())){
            $tJson =trim($this->input->post('tJson'));
            if(!is_array(json_decode($tJson,true))){
                $data['errMsg'] = "数据不是json格式，不能提交！";
            }else{
                $this->setGlogTitleSetting($tJson);
                $data['sucMsg'] = '提交成功！';
            }
        }
        $data['tJson'] = $this->getGlogTitleSetting();
        $data['userInfo'] = $this->userInfo;
        $data['group'] = 'user';
        $data['menu'] = 'glog_title_add';
        $data['title'] = '通用日志标题';
        $this->load->view('general/header',$data);
        $this->load->view('general/menu');
        $this->load->view('log/glog_title_add',$data);
        $this->load->view('general/footer');
    }

    /**
     * 更新通用日志标题setting
     * @param $tJson
     */
    private function setGlogTitleSetting($tJson)
    {
        $data['f1'] = $tJson;
        $data['timeStamp'] = time();
        $this->other->setGeneralConf($data,7);
    }

    /**
     * 获取通用日志标题setting
     * @return mixed
     */
    private function getGlogTitleSetting()
    {
        $data = $this->other->getGeneralConf(7);
        return $data['f1'];
    }

    /**
     * 获取通用日志
     * @return mixed
     */
    private function getGlogTitle()
    {
        $data = $this->getGlogTitleSetting();
        return json_decode($data,true);
    }
    /**
     * 获取通用日志类型
     */
    private function getGlogTypeList()
    {
        $conf = $this->other->getGeneralConf(2);
        $typeList = $conf['f1'];
        $typeList = explode("\n", $typeList);

        return $typeList;
    }

    /**
     * 用户环境操作系统
     */
    public function log_users_os()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_users_os');

        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $ver = trim($this->input->post('ver'));
        $cid = trim($this->input->post('cid'));
        $sel = trim($this->input->post('sel'));
        $act = trim($this->input->post('act'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '不区分渠道') $cid = 'group';
        if($vcid == '全部渠道') $cid = 'all';

        if($act == ''){
            $startDate = date('Y-m-d', time() - 86400*31);
            $endDate = date('Y-m-d', time() - 86400);
            $ver = 'group';
            $cid = 'group';
            $sel = 'newInstall';
            $data['startDate'] = $endDate;
            $vcid = '不区分渠道';
        }else{
            $data['startDate'] = $startDate;
        }
        if($startDate == '' || $endDate == ''){
            $data['error'] = "起止日期都要填写！";
        }else{
            if($sel == 'newInstall')
                $data['userOsList'] = $this->log->getNewInstallUsersOsList($startDate, $endDate, $ver, $cid);
            if($sel == 'updateCheck')
                $data['userOsList'] = $this->log->getUpdateCheckUsersOsList($startDate, $endDate, $ver, $cid);
            if($this->input->post('act') == 'export')
                $this->logUsersOsExport($data['userOsList'], $ver, $cid);
        }
        $data['userInfo'] = $this->userInfo;
        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['endDate'] = $endDate;
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['sel'] = $sel;
        $data['vcid'] = $vcid;
        $data['group'] = 'usersInfo';
        $data['menu'] = 'usersInfo';
        $data['title'] = 'OS统计';
        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/log_users_os', $data);
        $this->load->view('general/footer');
    }

    /**
     *  用户环境操作系统数据导出Excel
     * @param $data
     * @param $cid
     */
    private function logUsersOsExport($data, $ver, $cid)
    {
        $outData['title'][] = "日期";
        if($ver != 'group')
        $outData['title'][] = "版本号";
        if($cid != 'group')
        $outData['title'][] = "渠道号";
        $outData['title'][] = "xp数量";
        $outData['title'][] = "占比";
        $outData['title'][] = "win7数量";
        $outData['title'][] = "占比";
        $outData['title'][] = "win8数量";
        $outData['title'][] = "占比";
        $outData['title'][] = "其他OS数量";
        $outData['title'][] = "占比";
        foreach($data as $row){
            $totalOs = $row['xp'] + $row['win7'] + $row['win8'] + $row['otherOs'];
            $trow = array();
            $trow[] = $row['date'];
            if($ver != 'group')
            $trow[] = $row['ver'];
            if($cid != 'group')
            $trow[] = $row['cid'];
            $trow[] = $row['xp'];
            $trow[] = round($row['xp'] / $totalOs, 4) * 100 . "%";
            $trow[] = $row['win7'];
            $trow[] = round($row['win7'] / $totalOs, 4) * 100 . "%";
            $trow[] = $row['win8'];
            $trow[] = round($row['win8'] / $totalOs, 4) * 100 . "%";
            $trow[] = $row['otherOs'];
            $trow[] = round($row['otherOs'] / $totalOs, 4) * 100 . "%";
            $outData['list'][] = $trow;
        }
        Utilityclass::exportExcel($outData);
    }

    /**
     * 用户环境安全软件
     */
    public function log_users_safe()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_users_safe');

        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $ver = trim($this->input->post('ver'));
        $cid = trim($this->input->post('cid'));
        $sel = trim($this->input->post('sel'));
        $act = trim($this->input->post('act'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '不区分渠道') $cid = 'group';
        if($vcid == '全部渠道') $cid = 'all';

        if($act == ''){
            $startDate = date('Y-m-d', time() - 86400*31);
            $endDate = date('Y-m-d', time() - 86400);
            $ver = 'group';
            $cid = 'group';
            $sel = 'newInstall';
            $data['startDate'] = $endDate;
            $vcid = '不区分渠道';
        }else{
            $data['startDate'] = $startDate;
        }
        if($startDate == '' || $endDate == ''){
            $data['error'] = "起止日期都要填写！";
        }else{
            if($sel == 'newInstall')
                $data['userSafeList'] = $this->log->getNewInstallUsersSafeList($startDate, $endDate, $ver, $cid);
            if($sel == 'updateCheck')
                $data['userSafeList'] = $this->log->getUpdateCheckUsersSafeList($startDate, $endDate, $ver, $cid);
            if($this->input->post('act') == 'export')
                $this->logUsersSafeExport($data['userSafeList'], $ver, $cid);
        }

        $data['userInfo'] = $this->userInfo;
        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['endDate'] = $endDate;
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;
        $data['sel'] = $sel;
        $data['group'] = 'usersInfo';
        $data['menu'] = 'usersInfo';
        $data['title'] = '安全软件';
        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/log_users_safe', $data);
        $this->load->view('general/footer');
    }

    /**用户环境安全软件导出数据Excel
     * @param $data
     * @param $ver
     * @param $cid
     */
    private function logUsersSafeExport($data, $ver, $cid)
   {
       $outData['title'][] = "日期";
       if($ver != 'group')
           $outData['title'][] = "版本号";
       if($cid != 'group')
           $outData['title'][] = "渠道号";
       $outData['title'][] = "360安全卫士(杀毒)数量";
       $outData['title'][] = "占比";
       $outData['title'][] = "腾讯管家数量";
       $outData['title'][] = "占比";
       $outData['title'][] = "百度安全卫士数量";
       $outData['title'][] = "占比";
       $outData['title'][] = "金山毒霸数量";
       $outData['title'][] = "占比";
       $outData['title'][] = "无安全软件数量";
       $outData['title'][] = "占比";
       foreach($data as $row){
           $trow = array();
           $trow[] = $row['date'];
           if($ver != 'group')
               $trow[] = $row['ver'];
           if($cid != 'group')
               $trow[] = $row['cid'];
           $trow[] = $row['360safe'];
           $trow[] = round($row['360safe'] / $row['totalAmount'], 4) * 100 . "%";
           $trow[] = $row['tencent'];
           $trow[] = round($row['tencent'] / $row['totalAmount'], 4) * 100 . "%";
           $trow[] = $row['baidu'];
           $trow[] = round($row['baidu'] / $row['totalAmount'], 4) * 100 . "%";
           $trow[] = $row['kingsoft'];
           $trow[] = round($row['kingsoft'] / $row['totalAmount'], 4) * 100 . "%";
           $trow[] = $row['nosafe'];
           $trow[] = round($row['nosafe'] / $row['totalAmount'], 4) * 100 . "%";
           $outData['list'][] = $trow;
       }
       Utilityclass::exportExcel($outData);
   }

    /**
     *  用户环境IE版本统计
     */
    public function log_users_ie()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_users_ie');
        $date = trim($this->input->post('date'));
        $ver = trim($this->input->post('ver'));
        $cid = trim($this->input->post('cid'));
        $act = trim($this->input->post('act'));
        $sel = trim($this->input->post('sel'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '全部渠道') $cid = 'all';

        if($act == ''){
            $date = date("Y-m-d", time() - 86400);
            $ver = 'all';
            $cid = 'all';
            $sel = 'newInstall';
            $vcid = '全部渠道';
        }else{
            $data['date'] = $date;
        }
        if($date == ''){
            $data['error'] = "日期需要填写！";
        }else{
            if($sel == 'newInstall'){
                $data['usersIEList'] = $this->log->getNewInstallUsersIEList($date, $ver, $cid);
            }
            if($sel == 'updateCheck'){
                $data['usersIEList'] = $this->log->getUpdateCheckUsersIEList($date, $ver, $cid);
            }
        }
        $data['userInfo'] = $this->userInfo;
        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['date'] = $date;
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;
        $data['sel'] = $sel;

        $data['group'] = 'usersInfo';
        $data['menu'] = 'usersInfo';
        $data['title'] = 'IE统计';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/log_users_ie', $data);
        $this->load->view('general/footer');
    }

    /**
     * 用户环境Flash版本统计
     */
    public function log_users_flash()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_users_flash');
        $date = trim($this->input->post('date'));
        $ver = trim($this->input->post('ver'));
        $cid = trim($this->input->post('cid'));
        $act = trim($this->input->post('act'));
        $sel = trim($this->input->post('sel'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '全部渠道') $cid = 'all';
        if($act == ''){
            $date = date("Y-m-d", time() - 86400);
            $ver = 'all';
            $cid = 'all';
            $sel = 'newInstall';
            $vcid = '全部渠道';
        }else{
            $data['date'] = $date;
        }
        if($date == ''){
            $data['error'] = "日期需要填写！";
        }else{
            if($sel == 'newInstall'){
                $data['usersFlashList'] = $this->log->getNewInstallUsersFlashList($date, $ver, $cid);
            }
            if($sel == 'updateCheck'){
                $data['usersFlashList'] = $this->log->getUpdateCheckUsersFlashList($date, $ver, $cid);
            }
        }
        $data['userInfo'] = $this->userInfo;
        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['date'] = $date;
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;
        $data['sel'] = $sel;

        $data['group'] = 'usersInfo';
        $data['menu'] = 'usersInfo';
        $data['title'] = 'Flash统计';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/log_users_flash', $data);
        $this->load->view('general/footer');
    }

    /**
     * 报活用户用户习惯启动页
     */
    public function log_users_homepage()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_users_homepage');

        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $ver = trim($this->input->post('ver'));
        $cid = trim($this->input->post('cid'));
        $sel = trim($this->input->post('sel'));
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
            $data['userHomePageList'] = $this->log->getUpdateCheckUsersHomePageList($startDate, $endDate, $ver, $cid);
            if($this->input->post('act') == 'export')
                $this->logUsersHomePageExport($data['userHomePageList'], $ver, $cid);
        }

        $data['userInfo'] = $this->userInfo;
        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['endDate'] = $endDate;
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;
        $data['sel'] = $sel;
        $data['group'] = 'usersHabit';
        $data['menu'] = '';
        $data['title'] = '启动页';
        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/log_users_homepage', $data);
        $this->load->view('general/footer');
    }

    /**
     * 报活用户用户习惯启动页导出数据Excel
     * @param $data
     * @param $ver
     * @param $cid
     */
    private function logUsersHomePageExport($data, $ver, $cid)
    {
        $outData['title'][] = "日期";
        if($ver != 'group')
            $outData['title'][] = "版本号";
        if($cid != 'group')
            $outData['title'][] = "渠道号";
        $outData['title'][] = "hao123(自有id)数量";
        $outData['title'][] = "占比";
        $outData['title'][] = "百度数量";
        $outData['title'][] = "占比";
        $outData['title'][] = "新标签页数量";
        $outData['title'][] = "占比";
        $outData['title'][] = "hao123(非自有id)数量";
        $outData['title'][] = "占比";
        $outData['title'][] = "其他启动页数量";
        $outData['title'][] = "占比";
        foreach($data as $row){
            $totalHomePage = $row['hao123PrivateId'] + $row['baidu'] + $row['newLabelPage'] + $row['hao123NonPrivateId'] + $row['other'];
            $trow = array();
            $trow[] = $row['date'];
            if($ver != 'group')
                $trow[] = $row['ver'];
            if($cid != 'group')
                $trow[] = $row['cid'];
            $trow[] = $row['hao123PrivateId'];
            $trow[] = round($row['hao123PrivateId'] / $totalHomePage, 4) * 100 . "%";
            $trow[] = $row['baidu'];
            $trow[] = round($row['baidu'] / $totalHomePage, 4) * 100 . "%";
            $trow[] = $row['newLabelPage'];
            $trow[] = round($row['newLabelPage'] / $totalHomePage, 4) * 100 . "%";
            $trow[] = $row['hao123NonPrivateId'];
            $trow[] = round($row['hao123NonPrivateId'] / $totalHomePage, 4) * 100 . "%";
            $trow[] = $row['other'];
            $trow[] = round($row['other'] / $totalHomePage, 4) * 100 . "%";
            $outData['list'][] = $trow;
        }
        Utilityclass::exportExcel($outData);
    }

    /**
     * 报活用户用户习惯hao123访问量
     */
    public function log_users_hao123pv()
    {
        $this->checkPermission($this->userInfo['permission'],'log_users_hao123pv');
        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $ver = trim($this->input->post('ver'));
        $cid = trim($this->input->post('cid'));
        $act = trim($this->input->post('act'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '不区分渠道') $cid = 'group';
        if($vcid == '全部渠道') $cid = 'all';
        if($act == ''){
            $startDate = date("Y-m-d", time() - 86400 * 31);
            $endDate = date("Y-m-d", time() - 86400);
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
            $data['userHao123PV'] = $this->log->getUpdateCheckUsersHao123PageView($startDate, $endDate, $ver, $cid);
            if($act == 'export')
                $this->logUsersHao123PVExport($data['userHao123PV'], $ver, $cid);
        }

        $data['userInfo'] = $this->userInfo;
        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;
        $data['endDate'] = $endDate;
        $data['group'] = 'usersHabit';
        $data['menu'] = '';
        $data['title'] = 'hao123访问量';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/log_users_hao123pv', $data);
        $this->load->view('general/footer');
    }

    /**
     * 报活用户用户习惯hao123访问量数据导出Excel
     * @param $data
     * @param $ver
     * @param $cid
     */
    private function logUsersHao123PVExport($data, $ver, $cid)
    {
        $outData['title'][] = "日期";
        if($ver != 'group')
        $outData['title'][] = "版本号";
        if($cid != 'group')
        $outData['title'][] = "渠道";
        $outData['title'][] = "hao123(自有tn)pv";
        $outData['title'][] = "hao123(自有tn)uv";
        $outData['title'][] = "hao123(非自有tn)pv";
        $outData['title'][] = "hao123(非自有tn)uv";

        $outData['title'][] = "tn为空访问量pv";
        $outData['title'][] = "tn为空访问量uv";
        $outData['title'][] = "自有tn尝试修复次数pv";
        $outData['title'][] = "自有tn尝试修复次数uv";

        $outData['title'][] = "超时未能修复pv";
        $outData['title'][] = "超时未能修复uv";
        $outData['title'][] = "超次数未能修复pv";
        $outData['title'][] = "超次数未能修复uv";
        foreach($data as $row){
            $trow = array();
            $trow[] = $row['date'];
            if($ver != 'group')
            $trow[] = $row['ver'];
            if($cid != 'group')
            $trow[] = $row['cid'];
            $trow[] = $row['privateTnPV'];
            $trow[] = $row['privateTnUV'];
            $trow[] = $row['nonPrivateTnPV'];
            $trow[] = $row['nonPrivateTnUV'];
            $trow[] = $row['tnIsNullPV'];
            $trow[] = $row['tnIsNullUV'];
            $trow[] = $row['privateTnTryRepairPV'];
            $trow[] = $row['privateTnTryRepairUV'];
            $trow[] = $row['timeOutPV'];
            $trow[] = $row['timeOutUV'];
            $trow[] = $row['numberOutPV'];
            $trow[] = $row['numberOutUV'];
            $outData['list'][] = $trow;
        }
        Utilityclass::exportExcel($outData);
    }

    /**
     * 报活用户用户习惯默认搜索引擎
     */
    public function log_users_defaultsearchengine()
    {
        $this->checkPermission($this->userInfo['permission'],'log_users_defaultsearchengine');
        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $ver = trim($this->input->post('ver'));
        $cid = trim($this->input->post('cid'));
        $act = trim($this->input->post('act'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '不区分渠道') $cid = 'group';
        if($vcid == '全部渠道') $cid = 'all';

        if($act == ''){
            $startDate = date('Y-m-d', time() - 86400 * 31);
            $endDate = date('Y-m-d', time() - 86400);
            $ver = 'group';
            $cid = 'group';
            $data['startDate'] = $endDate;
            $vcid = '不区分渠道';
        }else{
            $data['startDate'] = $startDate;
        }
        if($startDate == '' && $endDate == ''){
            $data['error'] = "起止日期都要填写！";
        }else{
            $data['userDefaultSearchEngineList'] = $this->log->getUpdateCheckUsersDefaultSearchEngineList($startDate, $endDate, $ver ,$cid);
            if($act == 'export')
                $this->logUsersDefaultSearchEngineExport($data['userDefaultSearchEngineList'], $ver, $cid);
        }

        $data['userInfo'] = $this->userInfo;
        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;
        $data['endDate'] = $endDate;
        $data['group'] = 'usersHabit';
        $data['menu'] = '';
        $data['title'] ='默认搜索引擎';

        $this->load->view('general/header',$data);
        $this->load->view('general/menu');
        $this->load->view('log/log_users_defaultsearchengine',$data);
        $this->load->view('general/footer');
    }

    /**
     * 报活用户用户习惯默认数据搜索引擎数据导出Excel
     * @param $data
     * @param $ver
     * @param $cid
     */
    private function logUsersDefaultSearchEngineExport($data, $ver, $cid)
    {
        $outData['title'][] = "日期";
        if($ver != 'group')
        $outData['title'][] = "版本号";
        if($cid != 'group')
        $outData['title'][] = "渠道";
        $outData['title'][] = "百度数量";
        $outData['title'][] = "占比";
        $outData['title'][] = "谷歌数量";
        $outData['title'][] = "占比";
        $outData['title'][] = "360数量";
        $outData['title'][] = "占比";
        $outData['title'][] = "搜狗数量";
        $outData['title'][] = "占比";
        $outData['title'][] = "SOSO数量";
        $outData['title'][] = "占比";
        $outData['title'][] = "其他默认搜索引擎数量";
        $outData['title'][] = "占比";
        foreach($data as $row){
            $trow = array();
            $total = $row['baidu'] + $row['google'] + $row['360so'] + $row['sogou'] + $row['soso'] + $row['other'];
            $trow[] = $row['date'];
            if($ver != 'group')
            $trow[] = $row['ver'];
            if($cid != 'group')
            $trow[] = $row['cid'];
            $trow[] = $row['baidu'];
            $trow[] = round($row['baidu'] / $total, 4) * 100 . "%";
            $trow[] = $row['google'];
            $trow[] = round($row['google'] / $total, 4) * 100 . "%";
            $trow[] = $row['360so'];
            $trow[] = round($row['360so'] / $total, 4) * 100 . "%";
            $trow[] = $row['sogou'];
            $trow[] = round($row['sogou'] / $total, 4) * 100 . "%";
            $trow[] = $row['soso'];
            $trow[] = round($row['soso'] / $total, 4) * 100 . "%";
            $trow[] = $row['other'];
            $trow[] = round($row['other'] / $total, 4) * 100 . "%";
            $outData['list'][] = $trow;
        }
        Utilityclass::exportExcel($outData);
    }

    /**
     * 报活用户设默数据
     */
    public function log_users_setdef()
    {
        $this->checkPermission($this->userInfo['permission'],'log_users_setdef');
        $startDate = trim($this->input->post('startDate'));
        $endDate = trim($this->input->post('endDate'));
        $ver = trim($this->input->post('ver'));
        $cid = trim($this->input->post('cid'));
        $vcid = trim($this->input->post('cid'));
        $act = trim($this->input->post('act'));
        if($vcid == '不区分渠道') $cid = 'group';
        if($vcid == '全部渠道') $cid = 'all';

        if($act == ''){
            $startDate = date("Y-m-d", time() - 86400 * 31);
            $endDate = date("Y-m-d", time() - 86400);
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
            $data['userSetDef'] = $this->log->getUpdateCheckUsersSetDefaultList($startDate, $endDate, $ver, $cid);
            if($act == 'export'){
                $this->logUserSetDefExport($data['userSetDef'], $ver, $cid);
            }
        }
        $data['userInfo'] = $this->userInfo;
        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;
        $data['endDate'] = $endDate;
        $data['group'] = 'usersHabit';
        $data['menu'] = '';
        $data['title'] = '设默数据';
        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/log_users_setdef', $data);
        $this->load->view('general/footer');
    }

    /**
     * 报活用户设默数据导出Excel
     * @param $data
     * @param $ver
     * @param $cid
     */
    private function logUserSetDefExport($data, $ver ,$cid)
    {
        $outData['title'][] = "日期";
        if($ver != 'group')
            $outData['title'][] = "版本号";
        if($cid != 'group')
            $outData['title'][] = "渠道";
        $outData['title'][] = "设默成功";
        $outData['title'][] = "设默失败";
        $outData['title'][] = "设默成功率";
        $outData['title'][] = "可提示设默数量";
        $outData['title'][] = "不能提示设默数量";
        $outData['title'][] = "可提示比例";
        foreach($data as $row){
            $trow = array();
            $total1 = $row['sd1Amount'] + $row['sd2Amount'];
            $total2 = $row['reminderSetDef'] + $row['noReminderSetDef'];
            $trow[] = $row['date'];
            if($ver != 'group')
                $trow[] = $row['ver'];
            if($cid != 'group')
                $trow[] = $row['cid'];
            $trow[] = $row['sd1Amount'];
            $trow[] = $row['sd2Amount'];
            $trow[] = round($row['sd1Amount'] / $total1, 4) * 100 . "%";
            $trow[] = $row['reminderSetDef'];
            $trow[] = $row['noReminderSetDef'];
            $trow[] = round($row['reminderSetDef'] / $total2, 4) * 100 . "%";
            $outData['list'][] = $trow;
        }
        Utilityclass::exportExcel($outData);
    }

    /**
     * 卸载用户卸载父进程统计
     */
    public function log_users_uninstallparentprocess()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_users_unpp');
        $date = trim($this->input->post('date'));
        $ver = trim($this->input->post('ver'));
        $cid = trim($this->input->post('cid'));
        $act = trim($this->input->post('act'));
        $vcid = trim($this->input->post('cid'));
        if($vcid == '全部渠道') $cid = 'all';
        if($act == ''){
            $date = date("Y-m-d", time() - 86400);
            $ver = 'all';
            $cid = 'all';
            $vcid = '全部渠道';
        }else{
            $data['date'] = $date;
        }
        if($date == ''){
            $data['error'] = "日期需要填写！";
        }else{
            $data['usersUnpp'] = $this->log->getUnInstallParentProcess($date, $ver, $cid);
        }

        $data['userInfo'] = $this->userInfo;
        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;
        $data['date'] = $date;
        $data['group'] = 'usersHabit';
        $data['menu'] = '';
        $data['title'] = '卸载父进程';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu', $data);
        $this->load->view('log/log_users_uninstallparentprocess', $data);
        $this->load->view('general/footer');
    }

    public function log_users_internetbehavior()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_users_ib');
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $ver = $this->input->post('ver');
        $cid = $this->input->post('cid');
        $vcid = $this->input->post('cid');
        if($vcid == '不区分渠道') $cid = 'group';
        if($vcid == '全部渠道') $cid = 'all';
        $act = $this->input->post('act');
        if($act == ''){
            $startDate = date("Y-m-d", time() - 86400 * 31);
            $endDate = date("Y-m-d", time() - 86400);
            $ver = 'group';
            $cid = 'group';
            $vcid = '不区分渠道';
            $data['startDate'] = $endDate;
        }else{
            $data['startDate'] = $startDate;
        }
        if($startDate == '' || $endDate == ''){
            $data['error'] = "起止日期都要填写！";
        }else{
            $data['userIBList'] = $this->log->getUpdateCheckUsersInternetBehavior($startDate, $endDate, $ver, $cid);
            if($act == 'export'){
                $this->logUsersInternetBehavior($data['userIBList'], $ver, $cid);
            }
        }

        $data['userInfo'] = $this->userInfo;
        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;
        $data['endDate'] = $endDate;
        $data['group'] = 'usersHabit';
        $data['menu'] = '';
        $data['title'] = "上网行为";

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/log_users_internetbehavior', $data);
        $this->load->view('general/footer');
    }

    /**
     * 报活用户上网行为导出Excel
     * @param $data
     * @param $ver
     * @param $cid
     */
    private function logUsersInternetBehavior($data, $ver, $cid)
    {
        $outData['title'][] = "日期";
        if($ver != 'group')
            $outData['title'][] = "版本号";
        if($cid != 'group')
            $outData['title'][] = "渠道";
        $outData['title'][] = "购物网页次数";
        $outData['title'][] = "购物网页人数";
        $outData['title'][] = "游戏网页次数";
        $outData['title'][] = "游戏网页人数";
        $outData['title'][] = "社交网页次数";
        $outData['title'][] = "社交网页人数";
        $outData['title'][] = "视频网页次数";
        $outData['title'][] = "视频网页人数";
        $outData['title'][] = "新闻网页次数";
        $outData['title'][] = "新闻网页人数";
        $outData['title'][] = "搜索网页次数";
        $outData['title'][] = "搜索网页人数";
        $outData['title'][] = "IT网页次数";
        $outData['title'][] = "IT网页人数";
        $outData['title'][] = "体育网页次数";
        $outData['title'][] = "体育网页人数";
        $outData['title'][] = "女性网页次数";
        $outData['title'][] = "女性网页人数";
        foreach($data as $row){
            $trow = array();
            $trow[] = $row['date'];
            if($ver != 'group')
                $trow[] = $row['ver'];
            if($cid != 'group')
                $trow[] = $row['cid'];
            $trow[] = $row['shoppingPV'];
            $trow[] = $row['shoppingUV'];
            $trow[] = $row['gamePV'];
            $trow[] = $row['gameUV'];
            $trow[] = $row['socialNetworkPV'];
            $trow[] = $row['socialNetworkUV'];
            $trow[] = $row['videoPV'];
            $trow[] = $row['videoUV'];
            $trow[] = $row['newsPV'];
            $trow[] = $row['newsUV'];
            $trow[] = $row['searchPV'];
            $trow[] = $row['searchUV'];
            $trow[] = $row['ITPV'];
            $trow[] = $row['ITUV'];
            $trow[] = $row['sportsPV'];
            $trow[] = $row['sportsUV'];
            $trow[] = $row['femalePV'];
            $trow[] = $row['femaleUV'];
            $outData['list'][] = $trow;
        }
        Utilityclass::exportExcel($outData);
    }

    public function log_users_outerlinkdomain()
    {
        $this->checkPermission($this->userInfo['permission'], 'log_users_ib');
        $date = $this->input->post('date');
        $ver = $this->input->post('ver');
        $cid = $this->input->post('cid');
        $vcid = $this->input->post('cid');
        $act = $this->input->post('act');
        if($vcid == '全部渠道') $cid = 'all';
        if($act == ''){
            $date = date("Y-m-d", time() - 86400);
            $ver = 'all';
            $cid = 'all';
            $vcid = '全部渠道';
        }else{
            $data['date'] = $date;
        }
        if($date == ''){
            $data['error'] = "日期需要填写！";
        }else{
            $data['usersOLD'] = $this->log->getUpdateCheckOuterLinkDomain($date, $ver, $cid);
        }

        $data['userInfo'] = $this->userInfo;
        $data['date'] = $date;
        $data['verMap'] = $this->log->getVerMap();
        $data['cidMap'] = $this->log->getCidMap();
        $data['cidMapDef'] = $this->log->getDefCidMap();
        $data['ver'] = $ver;
        $data['cid'] = $cid;
        $data['vcid'] = $vcid;
        $data['group'] = 'usersHabit';
        $data['menu'] = '';
        $data['title'] = '外链域名';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('log/log_users_outerlinkdomain', $data);
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