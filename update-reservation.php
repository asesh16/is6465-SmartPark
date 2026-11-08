<?php
// UC-RES-03: Update Parking Reservation
// Save confirmed changes to an existing reservation

require_once __DIR__ . '/reservation-data.php';
require_once __DIR__ . '/../includes/error-page.php';

// Only accept POST requests from the Review Changes page
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: reservations.php');
    exit;
}

// Find the existing reservation's position in the session array
$reservationId = trim($_POST['reservation_id'] ?? '');
$reservationIndex = sp_find_reservation_index($reservationId);

// Prevent changes to missing or cancelled reservations
if (
    $reservationIndex === null ||
    $_SESSION['reservations'][$reservationIndex]['status'] !== 'Confirmed'
) {
    header('Location: reservations.php');
    exit;
}

$originalLot = $_SESSION['reservations'][$reservationIndex]['lot'];

// Validate again before saving (the details came from hidden fields)
$input = sp_read_reservation_input($_POST);
$result = sp_validate_reservation($input, $reservationId, $originalLot);

// Stop the update if any validation errors occurred
if (!empty($result['errors'])) {
    sp_render_error_page(
        'Unable to Update Reservation',
        $result['errors'],
        'edit-reservation.php?id=' . urlencode($reservationId),
        'Back to Edit Reservation',
        'reservations'
    );
}

// Update the existing reservation in the PHP session
$_SESSION['reservations'][$reservationIndex]['lot'] = $input['parking_lot'];
$_SESSION['reservations'][$reservationIndex]['date'] = $input['reservation_date'];
$_SESSION['reservations'][$reservationIndex]['start_time'] = $input['start_time'];
$_SESSION['reservations'][$reservationIndex]['end_time'] = $input['end_time'];
$_SESSION['reservations'][$reservationIndex]['vehicle_plate'] = $input['vehicle_plate'];
$_SESSION['reservations'][$reservationIndex]['vehicle_type'] = $input['vehicle_type'];
$_SESSION['reservations'][$reservationIndex]['cost'] = $result['cost'];

// Moving to another lot frees a spot at the old lot and takes one at the new lot
if ($input['parking_lot'] !== $originalLot) {
    sp_change_available_spots($originalLot, +1);
    sp_change_available_spots($input['parking_lot'], -1);
}

// Preserve the original reservation ID and Confirmed status,
// then show the updated Reservation Details page
header('Location: reservation-details.php?id=' . urlencode($reservationId) . '&updated=1');
exit;
