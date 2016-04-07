<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta charset="utf-8">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title><?php echo $title?></title>
<link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' />
<link rel='stylesheet' href='bootstrap/css/bootstrap-datetimepicker.min.css' />
<link rel='stylesheet' href='bootstrap/css/bootstrap-select.min.css' />
<link rel='stylesheet' href='bootstrap/css/bootstrap-switch.min.css' />
<link rel='stylesheet' href='bootstrap/css/tablecloth.css' >
<link rel='stylesheet' href='bootstrap/css/prettify.css' >
<link rel='stylesheet' href='bootstrap/css/bootstrap-combobox.css' >
<link rel='stylesheet' href='css/main.css' />
<script src="js/jquery-1.9.1.min.js"></script>
<script src="js/juzi.js"></script>
</head>
<body id="juziAround">


<div class="navbar navbar-inverse navbar-fixed-top">

    <div id="juziBall" style="left: 100px; top: 0px; width:50px; height:50px; background:url(img/juzi_logo.png) no-repeat; position:absolute; cursor: move; z-index: 9999;"></div>

    <div class="container">

    <div class="navbar-header">
        <a href="index.php?/user/welcome/" class="navbar-brand" style="color: #FFFFFF;">桔子</a>
    </div>

    <div id="bs-example-navbar-collapse-8" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">

            <?php if(in_array('log_glog_list', $userInfo['permission']) || in_array('log_glog_title_add', $userInfo['permission']) || in_array('log_ntads_click', $userInfo['permission']) || in_array('log_canal_data', $userInfo['permission']) || in_array('log_keep_rate', $userInfo['permission']) || in_array('log_umid_keep_rate', $userInfo['permission']) || in_array('log_users', $userInfo['permission']) || in_array('log_umid_users', $userInfo['permission'])):?>
            <li class="dropdown <?php if($group == 'user'):?>active<?php endif;?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php if($group == 'user'):?><?php echo $title?><?php else:?>用户数据<?php endif;?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php if(in_array('log_users', $userInfo['permission'])):?>
                    <li><a href="index.php?/log/users/">用户量</a></li>
                    <?php endif;?>
                    <?php if(in_array('log_umid_users', $userInfo['permission'])):?>
                        <li><a href="index.php?/log/umid_users/">用户量(umid)</a></li>
                    <?php endif;?>
                    <?php if(in_array('log_keep_rate', $userInfo['permission'])):?>
                    <li><a href="index.php?/log/keep_rate/">留存率</a></li>
                    <?php endif;?>
                    <?php if(in_array('log_umid_keep_rate', $userInfo['permission'])):?>
                        <li><a href="index.php?/log/umid_keep_rate/">留存率(umid)</a></li>
                    <?php endif;?>
                    <?php if(in_array('log_canal_data', $userInfo['permission'])):?>
                        <li><a href="index.php?/log/canal_data/">渠道数据</a></li>
                    <?php endif;?>
                    <?php if(in_array('log_video_ff', $userInfo['permission'])):?>
                        <li><a href="index.php?/log/video_ff/">视频快进</a></li>
                    <?php endif;?>
                    <?php if(in_array('log_ntads_click', $userInfo['permission'])):?>
                        <li><a href="index.php?/log/ntads_click/">新标签页广告点击</a></li>
                    <?php endif;?>
                    <?php if(in_array('log_glog_list', $userInfo['permission'])):?>
                        <li><a href="index.php?/log/glog_list/">通用日志</a></li>
                    <?php endif;?>
                    <?php if(in_array('log_glog_title_add', $userInfo['permission'])):?>
                        <li><a href="index.php?/log/glog_title_add/">通用日志标题添加</a></li>
                    <?php endif;?>
                </ul>
            </li>
            <?php endif;?>

            <?php if(in_array('log_users_os',$userInfo['permission']) || in_array('log_users_safe',$userInfo[permission])):?>
                <li class="dropdown <?php if($group == 'usersInfo'):?>active<?php endif;?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php if($group == 'usersInfo'):?><?php echo $title?><?php else:?>用户环境<?php endif;?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php if(in_array('log_users_os', $userInfo['permission'])):?>
                            <li><a href="index.php?/log/log_users_os/">OS统计</a></li>
                        <?php endif;?>
                        <?php if(in_array('log_users_safe', $userInfo['permission'])):?>
                            <li><a href="index.php?/log/log_users_safe/">安全软件</a></li>
                        <?php endif;?>
                        <?php if(in_array('log_users_ie', $userInfo['permission'])):?>
                            <li><a href="index.php?/log/log_users_ie/">IE统计</a></li>
                        <?php endif;?>
                        <?php if(in_array('log_users_flash', $userInfo['permission'])):?>
                            <li><a href="index.php?/log/log_users_flash/">Flash统计</a></li>
                        <?php endif;?>
                    </ul>
                </li>
            <?php endif;?>

            <?php if(in_array('log_users_homepage', $userInfo['permission']) || in_array('log_users_defaultsearchengine', $userInfo['permission']) || in_array('log_users_hao123pv', $userInfo['permission']) || in_array('log_users_setdef', $userInfo['permission']) || in_array('log_users_unpp', $userInfo['permission']) || in_array('log_users_ib', $userInfo['permission']) || in_array('log_users_old', $userInfo['permission'])):?>
                <li class="dropdown <?php if($group == 'usersHabit'):?>active<?php endif;?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php if($group == 'usersHabit'):?><?php echo $title?><?php else:?>使用习惯<?php endif;?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php if(in_array('log_users_homepage', $userInfo['permission'])):?>
                            <li><a href="index.php?/log/log_users_homepage/">启动页</a></li>
                        <?php endif;?>
                        <?php if(in_array('log_users_hao123pv', $userInfo['permission'])):?>
                            <li><a href="index.php?/log/log_users_hao123pv/">hao123访问量</a></li>
                        <?php endif;?>
                        <?php if(in_array('log_users_defaultsearchengine', $userInfo['permission'])):?>
                            <li><a href="index.php?/log/log_users_defaultsearchengine/">默认搜索引擎</a></li>
                        <?php endif;?>
                        <?php if(in_array('log_users_setdef', $userInfo['permission'])):?>
                            <li><a href="index.php?/log/log_users_setdef/">设默数据</a></li>
                        <?php endif;?>
                        <?php if(in_array('log_users_unpp', $userInfo['permission'])):?>
                            <li><a href="index.php?/log/log_users_uninstallparentprocess/">卸载父进程</a></li>
                        <?php endif;?>
                        <?php if(in_array('log_users_ib', $userInfo['permission'])):?>
                            <li><a href="index.php?/log/log_users_internetbehavior/">上网行为</a></li>
                        <?php endif;?>
                        <?php if(in_array('log_users_old', $userInfo['permission'])):?>
                            <li><a href="index.php?/log/log_users_outerlinkdomain/">外链域名</a></li>
                        <?php endif;?>
                    </ul>
                </li>
            <?php endif;?>

            <?php if(in_array('log_success_rate', $userInfo['permission']) || in_array('log_error', $userInfo['permission'])):?>
            <li class="dropdown <?php if($group == 'install'):?>active<?php endif;?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php if($group == 'install'):?><?php echo $title?><?php else:?>安装情况<?php endif;?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php if(in_array('log_success_rate', $userInfo['permission'])):?>
                    <li><a href="index.php?/log/success_rate/">成功率</a></li>
                    <?php endif;?>
                    <?php if(in_array('log_error', $userInfo['permission'])):?>
                    <li><a href="index.php?/log/error_code/">错误码</a></li>
                    <?php endif;?>
                </ul>
            </li>
            <?php endif;?>

            <?php if(in_array('log_feedback_detail', $userInfo['permission']) || in_array('log_uninstall_reason', $userInfo['permission']) || in_array('log_uninstall_detail', $userInfo['permission'])):?>
            <li class="dropdown <?php if($group == 'uninstall'):?>active<?php endif;?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php if($group == 'uninstall'):?><?php echo $title?><?php else:?>卸载情况<?php endif;?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php if(in_array('log_uninstall_reason', $userInfo['permission'])):?>
                    <li><a href="index.php?/log/uninstall_reason/">卸载原因</a></li>
                    <?php endif;?>
                    <?php if(in_array('log_uninstall_detail', $userInfo['permission'])):?>
                    <li><a href="index.php?/log/uninstall_detail/">卸载详情</a></li>
                    <?php endif;?>
                    <?php if(in_array('log_feedback_detail', $userInfo['permission'])):?>
                        <li><a href="index.php?/log/feedback_detail/">意见反馈</a></li>
                    <?php endif;?>
                </ul>
            </li>
            <?php endif;?>

            <?php if(in_array('excpt_excpt_rate', $userInfo['permission']) || in_array('excpt_excpt_rank', $userInfo['permission']) || in_array('excpt_excpt_detail', $userInfo['permission'])):?>
            <li class="dropdown <?php if($group == 'excpt'):?>active<?php endif;?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php if($group == 'excpt'):?><?php echo $title?><?php else:?>质量监控<?php endif;?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php if(in_array('excpt_excpt_rate', $userInfo['permission'])):?>
                    <li><a href="index.php?/excpt/excpt_rate/">崩溃率</a></li>
                    <?php endif;?>
                    <?php if(in_array('excpt_excpt_rank', $userInfo['permission'])):?>
                    <li><a href="index.php?/excpt/excpt_rank/">崩溃排名</a></li>
                    <?php endif;?>
                    <?php if(in_array('excpt_excpt_detail', $userInfo['permission'])):?>
                    <li><a href="index.php?/excpt/excpt_detail/">崩溃详情</a></li>
                    <?php endif;?>
                </ul>
            </li>
            <?php endif;?>

            <?php if(in_array('update_go_page', $userInfo['permission']) || in_array('other_newtab_ads', $userInfo['permission']) || in_array('other_newtab_logo', $userInfo['permission']) || in_array('update_conf_list', $userInfo['permission']) || in_array('conflist_conf_list', $userInfo['permission']) || in_array('dlconf_conf_list', $userInfo['permission']) || in_array('other_get_update', $userInfo['permission']) || in_array('netbar_exe_download', $userInfo['permission']) || in_array('netbar_dll_download', $userInfo['permission']) || in_array('netbar_interface_list', $userInfo['permission'])):?>
            <li class="dropdown <?php if($group == 'update'):?>active<?php endif;?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php if($group == 'update'):?><?php echo $title?><?php else:?>升级<?php endif;?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php if(in_array('update_conf_list', $userInfo['permission'])):?>
                    <li><a href="index.php?/update/conf_list/">程序升级</a></li>
                    <?php endif;?>
                    <?php if(in_array('conflist_conf_list', $userInfo['permission'])):?>
                    <li><a href="index.php?/conflist/conf_list/">配置升级</a></li>
                    <?php endif;?>
                    <?php if(in_array('dlconf_conf_list', $userInfo['permission'])):?>
                        <li><a href="index.php?/dlconf/conf_list/">下载配置</a></li>
                    <?php endif;?>
                    <?php if(in_array('other_get_update', $userInfo['permission'])):?>
                        <li><a href="index.php?/other/get_update/">获取升级</a></li>
                    <?php endif;?>
                    <?php if(in_array('other_newtab_logo', $userInfo['permission'])):?>
                        <li><a href="index.php?/other/newtab_logo/">新标签页图标</a></li>
                    <?php endif;?>
                    <?php if(in_array('other_newtab_ads', $userInfo['permission'])):?>
                        <li><a href="index.php?/other/newtab_ads/">新标签页广告</a></li>
                    <?php endif;?>
                    <?php if(in_array('update_go_page', $userInfo['permission'])):?>
                        <li><a href="index.php?/update/go_page/">跳转页配置</a></li>
                    <?php endif;?>
                    <?php if(in_array('netbar_exe_download', $userInfo['permission'])):?>
                        <li><a href="index.php?/netbar/exe_download_conf/">网吧EXE下载</a></li>
                    <?php endif;?>
                    <?php if(in_array('netbar_dll_download', $userInfo['permission'])):?>
                        <li><a href="index.php?/netbar/dll_download_conf/">网吧DLL下载</a></li>
                    <?php endif;?>
                    <?php if(in_array('netbar_interface_list', $userInfo['permission'])):?>
                        <li><a href="index.php?/netbar/api_url_conf/">网吧接口列表</a></li>
                    <?php endif;?>
                    <?php if(in_array('netbar_interface_list', $userInfo['permission'])):?>
                        <li><a href="index.php?/netbar/cloud_control_conf/">网吧云控</a></li>
                    <?php endif;?>
                </ul>
            </li>
            <?php endif;?>

            <?php if(in_array('other_glog_type', $userInfo['permission']) || in_array('dbtool_run_sql', $userInfo['permission']) || in_array('cron_cron_pro', $userInfo['permission']) || in_array('cron_cron_insert_file', $userInfo['permission']) || in_array('cron_disk_usage', $userInfo['permission']) || in_array('cron_db_usage', $userInfo['permission']) || in_array('cron_warning', $userInfo['permission']) || in_array('activity_xiaoyuan', $userInfo['permission']) || in_array('ios_content_recommend', $userInfo['permission']) || in_array('ios_upgrade_reminder', $userInfo['permission'])):?>
            <li class="dropdown <?php if($group == 'cron' || $group == 'activity' || $group == 'ios'):?>active<?php endif;?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php if($group == 'cron' || $group == 'activity' || $group == 'ios'):?><?php echo $title?><?php else:?>其他<?php endif;?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php if(in_array('cron_cron_pro', $userInfo['permission'])):?>
                    <li><a href="index.php?/cron/cron_pro/">cron任务</a></li>
                    <?php endif;?>
                    <?php if(in_array('cron_cron_insert_file', $userInfo['permission'])):?>
                    <li><a href="index.php?/cron/cron_insert_file/">日志入库</a></li>
                    <?php endif;?>
                    <li class="divider"></li>
                    <?php if(in_array('cron_disk_usage', $userInfo['permission'])):?>
                    <li><a href="index.php?/cron/disk_usage/">磁盘占用</a></li>
                    <?php endif;?>
                    <?php if(in_array('cron_db_usage', $userInfo['permission'])):?>
                    <li><a href="index.php?/cron/db_usage/">DB占用</a></li>
                    <?php endif;?>
                    <?php if(in_array('cron_warning', $userInfo['permission'])):?>
                    <li><a href="index.php?/cron/warning/">错误报警</a></li>
                    <?php endif;?>
                    <li class="divider"></li>
                    <?php if(in_array('dbtool_run_sql', $userInfo['permission'])):?>
                    <li><a href="index.php?/dbtool/run_sql/">DB工具</a></li>
                    <?php endif;?>
                    <?php if(in_array('other_glog_type', $userInfo['permission'])):?>
                        <li><a href="index.php?/other/glog_type/">日志类型</a></li>
                    <?php endif;?>
                    <li class="divider"></li>
                    <li>&nbsp;&nbsp;<b>活动</b></li>
                    <?php if(in_array('activity_xiaoyuan', $userInfo['permission'])):?>
                        <li><a href="index.php?/activity/xiaoyuan/">校园活动</a> </li>
                    <?php endif;?>
                    <li class="divider"></li>
                    <li>&nbsp;&nbsp;<b>IOS</b></li>
                    <?php if(in_array('ios_content_recommend', $userInfo['permission'])):?>
                        <li><a href="index.php?/ios/content_recommend/">内容推荐</a> </li>
                    <?php endif;?>
                    <?php if(in_array('ios_upgrade_reminder', $userInfo['permission'])):?>
                        <li><a href="index.php?/ios/upgrade_reminder/">升级提示</a> </li>
                    <?php endif;?>
                    <?php if(in_array('ios_feedback', $userInfo['permission'])):?>
                        <li><a href="index.php?/ios/feedback/">意见反馈</a> </li>
                    <?php endif;?>
                </ul>
            </li>
            <?php endif;?>

            <?php if(in_array('other_set_canal_control', $userInfo['permission']) || in_array('user_user_list', $userInfo['permission']) || in_array('user_permission_list', $userInfo['permission']) || in_array('other_set_tn_map', $userInfo['permission']) || in_array('other_set_canal_filter', $userInfo['permission'])):?>
            <li class="dropdown <?php if($group == 'backstage'):?>active<?php endif;?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php if($group == 'backstage'):?><?php echo $title?><?php else:?>后台管理<?php endif;?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php if(in_array('user_user_list', $userInfo['permission'])):?>
                    <li><a href="index.php?/user/user_list/">用户管理</a></li>
                    <?php endif;?>
                    <?php if(in_array('user_permission_list', $userInfo['permission'])):?>
                    <li><a href="index.php?/user/permission_list/">权限管理</a></li>
                    <?php endif;?>
                    <?php if(in_array('other_set_tn_map', $userInfo['permission'])):?>
                        <li><a href="index.php?/other/set_tn_map/">TN对照表</a></li>
                    <?php endif;?>
                    <?php if(in_array('other_set_canal_control', $userInfo['permission'])):?>
                        <li><a href="index.php?/other/set_canal_control/">设置渠道控制</a></li>
                    <?php endif;?>
                    <?php if(in_array('other_set_canal_filter', $userInfo['permission'])):?>
                        <li><a href="index.php?/other/set_canal_filter/">渠道过滤</a></li>
                    <?php endif;?>
                </ul>
            </li>
            <?php endif;?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown active">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $userInfo['userName'];?><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#" data-toggle="modal" data-target="#cant">修改密码</a></li>
                    <li><a href="index.php?/user/logout/">登出</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</div>

<div id="cant" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">提示</h4>
            </div>
            <div class="modal-body">
                <h3><p style="text-align:center;">此功能暂未开放&hellip;</p></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="container">

  <div class="row">