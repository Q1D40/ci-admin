<div id="rightMain" class="col-md-12" role="main">
    <div class="alert alert-danger <?php if($error == ''):?>hide<?php else:?>fade in<?php endif;?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $error;?>
    </div>
    <form id="searchForm" role="form" action="" method="POST">
         <div class="row">
             <div class="col-md-3">
             <select name="database" class="form-control selectpicker">
                 <?php foreach($databaseList as $oneDatabase):?>
                     <option value="<?php echo $oneDatabase['Database'];?>" <?php if($oneDatabase['Database'] == $database):?>selected="selected"<?php endif;?>><?php echo $oneDatabase['Database'];?></option>
                 <?php endforeach;?>
             </select>
             </div>
             <p></p>
             <textarea name="sql" class="form-control" placeholder="sql" rows="5"><?php echo $sql;?></textarea>
             <p></p>
             <div class="btn-group col-md-3">
                <button id="searchbtn" type="button" class="btn btn-primary form-control">执行</button>
            </div>
             <input type="hidden" id="actHidden" name="act" value="search">
        </div>
    </form>

    <div style="height: 30px;"></div>

    <table class="table table-hover tbcloth">
        <thead>
        <tr>
            <?php foreach($data[0] as $k => $r):?>
                <th><?php echo $k;?></th>
            <?php endforeach;?>
        </tr>
        </thead>

        <tbody>
        <?php foreach($data as $key => $row):?>
            <tr>
            <?php foreach($row as $k => $r):?>
                <td><?php echo $r;?></td>
            <?php endforeach;?>
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
</script>