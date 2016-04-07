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
             <div class="btn-group col-md-2">
                 <button id="searchbtn" type="button" class="btn btn-primary">查询</button>
                 <button id="newPageSearchBtn" type="button" class="btn btn-primary">在新页面查询</button>
             </div>
             <div class="col-md-2">
                 <!--<button id="exportBtn" type="button" class="btn btn-success form-control">导出</button>-->
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

            <th>主进程崩溃次数</th>
            <th>mid数</th>
            <th>次数/mid数</th>
            <th>崩溃率</th>

            <th>网页进程崩溃次数</th>
            <th>mid数</th>
            <th>次数/mid数</th>
            <th>崩溃率</th>

            <th>其他进程崩溃次数</th>
            <th>mid数</th>
            <th>次数/mid数</th>
            <th>崩溃率</th>

            <th>总崩溃次数</th>
            <th>mid数</th>
            <th>次数/mid数</th>
            <th>崩溃率</th>
            <th>查看崩溃详情</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($excptRateList as $excptRate):?>
            <tr>
                <td class="date"><?php echo $excptRate['date'];?></td>

                <?php if($ver != 'group'):?>
                <td class="ver"><?php echo $excptRate['ver'];?></td>
                <?php endif;?>
                <?php if($cid != 'group'):?>
                <td class="cid"><?php echo $excptRate['cid'];?></td>
                <?php endif;?>

                <td><?php echo $excptRate['mainProNum'];?></td>
                <td><?php echo $excptRate['mainProMid'];?></td>
                <td><?php echo round($excptRate['mainProNum']/$excptRate['mainProMid'], 2);?></td>
                <td><?php echo round($excptRate['mainProMid']/$excptRate['dayActive'], 4)*100;?>%</td>

                <td><?php echo $excptRate['pageProNum'];?></td>
                <td><?php echo $excptRate['pageProMid'];?></td>
                <td><?php echo round($excptRate['pageProNum']/$excptRate['pageProMid'], 2);?></td>
                <td><?php echo round($excptRate['pageProMid']/$excptRate['dayActive'], 4)*100;?>%</td>

                <td><?php echo $excptRate['otherProNum'];?></td>
                <td><?php echo $excptRate['otherProMid'];?></td>
                <td><?php echo round($excptRate['otherProNum']/$excptRate['otherProMid'], 2);?></td>
                <td><?php echo round($excptRate['otherProMid']/$excptRate['dayActive'], 4)*100;?>%</td>

                <td><?php echo $excptRate['allProNum'];?></td>
                <td><?php echo $excptRate['allProMid'];?></td>
                <td><?php echo round($excptRate['allProNum']/$excptRate['allProMid'], 2);?></td>
                <td><?php echo round($excptRate['allProMid']/$excptRate['dayActive'], 4)*100;?>%</td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-zoom-in"></span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a viewType="excptMD5" class="viewRankBtn" href="#">MD5详情</a></li>
                            <li><a viewType="iev" class="viewRankBtn" href="#">IE版本</a></li>
                            <li><a viewType="osv" class="viewRankBtn" href="#">OS版本</a></li>
                            <li><a viewType="fv" class="viewRankBtn" href="#">Flash版本</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>

<form id="excptRankSearchForm" role="form" action="index.php?/excpt/excpt_rank/" method="POST" target="_blank">
    <input type="hidden" id="excptRankAppv" name="appv" value="">
    <input type="hidden" id="excptRankCid" name="cid" value="">
    <input type="hidden" id="excptRankStartDate" name="startDate" value="">
    <input type="hidden" id="excptRankEndDate" name="endDate" value="">
    <input type="hidden" id="excptRankViewType" name="viewType" value="">
    <input type="hidden" id="excptRankActHidden" name="act" value="search">
</form>

<script>
    $("#searchbtn").click(function(){
        $("#actHidden").val("search");
        $("#searchForm").attr("target", "_self");
        $("#searchForm").submit();
    });
    $("#newPageSearchBtn").click(function(){
        $("#actHidden").val("search");
        $("#searchForm").attr("target", "_blank");
        $("#searchForm").submit();
    });
    $("#exportBtn").click(function(){
        $("#actHidden").val("export");
        $("#searchForm").attr("target", "_blank");
        $("#searchForm").submit();
    });

    $(".viewRankBtn").click(function(){
        var viewType = $(this).attr("viewType");
        var startDate = $(this).parent().parent().parent().parent().parent().children(".date").html();
        var endDate = startDate;
        var appv = $(this).parent().parent().parent().parent().parent().children(".ver").html();
        if(typeof(appv) == 'undefined') appv = "all";
        var cid = $(this).parent().parent().parent().parent().parent().children(".cid").html();
        if(typeof(cid) == 'undefined') cid = "all";

        $("#excptRankAppv").attr("value", appv);
        $("#excptRankCid").attr("value", cid);
        $("#excptRankStartDate").attr("value", startDate);
        $("#excptRankEndDate").attr("value", endDate);
        $("#excptRankViewType").attr("value", viewType);

        $("#excptRankSearchForm").submit();
		return false;
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