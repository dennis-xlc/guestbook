<?php 
session_start(); 
if (!isset($_SESSION['admin']['id'])) {
    header('Location:login.php');
}
if (!isset($_GET['mid'])) {
    header('Location:index.php');
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
      <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> 留言管理</li>
      <li>/</li>
      <li> 留言详情</li>
  </ul>
</div>

<!--content-->
<div class="content">


<!--panel panel-default-->
<div class="panel panel-default">
<div class="panel-heading">
<span class="fl">
<a class="btn btn-primary btn-panel-heading" role="button" href="replymessage.php?mid=<?php echo $_GET['mid']?>">
  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 回复留言
</a>
</span>
<span class="fl">
<a class="btn btn-danger" role="button" href="javascript:void(0);" onclick="delconfirm(<?php echo $_GET['mid']?>);">
<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 删除留言
</a>
</span>

<span class="fr" style="width:300px;"></span>

<div class="clear"></div>
</div>
<div class="detail">
<?php

  include("../config/config.php");
  $conn = mysql_connect($dbhost, $dbuser, $dbpassword, $database) or die (mysql_error());
  mysql_select_db($database, $conn) or die (mysql_error());

  $qry = "select * from message where id = '".$_GET['mid']."'";
  $result = mysql_query($qry, $conn);
  $row = mysql_fetch_object($result);
  if(!$row) {
?>
  <span align="center">对不起，相应留言不存在！</span>
<?php
  } else {
?>

    <div class="form-group">
      <label for="title">留言标题：</label>
      <div class="message-title"><?php echo $row->title?></div>
    </div>
    
    <div class="form-group">
      <label for="content">留言内容：</label>
      <div class="message-content"><?php echo $row->content?></div>
    </div>
    <div class="form-group">
      <label for="message-reply">回复内容：</label>
      <div class="message-content"><?php echo $row->reply?></div>
    </div>
<?php
  }
  mysql_close($conn);
?>
  </div>

</div><!--panel panel-default End-->

</div><!--content End-->
</body>
<script>
function delconfirm(messageId){
  if( window.confirm("确定删除留言？") ){
    window.location = "./delmessage.php?mid=" + messageId;
  }
}
</script>
</html>