<?php

include_once 'user_session.php';

$userSession = new UserSession();
$userSession->closeSession();

header("location: ../index.php");
//include_once '../index.php';
//http_redirect('../index.php');

?>
