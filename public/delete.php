<?php

require_once '../app/config/database.php';
require_once '../app/core/Database.php';
require_once '../app/models/Product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

if(isset($_GET['id'])) {
    $product->id = $_GET['id'];
    $stmt = $product->readOne();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$row) {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

// Обработка подтверждения удаления
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['delete'])) {
        if($product->delete()) {
            header("Location: index.php?deleted=1");
            exit();
        }
    } else {
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🗑️ Подтверждение удаления - Modern Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --danger-gradient: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            --card-shadow: 0 20px 40px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .confirmation-container {
            max-width: 500px;
            width: 100%;
        }

        .confirmation-card {
            border: none;
            border-radius: 1.5rem;
            overflow: hidden;
            background: white;
            box-shadow: var(--card-shadow);
            text-align: center;
            transition: var(--transition);
        }

        .confirmation-card:hover {
            transform: translateY(-5px);
        }

        .confirmation-header {
            background: var(--danger-gradient);
            color: white;
            padding: 2.5rem;
            position: relative;
        }

        .warning-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .confirmation-body {
            padding: 2.5rem;
        }

        .product-info {
            background: #f8f9fa;
            border-radius: 1rem;
            padding: 1.5rem;
            margin: 2rem 0;
            text-align: left;
            border-left: 4px solid #ff6b6b;
        }

        .product-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .product-details {
            display: grid;
            gap: 0.5rem;
        }

        .product-detail {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .product-detail:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #718096;
            font-weight: 500;
        }

        .detail-value {
            color: #2d3748;
            font-weight: 600;
        }

        .btn-danger {
            background: var(--danger-gradient);
            border: none;
            border-radius: 0.8rem;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: var(--transition);
            width: 100%;
            margin-bottom: 1rem;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }

        .btn-outline-secondary {
            border: 2px solid #e2e8f0;
            border-radius: 0.8rem;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: var(--transition);
            width: 100%;
            color: #718096;
        }

        .btn-outline-secondary:hover {
            background: #f8f9fa;
            border-color: #cbd5e0;
            transform: translateY(-2px);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 2rem;
            transition: var(--transition);
        }

        .back-link:hover {
            color: #764ba2;
            transform: translateX(-5px);
        }

        .warning-text {
            color: #e53e3e;
            font-weight: 600;
            margin: 1.5rem 0;
            padding: 1rem;
            background: #fed7d7;
            border-radius: 0.5rem;
            border-left: 4px solid #e53e3e;
        }

        @media (max-width: 576px) {
            .confirmation-body {
                padding: 2rem 1.5rem;
            }

            .confirmation-header {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
<div class="confirmation-container">
    <a href="index.php" class="back-link">
        <i class="bi bi-arrow-left me-2"></i> Вернуться к каталогу
    </a>

    <div class="confirmation-card">
        <div class="confirmation-header">
            <div class="warning-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <h2 class="mb-2">Подтвердите удаление</h2>
            <p class="mb-0">Это действие нельзя отменить</p>
        </div>

        <div class="confirmation-body">
            <div class="warning-text">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                Внимание! Товар будет удален безвозвратно
            </div>

            <div class="product-info">
                <div class="product-title">
                    <?= htmlspecialchars($row['title']) ?>
                </div>
                <div class="product-details">
                    <div class="product-detail">
                        <span class="detail-label">ID товара:</span>
                        <span class="detail-value">#<?= $row['id'] ?></span>
                    </div>
                    <div class="product-detail">
                        <span class="detail-label">Цена:</span>
                        <span class="detail-value">$<?= htmlspecialchars($row['price']) ?></span>
                    </div>
                    <div class="product-detail">
                        <span class="detail-label">Категория:</span>
                        <span class="detail-value">#<?= htmlspecialchars($row['category_id']) ?></span>
                    </div>
                    <div class="product-detail">
                        <span class="detail-label">Добавлен:</span>
                        <span class="detail-value"><?= date('d.m.Y', strtotime($row['created_at'])) ?></span>
                    </div>
                </div>
            </div>

            <form method="POST">
                <button type="submit" name="delete" class="btn-danger">
                    <i class="bi bi-trash-fill me-2"></i> Да, удалить товар
                </button>
                <a href="index.php" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i> Отмена
                </a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>