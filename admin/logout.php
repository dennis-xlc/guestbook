<?php
function redirect2index() {
    echo '<script type="text/javascript">window.location.href = "../index.php";</script>';
}
 
session_start();
session_unset();
session_destroy();

redirect2index();
exit();
?>