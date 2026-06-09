<?php
/**
 * ARQUIVO: SALVAR TEMA
 * Papel: Fios Elétricos e Memória do Interruptor
 */

// A COLA
include '../includes/conexao.php';

// AS FUNÇÕES DA BIBLIOTECA
require_once '../includes/functions.php';

// O SEGURANÇA DA PORTA
verificarLogado();

// O SINAL DO CLIQUE
if (isset($_POST['tema'])) {
    
    // O LIMITADOR DO INTERRUPTOR
    $tema = $_POST['tema'] === 'escuro' ? 'escuro' : 'claro';
    
    // EMBLEMA DO CLIENTE
    $usuario_id = $_SESSION['usuario_id'];
    
    // MEMÓRIA CURTA 
    $_SESSION['tema'] = $tema;
    
    // MEMÓRIA LONGA 
    $stmt = $conn->prepare("UPDATE usuarios SET tema = ? WHERE id = ?");
    
    // COMPATIBILIDADE DOS DADOS
    $stmt->bind_param("si", $tema, $usuario_id);
    
    // ATUALIZANDO O REGISTRO
    $stmt->execute();
    
    // RESPOSTA PARA O INTERRUPTOR
    echo $tema; 
}
?>