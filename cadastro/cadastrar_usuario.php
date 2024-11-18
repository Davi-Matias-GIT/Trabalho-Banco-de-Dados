<?php
session_start();
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (empty($nome) || empty($email) || empty($senha)) {
        echo "<script>alert('Todos os campos são obrigatórios.'); window.location.href='cadastro.html';</script>";
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Email já cadastrado.'); window.location.href='cadastro.html';</script>";
        exit();
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    
    try {
        if ($stmt->execute([$nome, $email, $senhaHash])) {
            echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='login.html';</script>";
            exit();
        } else {
            echo "<script>alert('Erro ao cadastrar usuário.'); window.location.href='cadastro.html';</script>";
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { 
            echo "<script>alert('Email já cadastrado.'); window.location.href='cadastro.html';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar usuário: " . htmlspecialchars($e->getMessage()) . "'); window.location.href='cadastro.html';</script>";
        }
        exit();
    }
}
?>