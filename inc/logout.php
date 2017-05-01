<?php 
include_once 'session.php';
$sess = new session();
$sess->logout();
include_once 'navbar.php';
include_once 'functions.php';

echo "you are logged out! Redirecting you now";
redirect('../index.php');


 ?>