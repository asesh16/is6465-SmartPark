<?php
// UC-LOT View Parking Lot Details
// Shows one lot; Lot Managers can edit or delete it, Drivers can reserve it

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/lot-data.php';

// Find the lot from the ID in the URL
$lotId = (int) ($_GET['lot_id'] ?? 0);
$selectedLot = $parkingLots[$lotId] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Lot Details | SmartPark Solutions</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Shared SmartPark CSS -->
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="sp-page">

<?php
$basePath = '../';
$activePage = $isLotManager ? 'lots' : 'find';
require __DIR__ . '/../includes/header.php';
?>

    <main class="container mt-5 mb-5">
        <h1>Parking Lot Details</h1>

        <?php if ($selectedLot === null): ?>

            <div class="alert alert-danger mt-4">
                The selected parking lot could not be found.
            </div>

        <?php else: ?>

            <div class="card mt-4 mb-4" style="max-width: 720px;">
                <div class="card-body">
                    <h2><?= htmlspecialchars($selectedLot['location']) ?></h2>

                    <dl>
                        <dt>Location</dt>
                        <dd><?= htmlspecialchars($selectedLot['location']) ?></dd>

                        <dt>Total Spots</dt>
                        <dd><?= $selectedLot['total_spots'] ?></dd>

                        <dt>Available spots</dt>
                        <dd><?= $selectedLot['available_spots'] ?></dd>

                        <dt>Hourly rate</dt>
                        <dd>$<?= number_format($selectedLot['hourly_rate'], 2) ?></dd>
                    </dl>

                    <div class="d-flex flex-wrap gap-2">
                        <?php if ($isLotManager): ?>
                            <a href="lot-update.php?lot_id=<?= $selectedLot['id'] ?>" class="btn btn-warning">
                                Edit Parking Lot
                            </a>
                            <a href="lot-delete.php?lot_id=<?= $selectedLot['id'] ?>" class="btn btn-danger">
                                Delete Parking Lot
                            </a>
                        <?php elseif ($selectedLot['available_spots'] > 0): ?>
                            <a href="../reservation-management/create-reservation.php?lot=<?= urlencode($selectedLot['location']) ?>" class="btn btn-success">
                                Reserve a Spot Here
                            </a>
                        <?php else: ?>
                            <span class="badge bg-secondary">This lot is full</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <p><a href="lot-list.php">Back to parking lots</a></p>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
