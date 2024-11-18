<?php
include 'db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade_estoque = $_POST['quantidade_estoque'];

    $stmt = $pdo->prepare("UPDATE produtos SET nome=?, descricao=?, preco=?, quantidade_estoque=? WHERE id=?");
    $stmt->execute([$nome, $descricao, $preco, $quantidade_estoque, $id]);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Produto</title>
</head>
<body>
    <h1>Atualizar Produto</h1>
    <form method="post">
        Nome: <input type="text" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required><br>
        Descrição: <textarea name="descricao" required><?php echo htmlspecialchars($produto['descricao']); ?></textarea><br>
        Preço: <input type="text" name="preco" value="<?php echo htmlspecialchars($produto['preco']); ?>" required><br>
        Quantidade em Estoque: <input type="number" name="quantidade_estoque" value="<?php echo htmlspecialchars($produto['quantidade_estoque']); ?>" required><br>
        <input type="submit" value="Atualizar">
    </form>
</body>
</html>
