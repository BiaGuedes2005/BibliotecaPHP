<?php
/**
 * ARQUIVO: EXCLUIR LIVRO
 * Papel: O Caminhão de Descarte do Cliente (Remoção definitiva)
 */

// A COLA 
include '../includes/conexao.php';

// AS FUNÇÕES DA BIBLIOTECA
require_once '../includes/functions.php';

// O SEGURANÇA DA PORTA
verificarLogado();

// O BILHETE DA URL
if (isset($_GET['id'])) {
    
    // CONVERSÃO DE SEGURANÇA
    $id = (int)$_GET['id'];
    
    // EMBLEMA DO CLIENTE
    $usuario_id = $_SESSION['usuario_id'];

    // --- SEGURANÇA EXTREMA (O TRITURADOR) ---

    $stmt = $conn->prepare("DELETE FROM livros WHERE id = ? AND usuario_id = ?");
    
    // CARIMBO DOS DADOS
    $stmt->bind_param("ii", $id, $usuario_id);
    
    // EXECUTANDO O DESCARTE
    $stmt->execute();
}


header("Location: perfil.php");

// PORTA TRANCADA
exit();
?>