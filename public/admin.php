<?php
use Webshop\Database;
use Webshop\Product;

require_once __DIR__ . '/../src/database.php';
require_once __DIR__ . '/../src/product.php';

$db = new Database();
$product = new Product($db);

// Produkt hinzufügen
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_product"])) {
    $name = $_POST["name"];
    $price = (float)$_POST["price"];
    $image = $_POST["image"];
    $description = $_POST["description"];
    
    if ($product->addProduct($name, $price, $image, $description)) {
        echo "<p>Produkt hinzugefügt!</p>";
    } else {
        echo "<p>Fehler beim Hinzufügen!</p>";
    }
}

// Produkt löschen
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_product"])) {
    $id = (int)$_POST["product_id"];
    
    if ($product->deleteProduct($id)) {
        echo "<p>Produkt gelöscht!</p>";
    } else {
        echo "<p>Fehler beim Löschen!</p>";
    }
}

$products = $product->getAllProducts();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../public/css/pico.classless.min.css">
</head>
<body>
    <h1>Admin Panel</h1>

    <h2>Neues Produkt hinzufügen</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Produktname" required>
        <input type="number" name="price" placeholder="Preis" step="0.01" required>
        <input type="text" name="image" placeholder="Bild-URL">
        <textarea name="description" placeholder="Beschreibung"></textarea>
        <button type="submit" name="add_product">Hinzufügen</button>
    </form>

    <h2>Produkte löschen</h2>
    <form method="POST">
        <select name="product_id">
            <?php foreach ($products as $p): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?> - <?= $p['price'] ?>€</option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="delete_product">Löschen</button>
    </form>
</body>
</html>
