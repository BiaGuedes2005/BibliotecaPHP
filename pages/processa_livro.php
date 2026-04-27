<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegamos todos os campos que você colocou no formulário
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

    // Se a lista de livros não existir na sessão, criamos ela
    if (!isset($_SESSION['meus_livros'])) {
        $_SESSION['meus_livros'] = [];
    }

    // Adiciona o novo livro no início da lista (para aparecer primeiro no index)
    array_unshift($_SESSION['meus_livros'], $novoLivro);

    // Redireciona de volta para a home
    header("Location: ../index.php");
    exit();
}