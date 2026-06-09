<?php
/**
 * ARQUIVO: EXCLUIR USUÁRIO (ADM)
 * Papel: O Poder de Banimento do Diretor (Exclusão Lógica)
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

// O ALVO DO BANIMENTO
if (isset($_GET['id'])) {
    
    // CONVERSÃO DE SEGURANÇA
    $id_usuario = (int)$_GET['id'];

    // --- TRAVA ANTI-AUTODESTRUIÇÃO ---
    if ($id_usuario === $_SESSION['usuario_id']) {
        header("Location: adm_dashboard.php?erro=autoeleminacao");
        exit();
    }

    // --- O CARIMBO DO BANIMENTO (EXCLUSÃO LÓGICA) ---
    
    $stmt = $conn->prepare("UPDATE usuarios SET excluido_adm = 1 WHERE id = ?");
    $stmt->bind_param("i", $id_usuario);
    
    // EXECUTANDO A SENTENÇA:
    if ($stmt->execute()) {
        header("Location: adm_dashboard.php#usuarios");
    } else {
        echo "Erro ao excluir o usuário.";
    }
    exit();
} else {
    // Se o arquivo foi acessado por engano sem passar nenhum ID de usuário, apenas volta para o painel.
    header("Location: adm_dashboard.php");
    exit();
}
?>