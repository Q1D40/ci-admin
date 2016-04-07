<div id="rightMain" class="col-md-12" role="main">
    <div class="alert alert-danger <?php if($errMsg == ''):?>hide<?php else:?>fade in<?php endif;?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $errMsg;?>
    </div>

    <div class="alert alert-success <?php if($sucMsg == ''):?>hide<?php else:?>fade in<?php endif;?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $sucMsg;?>
    </div>

    <div style="height: 30px;"></div>
    <form action="" method="post" class="row">
        <p></p>
        <textarea name="code" id="code" class="form-control" rows="20" placeholder="跳转页配置"><?php echo $code;?></textarea>
        <p></p>
        <button type="submit" class="btn btn-primary">保存</button>
    </form>
</div>

<script>
    $(document).ready(function(){
        $(window).resize(function(){
            setRow();
        });
        setRow();
        function setRow(){
            var trow = Math.pow(document.documentElement.clientHeight,1.2) / Math.pow(window.screen.height,1.2) * 35;
            $('#code').attr("rows",trow);
        }
    });
</script>