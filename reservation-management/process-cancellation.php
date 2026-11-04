<?php
// UC-RES-04: Process Parking Reservation Cancellation
// Change reservation status without deleting the record

require_once __DIR__ . '/reservation-data.php';

// Only accept cancellation requests submitted through POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: reservations.php');
    exit;
}

// Receive the reservation ID
$reservationId = trim($_POST['reservation_id'] ?? '');

// Find the reservation in the PHP session
$reservationIndex = null;

foreach ($_SESSION['reservations'] as $index => $reservation) {
    if ($reservation['id'] === $reservationId) {
        $reservationIndex = $index;
        break;
    }
}

// Prevent cancellation of missing or already-cancelled reservations
if (
    $reservationIndex === null ||
    $_SESSION['reservations'][$reservationIndex]['status'] !== 'Confirmed'
) {
    header('Location: reservations.php');
    exit;
}

// Soft delete: update status instead of removing the reservation
$_SESSION['reservations'][$reservationIndex]['status'] = 'Cancelled';

// Redirect to the cancellation confirmation page
header('Location: cancellation-confirmation.php?id=' . urlencode($reservationId));
exit;
