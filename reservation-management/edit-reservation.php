<?php
// UC-RES-03: Edit Parking Reservation
// Retrieve an existing reservation for editing

require_once __DIR__ . '/reservation-data.php';

// Get the reservation ID from the URL
$reservationId = $_GET['id'] ?? '';

// Find the matching reservation
$selectedReservation = null;

foreach ($reservations as $reservation) {
    if ($reservation['id'] === $reservationId) {
        $selectedReservation = $reservation;
        break;
    }
}

// Only confirmed reservations can be edited
if (
    $selectedReservation === null ||
    $selectedReservation['status'] !== 'Confirmed'
) {
    header('Location: reservations.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Reservation | SmartPark</title>

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

            <a href="../home.php">Find Parking</a>

            <a href="reservations.php" class="active" aria-current="page">
                My Reservations
            </a>

            <a href="../login.php">Login</a>

        </nav>

    </div>
</header>

<div class="container mt-5">

    <h1>Edit Parking Reservation</h1>

    <p class="text-muted">
        Update the details of your existing parking reservation.
    </p>

    <div class="card mt-4">
        <div class="card-body">

            <h5 class="mb-3">
                Reservation ID:
                <?= htmlspecialchars($selectedReservation['id']) ?>
            </h5>

            <form action="update-reservation.php" method="POST">

                <input
                    type="hidden"
                    name="reservation_id"
                    value="<?= htmlspecialchars($selectedReservation['id'], ENT_QUOTES) ?>"
                >

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
                        <?php
                        $parkingLots = [
                            'Downtown Garage',
                            'Airport Lot B',
                            'Campus Lot 4',
                            'State Street Lot 2'
                        ];

                        foreach ($parkingLots as $lot):
                        ?>
                            <option
                                value="<?= htmlspecialchars($lot, ENT_QUOTES) ?>"
                                <?= $selectedReservation['lot'] === $lot ? 'selected' : '' ?>
                            >
                                <?= htmlspecialchars($lot) ?>
                            </option>
                        <?php endforeach; ?>
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
        value="<?= htmlspecialchars($selectedReservation['date'], ENT_QUOTES) ?>"
        min="<?= date('Y-m-d') ?>"
        required
    >

    <div id="formatted-date" class="form-text"></div>
</div>

<script>
function updateFormattedDate() {
    const dateInput = document.getElementById('reservation_date');
    const display = document.getElementById('formatted-date');

    if (!dateInput.value) {
        display.textContent = '';
        return;
    }

    const [year, month, day] = dateInput.value.split('-').map(Number);
    const selectedDate = new Date(year, month - 1, day);

    display.textContent = selectedDate.toLocaleDateString('en-US', {
        month: 'long',
        day: 'numeric',
        year: 'numeric'
    });
}

document.getElementById('reservation_date')
    .addEventListener('change', updateFormattedDate);

updateFormattedDate();
</script>


<div class="row">

    <!-- Start Time -->
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
            <?php
            for ($hour = 0; $hour < 24; $hour++) {
                foreach (['00', '30'] as $minute) {
                    $timeValue = sprintf('%02d:%s', $hour, $minute);
                    $timeLabel = date('g:i A', strtotime($timeValue));
                    $selected = $selectedReservation['start_time'] === $timeValue
                        ? 'selected'
                        : '';

                    echo '<option value="' . $timeValue . '" ' . $selected . '>' .
                         $timeLabel . '</option>';
                }
            }
            ?>
        </select>
    </div>

    <!-- End Time -->
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
            <?php
            for ($hour = 0; $hour < 24; $hour++) {
                foreach (['00', '30'] as $minute) {
                    $timeValue = sprintf('%02d:%s', $hour, $minute);
                    $timeLabel = date('g:i A', strtotime($timeValue));
                    $selected = $selectedReservation['end_time'] === $timeValue
                        ? 'selected'
                        : '';

                    echo '<option value="' . $timeValue . '" ' . $selected . '>' .
                         $timeLabel . '</option>';
                }
            }
            ?>
        </select>
    </div>

</div>


<!-- License Plate -->
<div class="mb-3">
    <label for="vehicle_plate" class="form-label">
        License Plate
    </label>

    <input
        type="text"
        class="form-control"
        id="vehicle_plate"
        name="vehicle_plate"
        maxlength="15"
        value="<?= htmlspecialchars($selectedReservation['vehicle_plate'], ENT_QUOTES) ?>"
        required
    >
</div>

<!-- Vehicle Type -->
<div class="mb-3">
    <label for="vehicle_type" class="form-label">
        Vehicle Type
    </label>

    <select
        class="form-select"
        id="vehicle_type"
        name="vehicle_type"
        required
    >
        <?php
        $vehicleTypes = [
            'Sedan',
            'SUV',
            'Truck',
            'Van',
            'Motorcycle',
            'Other'
        ];

        foreach ($vehicleTypes as $type):
        ?>
            <option
                value="<?= htmlspecialchars($type, ENT_QUOTES) ?>"
                <?= $selectedReservation['vehicle_type'] === $type ? 'selected' : '' ?>
            >
                <?= htmlspecialchars($type) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


<div class="d-flex gap-2 mt-4">

    <button type="submit" class="btn btn-success">
        Save Changes
    </button>

    <a href="reservations.php" class="btn btn-secondary">
        Cancel
    </a>

</div>

            </form>

        </div>
    </div>

</div>

</body>
</html>

