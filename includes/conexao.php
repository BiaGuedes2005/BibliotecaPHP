<?php
/**
 * ARQUIVO: CONEXÃO COM O BANCO DE DADOS
 * Papel: O Encanamento Principal (A Ponte entre o PHP e o MySQL)
 */

// ABERTURA DO ENCANAMENTO: 

$conn = new mysqli("localhost", "root", "", "banco_bibliotecaphp");

// TESTE DE PRESSÃO DOS CANOS:

if ($conn->connect_error) {
    // SISTEMA DE EMERGÊNCIA (Válvula de Escape):

    die("Erro na conexão: " . $conn->connect_error);
}

?>