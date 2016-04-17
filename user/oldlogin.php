<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录</title>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" media="screen" />
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script type="text/javascript" src="../js/jquery.min.js"></script>
</head>

<?php
  function phpAlert($msg) {
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
  }

  function redirect2index() {
    echo '<script type="text/javascript">alert("恭喜您，登录成功！");window.location.href = "./index.php";</script>';
  }

  function getUserId($conn, $name, $passwd) {
    $qry = "select id from user where name = '".$name."' and password = '".$passwd."'";
    $result = mysql_query($qry, $conn);
    $result = mysql_fetch_object($result);
    return $result->id;
  }

  function login($name, $passwd) {
    include("../config/config.php");
    $conn = mysql_connect($dbhost, $dbuser, $dbpassword, $database) or die (mysql_error());
    mysql_select_db($database, $conn) or die (mysql_error());

    // 判断用户名是否存在
    $userId = getUserId($conn, $name, $passwd);
    if ($userId) {
      $_SESSION['user']['id'] = $userId;
      $_SESSION['user']['name'] = $name;
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

<body  class="index">
<!--wrapper-->
<div class="wrapper border_radius_5px">
  <div class="logo fl"><img src="../images/logo.jpg" width="250" height="60" /></div>
    <div class="nav fr">
    <div class="fl">
      <a href="../index.php">首页</a>
    </div>
    <div class="fl">
      <a href="./register.php">注册</a>
    </div>
  </div>
  <div class="clear b15"></div>
  
  <div class="gBanner"><img src="../images/gBanner.jpg" width="930"/></div>
  
  <div class="b15"></div>

  <div class="basic-grey">
    <h1>用户登录</h1>
    <form id="loginForm" name="loginForm" method="post" action="" onsubmit="return checkLoginInfo();">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="120px" align="center"><span class="Prompt">用户名</span></td>
          <td>
            <input type="text" name="name" id="name" value="" /></td>
        </tr>
        <tr>
          <td align="center"><span class="Prompt">密码</span></td>
          <td><input type="password" name="passwd" id="passwd" value="" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="submit" class="submit" name="submit" id="submit" value="登录" /></td>
        </tr>
      </table>
    </form>
  </div>



</div><!--wrapper End-->

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