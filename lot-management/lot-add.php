<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Parking Lot | SmartPark Solutions</title>
</head>
<body>
    <header>
        <a href="../home.php">SmartPark Solutions</a>
        <nav aria-label="Main navigation">
            <a href="../home.php">Home</a>
            <a href="lot-list.php" aria-current="page">Manage Lots</a>
            <a href="../home.php">Find Parking</a>
            <a href="../login.php">Login</a>
        </nav>
    </header>

    <main>
        <h1>Add a Parking Lot</h1>
        <!-- Collect the details for a new lot. -->
        <form action="lot-list.php" method="post">
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
            <!-- Return to the lot list or submit the new lot details. -->
            <p>
                <a href="lot-list.php">Cancel</a>
                <button type="submit">Save parking lot</button>
            </p>
        </form>
    </main>
</body>
</html>