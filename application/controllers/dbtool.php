<?php

/**
 * DB工具控制器
 */
class Dbtool extends DH_Controller {

    private $cantDoList;
    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Dbtool_model', 'dbtool');

        $this->cantDoList = array('update ', 'delete ', 'insert ', 'alter ', 'create ', 'drop ', 'truncate ');
    }

    /**
     * 执行sql语句
     */
    public function run_sql()
    {
        $this->checkPermission($this->userInfo['permission'], 'dbtool_run_sql');

        $sql = trim($this->input->post('sql'));
        $sqlLower = strtolower($sql);
        $database = $this->input->post('database');

        if($sql != ''){
            foreach($this->cantDoList as $keyWord){
                if (strpos($sqlLower, $keyWord) !== false) {
                    $data['error'] = '禁止执行' . $keyWord . '操作';
                    break 1;
                }
            }
            if (strpos($sqlLower, 'select') !== false && strpos($sqlLower, 'limit') === false && !isset($data['error'])) {
                $data['error'] = '请添加limit限制查询条数';
            }
        }

        if($sql != '' && !isset($data['error'])){
            $data['data'] = $this->dbtool->runSQL($database, $sql);
        }

        $data['userInfo'] = $this->userInfo;

        $data['databaseList'] = $this->dbtool->showDatabases();
        $data['database'] = $database;
        $data['sql'] = $sql;
        $data['group'] = 'cron';
        $data['menu'] = 'dbtool';
        $data['title'] = 'DB工具';

        $this->load->view('general/header', $data);
        $this->load->view('general/menu');
        $this->load->view('dbtool/run_sql', $data);
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