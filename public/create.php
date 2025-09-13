<?php
require_once '../app/config/database.php';
require_once '../app/core/Database.php';
require_once '../app/models/Product.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);

    $product->title = $_POST['title'];
    $product->description = $_POST['description'];
    $product->price = $_POST['price'];
    $product->category_id = $_POST['category_id'];

    if($product->create()) {
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
    <title>➕ Добавить товар - Modern Store</title>
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
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-card {
            border: none;
            border-radius: 1.5rem;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }

        .form-card:hover {
            box-shadow: var(--hover-shadow);
        }

        .form-header {
            background: var(--primary-gradient);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .form-body {
            padding: 2.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 0.8rem;
            padding: 0.8rem 1rem;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .form-control::placeholder {
            color: #a0aec0;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 0.8rem;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: var(--transition);
            width: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #e2e8f0;
            border: none;
            border-radius: 0.8rem;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: var(--transition);
            width: 100%;
            color: #4a5568;
        }

        .btn-secondary:hover {
            background: #cbd5e0;
            transform: translateY(-2px);
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            z-index: 5;
        }

        .form-text {
            color: #718096;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 1.5rem;
            transition: var(--transition);
        }

        .back-link:hover {
            color: #764ba2;
            transform: translateX(-5px);
        }

        @media (max-width: 768px) {
            .form-body {
                padding: 2rem 1.5rem;
            }

            body {
                padding: 1rem;
            }
        }

        .floating-label {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .floating-label .form-control {
            padding: 1.2rem 1rem 0.8rem;
        }

        .floating-label label {
            position: absolute;
            top: 0.8rem;
            left: 1rem;
            color: #a0aec0;
            transition: var(--transition);
            pointer-events: none;
            font-size: 0.9rem;
        }

        .floating-label .form-control:focus + label,
        .floating-label .form-control:not(:placeholder-shown) + label {
            top: 0.3rem;
            left: 0.8rem;
            font-size: 0.75rem;
            color: #667eea;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Back Button -->
    <a href="index.php" class="back-link">
        <i class="bi bi-arrow-left me-2"></i> Назад к каталогу
    </a>

    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <div class="icon-container mb-3">
                    <i class="bi bi-plus-circle" style="font-size: 3rem;"></i>
                </div>
                <h2 class="mb-2">Добавить новый товар</h2>
                <p class="mb-0">Заполните информацию о новом товаре</p>
            </div>

            <div class="form-body">
                <form method="POST">
                    <!-- Название товара -->
                    <div class="floating-label">
                        <input type="text" name="title" class="form-control" placeholder=" " required>
                        <label>Название товара *</label>
                    </div>

                    <!-- Описание -->
                    <div class="mb-4">
                        <label class="form-label">Описание товара</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Подробное описание товара..."></textarea>
                        <div class="form-text">Необязательное поле</div>
                    </div>

                    <!-- Цена и категория в одной строке -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required>
                                <span class="input-icon">$</span>
                            </div>
                            <div class="form-text">Цена товара</div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="number" name="category_id" class="form-control" value="1" required>
                                <span class="input-icon">#</span>
                            </div>
                            <div class="form-text">ID категории</div>
                        </div>
                    </div>

                    <!-- Кнопки действий -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i> Добавить товар
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i> Отмена
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Анимация для плавающих labels
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            if (input.value) {
                input.parentElement.classList.add('focused');
            }

            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
    });
</script>
</body>
</html>