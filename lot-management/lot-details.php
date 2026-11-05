<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Lot Details | SmartPark Solutions</title>  
    <style>
        main section {
            display: none;
        }

        main section:target {
            display: block;
        }
    </style>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Shared SmartPark CSS -->
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    
<!-- SmartPark Administrative Navigation -->
<header class="smartpark-header">
    <div class="container smartpark-navbar">

        <a href="../home.php" class="smartpark-brand">
            SmartPark Solutions
        </a>

        <nav class="smartpark-nav-links" aria-label="Main navigation">

            <a href="../home.php">Home</a>

            <a href="lot-list.php" class="active" aria-current="page">
                Manage Lots
            </a>

            <a href="../reservation-management/reservations.php">View Reservations</a>


            <a href="../login.php">Login</a>

        </nav>

    </div>
</header>

    <main class="container mt-5 mb-5">
        <h1>Parking Lot Details</h1>
        <!-- Each section is a static detail view for one sample lot. -->
        <section id="lot-1">
        <div class="card mb-4" style="max-width: 720px;">
        <div class="card-body">    
        <h2>Downtown Garage</h2>
            <dl>
                <dt>Location</dt><dd>Downtown Garage</dd>
                <dt>Total Spots</dt><dd>120</dd>
                <dt>Available spots</dt><dd>42</dd>
                <dt>Hourly rate</dt><dd>$4.00</dd>
            </dl>
            <p>          
            <a href="lot-update.php#lot-1" class="btn btn-warning me-2">
                Edit Parking Lot
            </a>
            <a href="lot-delete.php?lot_id=1" class="btn btn-danger">
                Delete Parking Lot
            </a>
            </p>
            </div>
        </div>
        </section>

        <section id="lot-2">
            <div class="card mb-4" style="max-width: 720px;">
            <div class="card-body">
            <h2>Airport Lot B</h2>
            <dl>
                <dt>Location</dt><dd>Airport Lot B</dd>
                <dt>Total Spots</dt><dd>300</dd>
                <dt>Available spots</dt><dd>8</dd>
                <dt>Hourly rate</dt><dd>$2.00</dd>
            </dl>
            <p>    
            <a href="lot-update.php#lot-2" class="btn btn-warning me-2">
                Edit Parking Lot
            </a>
            <a href="lot-delete.php?lot_id=2" class="btn btn-danger">
                Delete Parking Lot
            </a>
            </p>
            </div>
        </div>
        </section>

        <section id="lot-3">
            <div class="card mb-4" style="max-width: 720px;">
            <div class="card-body">
            <h2>Campus Lot 4</h2>
            <dl>
                <dt>Location</dt><dd>Campus Lot 4</dd>
                <dt>Total Spots</dt><dd>65</dd>
                <dt>Available spots</dt><dd>0</dd>
                <dt>Hourly rate</dt><dd>$5.50</dd>
            </dl>
            <p>          
            <a href="lot-update.php#lot-3" class="btn btn-warning me-2">
                Edit Parking Lot
            </a>
            <a href="lot-delete.php?lot_id=3" class="btn btn-danger">
                Delete Parking Lot
            </a>
            </p>
            </div>
        </div>
        </section>

        <section id="lot-4">
        <div class="card mb-4" style="max-width: 720px;">
            <div class="card-body">
            <h2>State Street Lot 2</h2>
            <dl>
                <dt>Location</dt><dd>State Street Lot 2</dd>
                <dt>Total Spots</dt><dd>60</dd>
                <dt>Available spots</dt><dd>33</dd>
                <dt>Hourly rate</dt><dd>$1.50</dd>
            </dl>
            <p>           
            <a href="lot-update.php#lot-4" class="btn btn-warning me-2">
                Edit Parking Lot
            </a>
            <a href="lot-delete.php?lot_id=4" class="btn btn-danger">
                Delete Parking Lot
            </a>
            </p>
            </div>
        </div>
        </section>

        <p><a href="lot-list.php">Back to parking lots</a></p>
    </main>
</body>
</html>