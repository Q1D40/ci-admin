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
                 <input type="text" name="type" class="form-control" placeholder="类型" value="<?php echo $type;?>">
             </div>
             <div class="col-md-2">
                 <select name="status" class="form-control selectpicker">
                     <option value="all" <?php if($status == 'all'):?>selected="selected"<?php endif;?>>全部状态</option>
                     <option value="done" <?php if($status == 'done'):?>selected="selected"<?php endif;?>>已完成</option>
                     <option value="doing" <?php if($status == 'doing'):?>selected="selected"<?php endif;?>>运行中</option>
                 </select>
             </div>
            <div class="btn-group col-md-2">
                <button id="searchbtn" type="button" class="btn btn-primary">查询</button>
                <button id="newPageSearchBtn" type="button" class="btn btn-primary">在新页面查询</button>
            </div>
            <div class="col-md-2">
                <!--<button id="exportBtn" type="button" class="btn btn-success form-control">导出</button>-->
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
            <th>进程ID</th>
            <th>进程类型</th>
            <th>内存使用</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th>运行时长</th>
            <th>运行状态</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($cronLogList as $cronLog):?>
            <tr>
                <td><?php echo $cronLog['date'];?></td>
                <td><?php echo $cronLog['pid'];?></td>
                <td><?php echo $cronLog['type'];?></td>
                <td><?php if($cronLog['endTime'] > 0) echo round($cronLog['memory']/1024/1024, 2) . 'MB';?></td>
                <td><?php echo date('H:i:s', $cronLog['startTime']);?></td>
                <td><?php if($cronLog['endTime'] > 0) echo date('H:i:s', $cronLog['endTime']);?></td>
                <td><?php if($cronLog['endTime'] > 0) echo ($cronLog['endTime'] - $cronLog['startTime']) . '秒'; else echo (time() - $cronLog['startTime']) . '秒';?></td>
                <td><?php if($cronLog['endTime'] > 0) echo '<span style="color: #008000">已完成</span>'; else echo '<span style="color: #ff0000">运行中</span>';?></td>
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
</script>