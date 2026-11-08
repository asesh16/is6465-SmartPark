<?php
// UC-RES-03: Review Reservation Changes
// Validate proposed changes, recalculate the cost, and ask the driver to confirm

require_once __DIR__ . '/reservation-data.php';

// Only accept POST requests from the Edit Reservation form
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: reservations.php');
    exit;
}

// Find the reservation being edited
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

$originalReservation = $_SESSION['reservations'][$reservationIndex];

// Validate the proposed changes and recalculate the estimated cost
$input = sp_read_reservation_input($_POST);
$result = sp_validate_reservation($input, $reservationId, $originalReservation['lot']);
$errors = $result['errors'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Review Changes | SmartPark</title>

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

    <h1>Review Reservation Changes</h1>

    <p class="text-muted">
        Reservation <?= htmlspecialchars($reservationId) ?>.
        Confirm the updated details below, or go back to make more changes.
    </p>

    <?php if (!empty($errors)): ?>

        <div class="alert alert-danger mt-4">
            <h5>Unable to Update Reservation</h5>

            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="d-flex flex-wrap gap-2 mt-3">
            <form action="edit-reservation.php" method="POST">
                <input type="hidden" name="reservation_id" value="<?= htmlspecialchars($reservationId, ENT_QUOTES) ?>">
                <?= sp_hidden_reservation_fields($input) ?>
                <button type="submit" class="btn btn-secondary">Back to Edit</button>
            </form>

            <a href="reservation-details.php?id=<?= urlencode($reservationId) ?>&amp;discarded=1" class="btn btn-outline-secondary">
                Discard Changes
            </a>
        </div>

    <?php else: ?>

        <?php
        $summary = $input;
        $summaryCost = $result;
        require __DIR__ . '/reservation-summary-card.php';
        ?>

        <p class="text-muted mt-3">
            Original estimated cost: $<?= number_format($originalReservation['cost'], 2) ?>
            &rarr; updated estimated cost: <strong>$<?= number_format($result['cost'], 2) ?></strong>
        </p>

        <div class="d-flex flex-wrap gap-2 mt-4 mb-5">

            <form action="update-reservation.php" method="POST">
                <input type="hidden" name="reservation_id" value="<?= htmlspecialchars($reservationId, ENT_QUOTES) ?>">
                <?= sp_hidden_reservation_fields($input) ?>
                <button type="submit" class="btn btn-primary">
                    Confirm Changes
                </button>
            </form>

            <form action="edit-reservation.php" method="POST">
                <input type="hidden" name="reservation_id" value="<?= htmlspecialchars($reservationId, ENT_QUOTES) ?>">
                <?= sp_hidden_reservation_fields($input) ?>
                <button type="submit" class="btn btn-secondary">
                    Back to Edit
                </button>
            </form>

            <a href="reservation-details.php?id=<?= urlencode($reservationId) ?>&amp;discarded=1" class="btn btn-outline-secondary">
                Discard Changes
            </a>

        </div>

    <?php endif; ?>

</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
