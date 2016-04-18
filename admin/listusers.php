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
<title>所有用户</title>
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
      <li> 所有用户</li>
  </ul>
</div>

<!--content-->
<div class="content">

<?php

  include("../config/config.php");
  $conn = mysql_connect($dbhost, $dbuser, $dbpassword, $database) or die (mysql_error());
  mysql_select_db($database, $conn) or die (mysql_error());

  $qry = "select u.*, m_stats.m_count from user u left join 
          (select count(*) as m_count, user_id from message group by user_id) 
          as m_stats on u.id = m_stats.user_id";
  $result = mysql_query($qry, $conn);
  $rowNum = mysql_num_rows($result);
  
?>
<!--panel panel-default-->
<div class="panel panel-default">
<div class="panel-heading">
<span class="fl">
<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 所有用户列表
</span>

<span class="fr">共有<?php echo $rowNum?>个用户</span>

<div class="clear"></div>
</div>
<table  class="table table-hover table-bordered">
  <tr class="active" align="center">
    <td width="100" class="bgc"><strong>用户名</strong></td>
    <td width="150" align="center" class="bgc"><strong>邮箱</strong></td>
    <td width="50" align="center" class="bgc"><strong>性别</strong></td>
    <td width="100" align="center" class="bgc"><strong>留言次数</strong></td>
    <td width="150" align="center" class="bgc"><strong>操作</strong></td>
  </tr>
<?php
  if ($rowNum <= 0) {
?>
  <tr>
    <td colspan="5" align="center">对不起，目前没有任何用户！</td>
  </tr>
<?php
  } else {
    while($row = mysql_fetch_array($result)) {
?>
  <tr>
    <td align="center"><?php echo $row['name'] ?></td>
    <td align="center"><?php echo $row['email'] ?></td>
    <td align="center"><?php if($row['gender']=="F"){echo "女";}else{echo "男";}?></td>
    <td align="center"><?php if(!$row['m_count']){echo 0;}else{echo $row['m_count'];}?></td>
    <td align="center">
      <a class="btn btn-success btn-xs" role="button" href="user.php?userid=<?php echo $row['id']?>">
      <span class="glyphicon glyphicon-search"></span> 查看</a>  
    <a class="btn btn-danger btn-xs" role="button" href="javascript:void(0);" onclick="delconfirm(<?php echo $row['id']?>, '<?php echo $row['name']?>');">
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
function delconfirm(userId, userName){
  if( window.confirm("确定删除用户“"+userName+"”？该操作将删除用户及其留言！") ){
    window.location = "./deluser.php?userid=" + userId;
  }
}
</script>
</html>