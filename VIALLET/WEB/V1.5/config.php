<?php
session_start();

try {
    $pdo = new PDO(
    "mysql:host=127.0.0.1;dbname=SDS1;charset=utf8",
    "root",
    "",
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

} catch (PDOException $e) {
    die("Erreur PDO : " . $e->getMessage());
}


