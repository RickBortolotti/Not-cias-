<?php
include '../includes/db.php';

$stmt = $pdo->query('SELECT id, title, image, published_at FROM news ORDER BY published_at DESC LIMIT 10');
$news = $stmt->fetchAll();

function formatarData($timestamp) {
    $dias = [
        'Sunday' => 'Domingo', 'Monday' => 'Segunda-feira', 'Tuesday' => 'Terça-feira',
        'Wednesday' => 'Quarta-feira', 'Thursday' => 'Quinta-feira', 'Friday' => 'Sexta-feira',
        'Saturday' => 'Sábado'
    ];
    $meses = [
        'January' => 'janeiro', 'February' => 'fevereiro', 'March' => 'março',
        'April' => 'abril', 'May' => 'maio', 'June' => 'junho',
        'July' => 'julho', 'August' => 'agosto', 'September' => 'setembro',
        'October' => 'outubro', 'November' => 'novembro', 'December' => 'dezembro'
    ];

    $diaSemana = $dias[date('l', $timestamp)];
    $dia = date('d', $timestamp);
    $mes = $meses[date('F', $timestamp)];
    $ano = date('Y', $timestamp);

    return "$diaSemana, $dia de $mes de $ano";
}

$dataAtual = formatarData(time());
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revistinha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="logo.jpg" type="image/png">
    <style>
body {
    background-color: #f8f9fa;
    color: #212529;
    font-family: 'Merriweather', serif; /* Definindo Merriweather como a fonte principal para legibilidade e estilo jornalístico */
    overflow-x: hidden;
}
header {
    background-color: #cc0424;
    padding: 10px 0;
    text-align: center;
}
header img {
    max-width: 400px;
    height: auto;
}
.date-header {
    background-color: #666;
    text-align: center;
    padding: 2px 0;
    font-size: 1.2rem;
    color: #fff;
    border-bottom: 1px solid #ddd;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}
.container {
    max-width: 900px;
    margin: 30px auto;
}
.news-item {
    border: 1px solid #dee2e6;
    border-radius: 5px;
    overflow: hidden;
    margin-bottom: 20px;
    background-color: #ffffff;
}
.news-item img {
    width: 100%;
    height: auto;
}
.news-item h2 {
    font-size: 1.5rem;
    margin: 15px;
}
.news-item p {
    margin: 15px;
    color: #6c757d;
}
a.news-link {
    text-decoration: none;
    color: #007bff;
}
a.news-link:hover {
    text-decoration: underline;
}
footer {
    bottom: 0;
    width: 100%;
    text-align: center;
    color: #ffffff;
    background-color: #cc0424;
    padding: 10px 0;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.3);
}

    </style>
</head>
<body>
    <header>
        <img src="logoletra.png" alt="Logo do Portal">
    </header>
    <header class="date-header">
        <p><?= $dataAtual ?></p>
    </header>
    <div class="container">
        <h1 class="text-center mb-4">Últimas Notícias</h1>
        <?php foreach ($news as $n): ?>
            <div class="news-item">
                <?php if ($n['image']): ?>
                    <img src="../<?= $n['image'] ?>" alt="Imagem da notícia">
                <?php endif; ?>
                <h2><a href="news.php?id=<?= $n['id'] ?>" class="news-link"><?= htmlspecialchars($n['title']) ?></a></h2>
                <p>Publicado em: <?= date('d/m/Y H:i', strtotime($n['published_at'])) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <footer>
        &copy; <?= date('Y') ?> REVISTINHA. Todos os direitos reservados.
    </footer>
</body>
</html>
