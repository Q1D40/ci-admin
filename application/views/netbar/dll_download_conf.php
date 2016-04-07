<div id="rightMain" class="col-md-12" role="main">

    <div class="alert alert-danger <?php if($error == ''):?>hide<?php else:?>fade in<?php endif;?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $error;?>
    </div>

    <div class="alert alert-success <?php if($success == ''):?>hide<?php else:?>fade in<?php endif;?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $success;?>
    </div>

    <div style="height: 30px;"></div>

    <form role="form" action="" method="POST">
        <div class="row">
            <div class="col-md-10">
                <textarea name="f1" id="f1" class="form-control" placeholder="json" rows="15"><?php echo $conf9['f1']?></textarea>
            </div>
        </div>
        <div style="height: 10px;"></div>
        <div class="row">
            <div class="btn-group col-md-3">
                <button type="submit" class="btn btn-success form-control save" data-loading-text="正在保存..." name="act" value="new">保存</button>
            </div>
        </div>
    </form>

</div>


<script>
    $(document).ready(function(){
        $('.save').click(function () {
            $(this).button('loading');
        });
        $(window).resize(function(){
            setRow();
        });
        setRow();
        function setRow(){
            var trow = (Math.pow(document.documentElement.clientHeight,1.2) / Math.pow(window.screen.height,1.2)) * 35;
            $('#f1').attr("rows",trow);
        }
    });
</script>