<div id="rightMain" class="col-md-12" role="main">
    <div class="alert alert-danger fade in">
        最新Adblock版本号<?php echo $adblockLastVersion;?>
    </div>
    <a href="index.php?/conflist/conf_list/" type="button" class="btn btn-default col-md-1">
        <span class="glyphicon glyphicon-arrow-left"></span> 返回
    </a>
    <div style="height: 50px;"></div>

    <form action="index.php?/conflist/conf_list/" id="btnFormSubmit" method="post" class="row">
        <p></p>
        <b>条件：</b>
        <textarea name="condition" id="condition" class="form-control" rows="15" placeholder="条件判断"><?php echo $condition;?></textarea>
        <p></p>
        <b>内容：</b>
        <textarea name="code" id="code" class="form-control" rows="18" placeholder="升级配置"><?php echo $content;?></textarea>
        <p></p>
        <button type="button" id="btnSave" class="btn btn-primary">保存</button>
    </form>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">警告：</h4>
            </div>
            <div class="modal-body">
                <span id="flist"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">终止</button>
                <button type="button" class="btn btn-danger" id="btnSubmit">仍要继续</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#btnSave").click(function(){
            var condition = $("#condition").val();
            var code = $("#code").val();
            $.ajax({
                type:'POST',
                url:'index.php?/conflist/judge_file/',
                data:{'code':code,'condition':condition},
                success:function(data){
                   var jsonObj = JSON.parse(data);
                   if(jsonObj.result == 1){
                       $("#btnFormSubmit").submit();
                   }
                   if(jsonObj.result == 0){
                       $('#myModal').modal();
                       var fstr = "该服务器上不存在以下文件：<br />";
                       for(var i=0;i<jsonObj.file.length;i++){
                        fstr += "<br />" + jsonObj['file'][i];
                       }
                       $("#flist").html(fstr);
                   }
                   if(jsonObj.result == 2){
                       $('#myModal').modal();
                       var kstr = "条件返回值中以下内容有误：<br />";
                       for(var i=0;i<jsonObj.key.length;i++){
                           kstr += "<br />" + jsonObj['key'][i];
                       }
                       $("#flist").html(kstr);
                   }
                }
            });
        });
        $("#btnSubmit").click(function(){
            $("#btnFormSubmit").submit();
        });
        $(window).resize(function(){
            setRow("condition");
            setRow("code");
        });
        setRow("condition");
        setRow("code");
        function setRow(rowId){
            var trow = (Math.pow(document.documentElement.clientHeight,1.2) / Math.pow(window.screen.height,1.2)) * 20;
            $('#' + rowId).attr("rows",trow);
        }
    })
</script>