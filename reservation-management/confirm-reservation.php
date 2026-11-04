<?php
// UC-RES-01: Confirm Parking Reservation
// Save a validated reservation and display confirmation

require_once __DIR__ . '/reservation-data.php';

// Only accept POST requests from the Reservation Summary page
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create-reservation.php');
    exit;
}

// Receive the submitted reservation information
$parkingLot = trim($_POST['parking_lot'] ?? '');
$reservationDate = trim($_POST['reservation_date'] ?? '');
$startTime = trim($_POST['start_time'] ?? '');
$endTime = trim($_POST['end_time'] ?? '');
$vehiclePlate = strtoupper(trim($_POST['vehicle_plate'] ?? ''));
$vehicleType = trim($_POST['vehicle_type'] ?? '');

// Prepare to validate the reservation before saving
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

// Check required fields
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
    $errors[] = 'Invalid parking lot selected.';
}

// Validate reservation date
$date = DateTimeImmutable::createFromFormat('!Y-m-d', $reservationDate);

if (!$date || $date->format('Y-m-d') !== $reservationDate) {
    $errors[] = 'Invalid reservation date.';
} elseif ($reservationDate < date('Y-m-d')) {
    $errors[] = 'Reservation date cannot be in the past.';
}

// Validate time format and 30-minute increments
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
    $errors[] = 'Invalid vehicle type selected.';
}

// Check simulated parking availability
if (empty($errors)) {
    foreach ($reservations as $existingReservation) {
        if (
            $existingReservation['status'] === 'Confirmed' &&
            $existingReservation['lot'] === $parkingLot &&
            $existingReservation['date'] === $reservationDate &&
            $startTime < $existingReservation['end_time'] &&
            $endTime > $existingReservation['start_time']
        ) {
            $errors[] = 'This parking lot is unavailable during the selected time.';
            break;
        }
    }
}

 
// Stop the confirmation process if validation fails
if (!empty($errors)) {
    http_response_code(400);

    echo '<h2>Unable to Confirm Reservation</h2>';
    echo '<ul>';

    foreach ($errors as $error) {
        echo '<li>' . htmlspecialchars($error) . '</li>';
    }

    echo '</ul>';
    echo '<a href="create-reservation.php">Back to Reservation Form</a>';
    exit;
}

// Calculate the final parking cost
$startTimestamp = strtotime($reservationDate . ' ' . $startTime);
$endTimestamp = strtotime($reservationDate . ' ' . $endTime);

$parkingHours = ($endTimestamp - $startTimestamp) / 3600;
$hourlyRate = $parkingRates[$parkingLot];
$totalCost = round($parkingHours * $hourlyRate, 2);

// Generate a unique reservation ID
$highestId = 1000;

foreach ($reservations as $existingReservation) {
    if (preg_match('/^RES-(\d+)$/', $existingReservation['id'], $matches)) {
        $highestId = max($highestId, (int) $matches[1]);
    }
}

$newReservationId = 'RES-' . ($highestId + 1);

// Create the new reservation record
$newReservation = [
    'id' => $newReservationId,
    'lot' => $parkingLot,
    'date' => $reservationDate,
    'start_time' => $startTime,
    'end_time' => $endTime,
    'vehicle_plate' => $vehiclePlate,
    'vehicle_type' => $vehicleType,
    'cost' => $totalCost,
    'status' => 'Confirmed'
];

// Save the reservation in the PHP session
$_SESSION['reservations'][] = $newReservation;

// Redirect to the confirmation page
header('Location: reservation-confirmation.php?id=' . urlencode($newReservationId));
exit;
?>
