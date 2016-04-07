<div id="rightMain" class="col-md-12" role="main">
    <div class="alert alert-warning <?php if($error == ''):?>hide<?php else:?>fade in<?php endif;?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $error;?>
    </div>

    <a href="index.php?/user/user_list/" type="button" class="btn btn-default col-md-1">
        <span class="glyphicon glyphicon-arrow-left"></span> 返回
    </a>
    <div style="height: 50px;"></div>

    <form action="index.php?/user/user_<?php echo $act;?>/<?php echo $user['uid'];?>" method="post" class="form-horizontal" role="form">
        <div class="form-group">
        <div class="col-md-4">
            <input type="text" name="userName" class="form-control" placeholder="用户名" value="<?php echo $user['userName'];?>">
        </div>
        <div class="col-md-4">
            <input type="text" name="passWord" autoComplete="off" class="form-control" placeholder="密码" value="">
        </div>
        </div>

        <?php foreach($permissionList as $permission):?>
            <div class="form-group">
                <div class="col-md-4">
                    <label class="control-label" for="<?php echo $permission['key'];?>"><?php echo $permission['name'];?></label>
                </div>
                <div class="col-md-4">
                    <input id="<?php echo $permission['key'];?>" class='switch switch-mini myswitch' type="checkbox" name="permission[]" value="<?php echo $permission['id'];?>" <?php if(in_array($permission['id'], $user['permission'])):?>checked<?php endif;?>>
                </div>
            </div>
        <?php endforeach;?>

        <div class="form-group">
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary form-control">保存</button>
            </div>
        </div>
    </form>
</div>