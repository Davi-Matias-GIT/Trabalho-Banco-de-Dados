<?php
session_start();
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $imagem = $_POST['imagem'];

    $stmt = $pdo->prepare("INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $descricao, $preco, $imagem]);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
}

if (isset($_POST['edit_product'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $imagem = $_POST['imagem'];

    $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, descricao = ?, preco = ?, imagem = ? WHERE id = ?");
    $stmt->execute([$nome, $descricao, $preco, $imagem, $id]);
}

$stmt = $pdo->query("SELECT * FROM produtos");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalVendasStmt = $pdo->query("SELECT SUM(ip.quantidade) AS total_sales FROM itens_pedido ip");
$totalVendas = $totalVendasStmt->fetchColumn();

$salesByIdStmt = $pdo->query("
    SELECT p.id, p.nome, SUM(ip.quantidade) AS total_sales 
    FROM itens_pedido ip 
    JOIN produtos p ON ip.produto_id = p.id 
    GROUP BY p.id");
$salesByIdData = $salesByIdStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produtos - Electry</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            drawTotalSalesChart();
            drawSalesByIdChart();
        }

        function drawTotalSalesChart() {
            var data = google.visualization.arrayToDataTable([
                ['Vendas', 'Total'],
                ['Total Vendas', <?php echo intval($totalVendas); ?>]
            ]);

            var options = {
                title: 'Total de Vendas',
                width: 300,
                height: 200,
                legend: { position: 'none' },
            };

            var chart = new google.visualization.BarChart(document.getElementById('total_sales_chart'));
            chart.draw(data, options);
        }

        function drawSalesByIdChart() {
            var data = google.visualization.arrayToDataTable([
                ['Produto', 'Vendas'],
                <?php
                foreach ($salesByIdData as $row) {
                    echo "['" . htmlspecialchars($row['nome']) . "', " . intval($row['total_sales']) . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Vendas por ID',
                width: 300,
                height: 200,
                pieHole: 0.4,
            };

            var chart = new google.visualization.PieChart(document.getElementById('sales_by_id_chart'));
            chart.draw(data, options);
        }
    </script>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

<header>
    <h1>Adicionar Produtos - Electry</h1>
</header>

<main>
    <h2>Adicionar Produto</h2>
    <form method="post" action="">
        Nome: <input type="text" name="nome" required><br />
        Descrição: <input type="text" name="descricao"><br />
        Preço: <input type="text" name="preco" required><br />
        Imagem: <input type="text" name="imagem"><br /> 
        <button type="submit" name="add_product">Adicionar Produto</button>
    </form>

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
                          
                            <form method="post" action="">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($produto['id']); ?>">
                                Nome: <input type="text" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required><br />
                                Descrição: <input type="text" name="descricao" value="<?php echo htmlspecialchars($produto['descricao']); ?>"><br />
                                Preço: <input type="text" name="preco" value="<?php echo htmlspecialchars($produto['preco']); ?>" required><br />
                                Imagem: <input type="text" name="imagem" value="<?php echo htmlspecialchars($produto['imagem']); ?>"><br />
                                <button type="submit" name="edit_product">Editar</button>
                            </form>

                            <a href="?delete=<?php echo htmlspecialchars($produto['id']); ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum produto disponível.</p>
    <?php endif; ?>

<div id="total_sales_chart" style="width: 300px; height: 200px; margin-top: 20px;"></div>
<div id="sales_by_id_chart" style="width: 300px; height: 200px; margin-top: 20px;"></div>

<footer>
<p>&copy; 2024 Electry. Todos os direitos reservados.</p>
</footer>

</body>

</html>