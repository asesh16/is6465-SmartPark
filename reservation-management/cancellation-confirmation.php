<?php
// UC-RES-04: Cancellation Confirmation
// Display a successfully cancelled reservation

require_once __DIR__ . '/reservation-data.php';

// Get the reservation ID from the URL
$reservationId = $_GET['id'] ?? '';

// Find the matching reservation
$cancelledReservation = null;

foreach ($reservations as $reservation) {
    if ($reservation['id'] === $reservationId) {
        $cancelledReservation = $reservation;
        break;
    }
}

// Only display this page for cancelled reservations
if (
    $cancelledReservation === null ||
    $cancelledReservation['status'] !== 'Cancelled'
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

    <title>Reservation Cancelled | SmartPark</title>

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

            <a href="create-reservation.php">Make a Reservation</a>

            <a href="reservations.php" class="active" aria-current="page">
                View Reservations
            </a>

            <a href="../login.php">Login</a>

        </nav>

    </div>
</header>

<div class="container mt-5">

    <div class="card shadow-sm">
        <div class="card-body text-center p-5">

            <h1 class="mb-3">
                Reservation Cancelled
            </h1>

            <p class="lead">
                Your parking reservation has been successfully cancelled.
            </p>

            <p class="text-muted">
                This reservation will remain available in your reservation history.
            </p>

            <hr>

            <h5>Reservation ID</h5>

            <h3 class="mb-4">
                <?= htmlspecialchars($cancelledReservation['id']) ?>
            </h3>

            <p>
                <strong>Parking Lot:</strong>
                <?= htmlspecialchars($cancelledReservation['lot']) ?>
            </p>

            <p>
                <strong>Date:</strong>
                <?= htmlspecialchars(date('F j, Y', strtotime($cancelledReservation['date']))) ?>
            </p>

            <p>
                <strong>Start Time:</strong>
                <?= htmlspecialchars(date('g:i A', strtotime($cancelledReservation['start_time']))) ?>
            </p>

            <p>
                <strong>End Time:</strong>
                <?= htmlspecialchars(date('g:i A', strtotime($cancelledReservation['end_time']))) ?>
            </p>

            <p>
                <strong>License Plate:</strong>
                <?= htmlspecialchars($cancelledReservation['vehicle_plate']) ?>
            </p>

            <p>
                <strong>Vehicle Type:</strong>
                <?= htmlspecialchars($cancelledReservation['vehicle_type']) ?>
            </p>

            <p>
                <strong>Original Estimated Cost:</strong>
                $<?= number_format($cancelledReservation['cost'], 2) ?>
            </p>

            <span class="badge bg-secondary mt-2 mb-4">
                Cancelled
            </span>

            <div>
                <a href="reservations.php" class="btn btn-primary">
                    Back to My Reservations
                </a>
            </div>

        </div>
    </div>

</div>

</body>
</html>
