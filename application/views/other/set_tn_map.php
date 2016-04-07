<div id="rightMain" class="col-md-12" role="main">

    <a target="_blank" href="index.php?/other/show_tn_map/" type="button" class="btn btn-default">
        <span class="glyphicon glyphicon-eye-open"></span>
    </a>

    <div style="height: 30px;"></div>

    <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-default active">
            <input type="radio" name="options" id="singleAdd"> 单条添加
        </label>
        <label class="btn btn-default">
            <input type="radio" name="options" id="multiAdd"> 批量添加
        </label>
    </div>



    <div style="height: 30px;"></div>

    <form id="searchForm" role="form" action="" method="POST" style="display: none;">
         <div class="row">
             <div class="col-md-10">
                <textarea name="content" class="form-control" placeholder="字段间用TAB分割 多条记录换行分割" rows="5"></textarea>
             </div>
        </div>
        <div style="height: 10px;"></div>
        <div class="row">
            <div class="btn-group col-md-3">
                <button ype="submit" class="btn btn-primary form-control save" data-loading-text="正在保存...">添加</button>
            </div>
        </div>
        <input type="hidden" name="add" value="single"/>
    </form>

    <form id="searchForm2" role="form" action="" method="POST">
        <div class="row">
            <div class="col-md-2">
                <input type="text" name="cid" class="form-control" placeholder="渠道号" value="">
            </div>
            <div class="col-md-2">
                <input type="text" name="tn" class="form-control" placeholder="TN" value="">
            </div>
            <div class="col-md-2">
                <input type="text" name="purpose" class="form-control" placeholder="用途" value="">
            </div>
            <div class="col-md-2">
                <input type="text" name="canalUserName" class="form-control" placeholder="渠道用户名" value="">
            </div>
            <div class="col-md-2">
                <input type="text" name="edition" class="form-control" placeholder="使用版本" value="">
            </div>
        </div>
        <div style="height: 10px;"></div>
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="url" class="form-control" placeholder="URL" value="">
            </div>
            <div class="col-md-2">
                网吧版&nbsp;<input id="netbarv"  class='switch myswitch' type="checkbox" name="netbarv">
            </div>
            <div class="col-md-2">
                导出&nbsp;<input id="status"  class='switch myswitch' type="checkbox" name="status">
            </div>
        </div>
        <div style="height: 10px;"></div>
        <div class="row">
            <div class="btn-group col-md-3">
                <button type="submit" class="btn btn-primary form-control save" data-loading-text="正在保存...">添加</button>
            </div>
        </div>
        <input type="hidden" name="add" value="multi"/>
    </form>

    <div style="height: 30px;"></div>

    <table class="table table-hover tbcloth">
        <thead>
        <tr>
            <th>渠道号</th>
            <th>TN</th>
            <th>用途</th>
            <th>渠道用户名</th>
            <th>使用版本</th>
            <th>添加时间</th>
            <th>网吧版</th>
            <th>是否导出</th>
            <th>操作</th>
            <th>下载</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($tnList as $tn):?>
            <tr>
                <td><?php echo $tn['cid'];?></td>
                <td><?php echo $tn['tn'];?></td>
                <td><?php echo $tn['purpose'];?></td>
                <td><?php echo $tn['canalUserName'];?></td>
                <td><?php echo $tn['edition'];?></td>
                <td><?php echo date("Y-m-d H:i:s", $tn['timeStamp']);?></td>
                <td><input  class='switch switch-mini myswitch' type="checkbox" <?php if($tn['netbarv'] == 1):?>checked<?php endif;?>></td>
                <td><input  class='switch switch-mini myswitch' type="checkbox" <?php if($tn['status'] == 1):?>checked<?php endif;?>></td>
                <td name="<?php echo $tn['cid'];?>"><a class="delA" href="#<?php echo $tn['cid'];?>">删除</a></td>
                <td>
                    <a target="_blank" href="<?php echo $tn['url'];?>" type="button" class="btn btn-default">
                        <span class="glyphicon glyphicon-eye-open"></span>
                    </a>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

</div>


<script>
    $('.save').click(function () {
        $(this).button('loading');
    });
    $('td').on('click', '.delA', function(event){
        var cid = $(this).parent().parent().parent().parent().find("td").eq(0).html();
        $(this).parent("td").html('<a class="cfmA" href="#' + cid + '">确定</a>&nbsp;&nbsp;<a class="cnlA" href="#' + cid + '">取消</a>');
    });
    $('td').on('click', '.cnlA', function(event){
        var cid = $(this).parent().parent().parent().parent().find("td").eq(0).html();
        $(this).parent("td").html('<a class="delA" href="#' + cid + '">删除</a>');
    });
    $('td').on('click', '.cfmA', function(event){
        var cid = $(this).parent().parent().find("td").eq(0).html();
        $(this).parent("td").parent("tr").hide();
        $.post("index.php?/other/del_tn/" + cid);
    });
    $('#status').on('switch-change', function (e, data) {
        var cid = $(this).parent().parent().parent().parent().find("td").eq(0).html();
        if(data.value == true){
            $.post("index.php?/other/set_tn_status/1/" + cid);
        }else{
            $.post("index.php?/other/set_tn_status/0/" + cid);
        }
    });
    $('#netbarv').on('switch-change', function (e, data) {
        var cid = $(this).parent().parent().parent().parent().find("td").eq(0).html();
        if(data.value == true){
            $.post("index.php?/other/set_tn_netbarv/1/" + cid);
        }else{
            $.post("index.php?/other/set_tn_netbarv/0/" + cid);
        }
    });
    $('#singleAdd').change(function () {
        $("#searchForm").hide("slow");
        $("#searchForm2").show("slow");
    });
    $('#multiAdd').change(function () {
        $("#searchForm2").hide("slow");
        $("#searchForm").show("slow");
    });
</script>