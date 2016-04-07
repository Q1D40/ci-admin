<div id="rightMain" class="col-md-12" role="main">
    <div class="alert alert-warning <?php if($error == ''):?>hide<?php else:?>fade in<?php endif;?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $error;?>
    </div>
    <form id="searchForm" role="form" action="" method="POST">
        <div class="row">
        </div>
    </form>

    <div style="height: 30px;"></div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>日期</th>
            <th>时间</th>
            <th>类型</th>
            <th>任务</th>
            <th>超时</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($warningLogList as $warningLog):?>
            <tr>
                <td><?php echo $warningLog['date'];?></td>
                <td><?php echo date('H:i:s', $warningLog['timeStamp']);?></td>
                <td><?php echo $warningLog['type'];?></td>
                <td><?php echo $warningLog['ext1'];?></td>
                <td><?php echo $warningLog['ext2'] . '秒';?></td>
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