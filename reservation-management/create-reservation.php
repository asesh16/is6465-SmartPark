<?php
// UC-RES-01: Create Parking Reservation
// Load shared reservation data and PHP session

require_once __DIR__ . '/reservation-data.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Reservation | SmartPark</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

            <a href="create-reservation.php" class="active" aria-current="page">Make a Reservation</a>

            <a href="reservations.php">
                View Reservations
            </a>

            <a href="../login.php">Login</a>

        </nav>

    </div>
</header>

<div class="container mt-5">

    <h1>Create Parking Reservation</h1>

    <p class="text-muted">
        Select your parking details to create a new reservation.
    </p>

<form action="reservation-summary.php" method="POST">

    <div class="card mt-4">
        <div class="card-body">

            <h5 class="card-title mb-4">Parking Details</h5>

            <div class="mb-3">
                <label for="parking_lot" class="form-label">
                    Parking Lot
                </label>

                <select
                    class="form-select"
                    id="parking_lot"
                    name="parking_lot"
                    required
                >
                    <option value="">Select a parking lot</option>
                    <option value="Downtown Garage">
                        Downtown Garage - $4.00/hour
                    </option>
                    <option value="Airport Lot B">
                        Airport Lot B - $2.00/hour
                    </option>
                    <option value="Campus Lot 4">
                        Campus Lot 4 - $5.50/hour
                    </option>
                    <option value="State Street Lot 2">
                        State Street Lot 2 - $1.50/hour
                    </option>
                </select>
            </div>

<div class="mb-3">
    <label for="reservation_date" class="form-label">
        Reservation Date
    </label>

    <input
        type="date"
        class="form-control"
        id="reservation_date"
        name="reservation_date"
        min="<?= date('Y-m-d') ?>"
        required
    >
    
<div id="formatted-date" class="form-text">
    Select a date to see the full date format.
</div>

<script>
document.getElementById('reservation_date').addEventListener('change', function () {
    const display = document.getElementById('formatted-date');

    if (!this.value) {
        display.textContent = 'Select a date to see the full date format.';
        return;
    }

    const [year, month, day] = this.value.split('-').map(Number);
    const selectedDate = new Date(year, month - 1, day);

    display.textContent = selectedDate.toLocaleDateString('en-US', {
        month: 'long',
        day: 'numeric',
        year: 'numeric'
    });
});
</script>

</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="start_time" class="form-label">
            Start Time
        </label>

<select
    class="form-select"
    id="start_time"
    name="start_time"
    required
>
    <option value="">Select Start Time</option>

    <?php
    for ($hour = 0; $hour < 24; $hour++) {
        foreach (['00', '30'] as $minute) {
            $timeValue = sprintf('%02d:%s', $hour, $minute);
            $timeLabel = date('g:i A', strtotime($timeValue));

            echo '<option value="' . $timeValue . '">' .
                 $timeLabel . '</option>';
        }
    }
    ?>
</select>

    </div>

    <div class="col-md-6 mb-3">
        <label for="end_time" class="form-label">
            End Time
        </label>

<select
    class="form-select"
    id="end_time"
    name="end_time"
    required
>
    <option value="">Select Start Time</option>

    <?php
    for ($hour = 0; $hour < 24; $hour++) {
        foreach (['00', '30'] as $minute) {
            $timeValue = sprintf('%02d:%s', $hour, $minute);
            $timeLabel = date('g:i A', strtotime($timeValue));

            echo '<option value="' . $timeValue . '">' .
                 $timeLabel . '</option>';
        }
    }
    ?>
</select>

    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="vehicle_plate" class="form-label">
            License Plate Number
        </label>

        <input
            type="text"
            class="form-control"
            id="vehicle_plate"
            name="vehicle_plate"
            placeholder="Example: ABC123"
            maxlength="15"
            required
        >
    </div>

    <div class="col-md-6 mb-3">
        <label for="vehicle_type" class="form-label">
            Vehicle Type
        </label>

        <select
            class="form-select"
            id="vehicle_type"
            name="vehicle_type"
            required
        >
            <option value="">Select vehicle type</option>
            <option value="Sedan">Sedan</option>
            <option value="SUV">SUV</option>
            <option value="Truck">Truck</option>
            <option value="Van">Van</option>
            <option value="Motorcycle">Motorcycle</option>
            <option value="Other">Other</option>
        </select>
    </div>
</div>

        </div>
    </div>

<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-primary">
        Review Reservation
    </button>

    <a href="reservations.php" class="btn btn-secondary">
        Cancel
    </a>
</div>

</form>

</div>

</body>
</html>
