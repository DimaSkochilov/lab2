<?php

try {
	$pdo = new PDO('mysql:dbname=crud; host=127.0.0.1', 'root', 'root');
} catch (PDOException $e) {
	die($e->getMessage());
}