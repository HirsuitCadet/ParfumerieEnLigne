<?php

class Order
{
    private static ?string $userColumn = null;

    private static function resolveUserColumn(PDO $pdo): ?string
    {
        if (self::$userColumn !== null) {
            return self::$userColumn;
        }

        $stmt = $pdo->query("SHOW COLUMNS FROM orders");
        $columns = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            if (!isset($row["Field"])) {
                continue;
            }
            $columns[strtolower($row["Field"])] = $row["Field"];
        }

        $candidates = ["user_id", "customer_id", "client_id"];
        foreach ($candidates as $candidate) {
            if (isset($columns[$candidate])) {
                self::$userColumn = $columns[$candidate];
                return self::$userColumn;
            }
        }

        self::$userColumn = null;
        return null;
    }

    public static function create(PDO $pdo, array $user, array $items, float $totalTtc): int
    {
        $userColumn = self::resolveUserColumn($pdo);
        $customerName = trim(($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? ''));
        $customerEmail = $user['email'] ?? '';

        $pdo->beginTransaction();
        try {
            if ($userColumn) {
                $stmt = $pdo->prepare("INSERT INTO orders ($userColumn, customer_name, customer_email, total) VALUES (?, ?, ?, ?)");
                $stmt->execute([(int) $user['id'], $customerName, $customerEmail, $totalTtc]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_email, total) VALUES (?, ?, ?)");
                $stmt->execute([$customerName, $customerEmail, $totalTtc]);
            }

            $orderId = (int) $pdo->lastInsertId();
            $itemStmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($items as $item) {
                $itemStmt->execute([
                    $orderId,
                    (int) $item['id'],
                    (int) $item['quantity'],
                    (float) $item['price']
                ]);
            }

            $pdo->commit();
            return $orderId;
        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function listForUser(PDO $pdo, array $user): array
    {
        $userColumn = self::resolveUserColumn($pdo);

        if ($userColumn) {
            $stmt = $pdo->prepare("SELECT id, customer_name, customer_email, total, created_at FROM orders WHERE $userColumn = ? ORDER BY created_at DESC");
            $stmt->execute([(int) $user['id']]);
        } else {
            $stmt = $pdo->prepare("SELECT id, customer_name, customer_email, total, created_at FROM orders WHERE customer_email = ? ORDER BY created_at DESC");
            $stmt->execute([$user['email'] ?? '']);
        }

        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($orders)) {
            return [];
        }

        $orderIds = array_map(fn($o) => (int) $o['id'], $orders);
        $placeholders = implode(',', array_fill(0, count($orderIds), '?'));
        $itemsStmt = $pdo->prepare(
            "SELECT oi.order_id, oi.product_id, oi.quantity, oi.price, p.name, p.image
             FROM order_items oi
             LEFT JOIN products p ON p.id = oi.product_id
             WHERE oi.order_id IN ($placeholders)
             ORDER BY oi.id ASC"
        );
        $itemsStmt->execute($orderIds);
        $items = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);

        $byOrder = [];
        foreach ($items as $item) {
            $oid = (int) $item['order_id'];
            if (!isset($byOrder[$oid])) {
                $byOrder[$oid] = [];
            }
            $byOrder[$oid][] = $item;
        }

        foreach ($orders as &$order) {
            $oid = (int) $order['id'];
            $order['items'] = $byOrder[$oid] ?? [];
        }
        unset($order);

        return $orders;
    }
}
