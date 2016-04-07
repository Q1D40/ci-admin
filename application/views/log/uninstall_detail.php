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
                    <option value="all" <?php if($ver == 'all'):?>selected="selected"<?php endif;?>>不区分版本</option>
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
             <div class="col-md-2">
                 <input type="text" name="ud" class="form-control" placeholder="卸载详情" value="<?php echo $ud;?>">
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
            <input type="hidden" id="page" name="page" value="1">
        </div>
    </form>

    <div style="height: 30px;"></div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>日期</th>
            <th>版本号</th>
            <th>渠道</th>
            <th style="width: 600px;">卸载详情</th>
            <th>联系方式</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($uninstallDetailList as $uninstallDetail):?>
            <tr>
                <td><?php echo date('Y-m-d H:i:s', $uninstallDetail['timeStamp']);?></td>
                <td><?php echo $uninstallDetail['ver'];?></td>
                <td><?php echo $uninstallDetail['cid'];?></td>
                <td><?php echo $uninstallDetail['ud'];?></td>
                <td><?php echo $uninstallDetail['uc'];?></td>
                <td>
                    <a target="_blank" href="index.php?/log/uninstall_detail_sdata/<?php echo date('Ymd', $uninstallDetail['timeStamp']);?>/<?php echo $uninstallDetail['sid'];?>/">源数据</a>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <div style="height: 30px;"></div>

    <div class="form-inline">
        <ul class="pagination">
            <?php if($page['pre'] > 0):?>
                <li page="<?php echo $page['pre'];?>"><a href="#">上一页</a></li>
            <?php else:?>
                <li class="disabled"><a href="#">上一页</a></li>
            <?php endif;?>

            <?php foreach($page['left'] as $row):?>
                <?php if($row == '...'):?>
                    <li class="disabled"><a href="#">...</a></li>
                <?php else:?>
                    <li page="<?php echo $row;?>"><a href="#"><?php echo $row;?></a></li>
                <?php endif;?>
            <?php endforeach;?>

            <li class="active"><a href="#"><?php echo $page['current'];?> <span class="sr-only">(current)</span></a></li>

            <?php foreach($page['right'] as $row):?>
                <?php if($row == '...'):?>
                    <li class="disabled"><a href="#">...</a></li>
                <?php else:?>
                    <li page="<?php echo $row;?>"><a href="#"><?php echo $row;?></a></li>
                <?php endif;?>
            <?php endforeach;?>

            <?php if($page['next'] > 0):?>
                <li page="<?php echo $page['next'];?>"><a href="#">下一页</a></li>
            <?php else:?>
                <li class="disabled"><a href="#">下一页</a></li>
            <?php endif;?>
        </ul>
        <input id="jumpPageTxt" type="text" class="form-control" placeholder="页" style="width:45px; position:relative;top:-33px;">
        <a id="jumpPageBtn" href="#" type="button" class="btn btn-danger" style="position:relative;top:-33px;">GO!</a>
        <span style="color:#999999; font-size:18px; position:relative;top:-30px;">共<?php echo $count;?>条 <?php echo $allPage;?>页</span>
     </div>

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
    $(".pagination li").click(function(){
        if($(this).attr("class") != 'disabled' && $(this).attr("class") != 'active'){
            $("#page").val($(this).attr("page"));
            $("#searchForm").attr("target", "_self")
            $("#searchForm").submit();
        }
    });
    $("#jumpPageBtn").click(function(){
        $("#page").val($("#jumpPageTxt").val());
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