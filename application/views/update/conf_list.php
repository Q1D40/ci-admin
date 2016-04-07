<div id="rightMain" class="col-md-12" role="main">
    <div class="alert alert-danger fade in">
        注意：安装包名称可自定义，配置文件中要返回完整的安装包名（不包含扩展名）加版本号，中间用<em>&</em>符连接。例如：return 'JuziBrowser_1.0.0.1&1.0.0.1';
    </div>
	<!--开始修改lee-->
	<?php if($errMsg!=null) :?>
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
    <a href="index.php?/update/conf_add/" class="btn btn-primary">修改配置</a>
    <a href="index.php?/update/upload/" class="btn btn-success">上传安装包</a>
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
            <?php if($conf['file'] != 'default_conf.inc'):?>
            <tr>
                <td><?php echo $conf['file'];?> <?php if($conf['file'] == $currentConf['file']):?><span style="color: #FF0000">[当前使用]</span><?php endif;?></td>
                <td><?php echo date("Y-m-d H:i:s", $conf['ctime']);?></td>
                <td>
                    <a href="index.php?/update/conf_view/<?php echo base64_encode($conf['file']);?>" target="_blank" type="button" class="btn btn-default col-md-2">完整</a>
                    <a href="index.php?/update/code_view/<?php echo base64_encode($conf['file']);?>" target="_blank" type="button" class="btn btn-default col-md-2">条件</a>
                </td>
            </tr>
            <?php endif;?>
        <?php endforeach;?>
        </tbody>

        <thead>
        <tr>
            <th>系统默认</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>default_conf.inc</td>
            <td>
                <a href="index.php?/update/conf_view/<?php echo base64_encode('default_conf.inc');?>" target="_blank" type="button" class="btn btn-default col-md-3">完整</a>
            </td>
        </tr>
        </tbody>

    </table>
</div>