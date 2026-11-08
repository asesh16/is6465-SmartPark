<?php
// UC-RES-02: View Parking Reservations
// Load shared reservation data from the PHP session

require_once __DIR__ . '/reservation-data.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations | SmartPark</title>

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
        
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <h1 class="mb-0"><?= $isLotManager ? 'All Reservations' : 'My Reservations' ?></h1>

</div>
        <p class="text-muted">
            <?= $isLotManager
                ? 'Review upcoming reservations for SmartPark parking lots.'
                : 'View and manage your parking reservations.' ?>
        </p>

<?php if (empty($reservations)): ?>

    <!-- UC-RES-02: no reservations available -->
    <div class="card mt-4">
        <div class="card-body text-center p-5">
            <h2 class="h4">You have no parking reservations yet</h2>
            <p class="text-muted">Create a reservation to see it here.</p>
            <div class="d-flex justify-content-center flex-wrap gap-2">
                <a href="create-reservation.php" class="btn btn-primary">Create New Reservation</a>
                <a href="../home.php" class="btn btn-secondary">Return Home</a>
            </div>
        </div>
    </div>

<?php else: ?>

<div class="table-responsive mt-4">
    <table class="table table-striped table-hover align-middle">
        <thead>
            <tr>
                <th>Reservation ID</th>
                <th>Parking Lot</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Cost</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?= htmlspecialchars($reservation['id']) ?></td>
                    <td><?= htmlspecialchars($reservation['lot']) ?></td>
                    <td><?= htmlspecialchars(date('F j, Y', strtotime($reservation['date']))) ?></td>   
                    <td><?= htmlspecialchars(date('g:i A', strtotime($reservation['start_time']))) ?></td>
                    <td><?= htmlspecialchars(date('g:i A', strtotime($reservation['end_time']))) ?></td>
                    <td>$<?= number_format($reservation['cost'], 2) ?></td>
                    <td>
                        <?php if ($reservation['status'] === 'Confirmed'): ?>
                            <span class="badge bg-success">Confirmed</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Cancelled</span>
                        <?php endif; ?>
                    </td>
                    <td>                  
                        <a href="reservation-details.php?id=<?= urlencode($reservation['id']) ?>"
                        class="btn btn-sm btn-primary">View</a>

                        <?php if ($reservation['status'] === 'Confirmed' && !$isLotManager): ?>
                            <a href="edit-reservation.php?id=<?= urlencode($reservation['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="cancel-reservation.php?id=<?= urlencode($reservation['id']) ?>" class="btn btn-danger btn-sm">Cancel</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- My Reservations wireframe: actions below the table -->
<div class="d-flex justify-content-center flex-wrap gap-3 mt-4 mb-5">
    <?php if (!$isLotManager): ?>
        <a href="create-reservation.php" class="btn btn-primary">
            Create New Reservation
        </a>
    <?php endif; ?>

    <a href="../home.php" class="btn btn-secondary">
        Return to Home
    </a>
</div>

<?php endif; ?>
    </div>

<?php require __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
