<div id="rightMain" class="col-md-12" role="main">
    <div class="alert alert-warning <?php if($error == ''):?>hide<?php else:?>fade in<?php endif;?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $error;?>
</div>
<form id="searchForm" role="form" action="" method="POST">
    <div class="row">
        <div class="col-md-2">
            <input type="text" name="startDate" class="form-control datetimepicker" value="<?php echo $startDate;?>">
        </div>
        <div class="col-md-2">
            <input type="text" name="endDate" class="form-control datetimepicker" value="<?php echo $endDate;?>">
        </div>
        <div class="col-md-2">
            <select name="ver" class="form-control combobox">
                <option value="group" <?php if($ver == 'group'):?>selected="selected"<?php endif;?>>不区分版本</option>
                <option value="all" <?php if($ver == 'all'):?>selected="selected"<?php endif;?>>全部版本</option>
                <?php foreach($verMap as $verOne):?>
                    <option value="<?php echo $verOne;?>" <?php if($verOne == $ver):?>selected="selected"<?php endif;?>><?php echo $verOne;?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="col-md-2">
            <script>
                var cidArr = new Array();
                <?php foreach($cidMap as $cidOne):?>
                cidArr.push("<?php echo $cidOne;?>");
                <?php endforeach;?>
                var cidArrDef = new Array();
                cidArrDef.push("不区分渠道");
                cidArrDef.push("全部渠道");
                cidArrDef.push("Organ");
                cidArrDef.push("D2");
                cidArrDef.push("U2");
                <?php foreach($cidMapDef as $cidOne):?>
                cidArrDef.push("<?php echo $cidOne;?>");
                <?php endforeach;?>
            </script>
            <div class="input-group cid-box">
                <input type="text" class="form-control" autocomplete="off" name="cid" value="<?php echo $vcid;?>">
                <ul class="dropdown-menu dropdown-menu-right cid-box-list" role="menu" style="height: 300px; overflow-y:scroll;">
                </ul>
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">&nbsp;<span class="caret"></span></button>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <select name="sel" class="form-control selectpicker">
                <option value="gtTen" <?php if($sel == 'gtTen'):?>selected="selected"<?php endif;?>>过滤日活小于10</option>
                <option value="showAll" <?php if($sel == 'showAll'):?>selected="selected"<?php endif;?>>不过滤</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="btn-group col-md-2">
            <button id="searchbtn" type="button" class="btn btn-primary">查询</button>
            <button id="newPageSearchBtn" type="button" class="btn btn-primary">在新页面查询</button>
        </div>
        <div class="col-md-2">
            <button id="exportBtn" type="button" class="btn btn-success form-control">导出</button>
        </div>
        <input type="hidden" id="actHidden" name="act" value="search">
        <div class="btn-group col-md-2">
            <a target="_blank" href="index.php?/other/show_tn_map/" type="button" class="btn btn-default">
                <span class="glyphicon glyphicon-eye-open"></span>
            </a>
        </div>
    </div>
</form>

<div style="height: 30px;"></div>

