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
            <div class="btn-group col-md-2">
                <button id="searchbtn" type="button" class="btn btn-primary">查询</button>
                <button id="newPageSearchBtn" type="button" class="btn btn-primary">在新页面查询</button>
            </div>
            <div class="col-md-2">
                <button id="exportBtn" type="button" class="btn btn-success form-control">导出</button>
            </div>
             <input type="hidden" id="actHidden" name="act" value="search">
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
                <a href="#" class="tip" data-toggle="tooltip" title="经常崩溃、卡住或网页无法显示">
                    原因1数量
                </a>
            </th>
            <th>占比</th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="经常显示错乱或白屏，操作一下就好了">
                    原因2数量
                </a>
            </th>
            <th>占比</th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="某些网页始终错乱或功能不正常">
                    原因3数量
                </a>
            </th>
            <th>占比</th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="浏览器反应慢，用起来不流畅">
                    原因4数量
                </a>
            </th>
            <th>占比</th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="缺少我要的功能">
                    原因5数量
                </a>
            </th>
            <th>占比</th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="外观用着不习惯">
                    原因6数量
                </a>
            </th>
            <th>占比</th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="打开网页慢">
                    原因7数量
                </a>
            </th>
            <th>占比</th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="其他">
                    原因8数量
                </a>
            </th>
            <th>占比</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($uninstallReasonList as $uninstallReason):?>
            <tr>
                <td><?php echo $uninstallReason['date'];?></td>

                <?php if($ver != 'group'):?>
                <td><?php echo $uninstallReason['ver'];?></td>
                <?php endif;?>
                <?php if($cid != 'group'):?>
                <td><?php echo $uninstallReason['cid'];?></td>
                <?php endif;?>

                <td><?php echo $uninstallReason['r1'];?></td>
                <td><?php echo round($uninstallReason['r1']/$uninstallReason['all'], 4)*100;?>%</td>

                <td><?php echo $uninstallReason['r2'];?></td>
                <td><?php echo round($uninstallReason['r2']/$uninstallReason['all'], 4)*100;?>%</td>

                <td><?php echo $uninstallReason['r3'];?></td>
                <td><?php echo round($uninstallReason['r3']/$uninstallReason['all'], 4)*100;?>%</td>

                <td><?php echo $uninstallReason['r4'];?></td>
                <td><?php echo round($uninstallReason['r4']/$uninstallReason['all'], 4)*100;?>%</td>

                <td><?php echo $uninstallReason['r5'];?></td>
                <td><?php echo round($uninstallReason['r5']/$uninstallReason['all'], 4)*100;?>%</td>

                <td><?php echo $uninstallReason['r6'];?></td>
                <td><?php echo round($uninstallReason['r6']/$uninstallReason['all'], 4)*100;?>%</td>

                <td><?php echo $uninstallReason['r7'];?></td>
                <td><?php echo round($uninstallReason['r7']/$uninstallReason['all'], 4)*100;?>%</td>

                <td><?php echo $uninstallReason['r8'];?></td>
                <td><?php echo round($uninstallReason['r8']/$uninstallReason['all'], 4)*100;?>%</td>
            </tr>
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