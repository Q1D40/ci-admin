<div id="rightMain" class="col-md-12" role="main">
    <div class="alert alert-danger fade in">
        注意：安装包名称可自定义，配置文件中要返回完整的安装包名（不包含扩展名）加版本号，中间用<em>&</em>符连接。例如：return 'JuziBrowser_1.0.0.1&1.0.0.1';
    </div>
    <a href="index.php?/update/conf_list/" type="button" class="btn btn-default col-md-1">
        <span class="glyphicon glyphicon-arrow-left"></span> 返回
    </a>
    <div style="height: 50px;"></div>

    <form action="index.php?/update/conf_list/" id="btnSaveForm" method="post" class="row">
        <p></p>
        <textarea name="conf" id="conf" class="form-control" rows="20" placeholder="升级配置"><?php echo $preConf;?></textarea>
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
                该服务器上不存在以下文件：<br /><span id="flist"></span>
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
            var code = $("#conf").val();
            $.ajax({
                type:'POST',
                url:'index.php?/update/judge_file/',
                data:{'conf':code},
                success:function(data){
                  var jsonObj = JSON.parse(data);
                    if(jsonObj.result == 1){
                        $("#btnSaveForm").submit();
                    }else{
                        $('#myModal').modal();
                        var fstr = "";
                        for(var i=0;i<jsonObj.file.length;i++){
                            fstr += "<br />" + jsonObj.file[i];
                        }
                        $("#flist").html(fstr);
                    }
                }
            });
        });
        $("#btnSubmit").click(function(){
            $("#btnSaveForm").submit();
        });

        $(window).resize(function(){
           setRow();
        });
        setRow();
        function setRow(){
            var trow = (Math.pow(document.documentElement.clientHeight,1.2) / Math.pow(window.screen.height,1.2)) * 35;
            $('#conf').attr("rows",trow);
        }
    });
</script>