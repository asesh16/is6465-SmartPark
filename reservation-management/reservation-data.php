<?php
// SmartPark shared reservation data
// Used by all Parking Reservation Management pages

// Start the shared SmartPark session (also loads the logged-in user)
require_once __DIR__ . '/../includes/session.php';

// Parking lots and hourly rates come from Parking Lot Management
require_once __DIR__ . '/../lot-management/lot-data.php';

// Initialize sample reservations only once per session
if (!isset($_SESSION['reservations'])) {
    $_SESSION['reservations'] = [
        [
            'id' => 'RES-1001',
            'lot' => 'Downtown Garage',
            'date' => '2026-11-10',
            'start_time' => '09:00',
            'end_time' => '11:00',
            'vehicle_plate' => 'ABC123',
            'vehicle_type' => 'Sedan',
            'cost' => 8.00,
            'status' => 'Confirmed'
        ],
        [
            'id' => 'RES-1002',
            'lot' => 'Airport Lot B',
            'date' => '2026-11-12',
            'start_time' => '13:00',
            'end_time' => '16:00',
            'vehicle_plate' => 'XYZ789',
            'vehicle_type' => 'SUV',
            'cost' => 6.00,
            'status' => 'Confirmed'
        ],
        [
            'id' => 'RES-1003',
            'lot' => 'Campus Lot 4',
            'date' => '2026-11-14',
            'start_time' => '10:00',
            'end_time' => '12:00',
            'vehicle_plate' => 'UTAH456',
            'vehicle_type' => 'Truck',
            'cost' => 11.00,
            'status' => 'Cancelled'
        ]
    ];
}

// Make reservations available to any page that includes this file
$reservations = $_SESSION['reservations'];

// Hourly rate for each lot, e.g. ['Downtown Garage' => 4.00, ...]
$parkingRates = [];
foreach ($parkingLots as $lot) {
    $parkingRates[$lot['location']] = $lot['hourly_rate'];
}

// Valid vehicle types
$validVehicleTypes = ['Sedan', 'SUV', 'Truck', 'Van', 'Motorcycle', 'Other'];

// Find a reservation's position in the session array, or null
function sp_find_reservation_index($reservationId)
{
    foreach ($_SESSION['reservations'] as $index => $reservation) {
        if ($reservation['id'] === $reservationId) {
            return $index;
        }
    }
    return null;
}

// Read the six reservation fields from a submitted form
function sp_read_reservation_input(array $source)
{
    return [
        'parking_lot' => trim($source['parking_lot'] ?? ''),
        'reservation_date' => trim($source['reservation_date'] ?? ''),
        'start_time' => trim($source['start_time'] ?? ''),
        'end_time' => trim($source['end_time'] ?? ''),
        'vehicle_plate' => strtoupper(trim($source['vehicle_plate'] ?? '')),
        'vehicle_type' => trim($source['vehicle_type'] ?? '')
    ];
}

// Validate a new or edited reservation and calculate its cost.
// $editingId: the reservation being edited (excluded from the overlap check)
// $originalLot: an edited reservation may stay at its current lot even if that lot is now full
// Returns ['errors' => [...], 'hours' => float, 'rate' => float, 'cost' => float]
function sp_validate_reservation(array $input, $editingId = null, $originalLot = null)
{
    global $parkingRates, $validVehicleTypes;

    $errors = [];
    $lot = $input['parking_lot'];
    $date = $input['reservation_date'];
    $start = $input['start_time'];
    $end = $input['end_time'];
    $plate = $input['vehicle_plate'];
    $type = $input['vehicle_type'];

    // Required fields
    if ($lot === '' || $date === '' || $start === '' || $end === '' || $plate === '' || $type === '') {
        $errors[] = 'Please complete all required fields.';
    }

    // Parking lot must exist and have open spots
    if ($lot !== '' && !array_key_exists($lot, $parkingRates)) {
        $errors[] = 'Please select a valid parking lot.';
    } elseif ($lot !== '' && $lot !== $originalLot && sp_lot_is_full($lot)) {
        $errors[] = $lot . ' is full. Please choose another parking lot.';
    }

    // Reservation date must be valid and not in the past
    if ($date !== '') {
        $parsedDate = DateTimeImmutable::createFromFormat('!Y-m-d', $date);

        if (!$parsedDate || $parsedDate->format('Y-m-d') !== $date) {
            $errors[] = 'Please enter a valid reservation date.';
        } elseif ($date < date('Y-m-d')) {
            $errors[] = 'Reservation dates cannot be in the past.';
        }
    }

    // Times use 30-minute increments and end after they start
    $validTimeFormat = '/^([01][0-9]|2[0-3]):(00|30)$/';

    if ($start !== '' && $end !== '') {
        if (!preg_match($validTimeFormat, $start) || !preg_match($validTimeFormat, $end)) {
            $errors[] = 'Reservations must start and end on the hour or half-hour.';
        } elseif ($end <= $start) {
            $errors[] = 'End time must be later than start time.';
        }
    }

    // License plate length
    if (strlen($plate) > 15) {
        $errors[] = 'License plate cannot exceed 15 characters.';
    }

    // Vehicle type
    if ($type !== '' && !in_array($type, $validVehicleTypes, true)) {
        $errors[] = 'Please select a valid vehicle type.';
    }

    // Simulated availability check: an overlapping Confirmed reservation
    // at the same lot and date makes the requested time unavailable
    if (empty($errors)) {
        foreach ($_SESSION['reservations'] as $existing) {
            if ($existing['id'] === $editingId || $existing['status'] !== 'Confirmed') {
                continue;
            }

            if (
                $existing['lot'] === $lot &&
                $existing['date'] === $date &&
                $start < $existing['end_time'] &&
                $end > $existing['start_time']
            ) {
                $errors[] = 'This parking lot is unavailable during the selected time. Please choose another time or parking lot.';
                break;
            }
        }
    }

    // Estimated cost = hours x hourly rate
    $hours = 0;
    $rate = 0;
    $cost = 0;

    if (empty($errors)) {
        $hours = (strtotime($date . ' ' . $end) - strtotime($date . ' ' . $start)) / 3600;
        $rate = $parkingRates[$lot];
        $cost = round($hours * $rate, 2);
    }

    return ['errors' => $errors, 'hours' => $hours, 'rate' => $rate, 'cost' => $cost];
}

// Hidden form fields that carry reservation details to the next step
function sp_hidden_reservation_fields(array $input)
{
    $html = '';

    foreach ($input as $name => $value) {
        $html .= '<input type="hidden" name="' . htmlspecialchars($name, ENT_QUOTES) .
                 '" value="' . htmlspecialchars($value, ENT_QUOTES) . "\">\n";
    }

    return $html;
}
