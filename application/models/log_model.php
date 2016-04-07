<?php

/**
 * 日志模型
 */
class Log_model extends CI_Model {

    private $ci;
    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('Arrayclass');
        $this->ci = &get_instance();
        $this->ci->load->model('Other_model');
    }

    /**
     * 获取用户量分析列表
     */
    public function getUsersList($startDate, $endDate, $ver, $cid)
    {
        $order = " ORDER BY `date` DESC ";

        if($cid != 'group' && $ver != 'group'){
            $select = " * ";
        }else{
            $select = " `date`, `ver`, `cid`, SUM(install) AS `install`, SUM(newInstall) AS `newInstall`, SUM(allNewInstall) AS `allNewInstall`, SUM(unInstall) AS `unInstall`, SUM(allUnInstall) AS `allUnInstall`, SUM(autoUpdate) AS `autoUpdate`, SUM(coverInstall) AS `coverInstall`, SUM(allKeep) AS `allKeep`, SUM(dayActiveUser) AS `dayActiveUser`, SUM(yesterdayActiveUser) AS `yesterdayActiveUser`, SUM(firstActiveUser) AS `firstActiveUser`, SUM(weekActiveUser) AS `weekActiveUser`, SUM(dayPostActive) AS `dayPostActive`, SUM(defaultBrowser) AS `defaultBrowser` ";
        }

        $where = '';
        $evalStr = '$users[$row[\'date\'] . \'_\' . $row[\'ver\'] . \'_\' . $row[\'cid\']] = $row;';
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
            $evalStr = '$users[$row[\'date\'] . \'_\' . $row[\'ver\'] . \'_\'] = $row;';
        }
        if($cid != 'group' && $ver == 'group'){
            $group = "GROUP BY `cid`, `date`";
            $order .= " , `cid` DESC ";
            $evalStr = '$users[$row[\'date\'] . \'__\' . $row[\'cid\']] = $row;';
        }
        if($cid == 'group' && $ver == 'group'){
            $group = "GROUP BY `date`";
            $evalStr = '$users[$row[\'date\'] . \'__\'] = $row;';
        }
        if($cid != 'group' && $ver != 'group'){
            $order .= " , `ver` DESC ";
        }

        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`users` WHERE `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";

        $query = $this->db->query($sql);
        $users = array();
        foreach ($query->result_array() as $row)
        {
            //$users[$row['date'] . '_' . $row['ver'] . '_' . $row['cid']] = $row;
            eval($evalStr);
        }
        return $users;
    }

    /**
     * 获取用户量(umid)分析列表
     * @param $startDate
     * @param $endDate
     * @param $ver
     * @param $cid
     * @return array
     */
    public function getUmidUsersList($startDate, $endDate, $ver, $cid)
    {
        $order = " ORDER BY `date` DESC ";

        if($cid != 'group' && $ver != 'group'){
            $select = " * ";
        }else{
            $select = " `date`, `ver`, `cid`, SUM(install) AS `install`, SUM(newInstall) AS `newInstall`, SUM(allNewInstall) AS `allNewInstall`, SUM(unInstall) AS `unInstall`, SUM(allUnInstall) AS `allUnInstall`, SUM(autoUpdate) AS `autoUpdate`, SUM(coverInstall) AS `coverInstall`, SUM(allKeep) AS `allKeep`, SUM(dayActiveUser) AS `dayActiveUser`, SUM(yesterdayActiveUser) AS `yesterdayActiveUser`, SUM(firstActiveUser) AS `firstActiveUser`, SUM(weekActiveUser) AS `weekActiveUser`, SUM(dayPostActive) AS `dayPostActive`, SUM(defaultBrowser) AS `defaultBrowser` ";
        }

        $where = '';
        $evalStr = '$users[$row[\'date\'] . \'_\' . $row[\'ver\'] . \'_\' . $row[\'cid\']] = $row;';
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
            $evalStr = '$users[$row[\'date\'] . \'_\' . $row[\'ver\'] . \'_\'] = $row;';
        }
        if($cid != 'group' && $ver == 'group'){
            $group = "GROUP BY `cid`, `date`";
            $order .= " , `cid` DESC ";
            $evalStr = '$users[$row[\'date\'] . \'__\' . $row[\'cid\']] = $row;';
        }
        if($cid == 'group' && $ver == 'group'){
            $group = "GROUP BY `date`";
            $evalStr = '$users[$row[\'date\'] . \'__\'] = $row;';
        }
        if($cid != 'group' && $ver != 'group'){
            $order .= " , `ver` DESC ";
        }

        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`umidUsers` WHERE `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";

        $query = $this->db->query($sql);
        $users = array();
        foreach ($query->result_array() as $row)
        {
            //$users[$row['date'] . '_' . $row['ver'] . '_' . $row['cid']] = $row;
            eval($evalStr);
        }
        return $users;
    }

    /**
     * 获取留存率列表
     */
    public function getKeepRateList($startDate, $endDate, $cid)
    {
        if($cid != 'group' ){
            $select = " * ";
        }else{
            $select = " `date`, SUM(newInstall) AS `newInstall` ";
            for($i=1; $i<=31; $i++){
                $select .= ", SUM(day" . $i . "Keep) AS `day" . $i . "Keep`";
            }
        }

        $where = '';
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

        if($cid == 'group'){
            $group = "GROUP BY `date`";
        }

        $order = " ORDER BY `date` DESC ";

        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`keepRate` WHERE `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";

        $query = $this->db->query($sql);
        $users = array();
        foreach ($query->result_array() as $row)
        {
            $users[] = $row;
        }
        return $users;
    }

    /**
     * 获取留存率(umid)列表
     * @param $startDate
     * @param $endDate
     * @param $cid
     * @return array
     */
    public function getUmidKeepRateList($startDate, $endDate, $cid)
    {
        if($cid != 'group' ){
            $select = " * ";
        }else{
            $select = " `date`, SUM(newInstall) AS `newInstall` ";
            for($i=1; $i<=31; $i++){
                $select .= ", SUM(day" . $i . "Keep) AS `day" . $i . "Keep`";
            }
        }

        $where = '';
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

        if($cid == 'group'){
            $group = "GROUP BY `date`";
        }

        $order = " ORDER BY `date` DESC ";

        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`umidKeepRate` WHERE `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";

        $query = $this->db->query($sql);
        $users = array();
        foreach ($query->result_array() as $row)
        {
            $users[] = $row;
        }
        return $users;
    }

    /**
     * 获取成功率分析列表
     */
    public function getSuccessRateList($startDate, $endDate, $ver, $cid)
    {
        $order = " ORDER BY `date` DESC ";

        if($cid != 'group' && $ver != 'group'){
            $select = " * ";
        }else{
            $select = " `date`, `ver`, `cid`, SUM(newInstallSuccess) AS `newInstallSuccess`, SUM(newInstallFailed) AS `newInstallFailed`, SUM(coverInstallSuccess) AS `coverInstallSuccess`, SUM(coverInstallFailed) AS `coverInstallFailed`, SUM(updateSuccess) AS `updateSuccess`, SUM(updateFailed) AS `updateFailed`, SUM(unInstallSuccess) AS `unInstallSuccess`, SUM(unInstallFailed) AS `unInstallFailed` ";
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

        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`successRate` WHERE `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";

        $query = $this->db->query($sql);
        $successRate = array();
        foreach ($query->result_array() as $row)
        {
            $successRate[] = $row;
        }
        return $successRate;
    }

    /**
     * 获取卸载原因分析列表
     */
    public function getUninstallReason($startDate, $endDate, $ver, $cid)
    {
        $order = " ORDER BY `date` DESC ";

        if($cid != 'group' && $ver != 'group'){
            $select = " * ";
        }else{
            $select = " `date`, `ver`, `cid`, SUM(r1) AS `r1`, SUM(r2) AS `r2`, SUM(r3) AS `r3`, SUM(r4) AS `r4`, SUM(r5) AS `r5`, SUM(r6) AS `r6`, SUM(r7) AS `r7`, SUM(r8) AS `r8`, SUM(`all`) AS `all`";
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

        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`uninstallReason` WHERE `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";

        $query = $this->db->query($sql);
        $uninstallReason = array();
        foreach ($query->result_array() as $row)
        {
            $uninstallReason[] = $row;
        }
        return $uninstallReason;
    }

    /**
     * 获取卸载详情列表
     */
    public function getUninstallDetail($startDate, $endDate, $ver, $cid, $ud, $start, $limit)
    {
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate) + 86400;
        $where = " WHERE `ud` != '' AND `timeStamp` >= '$startDate' AND `timeStamp` < '$endDate' ";
        if($ver !== 'all') $where .= ' AND ' . "`ver` = '$ver'";
        if($cid !== 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2') {
            $where .= ' AND ' . "`cid` = '$cid'";
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
        if($ud !== '') $where .= ' AND ' . "`ud` LIKE '%$ud%'";

        $limit = " LIMIT $start, $limit";

        $sql = "SELECT * FROM " . $this->db->mydbprefix . "logstatistics.uninstallDetail $where ORDER BY `id` DESC $limit";
        $query = $this->db->query($sql);
        $uninstallDetailList = array();
        foreach ($query->result_array() as $row)
        {
            $uninstallDetailList[] = $row;
        }

        return $uninstallDetailList;
    }

    /**
     * 获取卸载详情列表没分页
     */
    public function getUninstallDetailNoPage($startDate, $endDate, $ver, $cid, $ud)
    {
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate) + 86400;
        $where = " WHERE `ud` != '' AND `timeStamp` >= '$startDate' AND `timeStamp` < '$endDate' ";
        if($ver !== 'all') $where .= ' AND ' . "`ver` = '$ver'";
        if($cid !== 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2') {
            $where .= ' AND ' . "`cid` = '$cid'";
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
        if($ud !== '') $where .= ' AND ' . "`ud` LIKE '%$ud%'";

        $limit = " LIMIT 5000";

        $sql = "SELECT * FROM " . $this->db->mydbprefix . "logstatistics.uninstallDetail $where ORDER BY `id` DESC $limit";
        $query = $this->db->query($sql);
        $uninstallDetailList = array();
        foreach ($query->result_array() as $row)
        {
            $uninstallDetailList[] = $row;
        }

        return $uninstallDetailList;
    }

    /**
     * 获取卸载详情总数
     */
    public function getUninstallDetailCount($startDate, $endDate, $ver, $cid, $ud)
    {
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate) + 86400;
        $where = " WHERE `ud` != '' AND `timeStamp` >= '$startDate' AND `timeStamp` < '$endDate' ";
        if($ver !== 'all') $where .= ' AND ' . "`ver` = '$ver'";
        if($cid !== 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2') {
            $where .= ' AND ' . "`cid` = '$cid'";
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
        if($ud !== '') $where .= ' AND ' . "`ud` LIKE '%$ud%'";

        $sql = "SELECT COUNT(*) AS `num` FROM " . $this->db->mydbprefix . "logstatistics.uninstallDetail $where";
        $query = $this->db->query($sql);
        $data =  $query->row_array();
        return $data['num'];
    }

    /**
     * 获取卸载详情总数
     */
    public function getUninstallDetailSdata($date, $sid)
    {

        $sql = "SELECT * FROM " . $this->db->mydbprefix . "log.`unInstallQuestionPost$date` WHERE id='$sid' LIMIT 1";
        $query = $this->db->query($sql);
        $data =  $query->row_array();
        return $data;
    }

    /**
     * 获取意见反馈列表
     */
    public function getFeedbackDetail($startDate, $endDate, $ver, $cid, $ud, $start, $limit)
    {
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate) + 86400;
        $where = " WHERE `ud` != '' AND `timeStamp` >= '$startDate' AND `timeStamp` < '$endDate' ";
        if($ver !== 'all') $where .= ' AND ' . "`ver` = '$ver'";
        if($cid !== 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2') {
            $where .= ' AND ' . "`cid` = '$cid'";
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
        if($ud !== '') $where .= ' AND ' . "`ud` LIKE '%$ud%'";

        $limit = " LIMIT $start, $limit";

        $sql = "SELECT * FROM " . $this->db->mydbprefix . "logstatistics.feedbackDetail $where ORDER BY `id` DESC $limit";
        $query = $this->db->query($sql);
        $uninstallDetailList = array();
        foreach ($query->result_array() as $row)
        {
            $uninstallDetailList[] = $row;
        }

        return $uninstallDetailList;
    }

    /**
     * 获取意见反馈列表没分页
     */
    public function getFeedbackDetailNoPage($startDate, $endDate, $ver, $cid, $ud)
    {
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate) + 86400;
        $where = " WHERE `ud` != '' AND `timeStamp` >= '$startDate' AND `timeStamp` < '$endDate' ";
        if($ver !== 'all') $where .= ' AND ' . "`ver` = '$ver'";
        if($cid !== 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2') {
            $where .= ' AND ' . "`cid` = '$cid'";
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
        if($ud !== '') $where .= ' AND ' . "`ud` LIKE '%$ud%'";

        $limit = " LIMIT 5000";

        $sql = "SELECT * FROM " . $this->db->mydbprefix . "logstatistics.feedbackDetail $where ORDER BY `id` DESC $limit";
        $query = $this->db->query($sql);
        $uninstallDetailList = array();
        foreach ($query->result_array() as $row)
        {
            $uninstallDetailList[] = $row;
        }

        return $uninstallDetailList;
    }

    /**
     * 获取意见反馈总数
     */
    public function getFeedbackDetailCount($startDate, $endDate, $ver, $cid, $ud)
    {
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate) + 86400;
        $where = " WHERE `ud` != '' AND `timeStamp` >= '$startDate' AND `timeStamp` < '$endDate' ";
        if($ver !== 'all') $where .= ' AND ' . "`ver` = '$ver'";
        if($cid !== 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2') {
            $where .= ' AND ' . "`cid` = '$cid'";
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
        if($ud !== '') $where .= ' AND ' . "`ud` LIKE '%$ud%'";

        $sql = "SELECT COUNT(*) AS `num` FROM " . $this->db->mydbprefix . "logstatistics.feedbackDetail $where";
        $query = $this->db->query($sql);
        $data =  $query->row_array();
        return $data['num'];
    }

    /**
     * 获取意见反馈源数据
     */
    public function getFeedbackDetailSdata($date, $sid)
    {

        $sql = "SELECT * FROM " . $this->db->mydbprefix . "log.`feedback$date` WHERE id='$sid' LIMIT 1";
        $query = $this->db->query($sql);
        $data =  $query->row_array();
        return $data;
    }

    /**
     * 获取错误码分析列表
     */
    public function getErrorCodeList($date, $cid, $ver, $type, $result, $errorCode)
    {
        $order = " ORDER BY `number` DESC ";

        if($cid != 'group' && $ver != 'group' && $type != 'group' && $result != 'group'){
            $select = " * ";
        }else{
            $select = " `date`, `cid`, `ver`, `type`, `result`, `errorCode`, SUM(number) AS `number` ";
        }

        $where = '';
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
        if($ver != 'all' && $ver != 'group'){
            $where .= " AND `ver` = '$ver' ";
        }
        if($type != 'all' && $type != 'group'){
            $where .= " AND `type` = '$type' ";
        }
        if($result != 'all' && $result != 'group'){
            $where .= " AND `result` = '$result' ";
        }

        if($errorCode != ''){
            $where .= " AND `errorCode` = '$errorCode' ";
        }

        $group = " GROUP BY `errorCode` ";
        if($cid != 'group' ){
            $group .= " ,`cid` ";
        }
        if($ver != 'group' ){
            $group .= " ,`ver` ";
        }
        if($type != 'group' ){
            $group .= " ,`type` ";
        }
        if($result != 'group' ){
            $group .= " ,`result` ";
        }

        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`errorCode` WHERE `date` = '$date' $where $group $order";

        $query = $this->db->query($sql);
        $data = array();
        $allNumber = 0;
        foreach ($query->result_array() as $row)
        {
            $data[] = $row;
            $allNumber += $row['number'];
        }
        return array('data' => $data, 'allNumber' => $allNumber);
    }

    /**
     * 获取版本字典
     */
    public function getVerMapDb()
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "logstatistics.`verMap` ORDER BY ver DESC";
        $query = $this->db->query($sql);
        $verMap = array();
        foreach ($query->result_array() as $row)
        {
            $verMap[] = $row['ver'];
        }
        return $verMap;
    }

    /**
     * 获取版本字典去除错误数据
     */
    public function getVerMap()
    {
        $verMap = $this->getVerMapDb();
        $pot = "/\d\.\d\.\d\.\d/";
        foreach ($verMap as $key => $row)
        {
            if(!preg_match($pot,$row))
                unset($verMap[$key]);
        }
        return $verMap;
    }

    /**
     * 获取渠道字典
     */
    public function getCidMap()
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "logstatistics.`cidMap`";
        $query = $this->db->query($sql);
        $cidMap = array();
        foreach ($query->result_array() as $row)
        {
            if(strpos($row['cid'], '"') !== false)
               $row['cid'] = str_replace('"', '', $row['cid']);
            if(strpos($row['cid'], ';') !== false)
                unset($row['cid']);
            $cidMap[] = $row['cid'];
        }
        return $cidMap;
    }

    /**
     * 获取渠道字典
     */
    public function getDefCidMap()
    {
        $sql = "SELECT cid FROM " . $this->db->mydbprefix . "backstage.`tnList`";
        $query = $this->db->query($sql);
        $cidMap = array();
        foreach ($query->result_array() as $row)
        {
            if(strpos($row['cid'], '"') !== false)
                $row['cid'] = str_replace('"', '', $row['cid']);
            $cidMap[] = $row['cid'];
        }
        return $cidMap;
    }

    /**
     * 获取实时日活跃用户
     */
    public function getNowDayActive()
    {
        $tableSuffix = date("Ymd", time());
        $sql = "SELECT COUNT(*) AS nowDayActive FROM (SELECT * FROM " . $this->db->mydbprefix . "log.updateCheck$tableSuffix GROUP BY `mid`) AS oneMid LIMIT 1";
        $query = $this->db->query($sql);
        $data =  $query->row_array();
        return $data['nowDayActive'];
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
        foreach($dateArray as $date){
            $tDateName = $tableName . $date;
            $tableNameArray[$tDateName] = $tDateName;
        }
        return $tableNameArray;
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
     * 获取渠道数据
     */
    public function getCanalDataList($startDate, $endDate, $cid)
    {
        $where = " WHERE `date` >= '$startDate' AND `date` <= '$endDate' ";
        if($cid != 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2'){
            $where .= " AND `cid` = '$cid'";
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
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "logstatistics.canalData $where ORDER BY `date` DESC";
        $query = $this->db->query($sql);
        $dataList = array();
        foreach ($query->result_array() as $row)
        {
            $dataList[] = $row;
        }
        return $dataList;
    }

    /**
     * 创建今天和明天的表
     */
    public function createTodayAndNextDayTable()
    {
        $today = date("Ymd", time());
        $nextDay = date("Ymd", time() + 86400);
        $logTypeList = $this->getGlogTypeList();
        $sql = $this->db->glog_mysql;

        foreach ($logTypeList as $type) {
            if(trim($type) != ''){
                $todayTable = trim($type) . $today;
                $nextdayTable = trim($type) . $nextDay;
                $logSql = $sql;
                $logSql = str_replace('`库名`', '`' . $this->db->mydbprefix . 'log`', $logSql);
                $logSql = str_replace('`表名`', '`' . $todayTable . '`', $logSql);
                $this->db->query($logSql);
                $logSql = $sql;
                $logSql = str_replace('`库名`', '`' . $this->db->mydbprefix . 'log`', $logSql);
                $logSql = str_replace('`表名`', '`' . $nextdayTable . '`', $logSql);
                $this->db->query($logSql);
            }
        }
    }

    /**
     * 获取通用设置
     *
     * @return array $data
     */
    private function getGlogTypeList()
    {
        $sql = "SELECT * FROM " . $this->db->mydbprefix . "update.generalConf WHERE id = '2' LIMIT 1";
        $query = $this->db->query($sql);
        $data =  $query->row_array();
        $data = explode("\n", $data['f1']);
        return $data;
    }

    /**
     * 获取视频快进分析列表
     */
    public function getVideoFFList($startDate, $endDate, $ver, $cid)
    {
        $order = " ORDER BY `date` DESC ";

        if($cid != 'group' && $ver != 'group'){
            $select = " * ";
        }else{
            $select = " `date`, `ver`, `cid`";
            $extList = array('a', 'b', 'c', 'd', 'e');
            foreach($extList as $letter){
                for($i=0; $i<10; $i++){
                    $field = $letter . ($i+1);
                    $fieldt = $field . '-t';
                    $fieldu = $field . '-u';
                    $select .= ", SUM(`$fieldt`) AS `$fieldt`, SUM(`$fieldu`) AS `$fieldu`";
                }
            }
        }

        $where = '';
        $evalStr = '$users[$row[\'date\'] . \'_\' . $row[\'ver\'] . \'_\' . $row[\'cid\']] = $row;';
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
            $evalStr = '$users[$row[\'date\'] . \'_\' . $row[\'ver\'] . \'_\'] = $row;';
        }
        if($cid != 'group' && $ver == 'group'){
            $group = "GROUP BY `cid`, `date`";
            $order .= " , `cid` DESC ";
            $evalStr = '$users[$row[\'date\'] . \'__\' . $row[\'cid\']] = $row;';
        }
        if($cid == 'group' && $ver == 'group'){
            $group = "GROUP BY `date`";
            $evalStr = '$users[$row[\'date\'] . \'__\'] = $row;';
        }
        if($cid != 'group' && $ver != 'group'){
            $order .= " , `ver` DESC ";
        }

        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`gLog` WHERE `type` = 'speedup' AND `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";

        $query = $this->db->query($sql);
        $users = array();
        foreach ($query->result_array() as $row)
        {
            eval($evalStr);
        }
        return $users;
    }

    /**
     * 获取新标签页点击数据
     */
    public function getNtadsClick($startDate)
    {
        $tableSuffix = date("Ymd", strtotime($startDate));
        $tableName = 'ntadsclk' . $tableSuffix;
        $ctn = $this->checkTableName($tableName);
        if(count($ctn) < 1) return array();

        $sql = "SELECT COUNT(*) AS `times`, COUNT(DISTINCT `umid`) AS `users`, `h`, `as1` FROM " . $this->db->mydbprefix . "log.`$tableName` GROUP BY `h`, `as1` ORDER BY `id` DESC";

        $query = $this->db->query($sql);
        $data = array();
        foreach ($query->result_array() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    /**
     * 获取通用日志分析分析列表
     */
    public function getGlogList($startDate, $endDate, $ver, $cid, $type)
    {
        $order = " ORDER BY `date` DESC ";

        if($cid != 'group' && $ver != 'group'){
            $select = " * ";
        }else{
            $select = " `date`, `ver`, `cid`";
            $extList = array('a', 'b', 'c', 'd', 'e');
            foreach($extList as $letter){
                for($i=0; $i<10; $i++){
                    $field = $letter . ($i+1);
                    $fieldt = $field . '-t';
                    $fieldu = $field . '-u';
                    $select .= ", SUM(`$fieldt`) AS `$fieldt`, SUM(`$fieldu`) AS `$fieldu`";
                }
            }
        }

        $where = '';
        $evalStr = '$users[$row[\'date\'] . \'_\' . $row[\'ver\'] . \'_\' . $row[\'cid\']] = $row;';
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
            $evalStr = '$users[$row[\'date\'] . \'_\' . $row[\'ver\'] . \'_\'] = $row;';
        }
        if($cid != 'group' && $ver == 'group'){
            $group = "GROUP BY `cid`, `date`";
            $order .= " , `cid` DESC ";
            $evalStr = '$users[$row[\'date\'] . \'__\' . $row[\'cid\']] = $row;';
        }
        if($cid == 'group' && $ver == 'group'){
            $group = "GROUP BY `date`";
            $evalStr = '$users[$row[\'date\'] . \'__\'] = $row;';
        }
        if($cid != 'group' && $ver != 'group'){
            $order .= " , `ver` DESC ";
        }

        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`gLog` WHERE `type` = '$type' AND `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";

        $query = $this->db->query($sql);
        $users = array();
        foreach ($query->result_array() as $row)
        {
            eval($evalStr);
        }
        return $users;
    }

    /**
     * 获取新装用户环境操作系统版本信息
     * @param $startDate
     * @param $endDate
     * @param $cid
     * @return array
     */
    public function getNewInstallUsersOsList($startDate, $endDate, $ver, $cid)
    {
        $order = "ORDER BY `date` DESC";
        if($ver != 'group' && $cid != 'group'){
            $select = "*";
        }else{
            $select = "`date`, `ver`, `cid`, SUM(`xp`) AS  `xp`, SUM(`win7`) AS  `win7`, SUM(`win8`) AS  `win8`, SUM(`otherOs`) AS  `otherOs`";
        }
        $where = "";
        if($ver != 'all' && $ver != 'group'){
            $where .= " AND `ver` = '$ver'";
        }
        if($cid != 'all' && $cid != 'group' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2'){
            $where .= " AND `cid` = '$cid'";
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
            $group = "GROUP BY `date`, `ver`";
            $order .= ", `ver` DESC";
        }
        if($cid != 'group' && $ver == 'group'){
            $group = "GROUP BY `date`, `cid`";
            $order = ", `cid` DESC";
        }
        if($cid == 'group' && $ver == 'group' ){
            $group = "GROUP BY `date`";
        }
        if($cid != 'group' && $ver != 'group'){
            $group = "GROUP BY `date`, `ver`, `cid`";
            $order .= ", `ver` DESC, `cid` DESC";
        }
        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics. `newInstallUsersOs` WHERE `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";
        $query = $this->db->query($sql);
        $usersOs = array();
        foreach($query->result_array() as $row){
            $usersOs[] = $row;
        }
        return $usersOs;
    }

    /**
     * 获取报活用户操作系统版本信息
     * @param $startDate
     * @param $endDate
     * @param $ver
     * @param $cid
     * @return array
     */
    public function getUpdateCheckUsersOsList($startDate, $endDate, $ver, $cid)
    {
        $order = "ORDER BY `date` DESC";
        if($ver != 'group' && $cid != 'group'){
            $select = "*";
        }else{
            $select = "`date`, `ver`, `cid`, SUM(`xp`) AS  `xp`, SUM(`win7`) AS  `win7`, SUM(`win8`) AS  `win8`, SUM(`otherOs`) AS  `otherOs`";
        }
        $where = "";
        if($ver != 'all' && $ver != 'group'){
            $where .= " AND `ver` = '$ver'";
        }
        if($cid != 'all' && $cid != 'group' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2'){
            $where .= " AND `cid` = '$cid'";
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
            $group = "GROUP BY `date`, `ver`";
            $order .= ", `ver` DESC";
        }
        if($cid != 'group' && $ver == 'group'){
            $group = "GROUP BY `date`, `cid`";
            $order = ", `cid` DESC";
        }
        if($cid == 'group' && $ver == 'group' ){
            $group = "GROUP BY `date`";
        }
        if($cid != 'group' && $ver != 'group'){
            $group = "GROUP BY `date`, `ver`, `cid`";
            $order .= ", `ver` DESC, `cid` DESC";
        }
        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics. `updatecheckUsersOs` WHERE `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";
        $query = $this->db->query($sql);
        $usersOs = array();
        foreach($query->result_array() as $row){
            $usersOs[] = $row;
        }
        return $usersOs;
    }

    /**
     * 获取新装用户环境安全软件信息
     * @param $startDate
     * @param $endDate
     * @param $ver
     * @param $cid
     */
    public function getNewInstallUsersSafeList($startDate, $endDate, $ver, $cid)
    {
        $order = "ORDER BY `date` DESC";
        if($ver != 'group' && $cid != 'group'){
            $select = "*";
        }else{
            $select = "`date`, `ver`, `cid`, SUM(`360safe`) AS `360safe`, SUM(`tencent`) AS `tencent`, SUM(`baidu`) AS `baidu`, SUM(`kingsoft`) AS `kingsoft`, SUM(`nosafe`) AS `nosafe`, SUM(`totalAmount`) AS `totalAmount`";
        }
        $where = "";
        if($ver != 'group' && $ver != 'all'){
            $where .= " AND `ver` = '$ver'";
        }
        if($cid != 'group' && $cid != 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2'){
            $where .= " AND `cid` = '$cid'";
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

        if($cid =='group' && $ver !='group'){
            $group = "GROUP BY `date`, `ver`";
        }
        if($cid != 'group' && $ver =='group'){
            $group = "GROUP BY `date`, `cid`";
            $order .= ", `cid` DESC";
        }
        if($cid != 'group' && $ver != 'group'){
            $group = "GROUP BY `date`, `ver`, `cid`";
            $order .= ", `ver` DESC, `cid` DESC";
        }
        if($cid == 'group' && $ver == 'group'){
            $group = "GROUP BY `date`";
        }

        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics. `newInstallUsersSafe` WHERE `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";
        $query = $this->db->query($sql);
        $usersSafe = array();
        foreach($query->result_array() as $row){
            $usersSafe[] = $row;
        }
        return $usersSafe;
    }

    /**
     * 获取报活用户环境安全软件信息
     * @param $startDate
     * @param $endDate
     * @param $ver
     * @param $cid
     */
    public function getUpdateCheckUsersSafeList($startDate, $endDate, $ver, $cid)
    {
        $order = "ORDER BY `date` DESC";
        if($ver != 'group' && $cid != 'group'){
            $select = "*";
        }else{
            $select = "`date`, `ver`, `cid`, SUM(`360safe`) AS `360safe`, SUM(`tencent`) AS `tencent`, SUM(`baidu`) AS `baidu`, SUM(`kingsoft`) AS `kingsoft`, SUM(`nosafe`) AS `nosafe`, SUM(`totalAmount`) AS `totalAmount`";
        }
        $where = "";
        if($ver != 'group' && $ver != 'all'){
            $where .= " AND `ver` = '$ver'";
        }
        if($cid != 'group' && $cid != 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2'){
            $where .= " AND `cid` = '$cid'";
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


        if($cid =='group' && $ver !='group'){
            $group = "GROUP BY `date`, `ver`";
        }
        if($cid != 'group' && $ver =='group'){
            $group = "GROUP BY `date`, `cid`";
            $order .= ", `cid` DESC";
        }
        if($cid != 'group' && $ver != 'group'){
            $group = "GROUP BY `date`, `ver`, `cid`";
            $order .= ", `ver` DESC, `cid` DESC";
        }
        if($cid == 'group' && $ver == 'group'){
            $group = "GROUP BY `date`";
        }

        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics. `updateCheckUsersSafe` WHERE `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";
        $query = $this->db->query($sql);
        $usersSafe = array();
        foreach($query->result_array() as $row){
            $usersSafe[] = $row;
        }
        return $usersSafe;
    }

    /**
     * 获取新装用户环境IE版本信息
     * @param $startDate
     * @param $endDate
     * @param $ver
     * @param $cid
     */
    public function getNewInstallUsersIEList($date, $ver, $cid)
    {
        $select = "`ie`, SUM(`ieAmount`) as `totalIE`";
        $where = "";
        if($ver != 'all'){
            $where .= " AND `ver` = '$ver'";
        }
        if($cid != 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2'){
            $where .= " AND `cid` = '$cid'";
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
        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`newInstallUsersIE` WHERE `date` ='$date' $where GROUP BY `ie` ORDER BY `totalIE` DESC LIMIT 10";
        $query = $this->db->query($sql);
        $usersIE = array();
        $all = 0;
        foreach($query->result_array() as $row){
            $usersIE[$row['ie']] = $row['totalIE'];
            $all += $row['totalIE'];
        }
        $data['list'] = $usersIE;
        $data['all'] = $all;
        return $data;
    }

    /**
     * 获取报活用户环境IE版本信息
     * @param $date
     * @param $ver
     * @param $cid
     * @return array
     */
    public function getUpdateCheckUsersIEList($date, $ver, $cid)
    {
        $select = "`ie`, SUM(`ieAmount`) as `totalIE`";
        $where = "";
        if($ver != 'all'){
            $where .= " AND `ver` = '$ver'";
        }
        if($cid != 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2'){
            $where .= " AND `cid` = '$cid'";
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

        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`updateCheckUsersIE` WHERE `date` ='$date' $where GROUP BY `ie` ORDER BY `totalIE` DESC LIMIT 10";
        $query = $this->db->query($sql);
        $usersIE = array();
        $all = 0;
        foreach($query->result_array() as $row){
            $usersIE[$row['ie']] = $row['totalIE'];
            $all += $row['totalIE'];
        }
        $data['list'] = $usersIE;
        $data['all'] = $all;
        return $data;
    }

    /**
     * 获取新装用户环境Flash版本信息
     * @param $date
     * @param $ver
     * @param $cid
     * @return mixed
     */
    public function getNewInstallUsersFlashList($date, $ver, $cid)
    {
        $select = "`flash`, SUM(`flashAmount`) as `totalFlash`";
        $where = "";
        if($ver != 'all'){
            $where .= " AND `ver` = '$ver'";
        }
        if($cid != 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2'){
            $where .= " AND `cid` = '$cid'";
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
        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`newInstallUsersFlash` WHERE `date` ='$date' $where GROUP BY `flash` ORDER BY `totalFlash` DESC LIMIT 50";
        $query = $this->db->query($sql);
        $usersFlash = array();
        $all = 0;
        foreach($query->result_array() as $row){
            $usersFlash[$row['flash']] = $row['totalFlash'];
            $all += $row['totalFlash'];
        }
        $data['list'] = $usersFlash;
        $data['all'] = $all;
        return $data;
    }

    /**
     * 获取报活用户环境Flash版本信息
     * @param $date
     * @param $ver
     * @param $cid
     * @return mixed
     */
    public function getUpdateCheckUsersFlashList($date, $ver, $cid)
    {
        $select = "`flash`, SUM(`flashAmount`) AS `totalFlash`";
        $where = "";
        if($ver != 'all'){
            $where .= " AND `ver` = '$ver'";
        }
        if($cid != 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2'){
            $where .= " AND `cid` = '$cid'";
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
        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`updateCheckUsersFlash` WHERE `date` ='$date' $where GROUP BY `flash` ORDER BY `totalFlash` DESC LIMIT 50";
        $query = $this->db->query($sql);
        $usersFlash = array();
        $all = 0;
        foreach($query->result_array() as $row){
            $usersFlash[$row['flash']] = $row['totalFlash'];
            $all += $row['totalFlash'];
        }
        $data['list'] = $usersFlash;
        $data['all'] = $all;
        return $data;
    }

    /**
     * 获取卸载用户卸载父进程信息
     * @param $date
     * @param $ver
     * @param $cid
     * @return mixed
     */
    public function getUnInstallParentProcess($date, $ver, $cid)
    {
        $select = "`ipr`, SUM(`iprAmount`) AS `iprAmount`";
        $where = "";
        if($ver != 'all'){
            $where .= " AND `ver` = '$ver'";
        }
        if($cid != 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2'){
            $where .= "AND `cid` = '$cid'";
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
        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`unInstallParentProcess` WHERE `date` = '$date' $where GROUP BY `ipr` ORDER BY `iprAmount` DESC LIMIT 50";
        $query = $this->db->query($sql);
        $usersUnInstallPProcess = array();
        $all = 0;
        foreach($query->result_array() as $row){
            $usersUnInstallPProcess[$row['ipr']] = $row['iprAmount'];
            $all += $row['iprAmount'];
        }
        $data['list'] = $usersUnInstallPProcess;
        $data['all'] = $all;
        return $data;
    }

    /**
     * 获取报活用户外链启动域名信息(前50)
     * @param $date
     * @param $ver
     * @param $cid
     * @return mixed
     */
    public function getUpdateCheckOuterLinkDomain($date, $ver, $cid)
    {
        $select = "`op2`, SUM(`op2Amount`) AS `op2Amount`";
        $where = "";
        if($ver != 'all')
            $where .= " AND `ver` = '$ver'";
        if($cid != 'all')
            $where .= " AND `cid` = '$cid'";
        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`outerLinkDomain` WHERE `date` = '$date' $where GROUP BY `op2` ORDER BY `op2Amount` DESC LIMIT 50";
        $query = $this->db->query($sql);
        $usersUCOLD = array();
        $all = 0;
        foreach($query->result_array() as $row){
            $usersUCOLD[$row['op2']] = $row['op2Amount'];
            $all += $row['op2Amount'];
        }
        $data['list'] = $usersUCOLD;
        $data['all'] = $all;
        return $data;
    }

    /**
     * 获取报活用户用户习惯启动页信息
     * @param $startDate
     * @param $endDate
     * @param $ver
     * @param $cid
     * @return array
     */
    public function getUpdateCheckUsersHomePageList($startDate, $endDate, $ver, $cid)
    {
        $order = "ORDER BY `date` DESC";
        if($ver != 'group' && $cid != 'group'){
            $select = "*";
        }else{
            $select = "`date`, `ver`, `cid`, SUM(`hao123PrivateId`) AS `hao123PrivateId`, SUM(`baidu`) AS `baidu`, SUM(`newLabelPage`) AS `newLabelPage`, SUM(`hao123NonPrivateId`) AS `hao123NonPrivateId`, SUM(`other`) AS `other`";
        }
        $where = "";
        if($ver != 'group' && $ver != 'all'){
            $where .= " AND `ver` = '$ver'";
        }
        if($cid != 'group' && $cid != 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2'){
            $where .= " AND `cid` = '$cid'";
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
            $group = "GROUP BY `date`, `ver`";
            $order .= ", `ver` DESC";
        }
        if($cid != 'group' && $ver == 'group'){
            $group = "GROUP BY `date`, `cid`";
            $order .= ", `cid` DESC";
        }
        if($cid != 'group' && $ver != 'group'){
            $group = "GROUP BY `date`, `ver`, `cid`";
            $order .= ", `ver` DESC, `cid` DESC";
        }
        if($cid == 'group' && $ver == 'group'){
            $group = "GROUP BY `date`";
        }
        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`updateCheckUsersHomePage` WHERE `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";
        $query = $this->db->query($sql);
        $usersHomePage = array();
        foreach($query->result_array() as $row){
            $usersHomePage[] = $row;
        }
        return $usersHomePage;
    }

    /**
     * 获取报活用户用户习惯hao123访问量
     * @param $startDate
     * @param $endDate
     * @param $ver
     * @param $cid
     * @return array
     */
    public function getUpdateCheckUsersHao123PageView($startDate, $endDate, $ver, $cid)
    {
        $order = "ORDER BY `date` DESC";
        if($ver != 'group' && $cid != 'group'){
            $select = "*";
        }else{
            $select = "`date`, `ver`, `cid`, SUM(`privateTnPV`) AS `privateTnPV`, SUM(`privateTnUV`) AS `privateTnUV`, SUM(`nonPrivateTnPV`) AS `nonPrivateTnPV`, SUM(`nonPrivateTnUV`) AS `nonPrivateTnUV`, SUM(`tnIsNullPV`) AS `tnIsNullPV`, SUM(`tnIsNullUV`) AS `tnIsNullUV`, SUM(`privateTnTryRepairPV`) AS `privateTnTryRepairPV`, SUM(`privateTnTryRepairUV`) AS `privateTnTryRepairUV`, SUM(`timeOutPV`) AS `timeOutPV`, SUM(`timeOutUV`) AS `timeOutUV`, SUM(`numberOutPV`) AS `numberOutPV`, SUM(`numberOutUV`) AS `numberOutUV`";
        }
        $where = "";
        if($ver != 'group' && $ver != 'all'){
            $where .= " AND `ver` = '$ver'";
        }
        if($cid != 'group' && $cid != 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2'){
            $where .= " AND `cid` = '$cid'";
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
            $group = "GROUP BY `date`, `ver`";
            $order .= ", `ver` DESC";
        }
        if($cid != 'group' && $ver == 'group'){
            $group = "GROUP BY `date`, `cid`";
            $order .= ", `cid` DESC";
        }
        if($cid != 'group' && $ver != 'group'){
            $group = "GROUP BY `date`, `ver`, `cid`";
            $order .= ", `ver` DESC, `cid` DESC";
        }
        if($cid == 'group' && $ver == 'group'){
            $group = "GROUP BY `date`";
        }
        $sql = "SELECT $select from " . $this->db->mydbprefix . "logstatistics.`updateCheckUsersHao123PageView` WHERE `date` >= '$startDate' AND `date` <= 'endDate' $where $group $order";
        $query = $this->db->query($sql);
        $usersHao123PageView = array();
        foreach($query->result_array() as $row){
            $usersHao123PageView[] = $row;
        }
        return $usersHao123PageView;
    }

    /**
     * 获取报活用户用户习惯默认搜索引擎信息
     * @param $startDate
     * @param $endDate
     * @param $ver
     * @param $cid
     * @return array
     */
    public function getUpdateCheckUsersDefaultSearchEngineList($startDate, $endDate, $ver ,$cid)
    {
        $order = "ORDER BY `date` DESC";
        if($ver != 'group' && $cid != 'group'){
            $select = "*";
        }else{
            $select = "`date`, `ver`, `cid`, SUM(`baidu`) AS `baidu`, SUM(`google`) AS `google`, SUM(`360so`) AS `360so`, SUM(`sogou`) AS `sogou`, SUM(`soso`) AS `soso`, SUM(`other`) AS `other`";
        }
        $where = "";
        if($ver != 'group' && $ver != 'all'){
            $where .= " AND `ver` = '$ver'";
        }
        if($cid != 'group' && $cid != 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2'){
            $where .= " AND `cid` = '$cid'";
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
            $group = "GROUP BY `date`, `ver`";
            $order .= ", `ver` DESC";
        }
        if($cid != 'group' && $ver == 'group'){
            $group = "GROUP BY `date`, `cid`";
            $order .= ", `cid` DESC";
        }
        if($cid != 'group' && $ver != 'group'){
            $group = "GROUP BY `date`, `ver`, `cid`";
            $order .= ", `ver` DESC, `cid` DESC";
        }
        if($cid == 'group' && $ver == 'group'){
            $group = "GROUP BY `date`";
        }
        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`updateCheckUsersDefaultSearchEngine` WHERE `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";
        $query = $this->db->query($sql);
        $usersDefaultSearchEngine = array();
        foreach($query->result_array() as $row){
            $usersDefaultSearchEngine[] = $row;
        }
        return $usersDefaultSearchEngine;
    }

    /**
     * 获取报活用户设默数据信息
     * @param $startDate
     * @param $endDate
     * @param $ver
     * @param $cid
     * @return array
     */
    public function getUpdateCheckUsersSetDefaultList($startDate, $endDate, $ver, $cid)
    {
        $order = "ORDER BY `date` DESC";
        if($ver != 'group' && $cid != 'group'){
            $select = "*";
        }else{
            $select = "`date`, `ver`, `cid`, SUM(`sd1Amount`) AS `sd1Amount`, SUM(`sd2Amount`) AS `sd2Amount`, SUM(`reminderSetDef`) AS `reminderSetDef`, SUM(`noReminderSetDef`) AS `noReminderSetDef`";
        }
        $where = "";
        if($ver != 'group' && $ver != 'all'){
            $where .= " AND `ver` = '$ver'";
        }
        if($cid != 'group' && $cid != 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2'){
            $where .= " AND `cid` = '$cid'";
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
            $group = "GROUP BY `date`, `ver`";
            $order .= ", `ver` DESC";
        }
        if($cid != 'group' && $ver == 'group'){
            $group = "GROUP BY `date`, `cid`";
            $order .= ", `cid` DESC";
        }
        if($cid != 'group' && $ver != 'group'){
            $group = "GROUP BY `date`, `ver`, `cid`";
            $order .= ", `ver` DESC, `cid` DESC";
        }
        if($cid == 'group' && $ver == 'group'){
            $group = "GROUP BY `date`";
        }
        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`setDefaultData` WHERE `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";
        $query = $this->db->query($sql);
        $usersSetDef = array();
        foreach($query->result_array() as $row){
            $usersSetDef[] = $row;
        }
        return $usersSetDef;
    }

    /**
     * 获取报活用户上网行为数据信息
     * @param $startDate
     * @param $endDate
     * @param $ver
     * @param $cid
     * @return array
     */
    public function getUpdateCheckUsersInternetBehavior($startDate, $endDate, $ver, $cid)
    {
        $order = "ORDER BY `date` DESC";
        if($ver != 'group' && $cid != 'group'){
            $select = "*";
        }else{
            $select = "`date`, `ver`, `cid`, SUM(`shoppingPV`) AS `shoppingPV`, SUM(`shoppingUV`) AS `shoppingUV`, SUM(`gamePV`) AS `gamePV`, SUM(`gameUV`) AS `gameUV`, SUM(`socialNetworkPV`) AS `socialNetworkPV`, SUM(`socialNetworkUV`) AS `socialNetworkUV`, SUM(`videoPV`) AS `videoPV`, SUM(`videoUV`) AS `videoUV`, SUM(`newsPV`) AS `newsPV`, SUM(`newsUV`) AS `newsUV`, SUM(`searchPV`) AS `searchPV`, SUM(`searchUV`) AS `searchUV`, SUM(`ITPV`) AS `ITPV`, SUM(`ITUV`) AS `ITUV`, SUM(`sportsPV`) AS `sportsPV`, SUM(`sportsUV`) AS `sportsUV`, SUM(`femalePV`) AS `femalePV`, SUM(`femaleUV`) AS `femaleUV`";
        }
        $where = "";
        if($ver != 'group' && $ver != 'all'){
            $where .= " AND `ver` = '$ver'";
        }
        if($cid != 'group' && $cid != 'all' && $cid != 'Organ' && $cid != 'D2' && $cid != 'U2'){
            $where .= " AND `cid` = '$cid'";
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
            $group = "GROUP BY `date`, `ver`";
            $order .= ", `ver` DESC";
        }
        if($cid != 'group' && $ver == 'group'){
            $group = "GROUP BY `date`, `cid`";
            $order .= ", `cid` DESC";
        }
        if($cid != 'group' && $ver != 'group'){
            $group = "GROUP BY `date`, `ver`, `cid`";
            $order .= ", `ver` DESC, `cid` DESC";
        }
        if($cid == 'group' && $ver == 'group'){
            $group = "GROUP BY `date`";
        }
        $sql = "SELECT $select FROM " . $this->db->mydbprefix . "logstatistics.`internetBehavior` WHERE `date` >= '$startDate' AND `date` <= '$endDate' $where $group $order";
        $query = $this->db->query($sql);
        $usersIB = array();
        foreach($query->result_array() as $row){
            $usersIB[] = $row;
        }
        return $usersIB;
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        // TODO
    }
}