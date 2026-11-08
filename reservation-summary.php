<?php
// UC-RES-01: Reservation Summary
// Receive information from Create Parking Reservation

require_once __DIR__ . '/reservation-data.php';

// Only accept form submissions using POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create-reservation.php');
    exit;
}

// Receive and validate the six reservation fields,
// check availability, and calculate the estimated cost
$input = sp_read_reservation_input($_POST);
$result = sp_validate_reservation($input);
$errors = $result['errors'];
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
<body class="sp-page">

<?php
$basePath = '../';
$activePage = 'reservations';
require __DIR__ . '/../includes/header.php';
?>

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

        <!-- Return to the form with the entered details kept -->
        <form action="create-reservation.php" method="POST" class="mt-3">
            <?= sp_hidden_reservation_fields($input) ?>
            <button type="submit" class="btn btn-secondary">
                Back to Reservation Form
            </button>
        </form>

    <?php else: ?>

        <?php
        $summary = $input;
        $summaryCost = $result;
        require __DIR__ . '/reservation-summary-card.php';
        ?>

        <div class="d-flex flex-wrap gap-2 mt-4 mb-5">

            <form action="confirm-reservation.php" method="POST">
                <?= sp_hidden_reservation_fields($input) ?>
                <button type="submit" class="btn btn-primary">
                    Confirm Reservation
                </button>
            </form>

            <!-- Back to Edit keeps the entered details -->
            <form action="create-reservation.php" method="POST">
                <?= sp_hidden_reservation_fields($input) ?>
                <button type="submit" class="btn btn-secondary">
                    Back to Edit
                </button>
            </form>

        </div>

    <?php endif; ?>

</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
