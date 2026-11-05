<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Parking Lot | SmartPark Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header class="smartpark-header">
        <div class="container smartpark-navbar">
            <a href="../home.php" class="smartpark-brand">SmartPark Solutions</a>
            <nav class="smartpark-nav-links" aria-label="Main navigation">
                <a href="../home.php">Home</a>
                <a href="lot-list.php" class="active" aria-current="page">Manage Lots</a>
                <a href="../reservation-management/reservations.php">View Reservations</a>
                <a href="../login.php">Login</a>
            </nav>
        </div>
    </header>

    <main class="container mt-5 mb-5">
        <div class="card mx-auto" style="max-width: 560px;">
            <div id="confirmation" class="card-body p-4 p-md-5 text-center" hidden>
                <h1 class="h3 mb-3">Delete this parking lot?</h1>
                <p id="lot-name" class="mb-2"></p>
                <p class="text-muted mb-4">Deletion is not connected yet.</p>
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <a href="lot-list.php" class="btn btn-secondary px-4">Cancel</a>
                    <button type="button" class="btn btn-danger px-4" disabled>
                        Delete this lot
                    </button>
                </div>
            </div>
            <div id="not-found" class="card-body p-4 p-md-5 text-center" hidden>
                <h1 class="h3 mb-3">Unable to delete parking lot</h1>
                <p class="mb-4">The selected parking lot could not be found.</p>
                <a href="lot-list.php" class="btn btn-secondary">Back to parking lots</a>
            </div>
        </div>
    </main>
    <script>
        const lots = {
            1: 'Downtown Garage',
            2: 'Airport Lot B',
            3: 'Campus Lot 4',
            4: 'State Street Lot 2'
        };
        const lotId = new URLSearchParams(window.location.search).get('lot_id');
        const lotName = lots[lotId];

        if (lotName) {
            document.getElementById('lot-name').textContent = lotName;
            document.getElementById('confirmation').hidden = false;
        } else {
            document.getElementById('not-found').hidden = false;
        }
    </script>
</body>
</html>