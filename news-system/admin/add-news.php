<!-- add-news.php -->
<?php
include '../includes/db.php';
include '../includes/auth.php';
checkAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $published_at = $_POST['published_at'];
    $image = null;

    if (!empty($_FILES['image']['name'])) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../$image");
    }

    $stmt = $pdo->prepare('INSERT INTO news (title, content, image, published_at) VALUES (?, ?, ?, ?)');
    $stmt->execute([$title, $content, $image, $published_at]);

    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Notícia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="logo.jpg" type="image/png">
    <style>
        body {
            background-color: #2c3e50;
            color: #ecf0f1;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .btn-primary {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Adicionar Notícia</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Conteúdo</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>
        <div class="mb-3">
            <label for="published_at" class="form-label">Data de Publicação</label>
            <input type="datetime-local" class="form-control" id="published_at" name="published_at" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Imagem</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary w-100">Salvar</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
