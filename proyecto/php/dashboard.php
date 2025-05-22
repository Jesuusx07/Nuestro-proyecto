<?php
require_once 'SessionManager.php';

$session = new SessionManager();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit;
}
