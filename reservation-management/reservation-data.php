<?php
// SmartPark shared reservation data
// Used by all Parking Reservation Management pages

// Start a PHP session if one is not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
?>
