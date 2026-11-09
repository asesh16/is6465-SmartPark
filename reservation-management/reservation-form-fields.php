<?php
// Shared reservation form fields (UC-RES-01 Create and UC-RES-03 Edit)
// Before including, set:
//   $formValues   - the six reservation fields (from sp_read_reservation_input)
//   $currentLot   - (optional) the reservation's existing lot, selectable even if full
//   $submitLabel  - text of the submit button, e.g. 'Review Reservation'
//   $cancelUrl    - where the Cancel button goes
// Uses $parkingLots and $validVehicleTypes from reservation-data.php

$currentLot = $currentLot ?? '';

// 30-minute time options from 12:00 AM to 11:30 PM
$timeOptions = [];
for ($hour = 0; $hour < 24; $hour++) {
    foreach (['00', '30'] as $minute) {
        $timeOptions[] = sprintf('%02d:%s', $hour, $minute);
    }
}
?>
<div class="row">

    <!-- Parking Lot -->
    <div class="col-md-6 mb-3">
        <label for="parking_lot" class="form-label">
            Select Parking Lot
        </label>

        <select class="form-select" id="parking_lot" name="parking_lot" required>
            <option value="">Choose a parking lot</option>

            <?php foreach ($parkingLots as $lot): ?>
                <?php $isFull = $lot['available_spots'] <= 0 && $lot['location'] !== $currentLot; ?>
                <option
                    value="<?= htmlspecialchars($lot['location'], ENT_QUOTES) ?>"
                    data-rate="<?= number_format($lot['hourly_rate'], 2, '.', '') ?>"
                    <?= $formValues['parking_lot'] === $lot['location'] ? 'selected' : '' ?>
                    <?= $isFull ? 'disabled' : '' ?>
                >
                    <?= htmlspecialchars($lot['location']) ?> -
                    $<?= number_format($lot['hourly_rate'], 2) ?>/hour<?= $isFull ? ' (Full)' : '' ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Reservation Date -->
    <div class="col-md-6 mb-3">
        <label for="reservation_date" class="form-label">
            Reservation Date
        </label>

        <input
            type="date"
            class="form-control"
            id="reservation_date"
            name="reservation_date"
            value="<?= htmlspecialchars($formValues['reservation_date'], ENT_QUOTES) ?>"
            min="<?= date('Y-m-d') ?>"
            required
        >

        <div id="formatted-date" class="form-text">
            Select a date to see the full date format.
        </div>
    </div>

    <!-- Start Time -->
    <div class="col-md-6 mb-3">
        <label for="start_time" class="form-label">
            Start Time
        </label>

        <select class="form-select" id="start_time" name="start_time" required>
            <option value="">Select start time</option>
            <?php foreach ($timeOptions as $time): ?>
                <option value="<?= $time ?>" <?= $formValues['start_time'] === $time ? 'selected' : '' ?>>
                    <?= date('g:i A', strtotime($time)) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- End Time -->
    <div class="col-md-6 mb-3">
        <label for="end_time" class="form-label">
            End Time
        </label>

        <select class="form-select" id="end_time" name="end_time" required>
            <option value="">Select end time</option>
            <?php foreach ($timeOptions as $time): ?>
                <option value="<?= $time ?>" <?= $formValues['end_time'] === $time ? 'selected' : '' ?>>
                    <?= date('g:i A', strtotime($time)) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- License Plate -->
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
            value="<?= htmlspecialchars($formValues['vehicle_plate'], ENT_QUOTES) ?>"
            required
        >
    </div>

    <!-- Vehicle Type -->
    <div class="col-md-6 mb-3">
        <label for="vehicle_type" class="form-label">
            Vehicle Type
        </label>

        <select class="form-select" id="vehicle_type" name="vehicle_type" required>
            <option value="">Select vehicle type</option>
            <?php foreach ($validVehicleTypes as $type): ?>
                <option value="<?= $type ?>" <?= $formValues['vehicle_type'] === $type ? 'selected' : '' ?>>
                    <?= $type ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

</div>

<!-- Estimated cost and buttons (Create / Edit Reservation wireframes) -->
<div class="row g-3 align-items-stretch mt-1">
    <div class="col-md-7">
        <div class="sp-cost-box" aria-live="polite">
            <div class="sp-cost-label">Estimated Parking Cost</div>
            <div id="estimated-cost" class="sp-cost-value">$--.--</div>
            <div id="estimated-cost-note" class="sp-cost-note">
                Based on the selected parking lot and reservation duration.
            </div>
        </div>
    </div>

    <div class="col-md-5 d-grid gap-2 align-content-center">
        <button type="submit" class="btn btn-primary">
            <?= htmlspecialchars($submitLabel) ?>
        </button>

        <a href="<?= htmlspecialchars($cancelUrl, ENT_QUOTES) ?>" class="btn btn-secondary">
            Cancel
        </a>
    </div>
</div>

<script>
// Show the reservation date in a readable format, e.g. November 10, 2026
function updateFormattedDate() {
    const dateInput = document.getElementById('reservation_date');
    const display = document.getElementById('formatted-date');

    if (!dateInput.value) {
        display.textContent = 'Select a date to see the full date format.';
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

// Update the Estimated Parking Cost box as the driver fills in the form
function updateEstimatedCost() {
    const lot = document.getElementById('parking_lot');
    const start = document.getElementById('start_time').value;
    const end = document.getElementById('end_time').value;
    const costDisplay = document.getElementById('estimated-cost');
    const costNote = document.getElementById('estimated-cost-note');

    const selected = lot.options[lot.selectedIndex];
    const rate = selected ? parseFloat(selected.dataset.rate) : NaN;

    if (!lot.value || !start || !end || isNaN(rate)) {
        costDisplay.textContent = '$--.--';
        costNote.textContent = 'Based on the selected parking lot and reservation duration.';
        return;
    }

    const toMinutes = time => {
        const [hours, minutes] = time.split(':').map(Number);
        return hours * 60 + minutes;
    };

    const hours = (toMinutes(end) - toMinutes(start)) / 60;

    if (hours <= 0) {
        costDisplay.textContent = '$--.--';
        costNote.textContent = 'End time must be later than start time.';
        return;
    }

    costDisplay.textContent = '$' + (hours * rate).toFixed(2);
    costNote.textContent = hours + ' hour' + (hours === 1 ? '' : 's') + ' at $' + rate.toFixed(2) + ' per hour.';
}

document.addEventListener('DOMContentLoaded', () => {
    ['parking_lot', 'start_time', 'end_time'].forEach(id => {
        document.getElementById(id).addEventListener('change', updateEstimatedCost);
    });
    document.getElementById('reservation_date').addEventListener('change', updateFormattedDate);

    updateFormattedDate();
    updateEstimatedCost();
});
</script>
