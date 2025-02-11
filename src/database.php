<?php
namespace Webshop;

class Database {
    protected \mysqli $mysqli;

    public function __construct() {
        $this->mysqli = new \mysqli("localhost", "root", "", "shopify", 3306);
        if ($this->mysqli->connect_error) {
            die("DB-Fehler: " . $this->mysqli->connect_error);
        }
    }

    public function query(string $sql, array $params = []): array|bool|\mysqli_result {
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt) return false;

        if (!empty($params)) {
            $types = str_repeat("s", count($params));
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return str_starts_with(strtolower($sql), "select") ? $stmt->get_result()->fetch_all(MYSQLI_ASSOC) : true;
    }
}
