<?php
// SmartPark shared navigation header
// Before including, set:
//   $basePath   - '' for root pages, '../' for pages inside a folder
//   $activePage - home, find, reservations, lots, or login

require_once __DIR__ . '/session.php';

// Read the login state here so the header works in any scope
$currentUser = $_SESSION['user'] ?? null;
$currentRole = $currentUser['role'] ?? 'guest';
$isLotManager = ($currentRole === 'manager');

$basePath = $basePath ?? '';
$activePage = $activePage ?? '';

// Build a navigation link and mark the current page as active
if (!function_exists('sp_nav_link')) {
function sp_nav_link($href, $label, $key, $activePage)
{
    $isActive = ($key === $activePage);
    $attributes = $isActive ? ' class="active" aria-current="page"' : '';

    return '<a href="' . htmlspecialchars($href, ENT_QUOTES) . '"' . $attributes . '>' .
           htmlspecialchars($label) . '</a>';
}
}
?>
<!-- SmartPark Navigation (shared by all pages) -->
<header class="smartpark-header">
    <div class="container smartpark-navbar">

        <a href="<?= $basePath ?>home.php" class="smartpark-brand">
            SmartPark Solutions
        </a>

        <nav class="smartpark-nav-links" aria-label="Main navigation">

            <?= sp_nav_link($basePath . 'home.php', 'Home', 'home', $activePage) ?>

            <?php if ($isLotManager): ?>
                <!-- Lot Manager navigation (lot management wireframes) -->
                <?= sp_nav_link($basePath . 'lot-management/lot-list.php', 'Manage Lots', 'lots', $activePage) ?>
                <?= sp_nav_link($basePath . 'lot-management/lot-list.php?mode=find', 'Find Parking', 'find', $activePage) ?>
                <?= sp_nav_link($basePath . 'reservation-management/reservations.php', 'All Reservations', 'reservations', $activePage) ?>
            <?php else: ?>
                <!-- Driver and visitor navigation (reservation wireframes) -->
                <?= sp_nav_link($basePath . 'reservation-management/reservations.php', 'My Reservations', 'reservations', $activePage) ?>
                <?= sp_nav_link($basePath . 'lot-management/lot-list.php', 'Find Parking', 'find', $activePage) ?>
            <?php endif; ?>

            <?php if ($currentUser !== null): ?>
                <span class="smartpark-user">
                    <?= $isLotManager ? 'Lot Manager' : 'Driver' ?>
                </span>
                <a href="<?= $basePath ?>logout.php">Log Out</a>
            <?php else: ?>
                <?= sp_nav_link($basePath . 'login.php', 'Login', 'login', $activePage) ?>
            <?php endif; ?>

        </nav>

    </div>
</header>
