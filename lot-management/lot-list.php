<?php require __DIR__ . '/lot-data.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Lots | SmartPark Solutions</title>
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
        <h1>Parking Lots</h1>

        <form action="lot-list.php" method="get">
            <label for="lot-search">Find a lot</label>
            <input id="lot-search" name="search" type="search" placeholder="Find a lot">
            <button type="submit">Search</button>
            <a href="lot-add.php">Add a lot</a>
        </form>

        <table>
            <thead>
                <tr>
                    <th scope="col">Location</th>
                    <th scope="col">Available Spots</th>
                    <th scope="col">Hourly Rate</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lots as $lot): ?>
                    <tr>
                        <td><?= htmlspecialchars($lot['location'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= (int) $lot['available'] ?>/<?= (int) $lot['total'] ?></td>
                        <td>$<?= htmlspecialchars($lot['rate'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <a href="lot-details.php?id=<?= (int) $lot['id'] ?>">View</a>
                            <a href="lot-update.php?id=<?= (int) $lot['id'] ?>">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>