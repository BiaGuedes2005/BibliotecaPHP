<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];
    $senha_mestra_adm = "PROJETO2026"; // Senha que nós definimos

    if ($tipo === "adm") {
        $senha_digitada_adm = $_POST['senha_adm'];

        if ($senha_digitada_adm !== $senha_mestra_adm) {
            echo "<script>alert('Senha de ADM incorreta!'); window.history.back();</script>";
            exit();
        }
    }

    // Se chegou aqui, os dados estão validados!
    // No futuro, você daria um INSERT no seu banco de dados aqui.
    
    $_SESSION['logado'] = true;
    $_SESSION['usuario_nome'] = $nome;
    $_SESSION['tipo_usuario'] = $tipo;

    header("Location: ../index.php");
    exit();
}