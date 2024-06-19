<?php 
define('ROOT', 'http://localhost:8888/tagm/');
session_start();
include "classes/db.php";
include "classes/validator.php";

require_once('./resources/views/partials/header.php');

$url = empty($_GET['url']) ? "home" : $_GET['url'];
$url = explode("/", filter_var(trim($url,"/"),FILTER_SANITIZE_URL));
// echo '<pre>';var_dump($url);echo '</pre>';die;
if(file_exists("./resources/views/$url[0].php")){
	require("./resources/views/$url[0].php");
}else{
	require("./resources/views/404.php");
}

require_once('./resources/views/partials/footer.php');
?>