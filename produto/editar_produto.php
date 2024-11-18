<?php
session_start();
include 'db.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto - Electry</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <header>
        <div class="logo">
            <h1>Editar Produto</h1>
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
        <h2>Selecione um Produto para Editar</h2>

        <?php if (count($produtos) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Ações</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                            <td><?php echo htmlspecialchars($produto['descricao']); ?></td>
                            <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                            <td>
                                
                                <a href="editar_produto_form.php?id=<?php echo $produto['id']; ?>">Editar</a> 
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum produto disponível.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 Electry. Todos os direitos reservados.</p>
    </footer>

</body>
</html>
