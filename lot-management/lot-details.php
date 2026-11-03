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
    <title><?= $lot !== null ? htmlspecialchars($lot['location'], ENT_QUOTES, 'UTF-8') : 'Parking Lot Not Found' ?> | SmartPark Solutions</title>
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
        <?php else: ?>
        <h1><?= htmlspecialchars($lot['location'], ENT_QUOTES, 'UTF-8') ?></h1>
        <dl>
            <dt>Location</dt>
            <dd><?= htmlspecialchars($lot['location'], ENT_QUOTES, 'UTF-8') ?></dd>
            <dt>Total Spots</dt>
            <dd><?= (int) $lot['total'] ?></dd>
            <dt>Available spots</dt>
            <dd><?= (int) $lot['available'] ?></dd>
            <dt>Hourly rate</dt>
            <dd>$<?= htmlspecialchars($lot['rate'], ENT_QUOTES, 'UTF-8') ?></dd>
        </dl>
        <p>
            <a href="lot-update.php?id=<?= (int) $lot['id'] ?>">Edit parking lot</a>
            <button type="button">Delete this parking lot</button>
        </p>
        <?php endif; ?>
        <p><a href="lot-list.php">Back to parking lots</a></p>
    </main>
</body>
</html>