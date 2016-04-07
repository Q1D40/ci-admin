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
            <th>时间</th>
            <th>用量</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($diskUsageLogList as $diskUsageLog):?>
            <tr>
                <td><?php echo $diskUsageLog['date'];?></td>
                <td><?php echo date('H:i:s', $diskUsageLog['timeStamp']);?></td>
                <td><?php echo round($diskUsageLog['usage']/1024/1024, 2) . 'G'?></td>
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