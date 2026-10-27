
<?php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: http://localhost:5173');

require_once __DIR__ . '/../config/database.php';

try {
    $sql = "
        SELECT
            p.id,
            p.name,
            p.slug,
            p.brand,
            p.description,
            p.price,
            p.stock_quantity,
            p.condition_type,
            p.image_url,
            c.name AS category
        FROM products p
        INNER JOIN categories c
            ON p.category_id = c.id
        WHERE p.status = 'active'
        ORDER BY p.created_at DESC
    ";

    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'data' => $products
    ]);

} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Unable to retrieve products.'
    ]);
}
