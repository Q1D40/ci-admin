<?php

/**
 * CT控制器
 */
class Cron extends DH_Controller {

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Cron_model', 'cron');
        $this->load->library('Pageclass');
    }

    /**
     * cron任务
     */
    public function cron_pro()
    {
        $this->checkPermission($this->userInfo['permission'], 'cron_cron_pro');

        $date = trim($this->input->post('date'));
        $type = trim($this->input->post('type'));
        $act = trim($this->input->post('act'));
        $status = trim($this->input->post('status'));
        $page = trim($this->input->post('page'));

        if($act == ''){
            $date = date('Y-m-d', time());
            $status = 'all';
        }

        $count = $this->cron->getCronLogCount($date, $type, $status);
        $perPage = 100;
        $allPage = ceil($count / $perPage);
        if($page > $allPage) $page = $allPage;
        if($page <= 0) $page = 1;
        $start = $perPage * ($page - 1);

        $data['userInfo'] = $this->userInfo;

        $data['page'] = $this->pageclass->getPage($page, $allPage);
        $data['cronLogList'] = $this->cron->getCronLog($date, $type, $status, $start, $perPage);
        $data['count'] = $count;
        $data['allPage'] = $allPage;

        $data['date'] = $date;
        $data['type'] = $type;
        $data['status'] = $status;

        $data['group'] = 'cron';
        $data['menu'] = 'cron_pro';
        $data['title'] = 'cron任务';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('cron/cron_pro', $data);
        $this->load->view('general/footer');
    }

    /**
     * 日志入库
     */
    public function cron_insert_file()
    {
        $this->checkPermission($this->userInfo['permission'], 'cron_cron_insert_file');

        $date = trim($this->input->post('date'));
        $fileType = trim($this->input->post('fileType'));
        $act = trim($this->input->post('act'));
        $status = trim($this->input->post('status'));
        $page = trim($this->input->post('page'));

        if($act == ''){
            $date = date('Y-m-d', time());
            $status = 'all';
        }

        $count = $this->cron->getInsertFileLogCount($date, $fileType, $status);
        $perPage = 100;
        $allPage = ceil($count / $perPage);
        if($page > $allPage) $page = $allPage;
        if($page <= 0) $page = 1;
        $start = $perPage * ($page - 1);

        $data['userInfo'] = $this->userInfo;

        $data['page'] = $this->pageclass->getPage($page, $allPage);
        $data['insertFileLogList'] = $this->cron->getInsertFileLog($date, $fileType, $status, $start, $perPage);
        $data['count'] = $count;
        $data['allPage'] = $allPage;

        $data['date'] = $date;
        $data['fileType'] = $fileType;
        $data['status'] = $status;

        $data['group'] = 'cron';
        $data['menu'] = 'cron_insert_file';
        $data['title'] = '日志入库';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('cron/cron_insert_file', $data);
        $this->load->view('general/footer');
    }

    /**
     * 磁盘占用
     */
    public function disk_usage()
    {
        $this->checkPermission($this->userInfo['permission'], 'cron_disk_usage');

        $date = trim($this->input->post('date'));
        $act = trim($this->input->post('act'));
        $page = trim($this->input->post('page'));

        if($act == ''){
            $date = date('Y-m-d', time());
        }

        $count = $this->cron->getDiskUsageLogCount($date);
        $perPage = 100;
        $allPage = ceil($count / $perPage);
        if($page > $allPage) $page = $allPage;
        if($page <= 0) $page = 1;
        $start = $perPage * ($page - 1);

        $data['userInfo'] = $this->userInfo;

        $data['page'] = $this->pageclass->getPage($page, $allPage);
        $data['diskUsageLogList'] = $this->cron->getDiskUsageLog($date, $start, $perPage);
        $data['count'] = $count;
        $data['allPage'] = $allPage;

        $data['date'] = $date;

        $data['group'] = 'cron';
        $data['menu'] = 'disk_usage';
        $data['title'] = '磁盘占用';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('cron/disk_usage', $data);
        $this->load->view('general/footer');
    }

    /**
     * DB占用
     */
    public function db_usage()
    {
        $this->checkPermission($this->userInfo['permission'], 'cron_db_usage');

        $date = trim($this->input->post('date'));
        $act = trim($this->input->post('act'));
        $page = trim($this->input->post('page'));

        if($act == ''){
            $date = date('Y-m-d', time());
        }

        $count = $this->cron->getDbUsageLogCount($date);
        $perPage = 100;
        $allPage = ceil($count / $perPage);
        if($page > $allPage) $page = $allPage;
        if($page <= 0) $page = 1;
        $start = $perPage * ($page - 1);

        $data['userInfo'] = $this->userInfo;

        $data['page'] = $this->pageclass->getPage($page, $allPage);
        $data['dbUsageLogList'] = $this->cron->getDbUsageLog($date, $start, $perPage);
        $data['count'] = $count;
        $data['allPage'] = $allPage;

        $data['date'] = $date;

        $data['group'] = 'cron';
        $data['menu'] = 'db_usage';
        $data['title'] = 'DB占用';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('cron/db_usage', $data);
        $this->load->view('general/footer');
    }

    /**
     * 错误报警
     */
    public function warning()
    {
        $this->checkPermission($this->userInfo['permission'], 'cron_warning');

        $data['warningLogList'] = $this->cron->getWarningLog();

        $data['userInfo'] = $this->userInfo;

        $data['group'] = 'cron';
        $data['menu'] = 'warning';
        $data['title'] = '错误报警';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('cron/warning', $data);
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