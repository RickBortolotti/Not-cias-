<?php
include '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM news WHERE id = ?');
$stmt->execute([$id]);
$news = $stmt->fetch();

if (!$news) {
    header('Location: index.php');
    exit;
}

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
    <title><?= htmlspecialchars($news['title']) ?></title>
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
    position: relative;
    bottom: 0;
    width: 100%;
    text-align: center;
    color: #ffffff;
    background-color: #cc0424;
    padding: 10px 0;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.3);
}
.news-image {
    width: 800px; /* Ajuste inicial da largura da imagem */
    height: auto; /* Mantém a proporção */
}

.news-text {
    margin-top: 20px; /* Ajusta o espaçamento superior */
    font-size: 1.2rem; /* Ajuste do tamanho da fonte do texto */
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
        <div class="news-content">
            <h1><?= htmlspecialchars($news['title']) ?></h1>
            <?php if ($news['image']): ?>
    <img src="../<?= $news['image'] ?>" alt="Imagem da notícia" class="news-image">
<?php endif; ?>
<p class="news-text"><?= nl2br(htmlspecialchars($news['content'])) ?></p>
            <p class="text-muted">Publicado em: <?= date('d/m/Y H:i', strtotime($news['published_at'])) ?></p>
            <a href="index.php" class="btn btn-secondary mt-3">Voltar</a>
        </div>
    </div>
    <footer>
        &copy; <?= date('Y') ?> REVISTINHA. Todos os direitos reservados.
    </footer>
</body>
</html>
