<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade_estoque = $_POST['quantidade_estoque'];

    $stmt = $pdo->prepare("INSERT INTO produtos (nome, descricao, preco, quantidade_estoque) VALUES (?, ?, ?, ?)");
    
    if ($stmt->execute([$nome, $descricao, $preco, $quantidade_estoque])) {
        echo "Produto cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar produto.";
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
    <h1>Cadastrar Produto</h1>

    <form method="post" action="">
        Nome: <input type="text" name="nome" required><br>
        Descrição: <textarea name="descricao" required></textarea><br>
        Preço: <input type="text" name="preco" required><br>
        Quantidade em Estoque: <input type="number" name="quantidade_estoque" required><br>
        <input type="submit" value="Cadastrar">
    </form>

    <form action="index.php">
        <input type="submit" value="Voltar para a Página Inicial">
    </form>
</body>
</html>