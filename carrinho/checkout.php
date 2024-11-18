<?php
session_start();

if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
    echo "<script>alert('Seu carrinho está vazio.'); window.location.href='produtos.php';</script>";
    exit();
}


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Electry</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

<header>
    <h1>Finalizar Compra</h1>
</header>

<main>
    <form action="processar_compra.php" method="post">
        Nome: <input type="text" name="nome" required><br />
        Endereço: <input type="text" name="endereco" required><br />
        Telefone: <input type="text" name="telefone" required><br />
        Email: <input type="email" name="email" required><br />

        <button type="submit">Confirmar Compra</button>
    </form>
</main>

<footer>
    &copy; 2024 Electry. Todos os direitos reservados.
</footer>

</body>
</html>
