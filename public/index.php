<?php
require_once '../app/core/Database.php';
require_once '../app/models/Product.php';
require_once '../app/config/database.php';

header('Content-Type: text/html; charset=utf-8');
ini_set('default_charset', 'utf-8');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$stmt = $product->read();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛍️ Каталог товаров - Modern Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --card-shadow: 0 10px 25px rgba(0,0,0,0.1);
            --hover-shadow: 0 15px 35px rgba(0,0,0,0.15);
            --transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-brand {
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-section {
            background: var(--primary-gradient);
            padding: 3rem 0;
            margin-bottom: 3rem;
            border-radius: 0 0 2rem 2rem;
            color: white;
        }

        .product-card {
            border: none;
            border-radius: 1rem;
            overflow: hidden;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--hover-shadow);
        }

        .product-image {
            height: 200px;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .price-tag {
            background: var(--primary-gradient);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .category-badge {
            background: #e9ecef;
            color: #6c757d;
            padding: 0.4rem 0.8rem;
            border-radius: 1rem;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 0.8rem;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .action-buttons .btn {
            border-radius: 0.6rem;
            padding: 0.5rem 1rem;
            transition: var(--transition);
        }

        .action-buttons .btn:hover {
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .hero-section {
                border-radius: 0 0 1rem 1rem;
                padding: 2rem 0;
            }

            .product-card {
                margin-bottom: 1.5rem;
            }
        }

        .theme-switcher {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
        }
    </style>
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="bi bi-shop"></i> ModernStore
        </a>
        <div class="d-flex align-items-center">
            <span class="badge bg-primary me-3"><?= count($products) ?> товаров</span>
            <a href="create.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Добавить товар
            </a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">🛍️ Каталог товаров</h1>
        <p class="lead mb-4">Управляйте вашим интернет-магазином в одном месте</p>
    </div>
</div>

<!-- Products Grid -->
<div class="container">
    <?php if (count($products) > 0): ?>
        <div class="row g-4">
            <?php foreach ($products as $product): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="product-card shadow-sm">
                        <div class="product-image">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title fw-bold mb-0"><?= htmlspecialchars($product['title']) ?></h5>
                                <span class="price-tag">$<?= htmlspecialchars($product['price']) ?></span>
                            </div>

                            <p class="card-text text-muted mb-3"><?= htmlspecialchars($product['description']) ?></p>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="category-badge">
                                        <i class="bi bi-tag"></i> Категория #<?= htmlspecialchars($product['category_id']) ?>
                                    </span>
                                <small class="text-muted">
                                    <i class="bi bi-clock"></i>
                                    <?= date('d.m.Y', strtotime($product['created_at'])) ?>
                                </small>
                            </div>

                            <div class="action-buttons d-flex gap-2">
                                <a href="edit.php?id=<?= $product['id'] ?>" class="btn btn-outline-warning flex-fill">
                                    <i class="bi bi-pencil"></i> Редактировать
                                </a>
                                <a href="delete.php?id=<?= $product['id'] ?>" class="btn btn-outline-danger"
                                   onclick="return confirm('Удалить товар?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state bg-white rounded-3 shadow-sm">
            <i class="bi bi-inbox"></i>
            <h3>Товаров пока нет</h3>
            <p class="text-muted">Добавьте первый товар, чтобы начать работу</p>
            <a href="create.php" class="btn btn-primary btn-lg mt-3">
                <i class="bi bi-plus-circle"></i> Добавить первый товар
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Theme Switcher -->
<div class="theme-switcher">
    <button class="btn btn-dark rounded-circle p-3 shadow" onclick="toggleTheme()">
        <i class="bi bi-moon-stars"></i>
    </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleTheme() {
        const html = document.documentElement;
        const currentTheme = html.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        html.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);

        // Update icon
        const icon = document.querySelector('.theme-switcher i');
        icon.className = newTheme === 'dark' ? 'bi bi-sun' : 'bi bi-moon-stars';
    }

    // Load saved theme
    document.addEventListener('DOMContentLoaded', function() {
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', savedTheme);

        const icon = document.querySelector('.theme-switcher i');
        icon.className = savedTheme === 'dark' ? 'bi bi-sun' : 'bi bi-moon-stars';
    });
</script>
</body>
</html>