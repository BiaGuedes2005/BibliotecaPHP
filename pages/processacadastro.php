<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];
    $senha_mestra_adm = "PROJETO2026"; 

    // 1. Validação de ADM
    if ($tipo === "adm") {
        $senha_digitada_adm = $_POST['senha_adm'];

        if ($senha_digitada_adm !== $senha_mestra_adm) {
            echo "<script>alert('Senha de ADM incorreta!'); window.history.back();</script>";
            exit();
        }
    }

    // 2. SALVAR O USUÁRIO (Simulando o Banco de Dados)
    // Criamos uma lista de usuários na sessão para o login.php poder consultar
    if (!isset($_SESSION['usuarios_registrados'])) {
        $_SESSION['usuarios_registrados'] = [];
    }
    
    $_SESSION['usuarios_registrados'][$nome] = [
        'nome' => $nome,
        'senha' => $senha,
        'tipo' => $tipo
    ];

    // 3. LOGAR O USUÁRIO RECENTE
    $_SESSION['logado'] = true;
    $_SESSION['usuario_nome'] = $nome;
    $_SESSION['tipo_usuario'] = $tipo;

    // 4. REDIRECIONAR PARA O LUGAR CERTO
    if ($tipo === "adm") {
        header("Location: adm_dashboard.php"); // Vai para a planilha de ADM
    } else {
        header("Location: ../index.php"); // Usuário comum vai para a loja
    }
    exit();
}