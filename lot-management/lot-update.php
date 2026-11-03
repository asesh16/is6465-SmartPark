<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Parking Lot | SmartPark Solutions</title>
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
        <h1>Edit a Parking Lot</h1>
        <!-- Each anchor target gives a sample lot its own pre-filled edit form. -->
        <section id="lot-1">
            <h2>Editing Downtown Garage</h2>
            <form action="lot-list.php" method="post">
                <input type="hidden" name="lot_id" value="1">
                <p>
                    <label for="location-1">Location</label><br>
                    <input id="location-1" name="location" type="text" value="Downtown Garage" required>
                </p>
                <p>
                    <label for="total-spots-1">Total Spots</label><br>
                    <input id="total-spots-1" name="total_spots" type="number" min="1" step="1" value="120" required>
                </p>
                <p>
                    <label for="available-spots-1">Available spots</label>
                    <small id="availability-note-1">This field updates as reservations are made.</small><br>
                    <input id="available-spots-1" name="available_spots" type="number" value="42" readonly aria-describedby="availability-note-1">
                </p>
                <p>
                    <label for="hourly-rate-1">Hourly rate</label><br>
                    $<input id="hourly-rate-1" name="hourly_rate" type="number" min="0" step="0.01" value="4.00" required>
                </p>
                <p><a href="lot-list.php">Cancel</a> <button type="submit">Save parking lot</button></p>
            </form>
        </section>

        <section id="lot-2">
            <h2>Editing Airport Lot B</h2>
            <form action="lot-list.php" method="post">
                <input type="hidden" name="lot_id" value="2">
                <p>
                    <label for="location-2">Location</label><br>
                    <input id="location-2" name="location" type="text" value="Airport Lot B" required>
                </p>
                <p>
                    <label for="total-spots-2">Total Spots</label><br>
                    <input id="total-spots-2" name="total_spots" type="number" min="1" step="1" value="300" required>
                </p>
                <p>
                    <label for="available-spots-2">Available spots</label>
                    <small id="availability-note-2">This field updates as reservations are made.</small><br>
                    <input id="available-spots-2" name="available_spots" type="number" value="8" readonly aria-describedby="availability-note-2">
                </p>
                <p>
                    <label for="hourly-rate-2">Hourly rate</label><br>
                    $<input id="hourly-rate-2" name="hourly_rate" type="number" min="0" step="0.01" value="2.00" required>
                </p>
                <p><a href="lot-list.php">Cancel</a> <button type="submit">Save parking lot</button></p>
            </form>
        </section>

        <section id="lot-3">
            <h2>Editing Campus Lot 4</h2>
            <form action="lot-list.php" method="post">
                <input type="hidden" name="lot_id" value="3">
                <p>
                    <label for="location-3">Location</label><br>
                    <input id="location-3" name="location" type="text" value="Campus Lot 4" required>
                </p>
                <p>
                    <label for="total-spots-3">Total Spots</label><br>
                    <input id="total-spots-3" name="total_spots" type="number" min="1" step="1" value="65" required>
                </p>
                <p>
                    <label for="available-spots-3">Available spots</label>
                    <small id="availability-note-3">This field updates as reservations are made.</small><br>
                    <input id="available-spots-3" name="available_spots" type="number" value="0" readonly aria-describedby="availability-note-3">
                </p>
                <p>
                    <label for="hourly-rate-3">Hourly rate</label><br>
                    $<input id="hourly-rate-3" name="hourly_rate" type="number" min="0" step="0.01" value="5.50" required>
                </p>
                <p><a href="lot-list.php">Cancel</a> <button type="submit">Save parking lot</button></p>
            </form>
        </section>

        <section id="lot-4">
            <h2>Editing State Street Lot 2</h2>
            <form action="lot-list.php" method="post">
                <input type="hidden" name="lot_id" value="4">
                <p>
                    <label for="location-4">Location</label><br>
                    <input id="location-4" name="location" type="text" value="State Street Lot 2" required>
                </p>
                <p>
                    <label for="total-spots-4">Total Spots</label><br>
                    <input id="total-spots-4" name="total_spots" type="number" min="1" step="1" value="60" required>
                </p>
                <p>
                    <label for="available-spots-4">Available spots</label>
                    <small id="availability-note-4">This field updates as reservations are made.</small><br>
                    <input id="available-spots-4" name="available_spots" type="number" value="33" readonly aria-describedby="availability-note-4">
                </p>
                <p>
                    <label for="hourly-rate-4">Hourly rate</label><br>
                    $<input id="hourly-rate-4" name="hourly_rate" type="number" min="0" step="0.01" value="1.50" required>
                </p>
                <p><a href="lot-list.php">Cancel</a> <button type="submit">Save parking lot</button></p>
            </form>
        </section>
    </main>
</body>
</html>