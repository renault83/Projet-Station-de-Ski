<?php

session_start();

try {
    $pdo = new PDO(
    "mysql:host=192.168.3.2;dbname=SDS;charset=utf8",
    "renaud",
    "123456",
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

} catch (PDOException $e) {
    die("Erreur PDO : " . $e->getMessage());
}