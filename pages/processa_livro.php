<?php
include '../includes/conexao.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo    = trim($_POST['titulo']);
    $autor     = trim($_POST['autor']);
    $editora   = trim($_POST['editora']);
    $ano       = trim($_POST['ano']);
    $categoria = trim($_POST['categoria']);
    $sobre     = trim($_POST['sobre']);
    $descricao = trim($_POST['descricao']);
    $valor     = trim($_POST['valor']);
    $img_url   = trim($_POST['img_url']);
    $usuario_id = $_SESSION['usuario_id'];

    $stmt = $conn->prepare("INSERT INTO livros (titulo, autor, editora, ano, categoria, sobre, descricao, valor, img_url, usuario_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssissssi", $titulo, $autor, $editora, $ano, $categoria, $sobre, $descricao, $valor, $img_url, $usuario_id);

    if ($stmt->execute()) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "<script>alert('Erro ao cadastrar livro. Tente novamente.'); window.history.back();</script>";
    }
}
?>