<?php
session_start();
include 'db.php';

$stmtTotal = $pdo->prepare("SELECT SUM(ip.quantidade) AS total_sales 
                             FROM itens_pedido ip");
$stmtTotal->execute();
$totalSales = $stmtTotal->fetchColumn();

$stmtById = $pdo->prepare("SELECT p.id, p.nome, SUM(ip.quantidade) AS total_sales 
                            FROM itens_pedido ip 
                            JOIN produtos p ON ip.produto_id = p.id 
                            GROUP BY p.id");
$stmtById->execute();
$salesById = $stmtById->fetchAll(PDO::FETCH_ASSOC);

$data = [
    'total' => intval($totalSales),
    'by_id' => array_map(function($sale) {
        return [
            'id' => intval($sale['id']),
            'name' => $sale['nome'],
            'total_sales' => intval($sale['total_sales'])
        ];
    }, $salesById)
];

header('Content-Type: application/json');
echo json_encode($data);
?>