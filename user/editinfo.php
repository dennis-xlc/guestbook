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

<body>
<div class="admin-bread">
<span class="fr">
<a href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> 返回上一页</a> &nbsp;&nbsp;<a href="javascript:location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> 刷新</a>
  </span>
  <ul class="fl">
      <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> 用户管理</li>
      <li>/</li>
      <li> 修改个人信息</li>
  </ul>
</div>

<!--content-->
<div class="content">


<!--panel panel-default-->
<div>
<?php

  function phpAlert($msg) {
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
  }

  function redirect2UserInfo() {
    echo '<script type="text/javascript">alert("恭喜您，信息更新成功！");window.location.href = "./myinfo.php";</script>';
  }
  
  $userId = $_SESSION['user']['id'];

  function getAvatar() {
    if (!$_FILES['avatar']['tmp_name']) {
      return null;
    }
    $avatar = addslashes($_FILES['avatar']['tmp_name']);
    $avatar = file_get_contents($avatar);
    $avatar = base64_encode($avatar);
    return $avatar;
  }

  function updateUserInfo($userId, $email, $gender, $avatar) {
    include("../config/config.php");
    $conn = mysql_connect($dbhost, $dbuser, $dbpassword, $database) or die (mysql_error());
    mysql_select_db($database, $conn) or die (mysql_error());

    if ($avatar) {
      $qry = "update user set email = '".$email."', gender ='".$gender."', avatar ='".$avatar."' where id='".$userId."'";
    } else {
      $qry = "update user set email = '".$email."', gender ='".$gender."' where id='".$userId."'";
    }
    $result = mysql_query($qry, $conn);
    mysql_close($conn);
    if ($result) {
      redirect2UserInfo();
    }
  }

  if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $avatar = getAvatar();
    updateUserInfo($userId, $email, $gender, $avatar);
  }


  function loadUserInfo($userId) {
    include("../config/config.php");
    $conn = mysql_connect($dbhost, $dbuser, $dbpassword, $database) or die (mysql_error());
    mysql_select_db($database, $conn) or die (mysql_error());

    $qry = "select * from user where id = '".$userId."'";
    $result = mysql_query($qry, $conn);
    $result = mysql_fetch_object($result);
    mysql_close($conn);
    return $result;
  }
  $userInfo = loadUserInfo($userId);
  if($userInfo) {
?>
<form name="infoForm" onsubmit="return checkInfo();" id="infoForm" 
  method="post" action=""   enctype="multipart/form-data" >
<table  class="table table-hover table-bordered">
  <tr class="" align="center">
    <td width="70" align="center" class="bgc info-title"><strong>姓名</strong></td>
    <td width="200" align="left" class="bgc">
    <input disabled type="name" class="form-control" id="name" value="<?php echo $userInfo->name?>">
    </td>
  </tr>
  <tr class="" align="center">
    <td align="center" class="bgc info-title"><strong>邮箱</strong></td>
    <td align="left" class="bgc">
    <input type="email" class="form-control" name="email" value="<?php echo $userInfo->email?>">
    </td>
  </tr>
  <tr class="" align="center">
    <td align="center" class="bgc info-title"><strong>性别</strong></td>
    <td align="left" class="bgc">
      <label class="radio-inline">
        <input type="radio" name="gender" value="M"
          <?php if($userInfo->gender=="M"){echo "checked";}?>> 男
      </label>
      <label class="radio-inline">  
        <input type="radio" name="gender" value="F"
          <?php if($userInfo->gender=="F"){echo "checked";}?>> 女
      </label>

    </td>
  </tr>
  <tr class="" align="center">
    <td align="center" class="bgc info-title"><strong>头像</strong></td>
    <td align="left" class="bgc">
    	<span class="info-content"><img class="avatar" 
    		src="data:image;base64,<?php echo $userInfo->avatar?>" /></span><br/>
        <label for="avatar">选择一个新头像:</label>
        <input type="file" class="form-control-file" name="avatar">
    </td>
  </tr>
</table>
    <nav class="navbar navbar-default navbar-fixed-bottom">
  <div class="container-fluid">
    <button type="submit" name="submit" value="确认个人信息" class="btn btn-success navbar-btn"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> 确认个人信息</button>
  </div>
</nav>
</form>
<?php
  }
  
?>

</div><!--panel panel-default End-->

</div><!--content End-->
</body>
<script type="text/javascript">
function checkInfo() {
  if (infoForm.email.value==""){
    alert("请填写邮箱！");
    infoForm.email.focus();
    return false;
  }
}
</script>
</html>