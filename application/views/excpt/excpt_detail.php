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
                    <option value="all" <?php if($search['appv'] == 'all'):?>selected="selected"<?php endif;?>>不区分版本</option>
                    <?php foreach($verMap as $verOne):?>
                        <option value="<?php echo $verOne;?>" <?php if($verOne == $search['appv']):?>selected="selected"<?php endif;?>><?php echo $verOne;?></option>
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
        </div>

        <div class="row">
            <div class="col-md-2">
                <input type="text" name="excptMD5" class="form-control" placeholder="MD5" value="<?php echo $search['excptMD5'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="iev" class="form-control" placeholder="IE版本" value="<?php echo $search['iev'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="osv" class="form-control" placeholder="操作系统" value="<?php echo $search['osv'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="fv" class="form-control" placeholder="Flash版本" value="<?php echo $search['fv'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="uuid" class="form-control" placeholder="UUID" value="<?php echo $search['uuid'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="os64" class="form-control" placeholder="是否64系统" value="<?php echo $search['os64'];?>">
            </div>
        </div>
        <div style="height: 10px;"></div>
        <div class="row">
            <div class="col-md-2">
                <input type="text" name="procType" class="form-control" placeholder="进程类型" value="<?php echo $search['procType'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="browserMode" class="form-control" placeholder="进程模型" value="<?php echo $search['browserMode'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="bExit" class="form-control" placeholder="进程是否退出" value="<?php echo $search['bExit'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="threadStatus" class="form-control" placeholder="线程状态" value="<?php echo $search['threadStatus'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="excptpid" class="form-control" placeholder="崩溃进程ID" value="<?php echo $search['excptpid'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="excpttid" class="form-control" placeholder="崩溃线程ID" value="<?php echo $search['excpttid'];?>">
            </div>
        </div>
        <div style="height: 10px;"></div>
        <div class="row">
            <div class="col-md-2">
                <input type="text" name="excptUrl" class="form-control" placeholder="崩溃页面URL" value="<?php echo $search['excptUrl'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="excptCnt" class="form-control" placeholder="进程异常次数" value="<?php echo $search['excptCnt'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="excptTm" class="form-control" placeholder="崩溃时间" value="<?php echo $search['excptTm'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="tckExcpt" class="form-control" placeholder="进程开启时长" value="<?php echo $search['tckExcpt'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="threadErr" class="form-control" placeholder="线程中异常代码" value="<?php echo $search['threadErr'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="appcdln" class="form-control" placeholder="崩溃进程启动参数" value="<?php echo $search['appcdln'];?>">
            </div>
        </div>
        <div style="height: 10px;"></div>
        <div class="row">
            <div class="col-md-2">
                <input type="text" name="excptmod" class="form-control" placeholder="崩溃发生模块" value="<?php echo $search['excptmod'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="excptmodv" class="form-control" placeholder="崩溃模块版本" value="<?php echo $search['excptmodv'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="excptcode" class="form-control" placeholder="崩溃代码" value="<?php echo $search['excptcode'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="excptaddr" class="form-control" placeholder="崩溃地址（偏移）" value="<?php echo $search['excptaddr'];?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="excptwalk" class="form-control" placeholder="崩溃堆栈" value="<?php echo $search['excptwalk'];?>">
            </div>
        </div>
    </form>

    <div style="height: 30px;"></div>

    <table class="table table-hover tbcloth">
        <thead>
        <tr>
            <th>渠道号</th>
            <th>UUID</th>
            <th>操作系统版本</th>
            <th>IE版本</th>
            <th>Flash版本</th>
            <th>主程序版本</th>
            <th>崩溃模块</th>
            <th>模块版本</th>
            <th>崩溃代码</th>
            <th>崩溃地址</th>
            <th>堆栈MD5</th>
            <th>崩溃堆栈</th>
            <th>崩溃页面URL</th>
            <th>异常次数</th>
            <th>进程ID</th>
            <th>线程ID</th>
            <th>进程类型</th>
            <th>进程启动参数</th>
            <th>是否64位</th>
            <th>进程是否退出</th>
            <th>进程开启时长</th>
            <th>进程模型</th>
            <th>线程状态</th>
            <th>异常代码</th>
            <th>崩溃时间</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($excptLogList as $row):?>
            <tr>
                <td><?php echo $row['cid'];?></td>
                <td><?php echo $row['uuid'];?></td>
                <td><?php echo $row['osv'];?></td>
                <td><?php echo $row['iev'];?></td>
                <td><?php echo $row['fv'];?></td>
                <td><?php echo $row['appv'];?></td>
                <td><div style="word-break:break-all;dispaly:block;width:200px;"><?php echo $row['excptmod'];?></div></td>
                <td><?php echo $row['excptmodv'];?></td>
                <td><?php echo $row['excptcode'];?></td>
                <td><?php echo $row['excptaddr'];?></td>
                <td><a href="index.php?/excpt/down_dump/<?php echo base64_encode(date("Y", $row['timeStamp']) . '/' . date("m", $row['timeStamp']) . '/' . date("d", $row['timeStamp']) . '/' . $row['dump'] . '.dmp');?>" target="_blank"><?php echo $row['excptMD5'];?></a></td>
                <td><div style="word-break:break-all;dispaly:block;width:300px;"><?php echo $row['excptwalk'];?></div></td>
                <td><?php echo $row['excptUrl'];?></td>
                <td><?php echo $row['excptCnt'];?></td>
                <td><?php echo $row['excptpid'];?></td>
                <td><?php echo $row['excpttid'];?></td>
                <td><?php echo $row['procType'];?></td>
                <td><div style="word-break:break-all;dispaly:block;width:300px;"><?php echo $row['appcdln'];?></div></td>
                <td><?php echo $row['os64'];?></td>
                <td><?php echo $row['bExit'];?></td>
                <td><?php echo $row['tckExcpt'];?></td>
                <td><?php echo $row['browserMode'];?></td>
                <td><?php echo $row['threadStatus'];?></td>
                <td><?php echo $row['threadErr'];?></td>
                <td><?php echo $row['excptTm'];?></td>
            </tr>
            </a>
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