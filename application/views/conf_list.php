<div id="rightMain" class="col-md-12" role="main">
    <a href="index.php?/update/conf_add/" class="btn btn-primary">修改配置</a>
    <a href="index.php?/update/upload/" class="btn btn-success">上传安装包</a>
    <div style="height: 30px;"></div>

    <table class="table table-hover">

        <thead>
        <tr>
            <th>配置文件</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($confList as $k => $conf):?>
            <?php if($conf != 'default_conf.inc'):?>
            <tr>
                <td><?php echo $conf;?> <?php if($conf == $currentConf):?><span style="color: #FF0000">[当前使用]</span><?php endif;?></td>
                <td>
                    <a href="index.php?/update/conf_view/<?php echo base64_encode($conf);?>" target="_blank" type="button" class="btn btn-default col-md-2">
                        <span class="glyphicon glyphicon-eye-open"></span> 完整
                    </a>
                    <a href="index.php?/update/code_view/<?php echo base64_encode($conf);?>" target="_blank" type="button" class="btn btn-default col-md-2">
                        <span class="glyphicon glyphicon-eye-open"></span> 条件
                    </a>
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
                <a href="index.php?/update/conf_view/<?php echo base64_encode('default_conf.inc');?>" target="_blank" type="button" class="btn btn-default col-md-2">
                    <span class="glyphicon glyphicon-eye-open"></span> 完整
                </a>
            </td>
        </tr>
        </tbody>

    </table>
</div>