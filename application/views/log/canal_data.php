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
            <th>渠道号</th>
            <th>安装量</th>
            <th>日活量</th>
            <th>周留存</th>
            <th>月留存</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($canalDataList as $canalData):?>
            <tr>
                <td><?php echo $canalData['date'];?></td>
                <td><?php echo $canalData['cid'];?></td>
                <td><?php echo $canalData['install'];?></td>
                <td><?php echo $canalData['dayActive'];?></td>
                <td><?php echo $canalData['weekKeep'];?></td>
                <td><?php echo $canalData['monthKeep'];?></td>
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