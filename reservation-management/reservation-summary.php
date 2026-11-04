<?php
// UC-RES-01: Reservation Summary
// Receive information from Create Parking Reservation

require_once __DIR__ . '/reservation-data.php';

// Only accept form submissions using POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create-reservation.php');
    exit;
}

// Receive the six reservation fields
$parkingLot = trim($_POST['parking_lot'] ?? '');
$reservationDate = trim($_POST['reservation_date'] ?? '');
$startTime = trim($_POST['start_time'] ?? '');
$endTime = trim($_POST['end_time'] ?? '');
$vehiclePlate = strtoupper(trim($_POST['vehicle_plate'] ?? ''));
$vehicleType = trim($_POST['vehicle_type'] ?? '');

// Prepare an array for validation errors
$errors = [];

// Check that all required fields are provided
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

// Validate the selected parking lot
$parkingRates = [
    'Downtown Garage' => 4.00,
    'Airport Lot B' => 2.00,
    'Campus Lot 4' => 5.50,
    'State Street Lot 2' => 1.50
];

if ($parkingLot !== '' && !array_key_exists($parkingLot, $parkingRates)) {
    $errors[] = 'Please select a valid parking lot.';
}

// Validate reservation date
$date = DateTimeImmutable::createFromFormat('!Y-m-d', $reservationDate);

if (
    !$date ||
    $date->format('Y-m-d') !== $reservationDate
) {
    $errors[] = 'Please enter a valid reservation date.';
} elseif ($reservationDate < date('Y-m-d')) {
    $errors[] = 'Reservation dates cannot be in the past.';
}

// Validate start and end times
$validTimeFormat = '/^([01][0-9]|2[0-3]):[0-5][0-9]$/';

if (
    !preg_match($validTimeFormat, $startTime) ||
    !preg_match($validTimeFormat, $endTime)
) {
    $errors[] = 'Please enter valid start and end times.';

} elseif ($endTime <= $startTime) {
    $errors[] = 'End time must be later than start time.';
} elseif (
    !in_array(substr($startTime, 3, 2), ['00', '30'], true) ||
    !in_array(substr($endTime, 3, 2), ['00', '30'], true)
) {
    $errors[] = 'Reservations must start and end on the hour or half-hour.';
}

// Validate license plate length
if ($vehiclePlate !== '' && strlen($vehiclePlate) > 15) {
    $errors[] = 'License plate cannot exceed 15 characters.';
}

// Validate vehicle type
$validVehicleTypes = [
    'Sedan', 'SUV', 'Truck', 'Van', 'Motorcycle', 'Other'
];

if ($vehicleType !== '' && !in_array($vehicleType, $validVehicleTypes, true)) {
    $errors[] = 'Please select a valid vehicle type.';
}

 
// Calculate estimated parking cost
$estimatedCost = 0;
$parkingHours = 0;

if (empty($errors)) {
    // Convert parking times into timestamps
    $startTimestamp = strtotime($reservationDate . ' ' . $startTime);
    $endTimestamp = strtotime($reservationDate . ' ' . $endTime);

    // Calculate total parking hours
    $parkingHours = ($endTimestamp - $startTimestamp) / 3600;

    // Get the selected parking lot's hourly rate
    $hourlyRate = $parkingRates[$parkingLot];

    // Calculate estimated total cost
    $estimatedCost = round($parkingHours * $hourlyRate, 2);
}

// Simulated parking availability check
// For this midterm, assume each lot has one reservable space.
// Overlapping confirmed reservations make that space unavailable.

