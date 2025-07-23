<?php
require_once '../Config/SessionManager.php';

$session = new SessionManager();
$session->logout();

header("Location: ../login.php");
exit;
