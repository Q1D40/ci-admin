<div id="rightMain" class="col-md-12" role="main">
    <div class="alert alert-warning <?php if($error == ''):?>hide<?php else:?>fade in<?php endif;?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $error;?>
    </div>
    <form id="searchForm" role="form" action="" method="POST">
         <div class="row">
            <div class="col-md-2">
              <input type="text" name="date" class="form-control datetimepicker" value="<?php echo $date;?>">
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
                <select name="ver" class="form-control combobox">
                    <option value="group" <?php if($ver == 'group'):?>selected="selected"<?php endif;?>>不区分版本</option>
                    <option value="all" <?php if($ver == 'all'):?>selected="selected"<?php endif;?>>全部版本</option>
                    <?php foreach($verMap as $verOne):?>
                        <option value="<?php echo $verOne;?>" <?php if($verOne == $ver):?>selected="selected"<?php endif;?>><?php echo $verOne;?></option>
                    <?php endforeach;?>
                </select>
            </div>
             <div class="col-md-2">
                 <select name="type" class="form-control selectpicker">
                     <option value="group" <?php if($type == 'group'):?>selected="selected"<?php endif;?>>不区分类型</option>
                     <option value="all" <?php if($type == 'all'):?>selected="selected"<?php endif;?>>全部类型</option>
                     <?php foreach($typeMap as $key => $value):?>
                         <option value="<?php echo $key;?>" <?php if($key == $type):?>selected="selected"<?php endif;?>><?php echo $value;?></option>
                     <?php endforeach;?>
                 </select>
             </div>
             <div class="col-md-2">
                 <select name="result" class="form-control selectpicker">
                     <option value="group" <?php if(strval($result) == 'group'):?>selected="selected"<?php endif;?>>不区分结果</option>
                     <option value="all" <?php if(strval($result) == 'all'):?>selected="selected"<?php endif;?>>全部结果</option>
                     <?php foreach($resultMap as $key => $value):?>
                         <option value="<?php echo $key;?>" <?php if(strval($key) == strval($result)):?>selected="selected"<?php endif;?>><?php echo $value;?></option>
                     <?php endforeach;?>
                 </select>
             </div>
             <div class="col-md-2">
                 <input type="text" name="errorCode" class="form-control" placeholder="错误码" value="<?php echo $errorCode;?>">
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
        </div>
    </form>

    <div style="height: 30px;"></div>

    <table class="table table-hover tbcloth">
        <thead>
        <tr>
            <th>日期</th>
            <?php if($cid != 'group'):?>
                <th>渠道</th>
            <?php endif;?>
            <?php if($ver != 'group'):?>
            <th>版本号</th>
            <?php endif;?>
            <?php if($type != 'group'):?>
                <th>类型</th>
            <?php endif;?>
            <?php if(strval($result) != 'group'):?>
                <th>结果</th>
            <?php endif;?>
            <th>错误码</th>
            <th>次数</th>
            <th>占比</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($errorCodeList as $errorCode):?>
            <tr>
                <td><?php echo $errorCode['date'];?></td>

                <?php if($cid != 'group'):?>
                    <td><?php echo $errorCode['cid'];?></td>
                <?php endif;?>
                <?php if($ver != 'group'):?>
                <td><?php echo $errorCode['ver'];?></td>
                <?php endif;?>
                <?php if($type != 'group'):?>
                <td><?php echo $typeMap[$errorCode['type']];?></td>
                <?php endif;?>
                <?php if(strval($result) != 'group'):?>
                    <td><?php echo $resultMap[$errorCode['result']];?></td>
                <?php endif;?>

                <td><?php echo $errorCode['errorCode'];?></td>
                <td><?php echo $errorCode['number'];?></td>
                <td><?php echo round(($errorCode['number']/$allNumber), 4)*100;?>%</td>
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