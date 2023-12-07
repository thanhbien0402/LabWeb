<?php
session_start();

$page = 'home';
$allowed_pages = ['home', 'products', 'login', 'register'];

if (isset($_GET['page']) && in_array($_GET['page'], $allowed_pages)) {
    $page = $_GET['page'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">




    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col">
                    <img src="favicon.ico" alt="Company Logo">
                </div>
                <div class="col text-right">
                    <h1>Company Name</h1>
                </div>
            </div>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item <?= ($page === 'home' ? 'active' : '') ?>">
                        <a class="nav-link" href="index.php?page=home">Home</a>
                    </li>
                    <li class="nav-item <?= ($page === 'products' ? 'active' : '') ?>">
                        <a class="nav-link" href="index.php?page=products">Products</a>
                    </li>
                    <?php if (isset($_SESSION['userID'])): ?>
                        <li class="nav-item <?= ($page === 'logout' ? 'active' : '') ?>">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item <?= ($page === 'login' ? 'active' : '') ?>">
                            <a class="nav-link" href="index.php?page=login">Login</a>
                        </li>
                        <li class="nav-item <?= ($page === 'register' ? 'active' : '') ?>">
                            <a class="nav-link" href="index.php?page=register">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php include("$page.php"); ?>
    </div>

    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    &copy; 2023 Company Name. All rights reserved.
                </div>
            </div>
        </div>
    </footer>
                        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="script.js"></script>
</body>
</html>
