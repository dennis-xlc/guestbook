<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>注册</title>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" media="screen" />
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script type="text/javascript" src="../js/jquery.min.js"></script>
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
<body  class="index">
<!--wrapper-->
<div class="wrapper border_radius_5px">
  <div class="logo fl"><img src="../images/logo.jpg" width="250" height="60" /></div>
    <div class="nav fr">
    <div class="fl">
      <a href="../index.php">首页</a>
    </div>
    <div class="fl">
      <a href="./login.php">登录</a>
    </div>
  </div>
  <div class="clear b15"></div>
  
  <div class="gBanner"><img src="../images/gBanner.jpg" width="930"/></div>
  
  <div class="b15"></div>

  <div class="basic-grey">
    <h1>新用户注册<span>请认真填写您的注册信息！</span></h1>
    <form id="registerForm" name="registerForm" method="post" enctype="multipart/form-data" action="" onsubmit="return checkRegInfo();">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="120px" align="center"><span class="Prompt">用户名</span></td>
          <td>
            <input type="text" name="name" id="name"value="" /></td>
        </tr>
        <tr>
          <td align="center"><span class="Prompt">邮箱</span></td>
          <td><input type="text" name="email" id="email"value="" /></td>
        </tr>
        <tr>
          <td align="center"><span class="Prompt">性别</span></td>
          <td><select name="gender"><option value="M">男</option><option value="F">女</option></select></td>
        </tr>
        <tr>
          <td align="center"><span class="Prompt">密码</span></td>
          <td><input type="password" name="passwd" id="passwd"value="" /></td>
        </tr>
        <tr>
          <td align="center"><span class="Prompt">确认密码</span></td>
          <td><input type="password" name="passwd2" id="passwd2"value="" /></td>
        </tr>
        <tr>
          <td align="center"><span class="Prompt">头像</span></td>
          <td><input type="file" name="avatar" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="submit" class="submit" name="submit" id="submit" value="注册" /></td>
        </tr>
      </table>
    </form>
  </div>



</div><!--wrapper End-->

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