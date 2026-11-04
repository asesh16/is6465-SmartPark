<?php
// UC-RES-03: Update Parking Reservation
// Process changes to an existing confirmed reservation

require_once __DIR__ . '/reservation-data.php';

// Only accept POST requests from the Edit Reservation form
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: reservations.php');
    exit;
}

// Receive the reservation ID and updated form information
$reservationId = trim($_POST['reservation_id'] ?? '');
$parkingLot = trim($_POST['parking_lot'] ?? '');
$reservationDate = trim($_POST['reservation_date'] ?? '');
$startTime = trim($_POST['start_time'] ?? '');
$endTime = trim($_POST['end_time'] ?? '');
$vehiclePlate = strtoupper(trim($_POST['vehicle_plate'] ?? ''));
$vehicleType = trim($_POST['vehicle_type'] ?? '');

// Find the existing reservation's position in the session array
$reservationIndex = null;

foreach ($_SESSION['reservations'] as $index => $reservation) {
    if ($reservation['id'] === $reservationId) {
        $reservationIndex = $index;
        break;
    }
}

// Prevent changes to missing or cancelled reservations
if (
    $reservationIndex === null ||
    $_SESSION['reservations'][$reservationIndex]['status'] !== 'Confirmed'
) {
    header('Location: reservations.php');
    exit;
}

// Prepare to validate the updated reservation
$errors = [];

 
// Define valid parking lots and hourly rates
$parkingRates = [
    'Downtown Garage' => 4.00,
    'Airport Lot B' => 2.00,
    'Campus Lot 4' => 5.50,
    'State Street Lot 2' => 1.50
];

// Define valid vehicle types
$validVehicleTypes = [
    'Sedan', 'SUV', 'Truck', 'Van', 'Motorcycle', 'Other'
];

// Check that all required fields are completed
if (
    $parkingLot === '' ||
    $reservationDate === '' ||
    $startTime === '' ||
    $endTime === '' ||
    $vehiclePlate === '' ||
    $vehicleType === ''
) {
    $errors[] = 'Please complete all required fields.';
}

// Validate parking lot
if (!array_key_exists($parkingLot, $parkingRates)) {
    $errors[] = 'Please select a valid parking lot.';
}

// Validate reservation date
$date = DateTimeImmutable::createFromFormat('!Y-m-d', $reservationDate);

if (!$date || $date->format('Y-m-d') !== $reservationDate) {
    $errors[] = 'Please enter a valid reservation date.';
} elseif ($reservationDate < date('Y-m-d')) {
    $errors[] = 'Reservation dates cannot be in the past.';
}

// Validate start and end times using 30-minute increments
$validTimeFormat = '/^([01][0-9]|2[0-3]):(00|30)$/';

if (
    !preg_match($validTimeFormat, $startTime) ||
    !preg_match($validTimeFormat, $endTime)
) {
    $errors[] = 'Start and end times must use 30-minute increments.';
} elseif ($endTime <= $startTime) {
    $errors[] = 'End time must be later than start time.';
}

// Validate license plate
if ($vehiclePlate === '' || strlen($vehiclePlate) > 15) {
    $errors[] = 'License plate must contain 1 to 15 characters.';
}

// Validate vehicle type
if (!in_array($vehicleType, $validVehicleTypes, true)) {
    $errors[] = 'Please select a valid vehicle type.';
}

// Check parking availability for the updated reservation
if (empty($errors)) {

    foreach ($_SESSION['reservations'] as $existingReservation) {

        // Exclude the reservation currently being edited
        if ($existingReservation['id'] === $reservationId) {
            continue;
        }

        // Cancelled reservations do not occupy parking spaces
        if ($existingReservation['status'] !== 'Confirmed') {
            continue;
        }

        // Check for a conflict at the same lot, date, and time
        if (
            $existingReservation['lot'] === $parkingLot &&
            $existingReservation['date'] === $reservationDate &&
            $startTime < $existingReservation['end_time'] &&
            $endTime > $existingReservation['start_time']
        ) {
            $errors[] = 'This parking lot is unavailable during the selected time. Please choose another time or parking lot.';
            break;
        }
    }
}

// Stop the update if any validation errors occurred
if (!empty($errors)) {
    http_response_code(400);

    echo '<h2>Unable to Update Reservation</h2>';
    echo '<ul>';

    foreach ($errors as $error) {
        echo '<li>' . htmlspecialchars($error) . '</li>';
    }

    echo '</ul>';
    echo '<a href="edit-reservation.php?id=' .
         urlencode($reservationId) .
         '">Back to Edit Reservation</a>';
    exit;
}

// Calculate the updated parking cost
$startTimestamp = strtotime($reservationDate . ' ' . $startTime);
$endTimestamp = strtotime($reservationDate . ' ' . $endTime);

$parkingHours = ($endTimestamp - $startTimestamp) / 3600;
$hourlyRate = $parkingRates[$parkingLot];
$updatedCost = round($parkingHours * $hourlyRate, 2);

// Update the existing reservation in the PHP session
$_SESSION['reservations'][$reservationIndex]['lot'] = $parkingLot;
$_SESSION['reservations'][$reservationIndex]['date'] = $reservationDate;
$_SESSION['reservations'][$reservationIndex]['start_time'] = $startTime;
$_SESSION['reservations'][$reservationIndex]['end_time'] = $endTime;
$_SESSION['reservations'][$reservationIndex]['vehicle_plate'] = $vehiclePlate;
$_SESSION['reservations'][$reservationIndex]['vehicle_type'] = $vehicleType;
$_SESSION['reservations'][$reservationIndex]['cost'] = $updatedCost;

// Preserve the original reservation ID and Confirmed status

// Redirect to the updated Reservation Details page
header('Location: reservation-details.php?id=' . urlencode($reservationId));
exit;
?>
