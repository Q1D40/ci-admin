$(document).ready(function(){

    $('.datetimepicker').datetimepicker({
        format: 'yyyy-mm-dd',
        weekStart: 1,
        autoclose: true,
        minView: 2,
        language: 'zh-CN'
    });

    $('.selectpicker').selectpicker();

    $("#menuBtn").click(function(){
        $("#leftMenu").toggle();
        if($('#leftMenu').css('display') != "none"){
            $('#rightMain').removeClass('col-md-12');
            $('#rightMain').addClass('col-md-9');
            $('#newPageSearchBtn').html('新页');
        }else{
            $('#rightMain').removeClass('col-md-9');
            $('#rightMain').addClass('col-md-12');
            $('#newPageSearchBtn').html('在新页面查询');
        }
    });

    var options={
        animation:true,
        trigger:'hover'
    }
    $('.tip').tooltip(options);

    $('.myswitch').bootstrapSwitch();
    $('#autoUpdate').bootstrapSwitch();
    $('#autoUpdate').on('switch-change', function (e, data) {
        if(data.value == true){
            $.post("index.php?/conflist/set_adblock_auto_switch/1/");
        }else{
            $.post("index.php?/conflist/set_adblock_auto_switch/0/");
        }
    });

    $(".tbcloth").tablecloth({
          theme: "default",
          striped: true,
          sortable: true,
          condensed: true
    });

    $("a[data-toggle=popover]").popover().click(function(e) {
        e.preventDefault()
    });

	$('.combobox').combobox();

});