<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Lots | SmartPark Solutions</title>
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
        <h1>Parking Lots</h1>

        <!-- Search field and link to the form for adding a lot. -->
        
<form action="lot-list.php" method="get" class="d-flex flex-wrap align-items-end gap-3 mb-4">

    <div>
        <label for="lot-search" class="form-label">Find a lot</label>
        <input
            id="lot-search"
            name="search"
            type="search"
            class="form-control"
            placeholder="Search parking lots"
        >
    </div>

    <button type="submit" class="btn btn-primary">
        Search
    </button>

    <a href="lot-add.php" class="btn btn-primary">
        + Add a Lot
    </a>

</form>

        <!-- Show each lot and pass its ID to the view and edit pages. -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
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
                        <a href="lot-details.php#lot-1" class="btn btn-primary btn-sm">View</a>
                        <a href="lot-update.php#lot-1" class="btn btn-warning btn-sm">Edit</a>
                        <a href="lot-delete.php?lot_id=1" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>Airport Lot B</td>
                    <td>8/300</td>
                    <td>$2.00</td>
                    <td>
                        <a href="lot-details.php#lot-2" class="btn btn-primary btn-sm">View</a>
                        <a href="lot-update.php#lot-2" class="btn btn-warning btn-sm">Edit</a>
                        <a href="lot-delete.php?lot_id=2" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>Campus Lot 4</td>
                    <td>0/65</td>
                    <td>$5.50</td>
                    <td>
                        <a href="lot-details.php#lot-3" class="btn btn-primary btn-sm">View</a>
                        <a href="lot-update.php#lot-3" class="btn btn-warning btn-sm">Edit</a>
                        <a href="lot-delete.php?lot_id=3" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>State Street Lot 2</td>
                    <td>33/60</td>
                    <td>$1.50</td>
                    <td>
                        <a href="lot-details.php#lot-4" class="btn btn-primary btn-sm">View</a>
                        <a href="lot-update.php#lot-4" class="btn btn-warning btn-sm">Edit</a>
                        <a href="lot-delete.php?lot_id=4" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </main>
</body>
</html>