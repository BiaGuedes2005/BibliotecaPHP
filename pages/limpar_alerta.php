<?php
/**
 * ARQUIVO: LIMPAR ALERTA
 * Papel: Lixeira de Recados do Escritório Pessoal (Mudar status do aviso)
 */

// A COLA 
include '../includes/conexao.php';

// AS FUNÇÕES DA BIBLIOTECA
require_once '../includes/functions.php';

// O SEGURANÇA DA PORTA
verificarLogado();

// O BILHETE DO CLIQUE
if (isset($_GET['id'])) {
    
    // CONVERSÃO DE SEGURANÇA
    $id_livro = (int)$_GET['id'];
    
    // EMBLEMA DO CLIENTE

    // --- SEGURANÇA EXTREMA ---
    
    $stmt = $conn->prepare("UPDATE livros SET excluido_adm = 2 WHERE id = ? AND usuario_id = ?");
    
    // CARIMBO DOS DADOS
    $stmt->bind_param("ii", $id_livro, $usuario_id);
    
    // EXECUTANDO A LIMPEZA
    if ($stmt->execute()) {
        header("Location: perfil.php"); 
    }
    
    // PORTA TRANCADA
    exit();
}
?>