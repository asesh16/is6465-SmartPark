<?php
// UC-LOT Delete Parking Lot
// Only Lot Managers may use this page
require_once __DIR__ . '/../includes/require-manager.php';
require_once __DIR__ . '/../reservation-management/reservation-data.php';

// Find the lot from the URL or the submitted form
$lotId = (int) ($_POST['lot_id'] ?? $_GET['lot_id'] ?? 0);
$selectedLot = $_SESSION['lots'][$lotId] ?? null;

// A lot with Confirmed reservations cannot be deleted
$activeReservations = $selectedLot !== null
    ? sp_active_reservation_count($selectedLot['location'])
    : 0;

// Delete only after the Lot Manager confirms
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    $selectedLot !== null &&
    $activeReservations === 0
) {
    unset($_SESSION['lots'][$lotId]);

    header('Location: lot-list.php?deleted=' . urlencode($selectedLot['location']));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Parking Lot | SmartPark Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="sp-page">
<?php
$basePath = '../';
$activePage = 'lots';
require __DIR__ . '/../includes/header.php';
?>

    <main class="container mt-5 mb-5">
        <div class="card mx-auto" style="max-width: 560px;">

            <?php if ($selectedLot === null): ?>

                <!-- Lot not found -->
                <div class="card-body p-4 p-md-5 text-center">
                    <h1 class="h3 mb-3">Unable to delete parking lot</h1>
                    <p class="mb-4">The selected parking lot could not be found.</p>
                    <a href="lot-list.php" class="btn btn-secondary">Back to parking lots</a>
                </div>

            <?php elseif ($activeReservations > 0): ?>

                <!-- Lot still has Confirmed reservations -->
                <div class="card-body p-4 p-md-5 text-center">
                    <h1 class="h3 mb-3">This lot cannot be deleted yet</h1>
                    <p class="mb-2">
                        <strong><?= htmlspecialchars($selectedLot['location']) ?></strong>
                        has <?= $activeReservations ?> confirmed
                        reservation<?= $activeReservations === 1 ? '' : 's' ?>.
                    </p>
                    <p class="text-muted mb-4">
                        Reservations must be completed or cancelled before the lot can be removed.
                    </p>
                    <a href="lot-list.php" class="btn btn-secondary">Back to parking lots</a>
                </div>

            <?php else: ?>

                <!-- Deletion confirmation (lot-delete wireframe) -->
                <div class="card-body p-4 p-md-5 text-center">
                    <h1 class="h3 mb-3">Delete this parking lot?</h1>
                    <p class="mb-2">
                        <?= htmlspecialchars($selectedLot['location']) ?> will be removed.
                    </p>
                    <p class="text-muted mb-4">This action cannot be undone.</p>

                    <form action="lot-delete.php" method="POST" class="d-flex justify-content-center flex-wrap gap-3">
                        <input type="hidden" name="lot_id" value="<?= $lotId ?>">

                        <a href="lot-list.php" class="btn btn-secondary px-4">Cancel</a>

                        <button type="submit" class="btn btn-danger px-4">
                            Delete this lot
                        </button>
                    </form>
                </div>

            <?php endif; ?>

        </div>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
