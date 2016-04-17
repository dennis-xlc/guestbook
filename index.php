<?php 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>首页</title>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" media="screen" />
<link rel="stylesheet" type="text/css" href="./css/style.css"/>
<script type="text/javascript" src="./css/jquery.min.js"></script>
<link href="./css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./js/bootstrap.min.js"></script>
</head>

<body class="index">
<!--wrapper-->
<div class="wrapper border_radius_5px">
  <div class="logo fl"><img src="./images/logo.jpg" width="250" height="60" /></div>
  <div class="nav fr">
<?php  
if (isset($_SESSION['user']['id'])) {
?>
    <div class="fr">
      <span>
      欢迎您，
      <a href="./user/index.php"><?php echo $_SESSION['user']['name'] ?></a>！
    </span>
    </div>
<?php  
} else if (isset($_SESSION['admin']['id'])) {
?>
    <div class="fr">
      欢迎您，
      <a href="./admin/index.php">管理员</a>！
    </div>
<?php  
} else {
?>
    <div class="fl">
      <a class="btn btn-default" href="./user/login.php">用户登录</a>
    </div>
    <div class="fl">
      <a class="btn btn-default" href="./user/register.php">新用户注册</a>
    </div>
    <div class="fl">
      <a class="btn btn-default" href="./admin/login.php">管理员登录</a>
    </div>
<?php  
}
?>
  </div>
  
  <div class="clear b15"></div>
  
  <div class="gBanner"><img src="./images/gBanner.jpg" width="930"/></div>
  
  <div class="b15"></div>
  

  
  <div class="b15"></div>
<?php

  include("./config/config.php");
  $conn = mysql_connect($dbhost, $dbuser, $dbpassword, $database) or die (mysql_error());
  mysql_select_db($database, $conn) or die (mysql_error());

  $qry = "select * from message m, user u where m.user_id = u.id order by create_time desc";
  $result = mysql_query($qry, $conn);
  $rowNum = mysql_num_rows($result);
  $count = 0;
?>
<div class="adminlist">
  <span class="fr">共有<?php echo $rowNum; ?>条留言！</span>
  <div class="clear"></div>
</div>
<?php
  if ($rowNum > 0) {
    while($row = mysql_fetch_array($result)) {
      $count++;
?>
<div class="b15"></div>

<div class="megList">
  <div class="head fl"><img class="avatar" 
        src="data:image;base64,<?php echo $row['avatar'] ?>" /></div>
  <div class="meg fr">
    <div class="mTop">
      <span class="fl">
        <span class="user ico">用户：<?php echo $row['name'] ?></span>
        &nbsp;&nbsp;&nbsp;
        <span class="time ico">时间：<?php echo $row['create_time'] ?></span>
      </span>
      <span class="fr"><?php echo $count; ?></span>
      <div class="clear"></div>
    </div>
    <div class="mContent">
      <div>标题： <?php echo $row['title'] ?></div>
      <div>留言：</div>
      <div><?php echo $row['content'] ?></div>
      <?php if($row['reply']) {?>
      <div class="reply">
        <div class="tit">管理员回复：</div>
        <div class="con"><?php echo $row['reply'] ?></div>
      </div>
      <?php
        }
      ?>
    </div>
  </div>
  <div class="clear"></div>
</div>
<?php
    }
  }

?>


</div><!--wrapper End-->

<script type="text/javascript">
</body>
</html>