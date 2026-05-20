<?php
include '../includes/conexao.php';
require_once '../includes/functions.php';
verificarLogado();

if (isset($_POST['tema'])) {
    $tema = $_POST['tema'] === 'escuro' ? 'escuro' : 'claro';
    $usuario_id = $_SESSION['usuario_id'];
    
    // Salva na sessão
    $_SESSION['tema'] = $tema;
    
    // Salva no banco
    $stmt = $conn->prepare("UPDATE usuarios SET tema = ? WHERE id = ?");
    $stmt->bind_param("si", $tema, $usuario_id);
    $stmt->execute();
    
    echo $tema; // retorna o tema para o JS
}
?>