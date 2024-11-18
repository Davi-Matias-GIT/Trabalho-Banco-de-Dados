<?php
session_start();
include 'db.php'; 

if (isset($_POST['excluir'])) {
    
    if (isset($_POST['produtos'])) {
        foreach ($_POST['produtos'] as $produtoId => $quantidade) {
            $produtoId = intval($produtoId);
            $quantidade = intval($quantidade);

            foreach ($_SESSION['carrinho'] as $key => $item) {
                if ($item['id'] == $produtoId) {
                    if ($item['quantidade'] > $quantidade) {
                        $_SESSION['carrinho'][$key]['quantidade'] -= $quantidade;
                    } else {
                        unset($_SESSION['carrinho'][$key]);
                    }
                }
            }
        }
        echo "<script>alert('Produtos removidos do carrinho!'); window.location.href='carrinho.php';</script>";
    } else {
        echo "<script>alert('Nenhum produto selecionado.'); window.location.href='carrinho.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho - Electry</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <header>
    <img src="images/logo.png" alt="Logo da Empresa" style="max-width: 150px; height: auto;"> 
        <h1>Carrinho de Compras</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="produtos.php">Produtos</a></li>
                <li><a href="cadastro.html">Cadastro</a></li>
                <li><a href="login.html">Login</a></li>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <li><a href="sair.php">Sair</a></li> 
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Itens no Carrinho</h2>

        <?php if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0): ?>
            <form method="post" action="">
                <table border="1">
                    <thead>
                        <tr>
                            <th>Selecionar</th>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Total</th>
                            <th>Excluir Quantidade</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $totalCarrinho = 0;
                        foreach ($_SESSION['carrinho'] as $item): 
                            $totalItem = $item['preco'] * $item['quantidade'];
                            $totalCarrinho += $totalItem;
                        ?>
                            <tr>
                                
                                <td><input type="checkbox" name="produtos[<?php echo htmlspecialchars($item['id']); ?>]" value="<?php echo htmlspecialchars($item['quantidade']); ?>"></td>

                                <td><?php echo htmlspecialchars($item['id']); ?></td>
                                <td><?php echo htmlspecialchars($item['nome']); ?></td>

                                <td><?php echo isset($item['descricao']) ? htmlspecialchars($item['descricao']) : 'Sem descrição'; ?></td>

                                <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                                <td><?php echo htmlspecialchars($item['quantidade']); ?></td>
                                <td>R$ <?php echo number_format($totalItem, 2, ',', '.'); ?></td>

                                <td><input type="number" name="produtos[<?php echo htmlspecialchars($item['id']); ?>]" min="0" max="<?php echo htmlspecialchars($item['quantidade']); ?>" value="0"></td> 
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <button type="submit" name="excluir">Excluir Selecionados</button>

                <h3>Total do Carrinho: R$ <?php echo number_format($totalCarrinho, 2, ',', '.'); ?></h3>

            </form>

            <form action="checkout.php" method="post">
                <button type="submit">Finalizar Compra</button> 
            </form>

        <?php else: ?>
            <p>Nenhum item no carrinho.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 Electry. Todos os direitos reservados.</p>
    </footer>

</body>
</html>
