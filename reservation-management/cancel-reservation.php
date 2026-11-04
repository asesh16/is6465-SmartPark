<?php
// UC-RES-04: Cancel Parking Reservation
// Retrieve a confirmed reservation before cancellation

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

// Only confirmed reservations can be cancelled
if (
    $selectedReservation === null ||
    $selectedReservation['status'] !== 'Confirmed'
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

    <title>Cancel Reservation | SmartPark</title>

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

    <h1>Cancel Parking Reservation</h1>

    <p class="text-muted">
        Review the reservation details before confirming cancellation.
    </p>

    <div class="alert alert-warning mt-4">
        <strong>Are you sure you want to cancel this reservation?</strong>
        <p class="mb-0 mt-2">
            Once cancelled, this reservation cannot be edited or reactivated.
            Its details will remain available in your reservation history.
        </p>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            Reservation <?= htmlspecialchars($selectedReservation['id']) ?>
        </div>

        <div class="card-body">

            <p><strong>Parking Lot:</strong>
                <?= htmlspecialchars($selectedReservation['lot']) ?>
            </p>

            <p><strong>Date:</strong>
                <?= htmlspecialchars(date('F j, Y', strtotime($selectedReservation['date']))) ?>
            </p>

            <p><strong>Start Time:</strong>
                <?= htmlspecialchars(date('g:i A', strtotime($selectedReservation['start_time']))) ?>
            </p>

            <p><strong>End Time:</strong>
                <?= htmlspecialchars(date('g:i A', strtotime($selectedReservation['end_time']))) ?>
            </p>

            <p><strong>License Plate:</strong>
                <?= htmlspecialchars($selectedReservation['vehicle_plate']) ?>
            </p>

            <p><strong>Vehicle Type:</strong>
                <?= htmlspecialchars($selectedReservation['vehicle_type']) ?>
            </p>

            <p><strong>Estimated Cost:</strong>
                $<?= number_format($selectedReservation['cost'], 2) ?>
            </p>

            <p><strong>Status:</strong>
                <span class="badge bg-success">Confirmed</span>
            </p>

        </div>
    </div>

    <div class="d-flex gap-2 mt-4">

        <form action="process-cancellation.php" method="POST">
            <input
                type="hidden"
                name="reservation_id"
                value="<?= htmlspecialchars($selectedReservation['id'], ENT_QUOTES) ?>"
            >

            <button type="submit" class="btn btn-danger">
                Yes, Cancel Reservation
            </button>
        </form>

        <a href="reservations.php" class="btn btn-secondary">
            Keep Reservation
        </a>

    </div>

</div>

</body>
</html>

