<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>后台</title>

    <link href="themes/default/style.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="themes/css/core.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="themes/css/print.css" rel="stylesheet" type="text/css" media="print"/>
    <link href="uploadify/css/uploadify.css" rel="stylesheet" type="text/css" media="screen"/>
    <!--[if IE]>
    <link href="themes/css/ieHack.css" rel="stylesheet" type="text/css" media="screen"/>
    <![endif]-->

    <!--[if lte IE 9]>
    <script src="js/speedup.js" type="text/javascript"></script>
    <![endif]-->

    <script src="js/jquery-1.7.2.js" type="text/javascript"></script>
    <script src="js/jquery.cookie.js" type="text/javascript"></script>
    <script src="js/jquery.validate.js" type="text/javascript"></script>
    <script src="js/jquery.bgiframe.js" type="text/javascript"></script>
    <script src="xheditor/xheditor-1.2.1.min.js" type="text/javascript"></script>
    <script src="xheditor/xheditor_lang/zh-cn.js" type="text/javascript"></script>
    <script src="uploadify/scripts/jquery.uploadify.js" type="text/javascript"></script>

    <!-- svg图表  supports Firefox 3.0+, Safari 3.0+, Chrome 5.0+, Opera 9.5+ and Internet Explorer 6.0+ -->
    <script type="text/javascript" src="chart/raphael.js"></script>
    <script type="text/javascript" src="chart/g.raphael.js"></script>
    <script type="text/javascript" src="chart/g.bar.js"></script>
    <script type="text/javascript" src="chart/g.line.js"></script>
    <script type="text/javascript" src="chart/g.pie.js"></script>
    <script type="text/javascript" src="chart/g.dot.js"></script>

    <script src="js/dwz.core.js" type="text/javascript"></script>
    <script src="js/dwz.util.date.js" type="text/javascript"></script>
    <script src="js/dwz.validate.method.js" type="text/javascript"></script>
    <script src="js/dwz.barDrag.js" type="text/javascript"></script>
    <script src="js/dwz.drag.js" type="text/javascript"></script>
    <script src="js/dwz.tree.js" type="text/javascript"></script>
    <script src="js/dwz.accordion.js" type="text/javascript"></script>
    <script src="js/dwz.ui.js" type="text/javascript"></script>
    <script src="js/dwz.theme.js" type="text/javascript"></script>
    <script src="js/dwz.switchEnv.js" type="text/javascript"></script>
    <script src="js/dwz.alertMsg.js" type="text/javascript"></script>
    <script src="js/dwz.contextmenu.js" type="text/javascript"></script>
    <script src="js/dwz.navTab.js" type="text/javascript"></script>
    <script src="js/dwz.tab.js" type="text/javascript"></script>
    <script src="js/dwz.resize.js" type="text/javascript"></script>
    <script src="js/dwz.dialog.js" type="text/javascript"></script>
    <script src="js/dwz.dialogDrag.js" type="text/javascript"></script>
    <script src="js/dwz.sortDrag.js" type="text/javascript"></script>
    <script src="js/dwz.cssTable.js" type="text/javascript"></script>
    <script src="js/dwz.stable.js" type="text/javascript"></script>
    <script src="js/dwz.taskBar.js" type="text/javascript"></script>
    <script src="js/dwz.ajax.js" type="text/javascript"></script>
    <script src="js/dwz.pagination.js" type="text/javascript"></script>
    <script src="js/dwz.database.js" type="text/javascript"></script>
    <script src="js/dwz.datepicker.js" type="text/javascript"></script>
    <script src="js/dwz.effects.js" type="text/javascript"></script>
    <script src="js/dwz.panel.js" type="text/javascript"></script>
    <script src="js/dwz.checkbox.js" type="text/javascript"></script>
    <script src="js/dwz.history.js" type="text/javascript"></script>
    <script src="js/dwz.combox.js" type="text/javascript"></script>
    <script src="js/dwz.print.js" type="text/javascript"></script>

    <!-- 可以用dwz.min.js替换前面全部dwz.*.js (注意：替换是下面dwz.regional.zh.js还需要引入)
    <script src="bin/dwz.min.js" type="text/javascript"></script>
    -->
    <script src="js/dwz.regional.zh.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(function(){
            DWZ.init("dwz.frag.xml", {
                loginUrl:"login_dialog.html", loginTitle:"登录",	// 弹出登录对话框
//		loginUrl:"login.html",	// 跳到登录页面
                statusCode:{ok:200, error:300, timeout:301}, //【可选】
                pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"orderField", orderDirection:"orderDirection"}, //【可选】
                debug:false,	// 调试模式 【true|false】
                callback:function(){
                    initEnv();
                    $("#themeList").theme({themeBase:"themes"}); // themeBase 相对于index页面的主题base路径
                }
            });
        });

    </script>
