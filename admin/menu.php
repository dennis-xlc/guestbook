<?php 
session_start(); 
if (!isset($_SESSION['admin']['id'])) {
    header('Location:login.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台边栏</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.min.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<style>
body,html{height:100%}
</style>
</head>

<body style="background-color:#f2f9fd">
<div class="sidebar">
  <div class="logo"></div>
  <div class="con">
  
  
  <ul>
  	<li class="tit"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 留言管理</li>
    <li><a href="listnonreply.php" target="mainFrame">
      <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> 待回复留言</a>
    </li>
    <li><a href="listmessages.php" target="mainFrame">
      <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 所有留言</a>
    </li>
  </ul>
  
  <ul>
      <li class="tit">用户管理</li>
      <li><a href="listusers.php" target="mainFrame">
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 所有用户</a>
      </li>
  </ul>
  <ul>
      <li class="tit">信息管理</li>
      <li><a href="changepasswd.php" target="mainFrame">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 修改密码</a>
      </li>
  </ul>
  </div>
</div>
</body>
</html>