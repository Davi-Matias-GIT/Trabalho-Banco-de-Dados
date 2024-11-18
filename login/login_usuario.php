<?php
session_start();
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (empty($email) || empty($senha)) {
        echo "<script>alert('Todos os campos são obrigatórios.'); window.location.href='login.html';</script>";
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() === 0) {
        echo "<script>alert('Email não encontrado.'); window.location.href='login.html';</script>";
        exit();
    }

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($senha, $usuario['senha'])) {
      
        $_SESSION['usuario'] = $usuario['nome'];
        echo "<script>alert('Login realizado com sucesso!'); window.location.href='dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Senha incorreta.'); window.location.href='login.html';</script>";
        exit();
    }
}
?>