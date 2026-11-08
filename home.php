<?php
// SmartPark Home Page
// Entry point for Drivers and Lot Managers

require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/lot-management/lot-data.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home | SmartPark Solutions</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Shared SmartPark CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="sp-page">

<?php
$basePath = '';
$activePage = 'home';
require __DIR__ . '/includes/header.php';
?>

<main>

    <!-- Hero: the main message and the two most common driver tasks -->
    <section class="sp-hero">
        <div class="container">
            <div class="row align-items-center g-5">

                <div class="col-lg-6">
                    <p class="sp-eyebrow">Smart parking for busy drivers</p>

                    <h1 class="sp-hero-title">
                        Find, reserve, and manage parking before you leave home.
                    </h1>

                    <p class="sp-hero-lead">
                        SmartPark shows open spots in real time, lets you reserve a space
                        in advance, and keeps your reservations in one place, so you spend
                        less time circling the block.
                    </p>

                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="lot-management/lot-list.php" class="btn sp-btn-light btn-lg">
                            Find Parking
                        </a>

                        <a href="reservation-management/create-reservation.php" class="btn sp-btn-outline-light btn-lg">
                            Make a Reservation
                        </a>
                    </div>
                </div>

                <!-- Sample availability preview (same sample lots as the lot list) -->
                <div class="col-lg-6">
                    <div class="card sp-availability-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Parking Availability</span>
                            <span class="sp-live-dot">Sample data</span>
                        </div>

                        <ul class="list-group list-group-flush">
                            <?php foreach ($parkingLots as $lot): ?>
                                <li class="list-group-item sp-lot-row">
                                    <div>
                                        <a href="lot-management/lot-details.php?lot_id=<?= $lot['id'] ?>" class="sp-lot-name">
                                            <?= htmlspecialchars($lot['location']) ?>
                                        </a>
                                        <small class="d-block">
                                            $<?= number_format($lot['hourly_rate'], 2) ?> per hour
                                        </small>
                                    </div>

                                    <?php if ($lot['available_spots'] === 0): ?>
                                        <span class="badge sp-badge-full">Full</span>
                                    <?php elseif ($lot['available_spots'] / $lot['total_spots'] < 0.1): ?>
                                        <span class="badge sp-badge-low">
                                            <?= $lot['available_spots'] ?> of <?= $lot['total_spots'] ?> open
                                        </span>
                                    <?php else: ?>
                                        <span class="badge sp-badge-open">
                                            <?= $lot['available_spots'] ?> of <?= $lot['total_spots'] ?> open
                                        </span>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="card-body py-3 text-end">
                            <a href="lot-management/lot-list.php" class="sp-link-arrow">
                                See all parking lots &rarr;
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- How it works: mirrors the Create Reservation activity flow -->
    <section class="container sp-section">
        <h2 class="sp-section-title">How SmartPark works</h2>
        <p class="text-muted sp-section-lead">
            Three steps from searching to parking.
        </p>

        <div class="row g-4 mt-2">

            <div class="col-md-4">
                <div class="card h-100 sp-step-card">
                    <div class="card-body">
                        <span class="sp-step-number">1</span>
                        <h3 class="h5 mt-3">Find a lot</h3>
                        <p class="mb-0">
                            Compare parking lots by location, open spots, and hourly rate
                            before you start driving.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 sp-step-card">
                    <div class="card-body">
                        <span class="sp-step-number">2</span>
                        <h3 class="h5 mt-3">Reserve your spot</h3>
                        <p class="mb-0">
                            Choose a date, start and end time, and vehicle. Review the
                            estimated cost, then confirm your reservation.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 sp-step-card">
                    <div class="card-body">
                        <span class="sp-step-number">3</span>
                        <h3 class="h5 mt-3">Manage your plans</h3>
                        <p class="mb-0">
                            View your reservations at any time, edit a confirmed
                            reservation when plans change, or cancel it to free the space.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Role cards: Driver and Lot Manager entry points -->
    <section class="sp-section-alt">
        <div class="container sp-section">
            <div class="row g-4">

                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">For Drivers</div>
                        <div class="card-body">
                            <ul class="sp-check-list">
                                <li>See real-time parking availability</li>
                                <li>Reserve a parking spot in advance</li>
                                <li>View, edit, or cancel your reservations</li>
                                <li>Know your estimated cost before you confirm</li>
                            </ul>

                            <div class="d-flex flex-wrap gap-2 mt-4">
                                <a href="reservation-management/create-reservation.php" class="btn btn-primary">
                                    Make a Reservation
                                </a>
                                <a href="reservation-management/reservations.php" class="btn btn-secondary">
                                    View My Reservations
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">For Lot Managers</div>
                        <div class="card-body">
                            <ul class="sp-check-list">
                                <li>Add new parking facilities to SmartPark</li>
                                <li>Keep total spots and hourly rates up to date</li>
                                <li>Remove closed or incorrect parking lots</li>
                                <li>Review upcoming reservations for your lots</li>
                            </ul>

                            <div class="d-flex flex-wrap gap-2 mt-4">
                                <?php if ($isLotManager): ?>
                                    <a href="lot-management/lot-list.php" class="btn btn-primary">
                                        Manage Lots
                                    </a>
                                    <a href="lot-management/lot-add.php" class="btn btn-secondary">
                                        Add a Lot
                                    </a>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-primary">
                                        Lot Manager Login
                                    </a>
                                    <a href="lot-management/lot-list.php" class="btn btn-secondary">
                                        View Parking Lots
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Benefits from the project proposal -->
    <section class="container sp-section">
        <h2 class="sp-section-title">Why it matters</h2>

        <div class="row g-4 mt-2">
            <div class="col-sm-6 col-lg-3">
                <div class="sp-benefit">
                    <h3 class="h6">Less time searching</h3>
                    <p>Drivers go straight to a lot with open spots.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="sp-benefit">
                    <h3 class="h6">Reduced congestion</h3>
                    <p>Fewer cars circling the block means smoother traffic.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="sp-benefit">
                    <h3 class="h6">Lower emissions</h3>
                    <p>Less driving around saves fuel and cuts emissions.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="sp-benefit">
                    <h3 class="h6">Better experience</h3>
                    <p>Availability, booking, and pricing in one place.</p>
                </div>
            </div>
        </div>
    </section>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
