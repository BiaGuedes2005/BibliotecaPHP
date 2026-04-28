<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Campos do formulario
    $novoLivro = [
        'titulo'    => $_POST['titulo'],
        'autor'     => $_POST['autor'],
        'editora'   => $_POST['editora'],
        'ano'       => $_POST['ano'],
        'categoria' => $_POST['categoria'],
        'sobre'     => $_POST['sobre'],
        'descricao' => $_POST['descricao'],
        'valor'     => $_POST['valor'],
        'img_url'   => $_POST['img_url']
    ];

    // Se nao tiver lista de livros, ira criar ela
    if (!isset($_SESSION['meus_livros'])) {
        $_SESSION['meus_livros'] = [];
    }

    // Adiciona o novo livro
    array_unshift($_SESSION['meus_livros'], $novoLivro);

    // Redireciona para o index
    header("Location: ../index.php");
    exit();
}