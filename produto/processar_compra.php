<?php
session_start();
include 'db.php'; 

if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
    echo "<script>alert('Seu carrinho está vazio.'); window.location.href='produtos.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do cliente
    $nome = trim($_POST['nome']);
    $endereco = trim($_POST['endereco']);
    $telefone = trim($_POST['telefone']);
    $email = trim($_POST['email']);

    if (empty($nome) || empty($endereco) || empty($telefone) || empty($email)) {
        echo "<script>alert('Todos os campos são obrigatórios.'); window.location.href='checkout.php';</script>";
        exit();
    }

    try {
   
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO pedidos (nome, endereco, telefone, email) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $endereco, $telefone, $email]);
        
        $pedidoId = $pdo->lastInsertId();

        foreach ($_SESSION['carrinho'] as $item) {
          
            $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM produtos WHERE id = ?");
            $stmtCheck->execute([$item['id']]);
            if ($stmtCheck->fetchColumn() == 0) {
                throw new Exception("Produto com ID {$item['id']} não encontrado.");
            }

          
            $stmt = $pdo->prepare("INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco) VALUES (?, ?, ?, ?)");
            $stmt->execute([$pedidoId, $item['id'], $item['quantidade'], $item['preco']]);
        }

       
        $pdo->commit();

        unset($_SESSION['carrinho']);

        echo "<script>alert('Compra finalizada com sucesso!'); window.location.href='dashboard.php';</script>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script>alert('Erro ao processar a compra: " . htmlspecialchars($e->getMessage()) . "'); window.location.href='checkout.php';</script>";
    }
} else {
    echo "<script>alert('Método não permitido.'); window.location.href='checkout.php';</script>";
}
?>