<?php
session_start();
require_once '../includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //dados basicos que usuario e adm tem
    $nome = trim($_POST['nome']);
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];

    // vai verificar ser os campos de nome e senha estao preenchidos 
    if (empty($nome) || empty($senha)) {
        echo "<script>alert('Por favor, preencha nome e senha!'); window.history.back();</script>";
        exit();
    }

    // No caso de ADM, ai sim verifica a senha especial que e PROJETO2026
    if ($tipo === "adm") {
        $senha_mestra_adm = "PROJETO2026"; //senha
        $senha_digitada_adm = isset($_POST['senha_adm']) ? $_POST['senha_adm'] : '';

        if (empty($senha_digitada_adm)) {
            echo "<script>alert('Para ADM, a senha mestra é obrigatória!'); window.history.back();</script>";
            exit();
        }

        if ($senha_digitada_adm !== $senha_mestra_adm) {
            echo "<script>alert('Senha de ADM incorreta!'); window.history.back();</script>";
            exit();
        }
    }

    //Salvar na sessao
    if (!isset($_SESSION['usuarios_registrados'])) {
        $_SESSION['usuarios_registrados'] = [];
    }
    
    $_SESSION['usuarios_registrados'][$nome] = [
        'nome' => $nome,
        'senha' => $senha,
        'tipo' => $tipo
    ];

    $_SESSION['logado'] = true;
    $_SESSION['usuario_nome'] = $nome;
    $_SESSION['tipo_usuario'] = $tipo;

    if ($tipo === "adm") {
        header("Location: adm_dashboard.php");//Manda para pagina de adm se for um adm
    } else {
        header("Location: ../index.php");//Caso nao, manda para o index do usuario
    }
    exit();
}