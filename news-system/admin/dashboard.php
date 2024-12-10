<!-- dashboard.php -->
<?php
include '../includes/db.php';
include '../includes/auth.php';
checkAuth();

$stmt = $pdo->query('SELECT * FROM news ORDER BY published_at DESC');
$news = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="logo.jpg" type="image/png">
    <style>
        body {
            background-color: #2c3e50;
            color: #ecf0f1;
        }
        .container {
            margin-top: 50px;
        }
        .table {
            background: #34495e;
            color: #ecf0f1;
        }
        .btn-success {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }
        .logout-btn {
            margin-top: 10px;
            background-color: #95a5a6;
            border-color: #95a5a6;
        }
        .news-title {
            color: #ecf0f1; /* Texto branco para o título */
        }
        .news-date {
            color: #ecf0f1; /* Texto branco para a data */
        }
        .table-striped tbody tr:nth-of-type(odd) .news-title, .table-striped tbody tr:nth-of-type(odd) .news-date {
            color: #ecf0f1; /* Texto claro para linhas ímpares */
        }
        .table-striped tbody tr:nth-of-type(even) .news-title, .table-striped tbody tr:nth-of-type(even) .news-date {
            color: #ecf0f1; /* Texto escuro para linhas pares */
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Painel Administrativo REVISTINHA</h1>
    <a href="add-news.php" class="btn btn-success mb-3">Adicionar Notícia</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($news as $index => $n): ?>
                <tr>
                    <td class="news-title"><?= htmlspecialchars($n['title']) ?></td>
                    <td class="news-date"><?= $n['published_at'] ?></td>
                    <td>
                        <a href="edit-news.php?id=<?= $n['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="delete-news.php?id=<?= $n['id'] ?>" class="btn btn-danger btn-sm">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="logout.php" class="btn btn-secondary logout-btn">Sair</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
                