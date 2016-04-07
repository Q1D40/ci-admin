<div id="rightMain" class="col-md-12" role="main">
    <div class="alert alert-warning <?php if($error == ''):?>hide<?php else:?>fade in<?php endif;?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $error;?>
    </div>

    <a href="index.php?/user/permission_list/" type="button" class="btn btn-default col-md-1">
        <span class="glyphicon glyphicon-arrow-left"></span> 返回
    </a>
    <div style="height: 50px;"></div>

    <form action="index.php?/user/permission_<?php echo $act;?>/<?php echo $permission['id'];?>/" method="post" class="form-horizontal" role="form">
        <div class="form-group">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="名称" value="<?php echo $permission['name'];?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-4">
                <input type="text" name="key" class="form-control" placeholder="key" value="<?php echo $permission['key'];?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary form-control">保存</button>
            </div>
        </div>
    </form>
</div>