<table class="table table-hover tbcloth">
    <thead>
    <tr>
        <th>日期</th>
        <?php if($ver != 'group'):?>
            <th>版本号</th>
        <?php endif;?>
        <?php if($cid != 'group'):?>
            <th>渠道</th>
        <?php endif;?>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="安装成功的数量（mid除重）">
                安装量
            </a>
        </th>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="新安装成功的数量（mid除重）">
                新安装量
            </a>
        </th>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="新安装量累加">
                累计新安装量
            </a>
        </th>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="卸载成功的数量（mid除重）">
                卸载量
            </a>
        </th>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="卸载量累加">
                累计卸载量
            </a>
        </th>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="卸载量/日活跃用户">
                卸载率
            </a>
        </th>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="卸载量/新安装量">
                流失率
            </a>
        </th>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="升级成功的数量（mid除重）">
                自动升级
            </a>
        </th>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="覆盖安装成功的数量（mid除重）">
                覆盖安装
            </a>
        </th>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="累计新安装量-累计卸载量">
                累计留存
            </a>
        </th>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="升级检测的数量（mid除重）">
                日活跃用户
            </a>
        </th>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="首次启动浏览器的数量（mid除重）">
                首次激活用户
            </a>
        </th>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="7天内升级检测的数量（mid除重）">
                周活跃用户
            </a>
        </th>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="升级检测的数量">
                日报活次数
            </a>
        </th>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="周活跃用户/累计留存">
                激活率
            </a>
        </th>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="升级检测里是默认浏览器的数量/升级检测的数量">
                默认率
            </a>
        </th>
        <th>
            <a href="#" class="tip" data-toggle="tooltip" title="(日活跃用户-昨日活跃用户)/昨日活跃用户">
                增长率
            </a>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($usersList as $users):?>
       <?php if($users['dayActiveUser'] > 10 || $sel != 'gtTen'):?>
        <tr>
            <td><?php echo $users['date'];?></td>
            <?php if($ver != 'group'):?>
            <td><?php echo $users['ver'];?></td>
            <?php endif;?>
            <?php if($cid != 'group'):?>
            <td><?php echo $users['cid'];?></td>
            <?php endif;?>
            <td><?php echo $users['install'];?></td>
            <td><?php echo $users['newInstall'];?></td>
            <td><?php echo $users['allNewInstall'];?></td>
            <td><?php echo $users['unInstall'];?></td>
            <td><?php echo $users['allUnInstall'];?></td>
            <td><?php echo round($users['unInstall']/$users['dayActiveUser'], 4)*100;?>%</td>
            <td><?php echo round($users['unInstall']/$users['newInstall'], 4)*100;?>%</td>
            <td><?php echo $users['autoUpdate'];?></td>
            <td><?php echo $users['coverInstall'];?></td>
            <td><?php echo $users['allKeep'];?></td>
            <td><?php echo $users['dayActiveUser'];?></td>
            <td><?php echo $users['firstActiveUser'];?></td>
            <td><?php echo $users['weekActiveUser'];?></td>
            <td><?php echo $users['dayPostActive'];?></td>
            <td><?php echo round($users['weekActiveUser']/$users['allKeep'], 4)*100;?>%</td>
            <td><?php echo round($users['defaultBrowser']/$users['dayPostActive'], 4)*100;?>%</td>
            <td><?php echo round(($users['dayActiveUser'] - $users['yesterdayActiveUser'])/$users['yesterdayActiveUser'], 4)*100;?>%</td>
        </tr>
    <?php endif;?>
    <?php endforeach;?>
    </tbody>
</table>
</div>

<script>
    $("#searchbtn").click(function(){
        $("#actHidden").val("search");
        $("#searchForm").attr("target", "_self")
        $("#searchForm").submit();
    });
    $("#newPageSearchBtn").click(function(){
        $("#actHidden").val("search");
        $("#searchForm").attr("target", "_blank")
        $("#searchForm").submit();
    });
    $("#exportBtn").click(function(){
        $("#actHidden").val("export");
        $("#searchForm").attr("target", "_blank")
        $("#searchForm").submit();
    });

    $(".cid-box button").click(function(event){
        defCidbox();
        event.stopPropagation();
    });

    $(".cid-box input").click(function(event){
        event.stopPropagation();
    });

    $(".cid-box ul").delegate("li","click",function(){
        $(".cid-box input").val($(this).children("a").html());
    });

    $("body").on("propertychange input", ".cid-box input", function(){
        var input = $(this).val();
        searchCidbox(input);
    });

    $(".cid-box input").bind("propertychange", function(){
        var input = $(this).val();
        searchCidbox(input);
    });

    $("body").click(function(){
        $(".cid-box ul").hide();
    });

    function searchCidbox(input)
    {
        input = $.trim(input);
        var ulHtml = "";
        for(var i = 0; i < cidArr.length; i++){
            if(cidArr[i].indexOf(input) > -1){
                ulHtml += "<li><a href=\"#\">" + cidArr[i] + "</a></li>";
            }
        }
        $(".cid-box ul").html(ulHtml);
        if(input == "" || ulHtml == ""){
            $(".cid-box ul").hide();
        }else{
            $(".cid-box ul").show();
        }
    }

    function defCidbox()
    {
        if($(".cid-box ul").css('display') != "none"){
            $(".cid-box ul").hide();
        }else{
            var ulHtml = "";
            for(var i = 0; i < cidArrDef.length; i++){
                ulHtml += "<li><a href=\"#\">" + cidArrDef[i] + "</a></li>"
            }
            $(".cid-box ul").html(ulHtml);
            $(".cid-box ul").show();
        }
    }
</script>