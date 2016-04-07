<?php

/**
 * 崩溃信息模型
 */
class Excpt_model extends CI_Model {

    private $notLikeMap;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('Arrayclass');

        $this->notLikeMap = array('iev','osv','fv','appv','os64','procType','browserMode','bExit','threadStatus');
    }

    /**
     * 获取版本崩溃信息列表
     */
    public function getVersionExcptList($startDate, $endDate)
    {
        if($startDate == '')
            $startDate = $endDate;
        if($endDate == '')
            $endDate = $startDate;

        $totalExcptNum = $this->getTotalExcptNum($startDate, $endDate);

        $sql = "SELECT `version`, SUM(excptNum) AS versionExcpt FROM `versionExcpt` WHERE `date` >= '$startDate' AND `date` <= '$endDate' GROUP BY `version`";
        $query = $this->db->query($sql);
        $versionExcptList = array();
        foreach ($query->result_array() as $row)
        {
            $versionExcptList[$row['version']]['version'] = $row['version'];
            $versionExcptList[$row['version']]['versionExcpt'] = $row['versionExcpt'];
            $versionExcptList[$row['version']]['versionExcptProportion'] = round($row['versionExcpt'] / $totalExcptNum, 4) * 100;
        }

        Arrayclass::$sortKey = 'versionExcptProportion';
        Arrayclass::$sortType = 1;
        usort($versionExcptList, array("Arrayclass", "arraySunValueSort"));

        return $versionExcptList;
    }

    /**
     * 获取总崩溃数
     */
    private function getTotalExcptNum($startDate, $endDate)
    {
        if($startDate == '')
            $startDate = $endDate;
        if($endDate == '')
            $endDate = $startDate;

        $sql = "SELECT SUM(excptNum) AS totalExcptNum FROM `dateExcpt` WHERE `date` >= '$startDate' AND `date` <= '$endDate'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $totalExcptNum = $row['totalExcptNum'];

        return $totalExcptNum;
    }

    /**
     * 获取IE版本崩溃信息列表
     */
    public function getIeVersionExcptList($startDate, $endDate, $search)
    {
        if($startDate == '')
            $startDate = $endDate;
        if($endDate == '')
            $endDate = $startDate;

        $totalExcptNum = $this->getTotalExcptNum($startDate, $endDate);

        $dateArray = $this->timeQuantumToDateArray($startDate, $endDate);
        $tableNameArray = $this->dateArrayToTableName($dateArray, 'excptLog');
        $ieVersionExcptList = array();
        foreach($tableNameArray as $tableName){
            $oneDayIeVersionExcpt = $this->getOneDayIeVersionExcpt($tableName, $search);
            foreach($oneDayIeVersionExcpt as $row){
                $ieVersionExcptList[$row['iev']]['iev'] = $row['iev'];
                $ieVersionExcptList[$row['iev']]['ieVersionExcpt'] += $row['ieVersionExcpt'];
            }
        }

        foreach($ieVersionExcptList as $key => $row){
            $ieVersionExcptList[$key]['ieVersionExcptProportion'] = round($row['ieVersionExcpt'] / $totalExcptNum, 4) * 100;
        }

        Arrayclass::$sortKey = 'ieVersionExcptProportion';
        Arrayclass::$sortType = 1;
        usort($ieVersionExcptList, array("Arrayclass", "arraySunValueSort"));

        return $ieVersionExcptList;
    }

    /**
     * 获取一天(一张表)IE崩溃数据
     */
    private function getOneDayIeVersionExcpt($tableName, $search)
    {
        $checkTablename = $this->checkTableName($tableName);
        if(count($checkTablename) == 0) return array();

        $where = ' 1 = 1 ';
        foreach($search as $key => $value){
            if($value !== ''){
                if(in_array($key, $this->notLikeMap)){
                    $where .= ' AND ' . "`$key` = '$value'";
                }else{
                    $where .= ' AND ' . "`$key` LIKE '%$value%'";
                }
            }
        }
        $sql = "SELECT `iev`, COUNT(*) AS ieVersionExcpt FROM " . $this->db->mydbprefix . "excptlog.`$tableName` WHERE $where GROUP BY `iev`";
        $query = $this->db->query($sql);
        $ieVersionExcptList = array();
        foreach ($query->result_array() as $row)
        {
            $ieVersionExcptList[$row['iev']]['iev'] = $row['iev'];
            $ieVersionExcptList[$row['iev']]['ieVersionExcpt'] = $row['ieVersionExcpt'];
        }

        return $ieVersionExcptList;
    }

    /**
     * 获取dump列表
     */
    public function getDumpList($search)
    {
        if($search['startDate'] == '')
            $search['startDate'] = $search['endDate'];
        if($search['endDate'] == '')
            $search['endDate'] = $search['startDate'];

        $dateArray = $this->timeQuantumToDateArray($search['startDate'], $search['endDate']);
        $tableNameArray = $this->dateArrayToTableName($dateArray, 'excptLog');
        unset($search['startDate']);
        unset($search['endDate']);
        $dumpList = array();
        foreach($tableNameArray as $tableName){
            $oneDayDumpList = $this->getOneDayDumpList($tableName, $search);
            foreach($oneDayDumpList as $md5 => $dump){
                $dumpList[$md5] = $dump;
            }
        }

        return $dumpList;
    }

    /**
     * 获取一天(一张表)dump
     */
    private function getOneDayDumpList($tableName, $search)
    {
        $checkTablename = $this->checkTableName($tableName);
        if(count($checkTablename) == 0) return array();

        $where = ' 1 = 1 ';
        foreach($search as $key => $value){
            if($value !== '')
                if(in_array($key, $this->notLikeMap)){
                    $where .= ' AND ' . "`$key` = '$value'";
                }else{
                    $where .= ' AND ' . "`$key` LIKE '%$value%'";
                }
        }
        $sql = "SELECT `excptMD5`, `dump`, `timeStamp` FROM " . $this->db->mydbprefix . "excptlog.`$tableName` WHERE $where GROUP BY `excptMD5`";
        $query = $this->db->query($sql);
        $dumpList = array();
        foreach ($query->result_array() as $row)
        {
            $path = date("Y", $row['timeStamp']) . '/' . date("m", $row['timeStamp']) . '/' . date("d", $row['timeStamp']) . '/';
            $dumpList[$row['excptMD5']]['path']= $path . $row['dump'] . ".dmp";
            $dumpList[$row['excptMD5']]['md5']= $row['excptMD5'];
            $dumpList[$row['excptMD5']]['dump']= $row['dump'] . ".dmp";
            $dumpList[$row['excptMD5']]['timeStamp']= $row['timeStamp'];
        }

        return $dumpList;
    }

    /**
     * 检查表名是否存在
     */
    private function checkTableName($tableName)
    {
        $sql = "SELECT table_name FROM information_schema.TABLES WHERE table_name ='$tableName'";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * 通过时间段取出时期数组
     */
    private function timeQuantumToDateArray($startDate, $endDate)
    {
        for($date = strtotime($startDate); $date <= strtotime($endDate); $date += 86400){
            $dateArray[date("Ymd",$date)] = date("Ymd",$date);
        }
        return $dateArray;
    }

    /**
     * 日期数组转换表名数组
     */
    private function dateArrayToTableName($dateArray, $tableName)
    {
        $nowDate = date('Ymd', time());
        foreach($dateArray as $date){
            if($date == $nowDate)
                $tDateName = $tableName;
            else
                $tDateName = $tableName . $date;
            $tableNameArray[$tDateName] = $tDateName;
        }
        return $tableNameArray;
    }

    /**
     * 获取搜索字典
     */
    private function getSearchMap($field)
    {
        $sql = "SELECT `value`, `description` FROM `searchMap` WHERE `field` = '$field'";
        $query = $this->db->query($sql);
        $seatchMap = array();
        foreach ($query->result_array() as $row)
        {
            $seatchMap[] = $row;
        }

        return $seatchMap;
    }

    /**
     * 获取IE版本字典
     */
    public function getIevMap()
    {
        return $this->getSearchMap('iev');
    }

    /**
     * 获取操作系统版本字典
     */
    public function getOsvMap()
    {
        return $this->getSearchMap('osv');
    }

    /**
     * 获取flash版本字典
     */
    public function getFvMap()
    {
        return $this->getSearchMap('fv');
    }

    /**
     * 获取崩溃主程序版本字典
     */
    public function getAppvMap()
    {
        return $this->getSearchMap('appv');
    }

    /**
     * 获取进程类型字典
     */
    public function getProcTypeMap()
    {
        return $this->getSearchMap('procType');
    }

    /**
     * 获取进程模型字典
     */
    public function getBrowserModeMap()
    {
        return $this->getSearchMap('browserMode');
    }

    /**
     * 获取线程状态字典
     */
    public function getThreadStatusMap()
    {
        return $this->getSearchMap('threadStatus');
    }

    /**
     * 获取崩溃率分析列表
     */
    public function getExcptRate($startDate, $endDate, $ver, $cid)
    {
        $order = " ORDER BY `date` DESC ";

        if($cid != 'group' && $ver != 'group'){
            $select = " * ";
        }else{
            $select = " `date`, `ver`, `cid`, SUM(dayActive) AS `dayActive`, SUM(mainProNum) AS `mainProNum`, SUM(mainProMid) AS `mainProMid`, SUM(pageProNum) AS `pageProNum`, SUM(pageProMid) AS `pageProMid`, SUM(otherProNum) AS `otherProNum`, SUM(otherProMid) AS `otherProMid`, SUM(allProNum) AS `allProNum`, SUM(allProMid) AS `allProMid`";
        }

        $where = '';
        if($ver != 'all' && $ver != 'group'){
            $where .= " AND `ver` = '$ver' ";
        }
        if($cid != 'all' && $cid != 'group' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2'){
            $where .= " AND `cid` = '$cid' ";
        }
        if($cid == 'Organ'){
            $where .= " AND (`cid` LIKE '%_o2_%' OR `cid` in ('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'h7', 'h8', 'h9', 'h10', 'h11', 'h12', 'h13', 'h14', 'h15', 'h16', 'h17', 'h18', 'h19', 'h20', 'h21', 'h22', 'h23', 'h24', 'h25', 'h26', 'h27', 'h28', 'h29', 'h30'))";
        }
        if($cid == 'D2'){
            $where .= " AND (`cid` LIKE '%_d2_%' OR `cid` in ('d0', 'd1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7', 'd8', 'd9', 'd10', 'd11', 'd12', 'd13', 'd14', 'd15', 'd16', 'd17', 'd18', 'd19', 'd20', 'd21', 'd22', 'd23', 'd24', 'd25', 'd26', 'd27', 'd28', 'd29', 'd30'))";
        }
        if($cid == 'U2'){
            $where .= " AND (`cid` LIKE '%_u2_%' OR `cid` in ('c0', 'c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8', 'c9', 'c10', 'c11', 'c12', 'c13', 'c14', 'c15', 'c16', 'c17', 'c18', 'c19', 'c20', 'c21', 'c22', 'c23', 'c24', 'c25', 'c26', 'c27', 'c28', 'c29', 'c30'))";
        }

        if($cid == 'group' && $ver != 'group'){
            $group = "GROUP BY `ver`, `date`";
            $order .= " , `ver` DESC ";
        }
        if($cid != 'group' && $ver == 'group'){
            $group = "GROUP BY `cid`, `date`";
            $order .= " , `cid` DESC ";
        }
        if($cid == 'group' && $ver == 'group'){
            $group = "GROUP BY `date`";
        }
        if($cid != 'group' && $ver != 'group'){
            $order .= " , `ver` DESC ";
        }

        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "excptstatistics.`excptRate` WHERE `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";

        $query = $this->db->query($sql);
        $users = array();
        foreach ($query->result_array() as $row)
        {
            $users[] = $row;
        }
        return $users;
    }

    /**
     * 获取崩溃排名
     */
    public function getExcptRank($startDate, $endDate, $appv, $cid, $excptMD5, $iev, $osv, $fv, $viewType)
    {
        $dateArray = $this->timeQuantumToDateArray($startDate, $endDate);
        $tableNameArray = $this->dateArrayToTableName($dateArray, 'excptLog');

        $where = "WHERE 1=1 ";
        if($appv != 'all') $where .= " AND `appv` = '$appv' ";
        if($cid != 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2') {
            $where .= " AND `cid` = '$cid' ";
        }
        if($cid == 'Organ'){
            $where .= " AND (`cid` LIKE '%_o2_%' OR `cid` in ('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'h7', 'h8', 'h9', 'h10', 'h11', 'h12', 'h13', 'h14', 'h15', 'h16', 'h17', 'h18', 'h19', 'h20', 'h21', 'h22', 'h23', 'h24', 'h25', 'h26', 'h27', 'h28', 'h29', 'h30'))";
        }
        if($cid == 'D2'){
            $where .= " AND (`cid` LIKE '%_d2_%' OR `cid` in ('d0', 'd1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7', 'd8', 'd9', 'd10', 'd11', 'd12', 'd13', 'd14', 'd15', 'd16', 'd17', 'd18', 'd19', 'd20', 'd21', 'd22', 'd23', 'd24', 'd25', 'd26', 'd27', 'd28', 'd29', 'd30'))";
        }
        if($cid == 'U2'){
            $where .= " AND (`cid` LIKE '%_u2_%' OR `cid` in ('c0', 'c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8', 'c9', 'c10', 'c11', 'c12', 'c13', 'c14', 'c15', 'c16', 'c17', 'c18', 'c19', 'c20', 'c21', 'c22', 'c23', 'c24', 'c25', 'c26', 'c27', 'c28', 'c29', 'c30'))";
        }
        if($excptMD5 != '') $where .= " AND `excptMD5` LIKE '%$excptMD5%' ";
        if($iev != '') $where .= " AND `iev` LIKE '%$iev%' ";
        if($osv != '') $where .= " AND `osv` LIKE '%$osv%' ";
        if($fv != '') $where .= " AND `fv` LIKE '%$fv%' ";

        $excptRankList = array();
        foreach($tableNameArray as $tableName){
            $checkTablename = $this->checkTableName($tableName);
            if(count($checkTablename) == 0) continue 1;

            $sql = "SELECT COUNT(*) AS allCount FROM " . $this->db->mydbprefix . "excptlog.`$tableName` $where";
            $query = $this->db->query($sql);
            $rowArray = $query->row_array();
            $excptRankList['allCount'] += $rowArray['allCount'];

            $sql = "SELECT COUNT(*) AS viewTypeCount, `$viewType`  FROM " . $this->db->mydbprefix . "excptlog.`$tableName` $where GROUP BY `$viewType`";
            $query = $this->db->query($sql);
            foreach ($query->result_array() as $row)
            {
                $excptRankList['list'][$row[$viewType]] += $row['viewTypeCount'];
        }
        }
        arsort($excptRankList['list']);
        return $excptRankList;
    }

    /**
     * 获取崩溃日志详情
     */
    public function getExcptLog($startDate, $endDate, $search)
    {
        $dateArray = $this->timeQuantumToDateArray($startDate, $endDate);
        $tableNameArray = $this->dateArrayToTableName($dateArray, 'excptLog');
        arsort($tableNameArray);

        $where = " WHERE 1=1 ";
        foreach($search as $key => $value){
            if($key == 'appv' || $key == 'cid'){
                if($value !== 'all')
                    $where .= ' AND ' . "`$key` = '$value'";
            }else{
                if($value !== '')
                    $where .= ' AND ' . "`$key` LIKE '%$value%'";
            }
        }

        $excptLogList = array();
        foreach($tableNameArray as $tableName){
            $checkTablename = $this->checkTableName($tableName);
            if(count($checkTablename) == 0) continue 1;

            $sql = "SELECT * FROM " . $this->db->mydbprefix . "excptlog.`$tableName` $where ORDER BY `id` DESC LIMIT 1000";
            $query = $this->db->query($sql);
            foreach ($query->result_array() as $row)
            {
                $file = dirname(__FILE__) . $this->config->item('data_path') . 'dumpname/' . date("Y", $row['timeStamp']) . '/' . date("m", $row['timeStamp']) . '/' . date("d", $row['timeStamp']) . '/' . $row['dump'] . '.dmp';
                if(is_file($file)){
                    $excptLogList[] = $row;
                }
                if(count($excptLogList) >= 1000) break 2;
            }
        }
        return $excptLogList;
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        // TODO
    }
}