<?php
try {
    $db = new PDO("mysql:host=127.0.0.1;dbname=test;", 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo 'DB 연결 못함';
    exit;
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="dishes.csv"');

$fh = fopen("php://output", "wb");

$dishes = $db->query("SELECT dish_name, price, is_spicy FROM dishes");
while ($row = $dishes->fetch(PDO::FETCH_NUM)) {
    fputcsv($fh, $row);
}