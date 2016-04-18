<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员登录</title>
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

  function redirect2index() {
    echo '<script type="text/javascript">alert("恭喜您，登录成功！");window.location.href = "./index.php";</script>';
  }

  function getUserId($conn, $name, $passwd) {
    $qry = "select id from admin where name = '".$name."' and password = '".$passwd."'";
    $result = mysql_query($qry, $conn);
    $result = mysql_fetch_object($result);
    return $result;
  }

  function login($name, $passwd) {
    include("../config/config.php");
    $conn = mysql_connect($dbhost, $dbuser, $dbpassword, $database) or die (mysql_error());
    mysql_select_db($database, $conn) or die (mysql_error());

    // 判断用户名是否存在
    $user = getUserId($conn, $name, $passwd);
    if ($user) {
      $_SESSION['admin']['id'] = $user->id;
      $_SESSION['admin']['name'] = $name;
      redirect2index();
      return;
    } else {
      phpAlert("用户名和密码不一致！");
    }
  }

  if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $passwd = $_POST['passwd'];
    login($name,$passwd);
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
                   <a href="../user/login.php">
                        用户登录
                    </a>
                </li>
                <li>
                   <a href="../user/register.php">
                        用户注册
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
                        <form id="loginForm" class="form-horizontal" name="loginForm" method="post" action="" onsubmit="return checkLoginInfo();">
                            <div class="card center-block">
                                <div class="header text-center">管理员登录</div>
                                <div class="content">
                                  <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">用户名:</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" name="name" id="name">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">密码:</label>
                                    <div class="col-sm-10">
                                      <input type="password" class="form-control" name="passwd" id="passwd">
                                    </div>
                                  </div>
                                </div>
                                <div class="footer text-center">
                                   <input type="submit" class="submit btn btn-fill btn-primary btn-wd" name="submit" id="submit" value="登录" />
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
function checkLoginInfo() {
  if (loginForm.name.value==""){
    alert("请填写用户名！");
    loginForm.name.focus();
    return false;
  }
  if (loginForm.passwd.value==""){
    alert("请填写密码！");
    loginForm.passwd.focus();
    return false;
  }
}
</script>

</html>
