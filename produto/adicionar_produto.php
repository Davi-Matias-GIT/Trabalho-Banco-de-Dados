<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $imagem = $_POST['imagem'];

    $stmt = $pdo->prepare("INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$nome, $descricao, $preco, $imagem])) {
        echo "<script>alert('Produto adicionado com sucesso!'); window.location.href='dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Erro ao adicionar produto.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto - Electry</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <header>
        <div class="logo">
            <h1>Adicionar Produto</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Início</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <?php if (!isset($_SESSION['usuario'])): ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="cadastro.php">Cadastro</a></li>
                <?php else: ?>
                    <li><a href="logout.php">Sair</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Preencha os detalhes do produto</h2>
        <form action="" method="post">
            <label for="nome">Nome:</label><br>
            <input type="text" id="nome" name="nome" required><br>

            <label for="descricao">Descrição:</label><br>
            <textarea id="descricao" name="descricao" required></textarea><br>

            <label for="preco">Preço:</label><br>
            <input type="number" id="preco" name="preco" step="0.01" required><br>

            <label for="imagem">URL da Imagem:</label><br>
            <input type="text" id="imagem" name="imagem"><br>

            <input type="submit" value="Adicionar Produto">
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Electry. Todos os direitos reservados.</p>
    </footer>

</body>
</html>