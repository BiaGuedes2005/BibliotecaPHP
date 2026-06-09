<?php
/**
 * ARQUIVO: EXCLUIR LIVRO (ADM)
 * Papel: O Poder de Confisco do Diretor (Exclusão Lógica com Backup de Título)
 */

// A COLA 
include '../includes/conexao.php';

// AS FUNÇÕES DA BIBLIOTECA
require_once '../includes/functions.php';

// O SEGURANÇA DA PORTA
verificarLogado();

// --- BARREIRA DE PATENTE (SEGURANÇA DO DIRETOR) ---

if ($_SESSION['usuario_tipo'] !== 'adm') {
    header("Location: ../index.php"); 
    exit();
}

// O ALVO DO CONFISCO
if (isset($_GET['id'])) {
    
    // CONVERSÃO DE SEGURANÇA
    $id_livro = (int)$_GET['id'];

    // --- EXCLUSÃO LÓGICA E CAIXA PRETA ---
  
    $stmt = $conn->prepare("UPDATE livros SET excluido_adm = 1, titulo_original = titulo WHERE id = ?");
    
    // CARIMBO DE DADOS
    $stmt->bind_param("i", $id_livro);
    
    // EXECUTANDO O CONFISCO:
    if ($stmt->execute()) {
      
        header("Location: adm_dashboard.php#livros");
    }
    
    // PORTA TRANCADA
    exit();
}
?>