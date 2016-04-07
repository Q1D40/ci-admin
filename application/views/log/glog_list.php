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
                 <select name="rule" class="form-control selectpicker">
                     <option value="u" <?php if($rule == 'u'):?>selected="selected"<?php endif;?>>人数</option>
                     <option value="t" <?php if($rule == 't'):?>selected="selected"<?php endif;?>>次数</option>
                 </select>
             </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <select name="type" class="form-control selectpicker">
                    <?php foreach($typeList as $row):?>
                        <option value="<?php echo $row;?>" <?php if($row == $type):?>selected="selected"<?php endif;?>><?php echo $row;?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="btn-group col-md-2">
                <button id="searchbtn" type="button" class="btn btn-primary">查询</button>
                <button id="newPageSearchBtn" type="button" class="btn btn-primary">在新页面查询</button>
            </div>

            <!--
            <div class="col-md-2">
                <button id="exportBtn" type="button" class="btn btn-success form-control">导出</button>
            </div>
            -->
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
            <th>日活跃</th>

            <?php for($i=0; $i<10; $i++):?>
                <th><?php echo $glogTitle[$type]['a' . ($i+1)];?></th>
            <?php endfor;?>

            <?php for($i=0; $i<10; $i++):?>
                <th><?php echo $glogTitle[$type]['b' . ($i+1)];?></th>
            <?php endfor;?>

            <?php for($i=0; $i<10; $i++):?>
                <th><?php echo $glogTitle[$type]['c' . ($i+1)];?></th>
            <?php endfor;?>

            <?php for($i=0; $i<10; $i++):?>
                <th><?php echo $glogTitle[$type]['d' . ($i+1)];?></th>
            <?php endfor;?>

            <?php for($i=0; $i<10; $i++):?>
                <th><?php echo $glogTitle[$type]['e' . ($i+1)];?></th>
            <?php endfor;?>
        </tr>
        </thead>
        <tbody>

        <?php foreach($dataList as $key => $data):?>
            <tr>
                <td><?php echo $data['date'];?></td>
                <?php if($ver != 'group'):?>
                <td><?php echo $data['ver'];?></td>
                <?php endif;?>
                <?php if($cid != 'group'):?>
                <td><?php echo $data['cid'];?></td>
                <?php endif;?>
                <td><?php echo $usersList[$key]['dayActiveUser']+0;?>
                </td>
                <?php for($i=0; $i<10; $i++):?>
                    <td>
                        <a href="#" class="tip" data-toggle="tooltip" data-html="true" title="<p>人数：<?php echo $data['a' . ($i+1) . '-u'];?></p><p>次数：<?php echo $data['a' . ($i+1) . '-t'];?></p><p>人均：<?php echo round($data['a' . ($i+1) . '-t']/$data['a' . ($i+1) . '-u'], 2);?></p>">
                            <?php echo $data['a' . ($i+1) . '-' . $rule];?>
                        </a>
                    </td>
                <?php endfor;?>

                <?php for($i=0; $i<10; $i++):?>
                    <td>
                        <a href="#" class="tip" data-toggle="tooltip" data-html="true" title="<p>人数：<?php echo $data['b' . ($i+1) . '-u'];?></p><p>次数：<?php echo $data['b' . ($i+1) . '-t'];?></p><p>人均：<?php echo round($data['b' . ($i+1) . '-t']/$data['b' . ($i+1) . '-u'], 2);?></p>">
                            <?php echo $data['b' . ($i+1) . '-' . $rule];?>
                        </a>
                    </td>
                <?php endfor;?>

                <?php for($i=0; $i<10; $i++):?>
                    <td>
                        <a href="#" class="tip" data-toggle="tooltip" data-html="true" title="<p>人数：<?php echo $data['c' . ($i+1) . '-u'];?></p><p>次数：<?php echo $data['c' . ($i+1) . '-t'];?></p><p>人均：<?php echo round($data['c' . ($i+1) . '-t']/$data['c' . ($i+1) . '-u'], 2);?></p>">
                            <?php echo $data['c' . ($i+1) . '-' . $rule];?>
                        </a>
                    </td>
                <?php endfor;?>

                <?php for($i=0; $i<10; $i++):?>
                    <td>
                        <a href="#" class="tip" data-toggle="tooltip" data-html="true" title="<p>人数：<?php echo $data['d' . ($i+1) . '-u'];?></p><p>次数：<?php echo $data['d' . ($i+1) . '-t'];?></p><p>人均：<?php echo round($data['d' . ($i+1) . '-t']/$data['d' . ($i+1) . '-u'], 2);?></p>">
                            <?php echo $data['d' . ($i+1) . '-' . $rule];?>
                        </a>
                    </td>
                <?php endfor;?>

                <?php for($i=0; $i<10; $i++):?>
                    <td>
                        <a href="#" class="tip" data-toggle="tooltip" data-html="true" title="<p>人数：<?php echo $data['e' . ($i+1) . '-u'];?></p><p>次数：<?php echo $data['e' . ($i+1) . '-t'];?></p><p>人均：<?php echo round($data['e' . ($i+1) . '-t']/$data['e' . ($i+1) . '-u'], 2);?></p>">
                            <?php echo $data['e' . ($i+1) . '-' . $rule];?>
                        </a>
                    </td>
                <?php endfor;?>

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