<?php
$conn = new mysqli("localhost", "root", "", "banco_bibliotecaphp");

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>