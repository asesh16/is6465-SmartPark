<?php
// UC-LOT View Parking Lots
// Drivers see availability and can reserve; Lot Managers also see Add, Edit, and Delete

require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/lot-data.php';

// Lot Managers use the manage view unless they choose Find Parking
$manageMode = $isLotManager && (($_GET['mode'] ?? '') !== 'find');

// Filter lots by the search term (matches any part of the location)
$search = trim($_GET['search'] ?? '');
$matchingLots = $parkingLots;

if ($search !== '') {
    $matchingLots = array_filter($parkingLots, function ($lot) use ($search) {
        return stripos($lot['location'], $search) !== false;
    });
}

// Success messages after Add, Update, or Delete
$message = '';

if (isset($_GET['added'])) {
    $message = htmlspecialchars($_GET['added']) . ' was added.';
} elseif (isset($_GET['updated'])) {
    $message = htmlspecialchars($_GET['updated']) . ' was updated.';
} elseif (isset($_GET['deleted'])) {
    $message = htmlspecialchars($_GET['deleted']) . ' was deleted.';
}

$pageTitle = $manageMode ? 'Parking Lots' : 'Find Parking';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> | SmartPark Solutions</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Shared SmartPark CSS -->
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="sp-page">

<?php
$basePath = '../';
$activePage = $manageMode ? 'lots' : 'find';
require __DIR__ . '/../includes/header.php';
?>

    <main class="container mt-5 mb-5">
        <h1><?= $pageTitle ?></h1>

        <p class="text-muted">
            <?= $manageMode
                ? 'Add, update, or remove parking lots so drivers see accurate information.'
                : 'Compare open spots and hourly rates, then reserve a space.' ?>
        </p>

        <?php if ($message !== ''): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <!-- Search field and, for Lot Managers, the link to add a lot -->
        <form action="lot-list.php" method="get" class="d-flex flex-wrap align-items-end gap-3 mb-4">

            <?php if ($isLotManager && !$manageMode): ?>
                <input type="hidden" name="mode" value="find">
            <?php endif; ?>

            <div>
                <label for="lot-search" class="form-label">Find a lot</label>
                <input
                    id="lot-search"
                    name="search"
                    type="search"
                    class="form-control"
                    placeholder="Search parking lots"
                    value="<?= htmlspecialchars($search, ENT_QUOTES) ?>"
                >
            </div>

            <button type="submit" class="btn btn-primary">
                Search
            </button>

            <?php if ($search !== ''): ?>
                <a href="lot-list.php<?= $manageMode || !$isLotManager ? '' : '?mode=find' ?>" class="btn btn-secondary">
                    Clear
                </a>
            <?php endif; ?>

            <?php if ($manageMode): ?>
                <a href="lot-add.php" class="btn btn-primary ms-md-auto">
                    + Add a Lot
                </a>
            <?php endif; ?>

        </form>

        <?php if (empty($matchingLots)): ?>

            <!-- UC-LOT View: no lots found -->
            <div class="alert alert-info">
                No parking lots found<?= $search !== '' ? ' for "' . htmlspecialchars($search) . '"' : '' ?>.
            </div>

        <?php else: ?>

            <!-- Show each lot and pass its ID to the detail, edit, and delete pages -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Location</th>
                            <th scope="col">Available Spots</th>
                            <th scope="col">Hourly Rate</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($matchingLots as $lot): ?>
                            <tr>
                                <td><?= htmlspecialchars($lot['location']) ?></td>
                                <td><?= $lot['available_spots'] ?>/<?= $lot['total_spots'] ?></td>
                                <td>$<?= number_format($lot['hourly_rate'], 2) ?></td>
                                <td>
                                    <a href="lot-details.php?lot_id=<?= $lot['id'] ?>" class="btn btn-primary btn-sm">View</a>

                                    <?php if ($manageMode): ?>
                                        <a href="lot-update.php?lot_id=<?= $lot['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="lot-delete.php?lot_id=<?= $lot['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                    <?php elseif ($lot['available_spots'] <= 0): ?>
                                        <span class="badge bg-secondary">Full</span>
                                    <?php elseif (!$isLotManager): ?>
                                        <a href="../reservation-management/create-reservation.php?lot=<?= urlencode($lot['location']) ?>" class="btn btn-success btn-sm">Reserve</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
