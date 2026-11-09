<?php
// UC-RES-01: Create Parking Reservation
// Load shared reservation data and PHP session

require_once __DIR__ . '/reservation-data.php';

// Fill the form when returning from the summary (Back to Edit)
// or arriving from Find Parking with a lot already chosen
$formValues = sp_read_reservation_input($_POST);

if ($formValues['parking_lot'] === '') {
    $formValues['parking_lot'] = trim($_GET['lot'] ?? '');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Reservation | SmartPark</title>

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

    <h1>Create Parking Reservation</h1>

    <p class="text-muted">
        Select your parking details to create a new reservation.
    </p>

    <form action="reservation-summary.php" method="POST">

        <div class="card mt-4">
            <div class="card-body">

                <h5 class="card-title mb-4">Parking Details</h5>

                <?php
                $submitLabel = 'Review Reservation';
                $cancelUrl = 'reservations.php';
                require __DIR__ . '/reservation-form-fields.php';
                ?>

            </div>
        </div>

    </form>

</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
