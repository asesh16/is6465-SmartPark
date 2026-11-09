<?php
// Shared summary card (UC-RES-01 Reservation Summary wireframe,
// also used to review changes in UC-RES-03 Edit Reservation)
// Before including, set:
//   $summary     - the six reservation fields
//   $summaryCost - result of sp_validate_reservation (hours, rate, cost)
?>
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Parking Reservation Details</h5>
    </div>

    <div class="card-body">
        <div class="row g-4">

            <div class="col-md-6">
                <h6 class="mb-3">Reservation Details</h6>

                <p><strong>Parking Lot:</strong>
                    <?= htmlspecialchars($summary['parking_lot']) ?>
                </p>

                <p><strong>Reservation Date:</strong>
                    <?= htmlspecialchars(date('F j, Y', strtotime($summary['reservation_date']))) ?>
                </p>

                <p><strong>Start Time:</strong>
                    <?= htmlspecialchars(date('g:i A', strtotime($summary['start_time']))) ?>
                </p>

                <p class="mb-0"><strong>End Time:</strong>
                    <?= htmlspecialchars(date('g:i A', strtotime($summary['end_time']))) ?>
                </p>
            </div>

            <div class="col-md-6">
                <h6 class="mb-3">Vehicle Information</h6>

                <p><strong>License Plate:</strong>
                    <?= htmlspecialchars($summary['vehicle_plate']) ?>
                </p>

                <p class="mb-0"><strong>Vehicle Type:</strong>
                    <?= htmlspecialchars($summary['vehicle_type']) ?>
                </p>
            </div>

        </div>

        <hr>

        <div class="text-center">
            <h6>Estimated Parking Cost</h6>

            <h4 class="text-success mb-1">
                $<?= number_format($summaryCost['cost'], 2) ?>
            </h4>

            <p class="text-muted mb-0">
                <?= rtrim(rtrim(number_format($summaryCost['hours'], 1), '0'), '.') ?> hours
                at $<?= number_format($summaryCost['rate'], 2) ?> per hour
                &middot; based on hourly parking rate
            </p>
        </div>
    </div>
</div>
