<?php
// UC-LOT Add Parking Lot
// Only Lot Managers may use this page
require_once __DIR__ . '/../includes/require-manager.php';
require_once __DIR__ . '/lot-data.php';

$location = '';
$totalSpots = '';
$hourlyRate = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Receive the submitted lot details
    $location = trim($_POST['location'] ?? '');
    $totalSpots = trim($_POST['total_spots'] ?? '');
    $hourlyRate = trim($_POST['hourly_rate'] ?? '');

    // Validate submitted values
    $errors = sp_validate_lot($location, $totalSpots, $hourlyRate);

    // Save the lot and show the updated lot list
    if (empty($errors)) {
        $newId = empty($_SESSION['lots']) ? 1 : max(array_keys($_SESSION['lots'])) + 1;

        // A new lot starts with every spot available
        $_SESSION['lots'][$newId] = [
            'id' => $newId,
            'location' => $location,
            'total_spots' => (int) $totalSpots,
            'available_spots' => (int) $totalSpots,
            'hourly_rate' => round((float) $hourlyRate, 2)
        ];

        header('Location: lot-list.php?added=' . urlencode($location));
        exit;
    }
}

// Bootstrap class and message for a field with an error
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
    <title>Add a Parking Lot | SmartPark Solutions</title>
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
        <h1>Add a Parking Lot</h1>

        <!-- Collect the details for a new lot. -->
        <div class="card mt-4" style="max-width: 720px;">
            <div class="card-body">

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        Please correct the highlighted fields.
                    </div>
                <?php endif; ?>

                <form action="lot-add.php" method="POST" novalidate>

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

                    <!-- Availability is managed by reservations, so it cannot be entered here. -->
                    <div class="mb-3">
                        <label for="available-spots" class="form-label">Available spots</label>
                        <input
                            id="available-spots"
                            type="text"
                            class="form-control"
                            value="--"
                            readonly
                            aria-describedby="availability-note"
                        >
                        <div id="availability-note" class="form-text">
                            This field updates as reservations are made. A new lot starts with all spots available.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="hourly-rate" class="form-label">Hourly rate</label>
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

                    <!-- Return to the lot list or save the new lot -->
                    <div class="d-flex flex-wrap gap-2">
                        <a href="lot-list.php" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save parking lot</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
