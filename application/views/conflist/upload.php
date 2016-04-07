<div id="rightMain" class="col-md-12" role="main">
    <div class="alert alert-danger fade in">
        最新Adblock版本号<?php echo $adblockLastVersion;?>
    </div>
    <div class="alert alert-warning <?php if($error == ''):?>hide<?php else:?>fade in<?php endif;?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $error;?>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <a href="index.php?/conflist/conf_list/" type="button" class="btn btn-default col-md-1">
            <span class="glyphicon glyphicon-arrow-left"></span> 返回
        </a>

        <input type="file" name="file" id="file" class="col-md-3" />
        <input type="submit" name="submit" class="btn btn-success col-md-3" value="上传" />
    </form>

    <div style="height: 50px;"></div>

    <table class="table table-hover tbcloth">
        <thead>
        <tr>
            <th>配置文件</th>
            <th>日期</th>
            <th>下载地址</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($updateList as $update):?>
            <tr>
                <td><?php echo $update['file'];?></td>
                <td><?php echo date("Y-m-d H:i:s", $update['ctime']);?></td>
                <td><?php echo $download_install_url . $update['file'];?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>