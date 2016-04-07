<div id="rightMain" class="col-md-12" role="main">

    <div style="height: 30px;"></div>

    <form id="searchForm" role="form" action="" method="POST">
         <div class="row">
             <div class="col-md-10">
                <textarea name="f1" class="form-control" placeholder="多条记录换行分割" rows="10"><?php echo $conf['f1']?></textarea>
             </div>
        </div>
        <div style="height: 10px;"></div>
        <div class="row">
            <div class="btn-group col-md-3">
                <button type="submit" class="btn btn-primary form-control save" data-loading-text="正在保存...">保存</button>
            </div>
        </div>
    </form>

</div>


<script>
    $('.save').click(function () {
        $(this).button('loading');
    });
</script>