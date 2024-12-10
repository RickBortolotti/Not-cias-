<!-- login.php -->
<?php
include '../includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? AND password = ?');
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Usuário ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login REVISTINHA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="logo.jpg" type="image/png">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #2c3e50;
            color: #ecf0f1;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            background: #34495e;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }
        .login-container .btn-primary {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }
        .login-container .form-control {
            background-color: #2c3e50;
            color: #ecf0f1;
        }
        .login-container .form-label {
            color: #ecf0f1;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2 class="text-center">Login</h2>
    <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Usuário</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
