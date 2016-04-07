<div id="rightMain" class="col-md-12" role="main">


    <div style="height: 30px;"></div>

    <form id="searchForm" role="form" action="" method="POST">
         <div class="row">
             <p></p>
             <textarea name="content" id="content" class="form-control" placeholder="TN对照表" rows="20"><?php echo $content;?></textarea>
             <p></p>
             <div class="btn-group col-md-3">
                <button id="save" type="submit" class="btn btn-primary form-control" data-loading-text="正在保存...">保存</button>
            </div>
        </div>
    </form>


</div>

<script>
    $(document).ready(function(){
        $('#save').click(function () {
            $(this).button('loading');
        })

        $(window).resize(function(){
            setRow();
        });
        setRow();
        function setRow(){
            var trow = Math.pow(document.documentElement.clientHeight,1.2) / Math.pow(window.screen.height,1.2) * 35;
            $('#content').attr("rows",trow);
        }
    });
</script>

