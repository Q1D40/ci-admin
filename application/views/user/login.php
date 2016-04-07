<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta charset="utf-8">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>后台</title>
<link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' />
</head>
<body>



    <div class="container">


        <div class="row" style="height: 100px;">
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="alert alert-warning <?php if($error == ''):?>hide<?php else:?>fade in<?php endif;?>">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <?php echo $error;?>
                </div>
                <form role="form" action="index.php?/user/login" method="POST">
                    <div class="form-group">
                        <input type="text" name="userName" class="form-control" placeholder="用户名">
                    </div>
                    <div class="form-group">
                        <input type="password" name="passWord" class="form-control" placeholder="密码">
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                        <input type="text" name="code" class="form-control" placeholder="验证码">
                        </div>
                        <div class="col-md-3">
                            <img src="index.php?/user/create_captcha/" alt="" width="75" height="34" onclick="this.src='index.php?/user/create_captcha/'+new Date().getTime()"; />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary form-control">登 录</button>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>



    </div>


</body>
<script src="js/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</html>