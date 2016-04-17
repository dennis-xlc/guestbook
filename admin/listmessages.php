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
      <li> 所有留言</li>
  </ul>
</div>

<!--content-->
<div class="content">

<?php

  include("../config/config.php");
  $conn = mysql_connect($dbhost, $dbuser, $dbpassword, $database) or die (mysql_error());
  mysql_select_db($database, $conn) or die (mysql_error());

  $qry = "select * from message order by create_time desc";
  $result = mysql_query($qry, $conn);
  $rowNum = mysql_num_rows($result);
  
?>
<!--panel panel-default-->
<div class="panel panel-default">
<div class="panel-heading">
<span class="fl">
<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 所有留言列表
</span>

<span class="fr">共有<?php echo $rowNum?>条留言</span>

<div class="clear"></div>
</div>
<table  class="table table-hover table-bordered">
  <tr class="active" align="center">
    <td width="300" class="bgc"><strong>标题</strong></td>
    <td width="100" align="center" class="bgc"><strong>用户</strong></td>
    <td width="100" align="center" class="bgc"><strong>创建时间</strong></td>
    <td width="50" align="center" class="bgc"><strong>回复</strong></td>
    <td width="150" align="center" class="bgc"><strong>操作</strong></td>
  </tr>
<?php
  if ($rowNum <= 0) {
?>
  <tr>
    <td colspan="5" align="center">对不起，目前没有任何留言！</td>
  </tr>
<?php
  } else {
    while($row = mysql_fetch_array($result)) {
?>
  <tr>
    <td><?php echo $row['title'] ?></td>
    <td align="center">用户</td>
    <td align="center"><?php echo $row['create_time'] ?></td>
    <td align="center"><?php if($row['reply']) { echo "是";} else { echo "否";} ?></td>
    <td align="center">
      <a class="btn btn-success btn-xs" role="button" href="message.php?mid=<?php echo $row['id']?>">
      <span class="glyphicon glyphicon-search"></span> 查看</a> 
    <a class="btn btn-primary btn-xs" role="button" href="replymessage.php?mid=<?php echo $row['id']?>">
      <span class="glyphicon glyphicon-share"></span> 回复</a> 
    <a class="btn btn-danger btn-xs" role="button" href="javascript:void(0);" onclick="delconfirm(<?php echo $row['id']?>);">
      <span class="glyphicon glyphicon-trash"></span> 删除</a>
    </td>
  </tr>
<?php
    }
  }
  mysql_close($conn);
?>
</table>
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