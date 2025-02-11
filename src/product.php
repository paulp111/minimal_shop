<?php
namespace Webshop;

class Product {
    protected Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    // Alle Produkte abrufen
    public function getAllProducts(): array {
        return $this->db->query("SELECT * FROM products");
    }

    // Produkt hinzufügen
    public function addProduct(string $name, float $price, string $image, string $description): bool {
        return $this->db->query("INSERT INTO products (name, price, image, description) VALUES (?, ?, ?, ?)", 
            [$name, $price, $image, $description]);
    }

    // Produkt löschen
    public function deleteProduct(int $id): bool {
        return $this->db->query("DELETE FROM products WHERE id = ?", [$id]);
    }

    // Produkt bearbeiten
    public function updateProduct(int $id, string $name, float $price, string $image, string $description): bool {
        return $this->db->query("UPDATE products SET name = ?, price = ?, image = ?, description = ? WHERE id = ?", 
            [$name, $price, $image, $description, $id]);
    }
}
