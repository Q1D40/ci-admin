<div id="rightMain" class="col-md-12" role="main">
    <?php if(in_array('user_user_add', $userInfo['permission'])):?>
    <a href="index.php?/user/user_add/" type="button" class="btn btn-success col-md-1">+ 添加用户</a>
    <?php endif;?>
    <div style="height: 30px;"></div>

    <table class="table table-hover tbcloth">
        <thead>
        <tr>
            <th>用户名</th>
            <th>权限</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($userList as $user):?>
            <tr>
                <td><?php echo $user['userName'];?></td>
                <td><?php echo $user['permission'];?></td>
                <td>
                    <?php if(in_array('user_user_edit', $userInfo['permission'])):?>
                    <a href="index.php?/user/user_edit/<?php echo $user['uid'];?>/"><span class="glyphicon glyphicon-edit"></span></a>
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