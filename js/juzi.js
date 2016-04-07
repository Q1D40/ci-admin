window.onload = function (){
    var _ball = document.getElementById('juziBall');
    var _desk = document.getElementById("juziAround");
    var _x = 0;
    var _y = 0;

    _ball.onmousedown = function (){
        document.onmousemove=function (ev){
            /*获取鼠标坐标及滚动高度的兼容性写法*/
            var _event = ev || event;
            var _scrollx = document.documentElement.scrollLeft || document.body.scrollLeft;
            var _scrolly = document.documentElement.scrollTop || document.body.scrollTop;

            /*鼠标的横/纵坐标 + 滚动的高/宽度 - 灰色框的左/上边距，再减去小球的宽度的一半是为了让鼠标永远在球的中心*/
            var _l = _event.clientX + _scrollx - _desk.offsetLeft - _ball.offsetWidth / 2;
            var _t = _event.clientY + _scrolly - _desk.offsetTop - _ball.offsetHeight / 2;

            /*限定小于的拖动范围为灰色框内*/
            if (_l<0) { _l = 0; }
            if (_l>(_desk.offsetWidth - _ball.offsetWidth)) { _l = _desk.offsetWidth - _ball.offsetWidth; }
            if (_t<0) { _t = 0; }
            if (_t>(_desk.offsetHeight - _ball.offsetHeight)) { _t = _desk.offsetHeight - _ball.offsetHeight; }

            /*把计算出来的值赋给小球，即实现拖动*/
            _ball.style.left=_l+'px';
            _ball.style.top=_t+'px';

            /*当拖动时给小球一个速度，不至于释放鼠标时小于突然掉下来*/
            _speedx = _l - _x;
            _speedy = _t - _y;

            /*还原，嘿嘿，这个你自己想吧*/
            _x=_l;
            _y=_t;
        }

        /*放鼠标弹起时，让小球运动起来*/
        document.onmouseup=function (){
            document.onmousemove=null;
            document.onmouseup=null;

            _run();
        }
        /*关闭定时器，避免不停地点击拖动小球时造成开出N个定时器的bug，即每释放一次鼠标，都会先把原先的定时器关了之后再打开一个新的*/
        clearInterval(timer);
    }
}

var timer=null;
var _speedx=0;
var _speedy=0;

/*小球运动函数*/
function _run(){
    clearInterval(timer);
    timer = setInterval(function (){
        var _ball = document.getElementById('juziBall');
        var _desk = document.getElementById("juziAround");
        _speedy += 3;  //设定小球下落速度
        var _l = _ball.offsetLeft + _speedx;
        var _t = _ball.offsetTop + _speedy;

        /*使小球碰到上/下壁时反弹*/
        if(_t >= (_desk.offsetHeight - _ball.offsetHeight)){
            _speedy *= -0.9; //0.9是为了模拟重力加速度 及 能量损耗，（与实际是不符的，只是模拟，哈哈）
            _speedx *= 0.9;
            _t = _desk.offsetHeight - _ball.offsetHeight;
        }
        else if( _t <= 0){
            _speedy *= -1; //碰到上壁，则直接反弹
            _speedx *= 0.9;
            _t = 0;
        }

        /*使小球碰到左/右壁时反弹*/
        if( _l >= (_desk.offsetWidth - _ball.offsetWidth)){
            _speedx*= -0.9;
            _l = _desk.offsetWidth - _ball.offsetWidth;
        }
        else if(_l <= 0){
            _speedx *= -0.9;
            _l = 0;
        }

        /*这样子做是因为像素的最小单位是1, 而速度乘以一个小数之后，最后必定会出现一个0.x / -0.x的情况，此时会出现抖动*/
        if(Math.abs(_speedx) < 1){ _speedx = 0;}
        if(Math.abs(_speedy) < 1){_speedy = 0;}

        /*当小于最终停下来时，关闭定时器*/
        if(_speedx==0 && _speedy==0 && _t==_desk.offsetHeight - _ball.offsetHeight){
            clearInterval(timer);
        }
        else{
            _ball.style.left=_l+'px';
            _ball.style.top=_t+'px';
        }

    }, 30);
}
