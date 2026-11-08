<?php
// SmartPark Log Out
// Removes the logged-in user but keeps sample reservation data

require_once __DIR__ . '/includes/session.php';

unset($_SESSION['user']);
session_regenerate_id(true);

header('Location: login.php?logged_out=1');
exit;
