<?php
/**
 * ARQUIVO: PROCESSA LIVRO
 * Papel: Despacho e Cadastro de Novos Livros na Estante
 */

// A COLA
include '../includes/conexao.php';

// AS FUNÇÕES DA BIBLIOTECA
require_once '../includes/functions.php';

// O ENVIO DO FORMULÁRIO
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    //MÁSCARA DE GÁS
    $titulo     = trim($_POST['titulo']);
    $autor      = trim($_POST['autor']);
    $editora    = trim($_POST['editora']);
    $ano        = trim($_POST['ano']);
    $categoria  = trim($_POST['categoria']);
    $sobre      = trim($_POST['sobre']);
    $descricao  = trim($_POST['descricao']);
    $valor      = trim($_POST['valor']);
    $img_url    = trim($_POST['img_url']);
    
    // CARIMBO DE PROPRIEDADE
    $usuario_id = $_SESSION['usuario_id'];

    // PREPARANDO O ESPAÇO NA CAIXA
    $stmt = $conn->prepare("INSERT INTO livros (titulo, autor, editora, ano, categoria, sobre, descricao, valor, img_url, usuario_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // CARIMBANDO OS DADOS
    $stmt->bind_param("ssssssssss", $titulo, $autor, $editora, $ano, $categoria, $sobre, $descricao, $valor, $img_url, $usuario_id);

    // ENVIANDO PARA A PRATELEIRA
    if ($stmt->execute()) {
        header("Location: ../index.php");
        exit();
    } else {
        // DETECTOR DE FALHAS
        echo "Erro no banco de dados: " . $stmt->error;
        exit();
    }
}
?>