<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Lot Details | SmartPark Solutions</title>
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
        <h1>Parking Lot Details</h1>
        <!-- Each section is a static detail view for one sample lot. -->
        <section id="lot-1">
            <h2>Downtown Garage</h2>
            <dl>
                <dt>Location</dt><dd>Downtown Garage</dd>
                <dt>Total Spots</dt><dd>120</dd>
                <dt>Available spots</dt><dd>42</dd>
                <dt>Hourly rate</dt><dd>$4.00</dd>
            </dl>
            <p>
                <a href="lot-update.php#lot-1">Edit parking lot</a>
                <button type="button">Delete this parking lot</button>
            </p>
        </section>

        <section id="lot-2">
            <h2>Airport Lot B</h2>
            <dl>
                <dt>Location</dt><dd>Airport Lot B</dd>
                <dt>Total Spots</dt><dd>300</dd>
                <dt>Available spots</dt><dd>8</dd>
                <dt>Hourly rate</dt><dd>$2.00</dd>
            </dl>
            <p>
                <a href="lot-update.php#lot-2">Edit parking lot</a>
                <button type="button">Delete this parking lot</button>
            </p>
        </section>

        <section id="lot-3">
            <h2>Campus Lot 4</h2>
            <dl>
                <dt>Location</dt><dd>Campus Lot 4</dd>
                <dt>Total Spots</dt><dd>65</dd>
                <dt>Available spots</dt><dd>0</dd>
                <dt>Hourly rate</dt><dd>$5.50</dd>
            </dl>
            <p>
                <a href="lot-update.php#lot-3">Edit parking lot</a>
                <button type="button">Delete this parking lot</button>
            </p>
        </section>

        <section id="lot-4">
            <h2>State Street Lot 2</h2>
            <dl>
                <dt>Location</dt><dd>State Street Lot 2</dd>
                <dt>Total Spots</dt><dd>60</dd>
                <dt>Available spots</dt><dd>33</dd>
                <dt>Hourly rate</dt><dd>$1.50</dd>
            </dl>
            <p>
                <a href="lot-update.php#lot-4">Edit parking lot</a>
                <button type="button">Delete this parking lot</button>
            </p>
        </section>

        <p><a href="lot-list.php">Back to parking lots</a></p>
    </main>
</body>
</html>