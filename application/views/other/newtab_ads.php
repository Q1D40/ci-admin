<div id="rightMain" class="col-md-12" role="main">

    <div style="height: 30px;"></div>

    <div class="alert alert-danger <?php if($error == ''):?>hide<?php else:?>fade in<?php endif;?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $error;?>
    </div>

    <div class="alert alert-success <?php if($success == ''):?>hide<?php else:?>fade in<?php endif;?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $success;?>
    </div>

    <form id="searchForm" role="form" action="" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-10">
                <textarea name="f3" class="form-control" placeholder="广告规则" rows="10"><?php echo $adSetting;?></textarea>
            </div>
        </div>
        <div style="height: 10px;"></div>
        <div class="row">
            <div class="btn-group col-md-3">
                <button type="submit" class="btn btn-primary form-control save" data-loading-text="正在保存..." name="setting" value="1">保存</button>
            </div>
        </div>

        <div style="height: 60px;"></div>

        <div class="row">
            <div class="col-md-3">
                <select name="type" class="form-control selectpicker" id="type">
                    <option value="1" <?php if($type == 1):?>selected = "selected"<?php endif;?>>宫格</option>
                    <option value="2" <?php if($type == 2):?>selected = "selected"<?php endif;?>>文字链</option>
                    <option value="3" <?php if($type == 3):?>selected = "selected"<?php endif;?>>背景图</option>
                    <option value="4" <?php if($type == 4):?>selected = "selected"<?php endif;?>>浮层</option>
                </select>
            </div>
        </div>

        <div class="ad1">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="url" class="form-control" placeholder="URL 例：http://www.baidu.com/?tn=1112" value="">
                </div>
                <div class="col-md-3">
                    <input type="text" name="title" class="form-control" placeholder="标题 例：百度一下" value="">
                </div>
                <div class="col-md-6">
                    <input type="file" name="img" class="col-md-3" multiple=""/>
                </div>
            </div>
            <div style="height: 10px;"></div>
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="life" class="form-control" placeholder="生命周期 例：5" value="">
                </div>
                <div class="btn-group col-md-3">
                    <button type="submit" class="btn btn-primary form-control save" data-loading-text="正在保存..." name="logo" value="1">添加</button>
                </div>
            </div>
        </div>

        <div class="ad2" style="display: none">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="url" class="form-control" placeholder="URL 例：http://www.baidu.com/?tn=1112" value="">
                </div>
                <div class="col-md-3">
                    <input type="text" name="title" class="form-control" placeholder="标题 例：百度一下" value="">
                </div>
                <div class="btn-group col-md-3">
                    <button type="submit" class="btn btn-primary form-control save" data-loading-text="正在保存..." name="logo" value="1">添加</button>
                </div>
            </div>
        </div>

        <div class="ad3" style="display: none">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="pos" class="form-control" placeholder="位置 例：2" value="">
                </div>
                <div class="col-md-6">
                    <input type="file" name="img" class="col-md-3" multiple=""/>
                </div>
            </div>
            <div style="height: 10px;"></div>
            <div class="row">
                <div class="btn-group col-md-3">
                    <button type="submit" class="btn btn-primary form-control save" data-loading-text="正在保存..." name="logo" value="1">添加</button>
                </div>
            </div>
        </div>

        <div class="ad4" style="display: none">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="url" class="form-control" placeholder="URL 例：http://www.baidu.com/?tn=1112" value="">
                </div>
                <div class="col-md-3">
                    <input type="text" name="pos" class="form-control" placeholder="位置 例：2" value="">
                </div>
                <div class="col-md-6">
                    <input type="file" name="img" class="col-md-3" multiple=""/>
                </div>
            </div>
            <div style="height: 10px;"></div>
            <div class="row">
                <div class="col-md-2">
                    <input type="text" name="x1" class="form-control" placeholder="起始x坐标 例：10" value="">
                </div>
                <div class="col-md-2">
                    <input type="text" name="y1" class="form-control" placeholder="起始y坐标 例：10" value="">
                </div>
                <div class="col-md-2">
                    <input type="text" name="x2" class="form-control" placeholder="结束x坐标 例：250" value="">
                </div>
                <div class="col-md-2">
                    <input type="text" name="y2" class="form-control" placeholder="结束y坐标 例：250" value="">
                </div>
            </div>
            <div style="height: 10px;"></div>
            <div class="row">
                <div class="btn-group col-md-3">
                    <button type="submit" class="btn btn-primary form-control save" data-loading-text="正在保存..." name="logo" value="1">添加</button>
                </div>
            </div>
        </div>


    </form>

    <div style="height: 30px;"></div>

    <table class="table table-hover tbcloth ad1">
        <thead>
        <tr>
            <th>ID</th>
            <th>URL</th>
            <th>标题</th>
            <th>图片</th>
            <th>生命周期</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($adList as $key => $row):?>
            <?php if($row['type'] == 1):?>
            <tr>
                <td><?php echo $key;?></td>
                <td><?php echo $row['url'];?></td>
                <td><?php echo $row['title'];?></td>
                <td><a target="_blank" href="<?php echo $row['img'];?>"><img height="20" width="30" src="<?php echo $row['img'];?>" /></a></td>
                <td><?php echo $row['life'];?></td>
            </tr>
            <?php endif;?>
        <?php endforeach;?>
        </tbody>
    </table>

    <table class="table table-hover tbcloth ad2" style="display: none;">
        <thead>
        <tr>
            <th>ID</th>
            <th>URL</th>
            <th>标题</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($adList as $key => $row):?>
            <?php if($row['type'] == 2):?>
            <tr>
                <td><?php echo $key;?></td>
                <td><?php echo $row['url'];?></td>
                <td><?php echo $row['title'];?></td>
            </tr>
            <?php endif;?>
        <?php endforeach;?>
        </tbody>
    </table>

    <table class="table table-hover tbcloth ad3" style="display: none;">
        <thead>
        <tr>
            <th>ID</th>
            <th>图片</th>
            <th>位置</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($adList as $key => $row):?>
            <?php if($row['type'] == 3):?>
                <tr>
                    <td><?php echo $key;?></td>
                    <td><a target="_blank" href="<?php echo $row['img'];?>"><img height="20" width="30" src="<?php echo $row['img'];?>" /></a></td>
                    <td><?php echo $row['pos'];?></td>
                </tr>
            <?php endif;?>
        <?php endforeach;?>
        </tbody>
    </table>

    <table class="table table-hover tbcloth ad4" style="display: none;">
        <thead>
        <tr>
            <th>ID</th>
            <th>URL</th>
            <th>图片</th>
            <th>位置</th>
            <th>起始x坐标</th>
            <th>起始y坐标</th>
            <th>结束x坐标</th>
            <th>结束y坐标</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($adList as $key => $row):?>
            <?php if($row['type'] == 4):?>
                <tr>
                    <td><?php echo $key;?></td>
                    <td><?php echo $row['url'];?></td>
                    <td><a target="_blank" href="<?php echo $row['img'];?>"><img height="20" width="30" src="<?php echo $row['img'];?>" /></a></td>
                    <td><?php echo $row['pos'];?></td>
                    <td><?php echo $row['x1'];?></td>
                    <td><?php echo $row['y1'];?></td>
                    <td><?php echo $row['x2'];?></td>
                    <td><?php echo $row['y2'];?></td>
                </tr>
            <?php endif;?>
        <?php endforeach;?>
        </tbody>
    </table>

</div>

<script>
    setForm(<?php echo $type;?>);
    $('.save').click(function () {
        $(this).button('loading');
    });
    $('#type').change(function(){
        var type = $(this).val();
        setForm(type);
    });
    function setForm(type)
    {
        $('.ad1').hide();
        $('.ad2').hide();
        $('.ad3').hide();
        $('.ad4').hide();
        $('#searchForm input').attr('disabled', 'disabled');
        $('.ad' + type).show();
        $('.ad' + type + ' input').removeAttr("disabled");
    }
</script>