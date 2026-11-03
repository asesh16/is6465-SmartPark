<?php
$lots = [
    ['id' => 1, 'location' => 'Downtown Garage', 'available' => 42, 'total' => 120, 'rate' => '4.00'],
    ['id' => 2, 'location' => 'Airport Lot B', 'available' => 8, 'total' => 300, 'rate' => '2.00'],
    ['id' => 3, 'location' => 'Campus Lot 4', 'available' => 0, 'total' => 65, 'rate' => '5.50'],
    ['id' => 4, 'location' => 'State Street Lot 2', 'available' => 33, 'total' => 60, 'rate' => '1.50'],
];

$lotId = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
$lot = null;

foreach ($lots as $candidate) {
    if ($candidate['id'] === $lotId) {
        $lot = $candidate;
        break;
    }
}
