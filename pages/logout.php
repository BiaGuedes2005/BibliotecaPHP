<?php
/**
 * ARQUIVO: LOGOUT
 * Papel: Sair da Biblioteca e Devolver o Crachá
 */

// A COLA
include '../includes/conexao.php'; 
?>

<?php
// ENTRANDO NA SALA DE PROTOCOLO
session_start(); 

// ESVAZIANDO OS BOLSOS (Limpeza)
session_unset(); 

// QUEIMANDO O CRACHÁ (Destruição)
session_destroy(); 

// EXPULSÃO AMIGÁVEL
header("Location: login.php");

// PORTA TRANCADA
exit();
?>