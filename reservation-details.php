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
<body class="sp-page">

<?php
$basePath = '../';
$activePage = 'reservations';
require __DIR__ . '/../includes/header.php';
?>

<div class="container mt-5">
    <h1>Reservation Details</h1>
    <p class="text-muted">
        Review your parking reservation information.
    </p>

    <?php if ($selectedReservation !== null && isset($_GET['updated'])): ?>
        <div class="alert alert-success">
            Your reservation was updated. The reservation ID and Confirmed status were kept.
        </div>
    <?php elseif ($selectedReservation !== null && isset($_GET['discarded'])): ?>
        <div class="alert alert-info">
            Your changes were discarded. The original reservation was kept.
        </div>
    <?php endif; ?>

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
                    <?= htmlspecialchars(date('F j, Y', strtotime($selectedReservation['date']))) ?></p>

                <p><strong>Start Time:</strong>
                    <?= htmlspecialchars(date('g:i A', strtotime($selectedReservation['start_time']))) ?></p>

                <p><strong>End Time:</strong>
                    <?= htmlspecialchars(date('g:i A', strtotime($selectedReservation['end_time']))) ?></p>

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

    <div class="d-flex flex-wrap gap-2 mt-4">
        <?php if ($selectedReservation !== null && $selectedReservation['status'] === 'Confirmed' && !$isLotManager): ?>
            <a href="edit-reservation.php?id=<?= urlencode($selectedReservation['id']) ?>" class="btn btn-primary">
                Edit Reservation
            </a>
            <a href="cancel-reservation.php?id=<?= urlencode($selectedReservation['id']) ?>" class="btn btn-danger">
                Cancel Reservation
            </a>
        <?php endif; ?>

        <a href="reservations.php" class="btn btn-secondary">
            Back to <?= $isLotManager ? 'All' : 'My' ?> Reservations
        </a>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
