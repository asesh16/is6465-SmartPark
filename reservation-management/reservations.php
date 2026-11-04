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
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Shared SmartPark CSS -->
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<!-- SmartPark Customer Navigation -->
<header class="smartpark-header">
    <div class="container smartpark-navbar">

        <a href="../home.php" class="smartpark-brand">
            SmartPark Solutions
        </a>

        <nav class="smartpark-nav-links" aria-label="Main navigation">

            <a href="../home.php">Home</a>

            <a href="../home.php">Find Parking</a>

            <a href="reservations.php" class="active" aria-current="page">
                My Reservations
            </a>

            <a href="../login.php">Login</a>

        </nav>

    </div>
</header>

    <div class="container mt-5">
        
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">My Reservations</h1>

    <a href="create-reservation.php" class="btn btn-primary">
        + Create Reservation
    </a>
</div>
        <p class="text-muted">
            View and manage your parking reservations.
        </p>

<div class="table-responsive mt-4"> 
<div class="table-responsive">
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

                        <?php if ($reservation['status'] === 'Confirmed'): ?>
                            <a href="edit-reservation.php?id=<?= urlencode($reservation['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="cancel-reservation.php?id=<?= urlencode($reservation['id']) ?>" class="btn btn-danger btn-sm">Cancel</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>
    </div>

</body>
</html>
