<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Parking Lot | SmartPark Solutions</title>
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
        <h1>Add a Parking Lot</h1>
        <!-- Collect the details for a new lot. -->        
        <div class="card mt-4" style="max-width: 720px;">
            <div class="card-body">
        <form onsubmit="return false;">
            <p>
                <label for="location">Location</label><br>
                <input id="location" name="location" type="text" required>
            </p>
            <p>
                <label for="total-spots">Total Spots</label><br>
                <input id="total-spots" name="total_spots" type="number" min="1" step="1" required>
            </p>
            <!-- Availability is managed by reservations, so it cannot be entered here. -->
            <p>
                <label for="available-spots">Available spots</label>
                <small id="availability-note">This field updates as reservations are made.</small><br>
                <input id="available-spots" name="available_spots" type="text" value="--" readonly aria-describedby="availability-note">
            </p>
            <p>
                <label for="hourly-rate">Hourly rate</label><br>
                $<input id="hourly-rate" name="hourly_rate" type="number" min="0" step="0.01" required>
            </p>
            <!-- Return to the lot list or save the new lot when persistence is available. -->
            <p>
                <a href="lot-list.php" class="btn btn-secondary">Cancel</a>
                <button type="button" class="btn btn-primary" disabled>Save parking lot</button>
            </p>
        </form>
        </div>
    </div>
    </main>
</body>
</html>