</head>

<body scroll="no">
<div id="layout">
<div id="header">
    <div class="headerNav">

        <ul class="nav">
            <li><a href="index.php?/log/users/" target="_blank">新后台</a></li>

            <li><a><?php echo $userInfo['userName'];?></a></li>

            <li><a href="index.php?/user/changepwd/" target="dialog" width="600">修改密码</a></li>

            <li><a href="index.php?/user/logout/">退出</a></li>
        </ul>
        <ul class="themeList" id="themeList">
            <li theme="default"><div class="selected">蓝色</div></li>
            <li theme="green"><div>绿色</div></li>
            <!--<li theme="red"><div>红色</div></li>-->
            <li theme="purple"><div>紫色</div></li>
            <li theme="silver"><div>银色</div></li>
            <li theme="azure"><div>天蓝</div></li>
        </ul>
    </div>

    <!-- navMenu -->

</div>

<div id="leftside">
    <div id="sidebar_s">
        <div class="collapse">
            <div class="toggleCollapse"><div></div></div>
        </div>
    </div>
    <div id="sidebar">
        <div class="toggleCollapse"><h2>主菜单</h2><div>收缩</div></div>

        <div class="accordion" fillSpace="sidebar">
            <div class="accordionHeader">
                <h2><span>Folder</span>崩溃管理</h2>
            </div>
            <div class="accordionContent">
                <ul class="tree treeFolder">
                    <li><a>崩溃信息</a>
                        <ul>

                            <li><a href="index.php?/excpt/version_excpt_list/" target="navTab" rel="version_excpt_list" fresh="true">版本崩溃信息</a></li>
                            <li><a href="index.php?/excpt/ie_version_excpt_list/" target="navTab" rel="ie_version_excpt_list" fresh="true">IE版本崩溃信息</a></li>

                        </ul>
                    </li>

                </ul>
            </div>

        </div>
    </div>
</div>
<div id="container">
    <div id="navTab" class="tabsPage">
        <div class="tabsPageHeader">
            <div class="tabsPageHeaderContent"><!-- 显示左右控制时添加 class="tabsPageHeaderMargin" -->
                <ul class="navTab-tab">
                    <li tabid="main" class="main"><a href="javascript:;"><span><span class="home_icon">welcome</span></span></a></li>
                </ul>
            </div>
            <div class="tabsLeft">left</div><!-- 禁用只需要添加一个样式 class="tabsLeft tabsLeftDisabled" -->
            <div class="tabsRight">right</div><!-- 禁用只需要添加一个样式 class="tabsRight tabsRightDisabled" -->
            <div class="tabsMore">more</div>
        </div>
        <ul class="tabsMoreList">
            <li><a href="javascript:;">welcome</a></li>
        </ul>
        <div class="navTab-panel tabsPageContent layoutBox">
            <div class="page unitBox">
                <div class="accountInfo">


                </div>
                <div class="pageFormContent" layoutH="80" style="margin-right:230px">

                </div>

            </div>

        </div>
    </div>
</div>

</div>

<div id="footer">Copyright &copy; 2013 DarkHorse</div>

</body>
</html>