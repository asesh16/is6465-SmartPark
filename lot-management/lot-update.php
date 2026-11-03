<?php
require __DIR__ . '/lot-data.php';

if ($lot === null) {
    http_response_code(404);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lot !== null ? 'Edit ' . htmlspecialchars($lot['location'], ENT_QUOTES, 'UTF-8') : 'Parking Lot Not Found' ?> | SmartPark Solutions</title>
</head>
<body>
    <header>
        <a href="../home.php">SmartPark Solutions</a>
        <nav aria-label="Main navigation">
            <a href="../home.php">Home</a>
            <a href="lot-list.php" aria-current="page">Manage Lots</a>
            <a href="../home.php">Find Parking</a>
            <a href="../login.php">Login</a>
        </nav>
    </header>

    <main>
        <?php if ($lot === null): ?>
            <h1>Parking lot not found</h1>
            <p><a href="lot-list.php">Back to parking lots</a></p>
        <?php else: ?>
        <h1>Editing <?= htmlspecialchars($lot['location'], ENT_QUOTES, 'UTF-8') ?></h1>
        <form action="lot-list.php" method="post">
            <input type="hidden" name="lot_id" value="<?= (int) $lot['id'] ?>">
            <p>
                <label for="location">Location</label><br>
                <input id="location" name="location" type="text" value="<?= htmlspecialchars($lot['location'], ENT_QUOTES, 'UTF-8') ?>" required>
            </p>
            <p>
                <label for="total-spots">Total Spots</label><br>
                <input id="total-spots" name="total_spots" type="number" min="1" step="1" value="<?= (int) $lot['total'] ?>" required>
            </p>
            <p>
                <label for="available-spots">Available spots</label>
                <small id="availability-note">This field updates as reservations are made.</small><br>
                <input id="available-spots" name="available_spots" type="number" value="<?= (int) $lot['available'] ?>" readonly aria-describedby="availability-note">
            </p>
            <p>
                <label for="hourly-rate">Hourly rate</label><br>
                $<input id="hourly-rate" name="hourly_rate" type="number" min="0" step="0.01" value="<?= htmlspecialchars($lot['rate'], ENT_QUOTES, 'UTF-8') ?>" required>
            </p>
            <p>
                <a href="lot-list.php">Cancel</a>
                <button type="submit">Save parking lot</button>
            </p>
        </form>
        <?php endif; ?>
    </main>
</body>
</html>