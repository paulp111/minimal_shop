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

// Produkt bearbeiten
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["edit_product"])) {
    $id = (int)$_POST["product_id"];
    $name = $_POST["name"];
    $price = (float)$_POST["price"];
    $image = $_POST["image"];
    $description = $_POST["description"];

    if ($product->updateProduct($id, $name, $price, $image, $description)) {
        echo "<p>Produkt erfolgreich bearbeitet!</p>";
    } else {
        echo "<p>Fehler beim Bearbeiten.</p>";
    }
}

// Anzahl der Produkte abrufen
$product_count = $db->query("SELECT COUNT(*) as count FROM products")[0]['count'];

// Verkaufsstatistik abrufen
$sales = $db->query("SELECT p.name, COUNT(s.id) as total_sales 
                     FROM sales s 
                     JOIN products p ON s.product_id = p.id 
                     GROUP BY s.product_id");

$products = $product->getAllProducts();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/pico.classless.min.css">
</head>
<body>
    <main class="container">
        <h1>Admin Panel</h1>

        <h2>Neues Produkt hinzufügen</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Produktname" required>
            <input type="number" name="price" placeholder="Preis" step="0.01" required>
            <input type="text" name="image" placeholder="Bild-URL">
            <textarea name="description" placeholder="Beschreibung"></textarea>
            <button type="submit" name="add_product">Hinzufügen</button>
        </form>

        <h2>Produkte bearbeiten</h2>
        <form method="POST">
            <select name="product_id">
                <?php foreach ($products as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?> - <?= $p['price'] ?>€</option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="name" placeholder="Neuer Name" required>
            <input type="number" name="price" placeholder="Neuer Preis" step="0.01" required>
            <input type="text" name="image" placeholder="Neue Bild-URL">
            <textarea name="description" placeholder="Neue Beschreibung"></textarea>
            <button type="submit" name="edit_product">Bearbeiten</button>
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

        <h2>Statistik</h2>
        <h3>Gesamtzahl der Produkte: <?= $product_count ?></h3>

        <h3>Verkäufe</h3>
        <table>
            <thead>
                <tr>
                    <th>Produkt</th>
                    <th>Anzahl verkauft</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td><?= htmlspecialchars($sale['name']) ?></td>
                        <td><?= $sale['total_sales'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
