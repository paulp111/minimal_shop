<?php
use Webshop\Database;
use Webshop\Product;

require_once __DIR__ . '/../src/database.php';
require_once __DIR__ . '/../src/product.php';

$db = new Database();
$product = new Product($db);
$products = $product->getAllProducts();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <link rel="stylesheet" href="../public/css/pico.classless.min.css">

</head>
<body>
    <h1>Willkommen im Webshop</h1>
    <div>
        <?php foreach ($products as $p): ?>
            <div>
                <h2><?= htmlspecialchars($p['name']) ?></h2>
                <p>Preis: <?= number_format($p['price'], 2) ?> €</p>
                <p><?= htmlspecialchars($p['description']) ?></p>
                <button style="padding: 10px 20px; font-size: 16px; width: 200px;"
        onclick="alert('Produkt <?= $p['name'] ?> wurde hinzugefügt')">
    Add to Cart
</button>
            </div>

        <?php endforeach; ?>
    </div>
</body>
</html>
