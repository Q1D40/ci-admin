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
                <select name="appv" class="form-control combobox">
                    <option value="all" <?php if($appv == 'all'):?>selected="selected"<?php endif;?>>不区分版本</option>
                    <?php foreach($verMap as $verOne):?>
                        <option value="<?php echo $verOne;?>" <?php if($verOne == $appv):?>selected="selected"<?php endif;?>><?php echo $verOne;?></option>
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
                 <!--<button id="exportBtn" type="button" class="btn btn-success form-control">导出</button>-->
             </div>
             <input type="hidden" id="actHidden" name="act" value="search">
             <input type="hidden" id="viewType" name="viewType" value="<?php echo $viewType;?>">
        </div>
        <div class="row">
            <div class="col-md-2">
                <input type="text" name="excptMD5" class="form-control" placeholder="MD5" value="<?php echo $excptMD5;?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="iev" class="form-control" placeholder="IE版本" value="<?php echo $iev;?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="osv" class="form-control" placeholder="操作系统" value="<?php echo $osv;?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="fv" class="form-control" placeholder="Flash版本" value="<?php echo $fv;?>">
            </div>
        </div>
    </form>

    <div style="height: 30px;"></div>


    <ul class="nav nav-tabs">
        <li id="viewMd5" <?php if($viewType == 'excptMD5'):?>class="active"<?php endif;?>><a href="#">按MD5查看</a></li>
        <li id="viewIev" <?php if($viewType == 'iev'):?>class="active"<?php endif;?>><a href="#">按IE版本查看</a></li>
        <li id="viewOsv" <?php if($viewType == 'osv'):?>class="active"<?php endif;?>><a href="#">按操作系统查看</a></li>
        <li id="viewFv" <?php if($viewType == 'fv'):?>class="active"<?php endif;?>><a href="#">按Flash版本查看</a></li>
    </ul>

    <div style="height: 30px;"></div>

    <table class="table table-hover tbcloth">
        <thead>
        <tr>
            <th>
                <?php if($viewType == 'excptMD5'):?>MD5<?php endif;?>
                <?php if($viewType == 'iev'):?>IE版本<?php endif;?>
                <?php if($viewType == 'osv'):?>操作系统<?php endif;?>
                <?php if($viewType == 'fv'):?>Flash版本<?php endif;?>
            </th>
            <th>次数</th>
            <th>占比</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 0;?>
        <?php foreach($excptRankList['list'] as $value => $count):?>
            <?php $i++;?>
            <tr>
                <td><a href="#" class="viewDetail"><?php echo $value;?></a></td>
                <td><?php echo $count;?></td>
                <td><?php echo round($count/$excptRankList['allCount'], 4)*100;?>%</td>
            </tr>
            <?php if($i > 1000) break 1;?>
        <?php endforeach;?>
        </tbody>
    </table>
</div>

<form id="excptDetailSearchForm" role="form" action="index.php?/excpt/excpt_detail/" method="POST" target="_blank">
    <input type="hidden" id="excptDetailAppv" name="appv" value="<?php echo $appv;?>">
    <input type="hidden" id="excptDetailCid" name="cid" value="<?php echo $cid;?>">
    <input type="hidden" id="excptDetailStartDate" name="startDate" value="<?php echo $startDate;?>">
    <input type="hidden" id="excptDetailEndDate" name="endDate" value="<?php echo $endDate;?>">

    <input type="hidden" id="excptDetailExcptMD5" name="excptMD5" value="<?php echo $excptMD5;?>">
    <input type="hidden" id="excptDetailIev" name="iev" value="<?php echo $iev;?>">
    <input type="hidden" id="excptDetailOsv" name="osv" value="<?php echo $osv;?>">
    <input type="hidden" id="excptDetailFv" name="fv" value="<?php echo $fv;?>">

    <input type="hidden" id="excptRankActHidden" name="act" value="search">
</form>

<script>
    $(".viewDetail").click(function(){
        var viewType = '<?php echo $viewType;?>';

        if(viewType == 'excptMD5')
            $("#excptDetailExcptMD5").attr("value", $(this).html());
        if(viewType == 'iev')
            $("#excptDetailIev").attr("value", $(this).html());
        if(viewType == 'osv')
            $("#excptDetailOsv").attr("value", $(this).html());
        if(viewType == 'fv')
            $("#excptDetailFv").attr("value", $(this).html());

        $("#excptDetailSearchForm").submit();
		 return false;
    });

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

    $("#viewMd5").click(function(){
        $("#viewType").val("excptMD5");
        $("#searchForm").attr("target", "_self")
        $("#searchForm").submit();
    });
    $("#viewIev").click(function(){
        $("#viewType").val("iev");
        $("#searchForm").attr("target", "_self")
        $("#searchForm").submit();
    });
    $("#viewOsv").click(function(){
        $("#viewType").val("osv");
        $("#searchForm").attr("target", "_self")
        $("#searchForm").submit();
    });
    $("#viewFv").click(function(){
        $("#viewType").val("fv");
        $("#searchForm").attr("target", "_self")
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