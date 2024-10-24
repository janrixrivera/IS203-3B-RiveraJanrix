<?php
session_start();
session_destroy(); 
header("Location: login-employee-jcr.php");
exit();
?>
