<?php 

unset($_SESSION['id']);
unset($_SESSION['username']);
unset($_SESSION['email']);
$_SESSION['successMsg'] = "You have successfully loged out!";
header("Location:" . ROOT ."login");
die;
?>