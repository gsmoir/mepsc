<?php
/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: admin/login.php
 *
 * Description:
 * Administrator login page.
 *
 * Technology:
 * - PHP 8+
 * - Bootstrap 5
 * ============================================================================
 */

declare(strict_types=1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Already Logged In
|--------------------------------------------------------------------------
*/
if (isAdminLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';

/*
|--------------------------------------------------------------------------
| Login Processing
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (
        hash_equals(ADMIN_USERNAME, $username) &&
        hash_equals(ADMIN_PASSWORD, $password)
    ) {
        adminLogin();

        header('Location: index.php');
        exit;
    }

    $error = 'Invalid username or password.';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Administrator Login - <?php echo APP_NAME; ?></title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-lg-5 col-md-7">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    <h3 class="mb-0">
                        MEPSC Administrator Login
                    </h3>

                </div>

                <div class="card-body">

                    <?php if ($error !== ''): ?>

                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                        </div>

                    <?php endif; ?>

                    <form method="post" autocomplete="off">

                        <div class="mb-3">

                            <label
                                for="username"
                                class="form-label"
                            >
                                Username
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="username"
                                name="username"
                                required
                                autofocus
                            >

                        </div>

                        <div class="mb-4">

                            <label
                                for="password"
                                class="form-label"
                            >
                                Password
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                required
                            >

                        </div>

                        <div class="d-grid">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Login
                            </button>

                        </div>

                    </form>

                </div>

                <div class="card-footer text-center">

                    <a
                        href="../index.php"
                        class="btn btn-outline-secondary btn-sm"
                    >
                        ← Back to Public Portal
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>