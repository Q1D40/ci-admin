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
        </div>

        <div style="height: 10px;"></div>

        <div class="row">
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
            <th>URL</th>
            <th>标题</th>
            <th>图片</th>
            <th>生命周期</th>
            <th>人数</th>
            <th>次数</th>
            <th>时间</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($dataList as $data):?>
            <tr>
                <td><?php echo $startDate;?></td>
                <td><?php echo $adList[$data['as1']]['url'];?></td>
                <td><?php echo $adList[$data['as1']]['title'];?></td>
                <td><a target="_blank" href="#" data-toggle="popover" data-html="true" data-trigger="focus" data-placement="left" data-content='<img height="120" width="180" src="<?php echo $adList[$data['as1']]['img'];?>" />'><img height="20" width="30" src="<?php echo $adList[$data['as1']]['img'];?>" /></a></td>
                <td><?php echo $adList[$data['as1']]['life'];?></td>
                <td><?php echo $data['users'];?></td>
                <td><?php echo $data['times'];?></td>
                <td><?php echo $data['h'];?>点</td>
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
</script>