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
                <a href="#" class="tip" data-toggle="tooltip" title="报活用户用户习惯默认搜索引擎为百度的数量（mid不除重）">
                    百度数量
                </a>
            </th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="报活用户用户习惯默认搜索引擎为百度的数量占比 ">
                    占比
                </a>
            </th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="报活用户用户习惯默认搜索引擎谷歌数量（mid不除重）">
                    谷歌数量
                </a>
            </th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="报活用户用户习惯默认搜索引擎为谷歌的数量占比 ">
                    占比
                </a>
            </th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="报活用户用户习惯默认搜索引擎为360so/综合搜索的数量（mid不除重）">
                    360数量
                </a>
            </th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="报活用户用户习惯默认搜索引擎为360so/综合搜索的数量占比 ">
                    占比
                </a>
            </th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="报活用户用户习惯默认搜索引擎为搜狗的数量（mid不除重）">
                    搜狗数量
                </a>
            </th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="报活用户用户习惯默认搜索引擎为搜狗的数量占比 ">
                    占比
                </a>
            </th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="报活用户用户习惯默认搜索引擎为SOSO的数量（mid不除重）">
                    SOSO数量
                </a>
            </th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="报活用户用户习惯默认搜索引擎为SOSO的数量占比 ">
                    占比
                </a>
            </th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="报活用户用户习惯默认搜索引擎为其他的数量（mid不除重）">
                    其他数量
                </a>
            </th>
            <th>
                <a href="#" class="tip" data-toggle="tooltip" title="报活用户用户习惯默认搜索引擎为其他的数量占比 ">
                    占比
                </a>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($userDefaultSearchEngineList as $userDefaultSearchEngine):?>
            <?php $totalDefaultSearchEngine = $userDefaultSearchEngine['baidu'] + $userDefaultSearchEngine['google'] + $userDefaultSearchEngine['360so'] + $userDefaultSearchEngine['sogou'] + $userDefaultSearchEngine['soso'] + $userDefaultSearchEngine['other'];?>
            <tr>
                <td><?php echo $userDefaultSearchEngine['date'];?></td>
                <?php if($ver != 'group'):?>
                    <td><?php echo $userDefaultSearchEngine['ver'];?></td>
                <?php endif;?>
                <?php if($cid != 'group'):?>
                    <td><?php echo $userDefaultSearchEngine['cid'];?></td>
                <?php endif;?>
                <td><?php echo $userDefaultSearchEngine['baidu'];?></td>
                <td><?php echo round($userDefaultSearchEngine['baidu'] / $totalDefaultSearchEngine, 4) * 100;?>%</td>
                <td><?php echo $userDefaultSearchEngine['google']?></td>
                <td><?php echo round($userDefaultSearchEngine['google'] / $totalDefaultSearchEngine, 4) * 100;?>%</td>
                <td><?php echo $userDefaultSearchEngine['360so'];?></td>
                <td><?php echo round($userDefaultSearchEngine['360so'] / $totalDefaultSearchEngine, 4) * 100;?>%</td>
                <td><?php echo $userDefaultSearchEngine['sogou'];?></td>
                <td><?php echo round($userDefaultSearchEngine['sogou'] / $totalDefaultSearchEngine, 4) * 100;?>%</td>
                <td><?php echo $userDefaultSearchEngine['soso'];?></td>
                <td><?php echo round($userDefaultSearchEngine['soso'] / $totalDefaultSearchEngine, 4) * 100;?>%</td>
                <td><?php echo $userDefaultSearchEngine['other'];?></td>
                <td><?php echo round($userDefaultSearchEngine['other'] / $totalDefaultSearchEngine, 4) * 100;?>%</td>
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