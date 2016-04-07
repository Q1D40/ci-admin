<div id="rightMain" class="col-md-12" role="main">
    <?php if(in_array('user_permission_add', $userInfo['permission'])):?>
    <a href="index.php?/user/permission_add/" type="button" class="btn btn-success col-md-1">+ 添加权限</a>
    <?php endif;?>
    <div style="height: 30px;"></div>

    <table class="table table-hover tbcloth">
        <thead>
        <tr>
            <th>名称</th>
            <th>key</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($permissionList as $permission):?>
            <tr>
                <td><?php echo $permission['name'];?></td>
                <td><?php echo $permission['key'];?></td>
                <td>
                    <?php if(in_array('user_permission_edit', $userInfo['permission'])):?>
                    <a href="index.php?/user/permission_edit/<?php echo $permission['id'];?>/"><span class="glyphicon glyphicon-edit"></span></a>
                    <?php endif;?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>



</div>

<script>
    $("#searchbtn").click(function(){
        $("#actHidden").val("search");
        $("#searchForm").attr("target", "_self")
        $("#searchForm").submit();
    });
    $("#newPageSearchBtn").click(function(){
        $("#actHidden").val("search");
        $("#searchForm").attr("target", "_blank")
        $("#searchForm").submit();
    });
    $("#exportBtn").click(function(){
        $("#actHidden").val("export");
        $("#searchForm").attr("target", "_blank")
        $("#searchForm").submit();
    });
    $(".pagination li").click(function(){
        if($(this).attr("class") != 'disabled' && $(this).attr("class") != 'active'){
            $("#page").val($(this).attr("page"));
            $("#searchForm").attr("target", "_self")
            $("#searchForm").submit();
        }
    });
    $("#jumpPageBtn").click(function(){
        $("#page").val($("#jumpPageTxt").val());
        $("#searchForm").attr("target", "_self")
        $("#searchForm").submit();
    });
</script>