<?php
// UC-RES-03: Edit Parking Reservation
// Retrieve an existing reservation for editing

require_once __DIR__ . '/reservation-data.php';

// Get the reservation ID from the URL or the returning form
$reservationId = $_POST['reservation_id'] ?? $_GET['id'] ?? '';
$reservationIndex = sp_find_reservation_index($reservationId);

// Only confirmed reservations can be edited
if (
    $reservationIndex === null ||
    $_SESSION['reservations'][$reservationIndex]['status'] !== 'Confirmed'
) {
    header('Location: reservations.php');
    exit;
}

$selectedReservation = $_SESSION['reservations'][$reservationIndex];

// Show proposed changes when returning from the review page,
// otherwise the reservation's current details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formValues = sp_read_reservation_input($_POST);
} else {
    $formValues = [
        'parking_lot' => $selectedReservation['lot'],
        'reservation_date' => $selectedReservation['date'],
        'start_time' => $selectedReservation['start_time'],
        'end_time' => $selectedReservation['end_time'],
        'vehicle_plate' => $selectedReservation['vehicle_plate'],
        'vehicle_type' => $selectedReservation['vehicle_type']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Reservation | SmartPark</title>

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

    <h1>Edit Parking Reservation</h1>

    <p class="text-muted">
        Update the details of your existing parking reservation, then review your changes.
    </p>

    <form action="edit-reservation-summary.php" method="POST">

        <input
            type="hidden"
            name="reservation_id"
            value="<?= htmlspecialchars($selectedReservation['id'], ENT_QUOTES) ?>"
        >

        <div class="card mt-4">
            <div class="card-body">

                <h5 class="mb-4">
                    Reservation ID:
                    <?= htmlspecialchars($selectedReservation['id']) ?>
                </h5>

                <?php
                $currentLot = $selectedReservation['lot'];
                $submitLabel = 'Review Changes';
                $cancelUrl = 'reservation-details.php?id=' . urlencode($selectedReservation['id']);
                require __DIR__ . '/reservation-form-fields.php';
                ?>

            </div>
        </div>

    </form>

</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
