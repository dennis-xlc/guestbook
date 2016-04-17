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
      <li> 个人信息</li>
  </ul>
</div>

<!--content-->
<div class="content">


<!--panel panel-default-->
<div class="panel panel-default">
<div class="panel-heading">
<span class="fl">
<a class="btn btn-primary btn-panel-heading" role="button" href="editinfo.php">
  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 修改信息
</a>
</span>

<span class="fr" style="width:300px;"></span>

<div class="clear"></div>
</div>
<?php

  include("../config/config.php");
  $userId = $_SESSION['user']['id'];
  $conn = mysql_connect($dbhost, $dbuser, $dbpassword, $database) or die (mysql_error());
  mysql_select_db($database, $conn) or die (mysql_error());

  $qry = "select * from user where id = '".$userId."'";
  $result = mysql_query($qry, $conn);
  $row = mysql_fetch_object($result);
  if($row) {
?>

<table  class="table table-hover table-bordered">
  <tr class="" align="center">
    <td width="70" align="center" class="bgc info-title"><strong>姓名</strong></td>
    <td width="200" align="left" class="bgc">
    	<span class="info-content"><?php echo $row->name?></span>
    </td>
  </tr>
  <tr class="" align="center">
    <td align="center" class="bgc info-title"><strong>邮箱</strong></td>
    <td align="left" class="bgc">
    	<span class="info-content"><?php echo $row->email?></span>
    </td>
  </tr>
  <tr class="" align="center">
    <td align="center" class="bgc info-title"><strong>性别</strong></td>
    <td align="left" class="bgc">
    	<span class="info-content"><?php if($row->gender=="F"){echo "女";}else{echo "男";}?></span>
    </td>
  </tr>
  <tr class="" align="center">
    <td align="center" class="bgc info-title"><strong>头像</strong></td>
    <td align="left" class="bgc">
    	<span class="info-content"><img class="avatar" 
    		src="data:image;base64,<?php echo $row->avatar?>" /></span>
    </td>
  </tr>
</table>
<?php
  }
  mysql_close($conn);
?>

</div><!--panel panel-default End-->

</div><!--content End-->
</body>

</html>