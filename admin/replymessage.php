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
<link href="../include/kindeditor/themes/default/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../include/kindeditor/kindeditor-all-min.js"></script>
<script type="text/javascript" src="../include/kindeditor/lang/zh-CN.js"></script>
<script>
  var replyEditor;
  KindEditor.ready(function(K) {
    replyEditor = K.create('textarea[id="reply_editor"]', {
      autoHeightMode : true,
      urlType : 'domain',
      afterCreate : function() {
        this.loadPlugin('autoheight');
      },
      allowPreviewEmoticons : false,
      allowImageUpload : false,
      items : [
        'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
        'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
        'insertunorderedlist', '|', 'emoticons','link','|','undo','redo','fullscreen','|', 
        'selectall', 'source','about']
    });
  });
</script>
</head>
<?php
  function phpAlert($msg) {
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
  }

  function redirect2Message($messageId) {
    echo '<script type="text/javascript">alert("恭喜您，编辑留言成功！");window.location.href = "./message.php?mid='.$messageId.'";</script>';
  }

  function updateMessage($messageId, $reply) {
    include("../config/config.php");
    $conn = mysql_connect($dbhost, $dbuser, $dbpassword, $database) or die (mysql_error());
    mysql_select_db($database, $conn) or die (mysql_error());

    $reply = mysql_real_escape_string($reply);

    $qry = "update message set reply = '".$reply."' where id='".$messageId."'";
    $result = mysql_query($qry, $conn);
    mysql_close($conn);
    if($result) {
      redirect2Message($_GET['mid']);
    }
  }

  if(isset($_POST['submit'])) {
    $reply = $_POST['reply'];
    updateMessage($_GET['mid'], $reply);
  }
?>
<body>
<div class="admin-bread">
<span class="fr">
<a href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> 返回上一页</a> &nbsp;&nbsp;<a href="javascript:location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> 刷新</a>
  </span>
  <ul class="fl">
      <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span> 留言管理</li>
      <li>/</li>
      <li> 回复留言</li>
  </ul>
</div>

<!--content-->
<div class="content">

<div class="panel panel-default">
<div class="panel-heading">
<span class="fl">
<span class="glyphicon glyphicon-share" aria-hidden="true"></span> 回复留言
</span>


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
<form name="messageform" onsubmit="return checkReply();" id="messageform" 
  method="post" action="">

    <div class="form-group">
      <label for="title">留言标题：</label>
      <div class="message-title"><?php echo $row->title?></div>
    </div>

    <div class="form-group">
      <label for="content">留言内容：</label>
      <div class="message-content"><?php echo $row->content?></div>
    </div>
    
    <div class="form-group">
      <label for="reply">回复内容：</label>
      <textarea name="reply" id="reply_editor" class="form-control" rows="5" style="width:100%;"><?php echo $row->reply?></textarea>
    </div>
    <nav class="navbar navbar-default navbar-fixed-bottom">
  <div class="container-fluid">
    <button type="submit" name="submit" value="确认回复留言" class="btn btn-success navbar-btn">
    <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> 确认回复留言</button>
  </div>
</nav>
</form>
<?php
  }
  mysql_close($conn);
?>
</div>
</div>
</div><!--content End-->
</body>
<script type="text/javascript">
function checkReply() {
  
  if (replyEditor.isEmpty()){
    alert("请填写回复内容！");
    replyEditor.focus();
    return false;
  }
}
</script>
</html>