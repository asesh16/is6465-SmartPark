
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Parking Lot | SmartPark Solutions</title>
    <style>
        /* Show only the lot selected by the link from the lot list. */
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

                <a href="../home.php">Find Parking</a>

                <a href="../login.php">Login</a>
            </nav>

        </div>
    </header>

    <main class="container mt-5 mb-5">

        <h1 class="mb-2">Edit a Parking Lot</h1>
        <p class="text-muted mb-4">
            Update parking lot information below. Available spaces are automatically managed by the reservation system.
        </p>

        <!-- Downtown Garage -->
        <section id="lot-1" class="mb-4">

            <div class="card" style="max-width: 720px;">
                <div class="card-body p-4">

                    <h2 class="h4 mb-4">Editing Downtown Garage</h2>

                    <form action="lot-list.php" method="post">

                        <input type="hidden" name="lot_id" value="1">

                        <div class="mb-3">
                            <label for="location-1" class="form-label">
                                Location
                            </label>
                            <input
                                id="location-1"
                                name="location"
                                type="text"
                                class="form-control"
                                value="Downtown Garage"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="total-spots-1" class="form-label">
                                Total Spots
                            </label>
                            <input
                                id="total-spots-1"
                                name="total_spots"
                                type="number"
                                class="form-control"
                                min="1"
                                step="1"
                                value="120"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="available-spots-1" class="form-label">
                                Available Spots
                            </label>
                            <input
                                id="available-spots-1"
                                name="available_spots"
                                type="number"
                                class="form-control"
                                value="42"
                                readonly
                                aria-describedby="availability-note-1"
                            >
                            <div id="availability-note-1" class="form-text">
                                This field updates as reservations are made.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="hourly-rate-1" class="form-label">
                                Hourly Rate ($)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input
                                    id="hourly-rate-1"
                                    name="hourly_rate"
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    step="0.01"
                                    value="4.00"
                                    required
                                >
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">
                                Save Parking Lot
                            </button>

                            <a href="lot-list.php" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
                </div>

        </section>

        <!-- Airport Lot B -->
        <section id="lot-2" class="mb-4">

            <div class="card" style="max-width: 720px;">
                <div class="card-body p-4">

                    <h2 class="h4 mb-4">Editing Airport Lot B</h2>

                    <form action="lot-list.php" method="post">

                        <input type="hidden" name="lot_id" value="2">

                        <div class="mb-3">
                            <label for="location-2" class="form-label">
                                Location
                            </label>
                            <input
                                id="location-2"
                                name="location"
                                type="text"
                                class="form-control"
                                value="Airport Lot B"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="total-spots-2" class="form-label">
                                Total Spots
                            </label>
                            <input
                                id="total-spots-2"
                                name="total_spots"
                                type="number"
                                class="form-control"
                                min="1"
                                step="1"
                                value="300"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="available-spots-2" class="form-label">
                                Available Spots
                            </label>
                            <input
                                id="available-spots-2"
                                name="available_spots"
                                type="number"
                                class="form-control"
                                value="8"
                                readonly
                                aria-describedby="availability-note-2"
                            >
                            <div id="availability-note-2" class="form-text">
                                This field updates as reservations are made.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="hourly-rate-2" class="form-label">
                                Hourly Rate ($)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input
                                    id="hourly-rate-2"
                                    name="hourly_rate"
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    step="0.01"
                                    value="2.00"
                                    required
                                >
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">
                                Save Parking Lot
                            </button>

                            <a href="lot-list.php" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </section>

        <!-- Campus Lot 4 -->
        <section id="lot-3" class="mb-4">

            <div class="card" style="max-width: 720px;">
                <div class="card-body p-4">

                    <h2 class="h4 mb-4">Editing Campus Lot 4</h2>

                    <form action="lot-list.php" method="post">

                        <input type="hidden" name="lot_id" value="3">

                        <div class="mb-3">
                            <label for="location-3" class="form-label">
                                Location
                            </label>
                            <input
                                id="location-3"
                                name="location"
                                type="text"
                                class="form-control"
                                value="Campus Lot 4"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="total-spots-3" class="form-label">
                                Total Spots
                            </label>
                            <input
                                id="total-spots-3"
                                name="total_spots"
                                type="number"
                                class="form-control"
                                min="1"
                                step="1"
                                value="65"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="available-spots-3" class="form-label">
                                Available Spots
                            </label>
                            <input
                                id="available-spots-3"
                                name="available_spots"
                                type="number"
                                class="form-control"
                                value="0"
                                readonly
                                aria-describedby="availability-note-3"
                            >
                            <div id="availability-note-3" class="form-text">
                                This field updates as reservations are made.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="hourly-rate-3" class="form-label">
                                Hourly Rate ($)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input
                                    id="hourly-rate-3"
                                    name="hourly_rate"
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    step="0.01"
                                    value="5.50"
                                    required
                                >
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">
                                Save Parking Lot
                            </button>

                            <a href="lot-list.php" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </section>

        <!-- State Street Lot 2 -->
        <section id="lot-4" class="mb-4">

            <div class="card" style="max-width: 720px;">
                <div class="card-body p-4">

                    <h2 class="h4 mb-4">Editing State Street Lot 2</h2>

                    <form action="lot-list.php" method="post">

                        <input type="hidden" name="lot_id" value="4">

                        <div class="mb-3">
                            <label for="location-4" class="form-label">
                                Location
                            </label>
                            <input
                                id="location-4"
                                name="location"
                                type="text"
                                class="form-control"
                                value="State Street Lot 2"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="total-spots-4" class="form-label">
                                Total Spots
                            </label>
                            <input
                                id="total-spots-4"
                                name="total_spots"
                                type="number"
                                class="form-control"
                                min="1"
                                step="1"
                                value="60"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="available-spots-4" class="form-label">
                                Available Spots
                            </label>
                            <input
                                id="available-spots-4"
                                name="available_spots"
                                type="number"
                                class="form-control"
                                value="33"
                                readonly
                                aria-describedby="availability-note-4"
                            >
                            <div id="availability-note-4" class="form-text">
                                This field updates as reservations are made.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="hourly-rate-4" class="form-label">
                                Hourly Rate ($)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input
                                    id="hourly-rate-4"
                                    name="hourly_rate"
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    step="0.01"
                                    value="1.50"
                                    required
                                >
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">
                                Save Parking Lot
                            </button>

                            <a href="lot-list.php" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </section>

    </main>

</body>
</html>
