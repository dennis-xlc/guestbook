<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户登录</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.min.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script src="../js/cloud.js" type="text/javascript"></script> 

</head>



<?php
  function phpAlert($msg) {
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
  }

  function redirect2Login() {
    echo '<script type="text/javascript">alert("恭喜您，注册成功！");window.location.href = "./login.php";</script>';
  }

  function getAvatar() {
    $avatar = addslashes($_FILES['avatar']['tmp_name']);
    $avatar = file_get_contents($avatar);
    $avatar = base64_encode($avatar);
    return $avatar;
  }

  function checkUserExist($conn, $name) {
    $qry = "select count(*) as total from user where name = '".$name."'";
    $result = mysql_query($qry, $conn);
    $result = mysql_fetch_object($result);
    return $result->total > 0;
  }

  function register($name, $email, $gender, $passwd, $avatar) {
    include("../config/config.php");
    $conn = mysql_connect($dbhost, $dbuser, $dbpassword, $database) or die (mysql_error());
    mysql_select_db($database, $conn) or die (mysql_error());

    // 判断用户名是否存在
    if (checkUserExist($conn, $name)) {
      phpAlert("该用户名已经存在！");
      return;
    }

    // 将新用户信息插入数据库
    $qry = "insert into user (name, password, gender, email, avatar) values ('"
      .$name."', '".$passwd."', '".$gender."', '".$email."', '".$avatar."') ";
    $result = mysql_query($qry, $conn);
    mysql_close($conn);
    if($result) {
      // 跳转到登录页面
      redirect2Login("恭喜您，注册成功！");
    }
  }

  if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $passwd = $_POST['passwd'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $avatar = getAvatar();
    register($name, $email, $gender, $passwd, $avatar);
  }
?>


<body style="background-color:#1c77ac; background-image:url(../images/light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;">



    <div id="mainBody">
      <div id="cloud1" class="cloud"></div>
      <div id="cloud2" class="cloud"></div>
    </div>  
  
<nav class="navbar navbar-transparent navbar-absolute">
    <div class="container">    
        <div class="navbar-header">
            <a class="navbar-brand" href="../index.php">随意多功能留言板</a>
        </div>
        <div class="collapse navbar-collapse">       
            
            <ul class="nav navbar-nav navbar-right">
                <li>
                   <a href="../index.php">
                        首页
                    </a>
                </li>
                <li>
                   <a href="../user/register.php">
                        用户注册
                    </a>
                </li>
                <li>
                   <a href="../admin/login.php">
                        管理员登录
                    </a>
                </li>
                
            </ul>
        </div>
    </div>
</nav>
  <div class="full-page login-page">   
        
    <!--   you can change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
        <div class="content">
            <div class="container center-block">
                <div class="row">                   
                    <div class="center-block">
                      <form class="form-horizontal" id="registerForm" name="registerForm" method="post" 
                        enctype="multipart/form-data" action="" onsubmit="return checkRegInfo();">
                            <div class="card center-block">
                                <div class="header text-center">新用户注册</div>
                                <div class="content">
                                  <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">用户名:</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" name="name" id="name">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">邮箱:</label>
                                    <div class="col-sm-10">
                                      <input type="email" class="form-control" name="email" id="email">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">性别:</label>
                                    <div class="col-sm-10">
                                      <label class="radio-inline">
                                        <input type="radio" name="gender" value="M" checked> 男
                                      </label>
                                      <label class="radio-inline">  
                                        <input type="radio" name="gender" value="F"> 女
                                      </label>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">密码:</label>
                                    <div class="col-sm-10">
                                      <input type="password" class="form-control" name="passwd" id="passwd">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">确认密码:</label>
                                    <div class="col-sm-10">
                                      <input type="password" class="form-control" name="passwd2" id="passwd2">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">头像:</label>
                                    <div class="col-sm-10">
                                      <input type="file" name="avatar" />
                                      <p class="small help-block">选择一张图片作为头像.</p>
                                    </div>
                                  </div>
                                </div>
                                <div class="footer text-center">
                                  <input type="submit" class="submit btn btn-fill btn-primary btn-wd" name="submit" id="submit" value="注册" />
                                </div>
                            </div>
                                
                        </form>
                                
                    </div>                    
                </div>
            </div>
        </div>

    </div>
    
</body>
<script type="text/javascript">
function checkRegInfo() {
  if (registerForm.name.value==""){
    alert("请填写用户名！");
    registerForm.name.focus();
    return false;
  }
  if (registerForm.email.value==""){
    alert("请填写邮箱！");
    registerForm.email.focus();
    return false;
  }
  if (registerForm.passwd.value==""){
    alert("请填写密码！");
    registerForm.passwd.focus();
    return false;
  }
  if (registerForm.passwd2.value != registerForm.passwd.value){
    alert("两次密码不一致！");
    registerForm.passwd2.focus();
    return false;
  }
  if (registerForm.avatar.value==""){
    alert("请选择一张头像！");
    return false;
  }
}
</script>
</html>
