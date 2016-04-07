<div id="rightMain" class="col-md-12" role="main">

    <div style="height: 150px;"></div>

    <form id="searchForm" role="form" action="" method="POST">
    <div class="row">
        <div class="col-xs-3"></div>
        <div class="col-xs-4">
            <input type="text" class="form-control input-lg" placeholder="手机号" autocomplete="off" name="mobile" value="<?php echo $mobile;?>">
        </div>
        <div class="col-xs-2">
            <button type="submit" class="btn btn-success btn-lg btn-block">查询</button>
        </div>
        <div class="col-xs-3"></div>
    </div>

    <div class="row" style="height: 30px;"></div>

    <div class="row">
        <div class="col-xs-3"></div>
        <div class="col-xs-6" style="height: 163px;">
            <?php if($mobile != ''):?>
                <?php if(is_array($juice) && count($juice)):?>
                    <h3>机器码: <span style="font-weight:normal;"><?php echo substr($juice['umid'], 0, 32);?></span></h3>
                    <h3>手机号: <span style="font-weight:normal;"><?php echo substr($juice['mobile'], 0, 32);?></span></h3>
                    <h3>提交时间: <span style="font-weight:normal;"><?php echo date("Y年m月d日 H:i:s", $juice['timeStamp']);?></span></h3>
                    <h3>是否领取: <input id="switchStatus" class='switch myswitch' data-on="success" data-off="danger" type="checkbox" <?php if($juice['status'] == 1):?>checked<?php endif;?>></h3>
                <?php else:?>
                    <h3>
                        <div class="row">
                            <div class="col-xs-4"></div>
                            <div class="col-xs-4"><span style="color: red;">无记录！</span></div>
                            <div class="col-xs-4"></div>
                        <div>
                    </h3>
                <?php endif;?>
            <?php endif;?>
        </div>
        <div class="col-xs-3"></div>
    </div>
    </form>

</div>

<script>
    $('#switchStatus').on('switch-change', function (e, data) {
        var mobile = '<?php echo $juice['mobile'];?>';
        var status = 0;
        if(data.value == true){
            status = 1;
        }
        $.ajax({
            type:'POST',
            url:'index.php?/activity/set_xiaoyuan_juice_status/',
            data:{'mobile':mobile,'status':status}
        });
    });
</script>

