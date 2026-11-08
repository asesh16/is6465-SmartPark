<?php
// Shows validation errors on a full SmartPark page
// instead of plain, unstyled HTML.

function sp_render_error_page($pageTitle, array $errors, $backUrl, $backLabel, $activePage)
{
    http_response_code(400);
    $basePath = '../';
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> | SmartPark</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Shared SmartPark CSS -->
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="sp-page">

<?php require __DIR__ . '/header.php'; ?>

<div class="container mt-5">
    <h1><?= htmlspecialchars($pageTitle) ?></h1>

    <div class="alert alert-danger mt-4">
        <h5>Please fix the following:</h5>
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <a href="<?= htmlspecialchars($backUrl, ENT_QUOTES) ?>" class="btn btn-secondary mt-3">
        <?= htmlspecialchars($backLabel) ?>
    </a>
</div>

<?php require __DIR__ . '/footer.php'; ?>

</body>
</html>
    <?php
    exit;
}
