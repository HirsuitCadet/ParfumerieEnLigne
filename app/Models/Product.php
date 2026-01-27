<?php

class Product
{
    // Mapping identique à ton enum MudBlazor (à ajuster si besoin)
    private static array $categoryMap = [
        "cosmetiques" => 0,
        "capillaires" => 1,
        "miel" => 2,
        "maison" => 3,
        "brumes" => 4,
        "musc" => 5,
        "intime" => 5,
        "parfums" => 6,
        "gourmet" => 7,
    ];
    private static ?string $categoryColumn = null;

    public static function categoryIdFromSlug(?string $slug): ?int
    {
        if (!$slug) return null;
        $slug = strtolower(trim($slug));
        return self::$categoryMap[$slug] ?? null;
    }

    private static function resolveCategoryColumn(PDO $pdo): ?string
    {
        if (self::$categoryColumn !== null) {
            return self::$categoryColumn;
        }

        $stmt = $pdo->query("SHOW COLUMNS FROM products");
        $columns = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            if (!isset($row["Field"])) {
                continue;
            }
            $columns[strtolower($row["Field"])] = $row["Field"];
        }

        $candidates = ["category", "category_id", "categorie", "categorie_id", "type", "product_category", "cat"];
        foreach ($candidates as $candidate) {
            if (isset($columns[$candidate])) {
                self::$categoryColumn = $columns[$candidate];
                return self::$categoryColumn;
            }
        }

        self::$categoryColumn = null;
        return null;
    }

    private static function categorySelect(PDO $pdo): string
    {
        $col = self::resolveCategoryColumn($pdo);
        return $col ? ($col . " AS category") : "NULL AS category";
    }

    public static function all(PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT id, name, description, price, image, " . self::categorySelect($pdo) . " FROM products ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function byCategory(PDO $pdo, int $categoryId): array
    {
        $col = self::resolveCategoryColumn($pdo);
        if (!$col) {
            return [];
        }
        $stmt = $pdo->prepare("SELECT id, name, description, price, image, " . self::categorySelect($pdo) . "
                               FROM products
                               WHERE " . $col . " = ?
                               ORDER BY id DESC");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(PDO $pdo, int $id): ?array
    {
        $stmt = $pdo->prepare("SELECT id, name, description, price, image, " . self::categorySelect($pdo) . " FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $p = $stmt->fetch(PDO::FETCH_ASSOC);
        return $p ?: null;
    }
}
