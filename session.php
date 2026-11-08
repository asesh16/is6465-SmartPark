<?php
// SmartPark shared session
// Starts the PHP session and exposes the logged-in user (if any)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Logged-in user: ['email' => ..., 'role' => 'driver' | 'manager'], or null
$currentUser = $_SESSION['user'] ?? null;
$currentRole = $currentUser['role'] ?? 'guest';
$isLotManager = ($currentRole === 'manager');
