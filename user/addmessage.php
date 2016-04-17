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
<link href="../include/kindeditor/themes/default/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../include/kindeditor/kindeditor-all-min.js"></script>
<script type="text/javascript" src="../include/kindeditor/lang/zh-CN.js"></script>
<script>
  var messageEditor;
  KindEditor.ready(function(K) {
    messageEditor = K.create('textarea[id="message_editor"]', {
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

  function redirect2Mymessages() {
    echo '<script type="text/javascript">alert("恭喜您，添加留言成功！");window.location.href = "./listmessage.php";</script>';
  }

  function createMessage($userId, $title, $content) {
    include("../config/config.php");
    $conn = mysql_connect($dbhost, $dbuser, $dbpassword, $database) or die (mysql_error());
    mysql_select_db($database, $conn) or die (mysql_error());

    $title = mysql_real_escape_string($title);
    $content = mysql_real_escape_string($content);

    $qry = "insert into message (user_id, title, content) values ('"
      .$userId."', '".$title."', '".$content."') ";
    $result = mysql_query($qry, $conn);
    mysql_close($conn);
    if($result) {
      redirect2Mymessages();
    }
  }

  if(isset($_POST['submit'])) {
    $userId = $_SESSION['user']['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    createMessage($userId, $title, $content);
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
      <li> 添加留言</li>
  </ul>
</div>

<!--content-->
<div class="content">

<div class="panel panel-default">
<div class="panel-heading">
<span class="fl">
<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 新增留言
</span>


<div class="clear"></div>
</div>

<div class="detail">

<form name="messageform" onsubmit="return checkMessage();" id="messageform" 
  method="post" action="">

    <div class="form-group">
      <label for="title">留言标题：</label>
      <input name="title" type="text" class="form-control" id="title" value="">
    </div>
    
    <div class="form-group">
      <label for="content">留言内容：</label>
      <textarea name="content" id="message_editor" class="form-control" rows="5" style="width:100%;"></textarea>
    </div>
    <nav class="navbar navbar-default navbar-fixed-bottom">
  <div class="container-fluid">
    <button type="submit" name="submit" value="确认添加留言" class="btn btn-success navbar-btn"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> 确认添加留言</button>
  </div>
</nav>
</form>
</div>
</div>
</div><!--content End-->
</body>
<script type="text/javascript">
function checkMessage() {
  if (messageform.title.value==""){
    alert("请填写留言标题！");
    messageform.title.focus();
    return false;
  }
  
  if (messageEditor.isEmpty()){
    alert("请填写留言内容！");
    messageEditor.focus();
    return false;
  }
}
</script>
</html>