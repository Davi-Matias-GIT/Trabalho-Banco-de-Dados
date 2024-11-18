<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $senha = md5($_POST["senha"]); 

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE login = ? AND senha = ?");
    $stmt->execute([$login, $senha]);
    
    if ($stmt->rowCount() > 0) {
        $_SESSION['usuario'] = $login;
        header("Location: dashboard.php"); 
        exit();
    } else {
        echo "<script>alert('Login e/ou senha incorretos'); window.location.href='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Electry</title>
</head>
<body>

<h2>Login de Usuário</h2>

<form method="POST" action="">
    <label for="login">Email:</label><br>
    <input type="text" name="login" id="login" required><br>

    <label for="senha">Senha:</label><br>
    <input type="password" name="senha" id="senha" required><br>

    <input type="submit" value="Entrar"><br>

    Não tem uma conta? <a href="cadastro.php">Cadastre-se aqui!</a>
</form>

</body>
</html>