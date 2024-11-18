<?php
session_start();
include 'db.php'; 

if (isset($_GET['id'])) {
    $produtoId = intval($_GET['id']);
    
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->execute([$produtoId]);
    
    if ($stmt->rowCount() > 0) {
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = []; 
        }

        $found = false;
        foreach ($_SESSION['carrinho'] as &$item) {
            if ($item['id'] === $produto['id']) {
                $item['quantidade']++; 
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $_SESSION['carrinho'][] = [
                'id' => $produto['id'],
                'nome' => $produto['nome'],
                'preco' => $produto['preco'],
                'quantidade' => 1 
            ];
        }
        
        echo "<script>alert('Produto adicionado ao carrinho!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Produto não encontrado.'); window.location.href='produtos.php';</script>";
    }
} else {
    echo "<script>alert('ID do produto não especificado.'); window.location.href='produtos.php';</script>";
}
?>