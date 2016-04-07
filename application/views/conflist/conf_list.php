<div id="rightMain" class="col-md-12" role="main">
    <div class="alert alert-danger fade in">
        最新Adblock版本号<?php echo $adblockLastVersion;?>
    </div>
	<!--开始修改-->
	<?php if($errMsg != null):?>
	<div class="alert alert-danger alert-dismissable">
	 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	 <strong>错误：</strong>  <?php echo $errMsg; ?>
	</div>
	<?php endif;?>
	<?php if($sucMsg != null):?>
	<div class="alert alert-success alert-dismissable">
	 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	 <strong>成功：</strong>  <?php echo $sucMsg; ?>
	</div>
	<?php endif;?>
	<!--修改结束-->
    <a href="index.php?/conflist/conf_add/" class="btn btn-primary">修改配置</a>
    <a href="index.php?/conflist/upload/" class="btn btn-success">上传配置压缩包</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <span style="color:#999999; font-weight:bold; font-size: 18px;">自动抓取Adblock规则：</span><input id="autoUpdate" type="checkbox" <?php if($adblockAutoSwitch == 1):?>checked<?php endif;?>>
    <div style="height: 30px;"></div>

    <table class="table table-hover tbcloth">

        <thead>
        <tr>
            <th>配置文件</th>
            <th>日期</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($confList as $k => $conf):?>
            <tr>
                <td><?php echo $conf['file'];?> <?php if($conf['file'] == $currentConf['file']):?><span style="color: #FF0000">[当前使用]</span><?php endif;?></td>
                <td><?php echo date("Y-m-d H:i:s", $conf['ctime']);?></td>
                <td>
                    <a href="index.php?/conflist/conf_view/<?php echo base64_encode($conf['file']);?>" target="_blank" type="button" class="btn btn-default col-md-3">查看</a>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>

    </table>
</div>