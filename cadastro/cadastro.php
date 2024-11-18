<?php
session_start();
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $senha = md5($_POST["senha"]); 

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE login = ?");
    $stmt->execute([$login]);

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Esse login já existe'); window.location.href='cadastro.php';</script>";
        die();
    } else {

        $stmt = $pdo->prepare("INSERT INTO usuarios (login, senha) VALUES (?, ?)");
        if ($stmt->execute([$login, $senha])) {
            echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar usuário'); window.location.href='cadastro.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Electry</title>
</head>
<body>

<h2>Cadastro de Usuário</h2>

<form method="POST" action="">
    <label for="login">Email:</label><br>
    <input type="text" name="login" id="login" required><br>

    <label for="senha">Senha:</label><br>
    <input type="password" name="senha" id="senha" required><br>

    <input type="submit" value="Cadastrar"><br>

    Já tem uma conta? <a href="login.php">Faça login aqui!</a> 
</form>

</body>
</html>