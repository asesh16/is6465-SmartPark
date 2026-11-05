<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Lots | SmartPark Solutions</title>
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
        <h1>Parking Lots</h1>

        <!-- Search field and link to the form for adding a lot. -->
        <form action="lot-list.php" method="get">
            <label for="lot-search">Find a lot</label>
            <input id="lot-search" name="search" type="search" placeholder="Find a lot">
            <button type="submit">Search</button>
            <a href="lot-add.php">Add a lot</a>
        </form>

        <!-- Show each lot with actions for editing or deleting that record. -->
        <table>
            <thead>
                <tr>
                    <th scope="col">Location</th>
                    <th scope="col">Available Spots</th>
                    <th scope="col">Hourly Rate</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Sample records make the list usable without a database. -->
                <tr>
                    <td>Downtown Garage</td>
                    <td>42/120</td>
                    <td>$4.00</td>
                    <td>
                        <a href="lot-update.php#lot-1">Edit</a>
                        <button type="button">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Airport Lot B</td>
                    <td>8/300</td>
                    <td>$2.00</td>
                    <td>
                        <a href="lot-update.php#lot-2">Edit</a>
                        <button type="button">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Campus Lot 4</td>
                    <td>0/65</td>
                    <td>$5.50</td>
                    <td>
                        <a href="lot-update.php#lot-3">Edit</a>
                        <button type="button">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>State Street Lot 2</td>
                    <td>33/60</td>
                    <td>$1.50</td>
                    <td>
                        <a href="lot-update.php#lot-4">Edit</a>
                        <button type="button">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
</body>
</html>