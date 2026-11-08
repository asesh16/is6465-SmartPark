<?php
// Only Lot Managers may add, edit, or delete parking lots.
// Anyone else is sent to the login page with an explanation.

require_once __DIR__ . '/session.php';

if (!$isLotManager) {
    header('Location: ../login.php?required=manager');
    exit;
}
