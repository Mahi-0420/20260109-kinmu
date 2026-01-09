<?php
$host = 'localhost';
$dbname = 'kintaidb';
$user = 'kintaiuser';
$pass = 'kintaipass123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("接続エラー: " . $e->getMessage());
}
?>