if (empty($errors)) {
    foreach ($reservations as $existingReservation) {

        // Only confirmed reservations occupy parking spaces
        if ($existingReservation['status'] !== 'Confirmed') {
            continue;
        }

        // Check whether the parking lot and date match
        if (
            $existingReservation['lot'] === $parkingLot &&
            $existingReservation['date'] === $reservationDate
        ) {
            // Check whether the requested times overlap
            $timesOverlap = (
                $startTime < $existingReservation['end_time'] &&
                $endTime > $existingReservation['start_time']
            );

            if ($timesOverlap) {
                $errors[] = 'This parking lot is unavailable during the selected time. Please choose another time or parking lot.';
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reservation Summary | SmartPark</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Shared SmartPark CSS -->
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<!-- SmartPark Customer Navigation -->
<header class="smartpark-header">
    <div class="container smartpark-navbar">

        <a href="../home.php" class="smartpark-brand">
            SmartPark Solutions
        </a>

        <nav class="smartpark-nav-links" aria-label="Main navigation">

            <a href="../home.php">Home</a>

            <a href="../home.php">Find Parking</a>

            <a href="reservations.php" class="active" aria-current="page">
                My Reservations
            </a>

            <a href="../login.php">Login</a>

        </nav>

    </div>
</header>

<div class="container mt-5">

    <h1>Reservation Summary</h1>

    <p class="text-muted">
        Review your parking reservation before confirming.
    </p>

    <?php if (!empty($errors)): ?>

        <div class="alert alert-danger mt-4">
            <h5>Unable to Continue</h5>

            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <a href="create-reservation.php"
           class="btn btn-secondary mt-3">
            Back to Reservation Form
        </a>

    <?php else: ?>

        
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Parking Reservation Details</h5>
    </div>

    <div class="card-body">
        <h6 class="mb-3">Parking Information</h6>

        <p><strong>Parking Lot:</strong>
            <?= htmlspecialchars($parkingLot) ?>
        </p>

        <p><strong>Reservation Date:</strong>
            <?= htmlspecialchars(date('F j, Y', strtotime($reservationDate))) ?>
        </p>

        <p><strong>Start Time:</strong>
            <?= htmlspecialchars(date('g:i A', strtotime($startTime))) ?>
        </p>

        <p><strong>End Time:</strong>
            <?= htmlspecialchars(date('g:i A', strtotime($endTime))) ?>
        </p>

        <hr>

        <h6 class="mb-3">Vehicle Information</h6>

        <p><strong>License Plate:</strong>
            <?= htmlspecialchars($vehiclePlate) ?>
        </p>

        <p><strong>Vehicle Type:</strong>
            <?= htmlspecialchars($vehicleType) ?>
        </p>

        <hr>

        <h6>Estimated Parking Cost</h6>

        <p><strong>Duration:</strong>
            <?= number_format($parkingHours, 1) ?> hours
        </p>

        <p><strong>Hourly Rate:</strong>
            $<?= number_format($hourlyRate, 2) ?>
        </p>

        <h4 class="text-success">
            Estimated Total: $<?= number_format($estimatedCost, 2) ?>
        </h4>
    </div>
</div>

<div class="d-flex gap-2 mt-4 mb-5">

    <form action="confirm-reservation.php" method="POST">

        <input type="hidden" name="parking_lot"
               value="<?= htmlspecialchars($parkingLot, ENT_QUOTES) ?>">

        <input type="hidden" name="reservation_date"
               value="<?= htmlspecialchars($reservationDate, ENT_QUOTES) ?>">

        <input type="hidden" name="start_time"
               value="<?= htmlspecialchars($startTime, ENT_QUOTES) ?>">

        <input type="hidden" name="end_time"
               value="<?= htmlspecialchars($endTime, ENT_QUOTES) ?>">

        <input type="hidden" name="vehicle_plate"
               value="<?= htmlspecialchars($vehiclePlate, ENT_QUOTES) ?>">

        <input type="hidden" name="vehicle_type"
               value="<?= htmlspecialchars($vehicleType, ENT_QUOTES) ?>">

        <button type="submit" class="btn btn-success">
            Confirm Reservation
        </button>

    </form>

    <a href="create-reservation.php" class="btn btn-secondary">
        Back to Edit
    </a>

</div>

    <?php endif; ?>

</div>

</body>
</html>
