<?php
// UC-RES-02: View Reservation Details

// Load shared reservation data from the PHP session
require_once __DIR__ . '/reservation-data.php';

// Get the reservation ID from the URL
$reservationId = $_GET['id'] ?? '';

// Find the matching reservation
$selectedReservation = null;

foreach ($reservations as $reservation) {
    if ($reservation['id'] === $reservationId) {
        $selectedReservation = $reservation;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Details | SmartPark</title>

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
    <h1>Reservation Details</h1>
    <p class="text-muted">
        Review your parking reservation information.
    </p>

    <?php if ($selectedReservation === null): ?>

        <div class="alert alert-danger">
            Reservation not found.
        </div>

    <?php else: ?>

        <div class="card mt-4">
            <div class="card-header">
                Reservation <?= htmlspecialchars($selectedReservation['id']) ?>
            </div>

            <div class="card-body">
                <p><strong>Parking Lot:</strong>
                    <?= htmlspecialchars($selectedReservation['lot']) ?></p>

                <p><strong>Date:</strong>       
                    <?= htmlspecialchars(date('F j, Y', strtotime($selectedReservation['date']))) ?>

                <p><strong>Start Time:</strong>
                    <?= htmlspecialchars(date('g:i A', strtotime($selectedReservation['start_time']))) ?>

                <p><strong>End Time:</strong>
                    <?= htmlspecialchars(date('g:i A', strtotime($selectedReservation['end_time']))) ?>

                <p><strong>License Plate:</strong>
                    <?= htmlspecialchars($selectedReservation['vehicle_plate']) ?></p>

                <p><strong>Vehicle Type:</strong>
                    <?= htmlspecialchars($selectedReservation['vehicle_type']) ?></p>

                <p><strong>Estimated Cost:</strong>
                    $<?= number_format($selectedReservation['cost'], 2) ?></p>

                <p><strong>Status:</strong>
                    <?php if ($selectedReservation['status'] === 'Confirmed'): ?>
                        <span class="badge bg-success">Confirmed</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Cancelled</span>
                    <?php endif; ?>
                </p>
            </div>
        </div>

    <?php endif; ?>

    <a href="reservations.php" class="btn btn-secondary mt-4">
        Back to My Reservations
    </a>
</div>

</body>
</html>
