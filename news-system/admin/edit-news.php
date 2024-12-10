<!-- edit-news.php -->
<?php
include '../includes/db.php';
include '../includes/auth.php';
checkAuth();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: dashboard.php');
    exit;
}

// Obtém a notícia para edição
$stmt = $pdo->prepare('SELECT * FROM news WHERE id = ?');
$stmt->execute([$id]);
$news = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $published_at = $_POST['published_at'];
    $image = $news['image'];

    if (!empty($_FILES['image']['name'])) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../$image");
    }

    $stmt = $pdo->prepare('UPDATE news SET title = ?, content = ?, image = ?, published_at = ? WHERE id = ?');
    $stmt->execute([$title, $content, $image, $published_at, $id]);

    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Notícia</title>
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
        .img-thumbnail {
            max-width: 150px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Editar Notícia</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($news['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Conteúdo</label>
            <textarea class="form-control" id="content" name="content" rows="5" required><?= htmlspecialchars($news['content']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="published_at" class="form-label">Data de Publicação</label>
            <input type="datetime-local" class="form-control" id="published_at" name="published_at" value="<?= date('Y-m-d\TH:i', strtotime($news['published_at'])) ?>" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Imagem</label>
            <input type="file" class="form-control" id="image" name="image">
            <?php if ($news['image']): ?>
                <p>Imagem atual: <img src="../<?= $news['image'] ?>" alt="Imagem da notícia" class="img-thumbnail"></p>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary w-100">Salvar Alterações</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
