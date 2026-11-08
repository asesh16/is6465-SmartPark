<?php
// SmartPark Login
// Checks the form, remembers the chosen role in the session,
// and sends the user to the starting page for that role.
// Note: passwords are not checked against stored accounts yet.

require_once __DIR__ . '/includes/session.php';

// Starting page for each role
$roleHomePages = [
    'driver'  => 'reservation-management/reservations.php',
    'manager' => 'lot-management/lot-list.php'
];

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Receive the login form fields
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    // Validate the email address
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    // Validate the password length
    if (strlen($password) < 8) {
        $errors[] = 'Passwords must be at least 8 characters.';
    }

    // Validate the selected role
    if (!array_key_exists($role, $roleHomePages)) {
        $errors[] = 'Please choose Driver or Lot Manager.';
    }

    // Log the user in and redirect to their starting page
    if (empty($errors)) {
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'email' => $email,
            'role' => $role
        ];

        header('Location: ' . $roleHomePages[$role]);
        exit;
    }
}

// Messages shown when another page sends the user here
$loggedOut = isset($_GET['logged_out']);
$managerRequired = (($_GET['required'] ?? '') === 'manager');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | SmartPark Solutions</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Shared SmartPark CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="sp-page">

<?php
$basePath = '';
$activePage = 'login';
require __DIR__ . '/includes/header.php';
?>

<main class="container sp-login-page">

    <div class="card sp-login-card mx-auto">
        <div class="row g-0">

            <!-- Welcome panel -->
            <div class="col-md-5 sp-login-panel">
                <h2 class="h4">Welcome back</h2>

                <p>
                    Log in to reserve parking, manage your reservations, or update
                    your parking lots.
                </p>

                <ul class="sp-login-points">
                    <li>Drivers: find and reserve parking</li>
                    <li>Lot Managers: keep lot details current</li>
                </ul>
            </div>

            <!-- Login form -->
            <div class="col-md-7">
                <div class="card-body">

                    <?php if ($currentUser !== null): ?>

                        <!-- Already logged in -->
                        <h1 class="h3 mb-3">You are logged in</h1>

                        <p class="text-muted">
                            Signed in as
                            <strong><?= htmlspecialchars($currentUser['email']) ?></strong>
                            (<?= $isLotManager ? 'Lot Manager' : 'Driver' ?>).
                        </p>

                        <div class="d-grid gap-2 mt-4">
                            <a href="<?= $roleHomePages[$currentRole] ?>" class="btn btn-primary">
                                Continue
                            </a>
                            <a href="logout.php" class="btn btn-secondary">
                                Log Out
                            </a>
                        </div>

                    <?php else: ?>

                        <h1 class="h3 mb-1">Log in to SmartPark</h1>

                        <p class="text-muted mb-4">
                            Enter your email and password, then choose how you want to continue.
                        </p>

                        <?php if ($loggedOut): ?>
                            <div class="alert alert-success">
                                You have been logged out.
                            </div>
                        <?php endif; ?>

                        <?php if ($managerRequired): ?>
                            <div class="alert alert-warning">
                                Please log in as a Lot Manager to add, edit, or delete parking lots.
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= htmlspecialchars($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="login.php" method="POST">

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="name@example.com"
                                    autocomplete="email"
                                    value="<?= htmlspecialchars($email, ENT_QUOTES) ?>"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    Password
                                </label>

                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    minlength="8"
                                    autocomplete="current-password"
                                    aria-describedby="password-help"
                                    required
                                >

                                <div id="password-help" class="form-text">
                                    Passwords must be at least 8 characters.
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="remember_me"
                                    name="remember_me"
                                >

                                <label class="form-check-label" for="remember_me">
                                    Keep me logged in on this device
                                </label>
                            </div>

                            <!-- The button pressed decides the role -->
                            <div class="d-grid gap-2">
                                <button type="submit" name="role" value="driver" class="btn btn-primary">
                                    Log In as Driver
                                </button>

                                <button type="submit" name="role" value="manager" class="btn btn-secondary">
                                    Log In as Lot Manager
                                </button>
                            </div>

                        </form>

                        <p class="form-text text-center mt-4 mb-0">
                            Demo login: any valid email and an 8-character password will work.
                            Stored accounts are planned for the final submission.
                        </p>

                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>

    <p class="text-center mt-4">
        <a href="home.php">&larr; Back to Home</a>
    </p>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
