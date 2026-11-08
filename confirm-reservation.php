<?php
// UC-RES-01: Confirm Parking Reservation
// Save a validated reservation and display confirmation

require_once __DIR__ . '/reservation-data.php';
require_once __DIR__ . '/../includes/error-page.php';

// Only accept POST requests from the Reservation Summary page
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create-reservation.php');
    exit;
}

// Validate again before saving (the details came from hidden fields)
$input = sp_read_reservation_input($_POST);
$result = sp_validate_reservation($input);

// Stop the confirmation process if validation fails
if (!empty($result['errors'])) {
    sp_render_error_page(
        'Unable to Confirm Reservation',
        $result['errors'],
        'create-reservation.php',
        'Back to Reservation Form',
        'reservations'
    );
}

// Generate a unique reservation ID
$highestId = 1000;

foreach ($_SESSION['reservations'] as $existingReservation) {
    if (preg_match('/^RES-(\d+)$/', $existingReservation['id'], $matches)) {
        $highestId = max($highestId, (int) $matches[1]);
    }
}

$newReservationId = 'RES-' . ($highestId + 1);

// Save the reservation in the PHP session
$_SESSION['reservations'][] = [
    'id' => $newReservationId,
    'lot' => $input['parking_lot'],
    'date' => $input['reservation_date'],
    'start_time' => $input['start_time'],
    'end_time' => $input['end_time'],
    'vehicle_plate' => $input['vehicle_plate'],
    'vehicle_type' => $input['vehicle_type'],
    'cost' => $result['cost'],
    'status' => 'Confirmed'
];

// The reservation takes one open spot at the lot
sp_change_available_spots($input['parking_lot'], -1);

// Redirect to the confirmation page
header('Location: reservation-confirmation.php?id=' . urlencode($newReservationId));
exit;
