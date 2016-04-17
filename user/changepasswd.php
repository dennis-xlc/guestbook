<?php 
session_start(); 
if (!isset($_SESSION['user']['id'])) {
    header('Location:login.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主体</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.min.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
</head>
<?php
  function phpAlert($msg) {
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
  }

  function redirect2UserInfo() {
    echo '<script type="text/javascript">alert("恭喜您，密码修改成功！");window.location.href = "./myinfo.php";</script>';
  }

  function updatePasswd($userId, $passwd, $newpasswd) {
    include("../config/config.php");
    $conn = mysql_connect($dbhost, $dbuser, $dbpassword, $database) or die (mysql_error());
    mysql_select_db($database, $conn) or die (mysql_error());

    $qry = "select * from user where id = '".$userId."' and password = '".$passwd."'";
    $result = mysql_query($qry, $conn);
    $rowNum = mysql_num_rows($result);
    if($rowNum <= 0) {
      phpAlert("对不起，密码不正确！");
    } else {
      $qry = "update user set password = '".$newpasswd."' where id = '".$userId."'";
      $result = mysql_query($qry, $conn);
      if($result) {
        redirect2UserInfo();
      }
      
    }

    mysql_close($conn);
  }

  if(isset($_POST['submit'])) {
    $userId = $_SESSION['user']['id'];
    $passwd = $_POST['passwd'];
    $newpasswd = $_POST['newpasswd'];
    updatePasswd($userId, $passwd, $newpasswd);
  }
?>
<body>
<div class="admin-bread">
<span class="fr">
<a href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> 返回上一页</a> &nbsp;&nbsp;<a href="javascript:location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> 刷新</a>
  </span>
  <ul class="fl">
      <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> 用户管理</li>
      <li>/</li>
      <li> 修改密码</li>
  </ul>
</div>

<!--content-->
<div class="content">

<div class="panel panel-default">
<div class="panel-heading">
<span class="fl">
<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 修改密码
</span>


<div class="clear"></div>
</div>

<div class="detail">

<form name="passwdform" onsubmit="return checkPasswd();" id="passwdform" 
  method="post" action="">

    <div class="form-group">
      <label for="title">当前密码：</label>
      <input name="passwd" type="password" class="form-control" id="passwd" value="">
    </div>
    
    <div class="form-group">
      <label for="content">新的密码：</label>
      <input name="newpasswd" type="password" class="form-control" id="newpasswd" value="">
    </div>
    <div class="form-group">
      <label for="content">确认新密码：</label>
      <input name="verifypasswd" type="password" class="form-control" id="verifypasswd" value="">
    </div>
    <nav class="navbar navbar-default navbar-fixed-bottom">
  <div class="container-fluid">
    <button type="submit" name="submit" value="确认修改密码" class="btn btn-success navbar-btn"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> 确认修改密码</button>
  </div>
</nav>
</form>
</div>
</div>
</div><!--content End-->
</body>
<script type="text/javascript">
function checkPasswd() {
  if (passwdform.passwd.value==""){
    alert("请填写当前密码！");
    passwdform.passwd.focus();
    return false;
  }

  if (passwdform.newpasswd.value==""){
    alert("请填写新的密码！");
    passwdform.newpasswd.focus();
    return false;
  }

  if (passwdform.verifypasswd.value != passwdform.newpasswd.value){
    alert("两次新密码不一致！");
    passwdform.verifypasswd.focus();
    return false;
  }
}
</script>
</html>