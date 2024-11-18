<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;
    $preco = isset($_POST['preco']) ? $_POST['preco'] : null;
    $quantidade_estoque = isset($_POST['quantidade_estoque']) ? $_POST['quantidade_estoque'] : null;

    if ($nome && $descricao && $preco !== null && $quantidade_estoque !== null) {
       
        $stmt = $pdo->prepare("INSERT INTO produtos (nome, descricao, preco, quantidade_estoque) VALUES (?, ?, ?, ?)");
        
        if ($stmt->execute([$nome, $descricao, $preco, $quantidade_estoque])) {
            echo "Produto cadastrado com sucesso!";
            header("Location: index.html"); 
            exit();
        } else {
            echo "Erro ao cadastrar produto.";
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
</head>
<body>
    <button onclick="window.location.href='index.html'">Voltar para a Página Inicial</button>
</body>
</html>