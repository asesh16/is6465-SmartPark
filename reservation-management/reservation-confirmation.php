<?php
// UC-RES-01: Reservation Confirmation
// Display the newly confirmed reservation

require_once __DIR__ . '/reservation-data.php';

// Get the reservation ID from the URL
$reservationId = $_GET['id'] ?? '';

// Find the matching reservation
$confirmedReservation = null;

foreach ($reservations as $reservation) {
    if ($reservation['id'] === $reservationId) {
        $confirmedReservation = $reservation;
        break;
    }
}

// Redirect if the reservation does not exist
// or is not currently confirmed
if (
    $confirmedReservation === null ||
    $confirmedReservation['status'] !== 'Confirmed'
) {
    header('Location: reservations.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reservation Confirmed | SmartPark</title>

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

    <div class="card shadow-sm">
        <div class="card-body text-center p-5">

            <h1 class="text-success mb-3">
                Reservation Confirmed!
            </h1>

            <p class="lead">
                Your parking reservation has been successfully created.
            </p>

            <hr>

            <h5>Reservation ID</h5>

            <h3 class="mb-4">
                <?= htmlspecialchars($confirmedReservation['id']) ?>
            </h3>

            <p>
                <strong>Parking Lot:</strong>
                <?= htmlspecialchars($confirmedReservation['lot']) ?>
            </p>

            <p>
                <strong>Date:</strong>
                <?= htmlspecialchars(date('F j, Y', strtotime($confirmedReservation['date']))) ?>
            </p>

            <p>
                <strong>Start Time:</strong>
                <?= htmlspecialchars(date('g:i A', strtotime($confirmedReservation['start_time']))) ?>
            </p>

            <p>
                <strong>End Time:</strong>
                <?= htmlspecialchars(date('g:i A', strtotime($confirmedReservation['end_time']))) ?>
            </p>

            <p>
                <strong>License Plate:</strong>
                <?= htmlspecialchars($confirmedReservation['vehicle_plate']) ?>
            </p>

            <p>
                <strong>Vehicle Type:</strong>
                <?= htmlspecialchars($confirmedReservation['vehicle_type']) ?>
            </p>

            <h4 class="text-success mt-4">
                Total Cost:
                $<?= number_format($confirmedReservation['cost'], 2) ?>
            </h4>

            <span class="badge bg-success mt-2 mb-4">
                Confirmed
            </span>

            <div class="d-flex justify-content-center gap-2">
                <a href="reservations.php" class="btn btn-primary">
                    My Reservations
                </a>

                <a href="create-reservation.php" class="btn btn-outline-secondary">
                    Create Another Reservation
                </a>
            </div>

        </div>
    </div>

</div>

</body>
</html>
