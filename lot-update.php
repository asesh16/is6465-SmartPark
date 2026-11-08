<?php
// UC-LOT Update Parking Lot
// Only Lot Managers may use this page
require_once __DIR__ . '/../includes/require-manager.php';
require_once __DIR__ . '/../reservation-management/reservation-data.php';

// Find the lot to edit from the URL or the submitted form
$lotId = (int) ($_POST['lot_id'] ?? $_GET['lot_id'] ?? 0);
$selectedLot = $_SESSION['lots'][$lotId] ?? null;

$errors = [];

if ($selectedLot !== null) {

    // Start with the lot's current values
    $location = $selectedLot['location'];
    $totalSpots = (string) $selectedLot['total_spots'];
    $hourlyRate = number_format($selectedLot['hourly_rate'], 2, '.', '');

    // Spots currently taken by reservations
    $spotsInUse = $selectedLot['total_spots'] - $selectedLot['available_spots'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Receive the edited values
        $location = trim($_POST['location'] ?? '');
        $totalSpots = trim($_POST['total_spots'] ?? '');
        $hourlyRate = trim($_POST['hourly_rate'] ?? '');

        // Validate submitted values
        $errors = sp_validate_lot($location, $totalSpots, $hourlyRate, $lotId);

        if (!isset($errors['total_spots']) && (int) $totalSpots < $spotsInUse) {
            $errors['total_spots'] = 'Total spots cannot be less than the ' . $spotsInUse . ' spots currently in use.';
        }

        // Save the lot and show the updated lot list
        if (empty($errors)) {
            $oldLocation = $selectedLot['location'];

            $_SESSION['lots'][$lotId]['location'] = $location;
            $_SESSION['lots'][$lotId]['total_spots'] = (int) $totalSpots;
            $_SESSION['lots'][$lotId]['available_spots'] = (int) $totalSpots - $spotsInUse;
            $_SESSION['lots'][$lotId]['hourly_rate'] = round((float) $hourlyRate, 2);

            // Keep existing reservations linked to a renamed lot
            if ($oldLocation !== $location) {
                foreach ($_SESSION['reservations'] as $index => $reservation) {
                    if ($reservation['lot'] === $oldLocation) {
                        $_SESSION['reservations'][$index]['lot'] = $location;
                    }
                }
            }

            header('Location: lot-list.php?updated=' . urlencode($location));
            exit;
        }
    }
}

// Bootstrap class for a field with an error
function sp_field_class(array $errors, $field)
{
    return isset($errors[$field]) ? ' is-invalid' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Parking Lot | SmartPark Solutions</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Shared SmartPark CSS -->
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body class="sp-page">

<?php
$basePath = '../';
$activePage = 'lots';
require __DIR__ . '/../includes/header.php';
?>

    <main class="container mt-5 mb-5">

        <?php if ($selectedLot === null): ?>

            <h1 class="mb-4">Edit a Parking Lot</h1>

            <div class="alert alert-danger">
                The selected parking lot could not be found.
            </div>

            <a href="lot-list.php" class="btn btn-secondary">Back to parking lots</a>

        <?php else: ?>

            <h1 class="mb-2">Editing <?= htmlspecialchars($selectedLot['location']) ?></h1>
            <p class="text-muted mb-4">
                Update parking lot information below. Available spaces are automatically managed by the reservation system.
            </p>

            <div class="card" style="max-width: 720px;">
                <div class="card-body p-4">

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            Please correct the highlighted fields.
                        </div>
                    <?php endif; ?>

                    <form action="lot-update.php" method="POST" novalidate>

                        <input type="hidden" name="lot_id" value="<?= $lotId ?>">

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input
                                id="location"
                                name="location"
                                type="text"
                                class="form-control<?= sp_field_class($errors, 'location') ?>"
                                maxlength="100"
                                value="<?= htmlspecialchars($location, ENT_QUOTES) ?>"
                                required
                            >
                            <?php if (isset($errors['location'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['location']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="total-spots" class="form-label">Total Spots</label>
                            <input
                                id="total-spots"
                                name="total_spots"
                                type="number"
                                class="form-control<?= sp_field_class($errors, 'total_spots') ?>"
                                min="1"
                                step="1"
                                value="<?= htmlspecialchars($totalSpots, ENT_QUOTES) ?>"
                                required
                            >
                            <?php if (isset($errors['total_spots'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['total_spots']) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="available-spots" class="form-label">Available Spots</label>
                            <input
                                id="available-spots"
                                type="number"
                                class="form-control"
                                value="<?= $selectedLot['available_spots'] ?>"
                                readonly
                                aria-describedby="availability-note"
                            >
                            <div id="availability-note" class="form-text">
                                This field updates as reservations are made.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="hourly-rate" class="form-label">Hourly Rate ($)</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text">$</span>
                                <input
                                    id="hourly-rate"
                                    name="hourly_rate"
                                    type="number"
                                    class="form-control<?= sp_field_class($errors, 'hourly_rate') ?>"
                                    min="0"
                                    step="0.01"
                                    value="<?= htmlspecialchars($hourlyRate, ENT_QUOTES) ?>"
                                    required
                                >
                                <?php if (isset($errors['hourly_rate'])): ?>
                                    <div class="invalid-feedback"><?= htmlspecialchars($errors['hourly_rate']) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="lot-list.php" class="btn btn-secondary">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Save parking lot
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        <?php endif; ?>

    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
