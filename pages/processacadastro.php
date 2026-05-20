<?php
include '../includes/conexao.php';
require_once '../includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];

    if (empty($nome) || empty($senha)) {
        echo "<script>alert('Por favor, preencha nome e senha!'); window.history.back();</script>";
        exit();
    }

    // Verifica senha mestra se for ADM
    if ($tipo === "adm") {
        $senha_digitada_adm = isset($_POST['senha_adm']) ? $_POST['senha_adm'] : '';
        if (empty($senha_digitada_adm)) {
            echo "<script>alert('Para ADM, a senha mestra é obrigatória!'); window.history.back();</script>";
            exit();
        }
        if (!verificarSenhaAdm($senha_digitada_adm)) {
            echo "<script>alert('Senha de ADM incorreta!'); window.history.back();</script>";
            exit();
        }
    }

    // Salva no banco
    $resultado = cadastrarUsuario($nome, $senha, $tipo);

    if ($resultado === true) {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nome = ?");
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $usuario = $stmt->get_result()->fetch_assoc();

        $_SESSION['logado'] = true;
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];

        if ($tipo === "adm") {
            header("Location: adm_dashboard.php");
        } else {
            header("Location: ../index.php");
        }
        exit();
    } else {
        echo "<script>alert('$resultado'); window.history.back();</script>";
    }
}
?>