<?php
// SmartPark shared parking lot data
// Used by the lot pages, the reservation pages, and the home page.
// Lots are kept in the PHP session so Add, Update, and Delete work
// until a database is connected.

require_once __DIR__ . '/../includes/session.php';

// Initialize sample lots only once per session
if (!isset($_SESSION['lots'])) {
    $_SESSION['lots'] = [
        1 => ['id' => 1, 'location' => 'Downtown Garage',    'total_spots' => 120, 'available_spots' => 42, 'hourly_rate' => 4.00],
        2 => ['id' => 2, 'location' => 'Airport Lot B',      'total_spots' => 300, 'available_spots' => 8,  'hourly_rate' => 2.00],
        3 => ['id' => 3, 'location' => 'Campus Lot 4',       'total_spots' => 65,  'available_spots' => 0,  'hourly_rate' => 5.50],
        4 => ['id' => 4, 'location' => 'State Street Lot 2', 'total_spots' => 60,  'available_spots' => 33, 'hourly_rate' => 1.50],
    ];
}

// Make lots available to any page that includes this file
$parkingLots = $_SESSION['lots'];

// Find a lot's ID by its location name, or null if it does not exist
function sp_find_lot_id($location)
{
    foreach ($_SESSION['lots'] as $id => $lot) {
        if (strcasecmp($lot['location'], $location) === 0) {
            return $id;
        }
    }
    return null;
}

// True when the named lot has no open spots
function sp_lot_is_full($location)
{
    $id = sp_find_lot_id($location);
    return $id !== null && $_SESSION['lots'][$id]['available_spots'] <= 0;
}

// Add (+1) or release (-1) open spots when reservations change,
// keeping the count between 0 and the lot's total spots
function sp_change_available_spots($location, $change)
{
    $id = sp_find_lot_id($location);

    if ($id === null) {
        return;
    }

    $lot = $_SESSION['lots'][$id];
    $newCount = $lot['available_spots'] + $change;
    $newCount = max(0, min($lot['total_spots'], $newCount));

    $_SESSION['lots'][$id]['available_spots'] = $newCount;
}

// Number of Confirmed reservations at a lot (used before deleting a lot)
function sp_active_reservation_count($location)
{
    $count = 0;

    foreach ($_SESSION['reservations'] ?? [] as $reservation) {
        if ($reservation['lot'] === $location && $reservation['status'] === 'Confirmed') {
            $count++;
        }
    }

    return $count;
}

// Check the Add / Update lot form. Returns field => message errors.
function sp_validate_lot($location, $totalSpots, $hourlyRate, $editingId = null)
{
    $errors = [];

    if ($location === '') {
        $errors['location'] = 'Please enter the lot location.';
    } elseif (strlen($location) > 100) {
        $errors['location'] = 'Location cannot exceed 100 characters.';
    } else {
        $existingId = sp_find_lot_id($location);
        if ($existingId !== null && $existingId !== $editingId) {
            $errors['location'] = 'A parking lot with this location already exists.';
        }
    }

    if ($totalSpots === '' || filter_var($totalSpots, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
        $errors['total_spots'] = 'Total spots must be a whole number of at least 1.';
    }

    if ($hourlyRate === '' || !is_numeric($hourlyRate) || (float) $hourlyRate < 0) {
        $errors['hourly_rate'] = 'Hourly rate must be 0 or more.';
    } elseif ((float) $hourlyRate > 999.99) {
        $errors['hourly_rate'] = 'Hourly rate cannot exceed $999.99.';
    }

    return $errors;
}
