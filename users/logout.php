<?php
session_start();
include("includes/config.php");
mysqli_query($con,"UPDATE userlog  SET logout = CURRENT_TIMESTAMP WHERE username = '".$_SESSION['login']."' ORDER BY id DESC LIMIT 1");
session_unset();
session_destroy();
header('location: index.php');
?>
