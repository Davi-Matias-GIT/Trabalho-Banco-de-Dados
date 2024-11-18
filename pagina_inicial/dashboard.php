<?php
session_start();
include 'db.php'; 

$stmt = $pdo->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial - Electry</title>
    <link rel="stylesheet" href="style.css"> 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
    <style>

        #menuButton {
            position: absolute;
            right: 20px;
            top: 20px;
        }

        #dropdownMenu {
            display: none;
            position: absolute;
            right: 20px;
            top: 60px;
            background-color: white;
            border: 1px solid #ccc;
            z-index: 1000;
        }

        #dropdownMenu a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: black;
        }

        #dropdownMenu a:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
<header>
    <img src="images/logo.png" alt="Logo da Empresa" style="max-width: 150px; height: auto;"> 
    <h1>Electry</h1>
    <button id="menuButton">Menu</button>
    <div id="dropdownMenu">
        <a href="carrinho.php">Carrinho</a>
        <a href="cadastro.html">Cadastro</a>
        <a href="login.html">Login</a>
        <?php if (isset($_SESSION['usuario'])): ?>
            <a href="sair.php">Sair</a>
        <?php endif; ?>
    </div>
</header>

<main>
    <h2>Produtos Disponíveis</h2>

    <?php if (count($produtos) > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($produto['id']); ?></td>
                        <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                        <td><?php echo htmlspecialchars($produto['descricao']); ?></td>
                        <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>

                        <td><img src="<?php echo htmlspecialchars($produto['imagem']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" style="width:100px;height:auto;"></td>

                        <td>
                            <button onclick="window.location.href='adicionar_ao_carrinho.php?id=<?php echo $produto['id']; ?>'">Adicionar ao Carrinho</button> 
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

<script>
document.getElementById('menuButton').addEventListener('click', function() {
    var menu = document.getElementById('dropdownMenu');
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
});

window.onclick = function(event) {
    if (!event.target.matches('#menuButton')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.style.display === 'block') {
                openDropdown.style.display = 'none';
            }
        }
    }
}
</script>

</body>
