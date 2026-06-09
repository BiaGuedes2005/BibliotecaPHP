<?php
/**
 * ARQUIVO: PROCESSA CADASTRO
 * Papel: Mesa de Cadastro e Emissão de Crachá
 */

// A COLA
include '../includes/conexao.php';

// Livro de regras
require_once '../includes/functions.php';

// O ENVIO DA FICHA
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // PEGANDO OS DADOS DA MESA
    $nome = trim($_POST['nome']);
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];

    // CHECAGEM DE CAMPOS VAZIOS
    if (empty($nome) || empty($senha)) {
        echo "<script>alert('Por favor, preencha nome e senha!'); window.history.back();</script>";
        exit();
    }

    // A SALA DA DIRETORIA
    if ($tipo === "adm") {
        
        $senha_digitada_adm = isset($_POST['senha_adm']) ? $_POST['senha_adm'] : '';
        //pidao
        if (empty($senha_digitada_adm)) {
            echo "<script>alert('Para ADM, a senha mestra é obrigatória!'); window.history.back();</script>";
            exit();
        }
        
        // TOC
        if (!verificarSenhaAdm($senha_digitada_adm)) {
            echo "<script>alert('Senha de ADM incorreta!'); window.history.back();</script>";
            exit();
        }
    }

    // COLOCANDO NO ARQUIVO MORTO
    $resultado = cadastrarUsuario($nome, $senha, $tipo);

    // ENTREGA DO CRACHÁ (SESSÃO DE LOGADO)
    if ($resultado === true) {
        
        // BUSCA DA FICHA CRIADA
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nome = ?");
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $usuario = $stmt->get_result()->fetch_assoc();

        // GERANDO O CRACHÁ DO USUÁRIO (
        $_SESSION['logado'] = true;                     // Ativa o sinalizador que o Segurança da Porta exige.
        $_SESSION['usuario_id'] = $usuario['id'];       // Guarda o número de identificação do membro.
        $_SESSION['usuario_nome'] = $usuario['nome'];   // Guarda o nome dele para falar "Olá, Fulano".
        $_SESSION['usuario_tipo'] = $usuario['tipo'];   // Guarda o nível de acesso (adm ou cliente).

        // ENCAMINHAMENTO 
        if ($tipo === "adm") {
            // adm
            header("Location: adm_dashboard.php");
        } else {
            // normal
            header("Location: ../index.php");
        }
        exit(); 
        
    } else {
        // ALERTA DE ERRO
        echo "<script>alert('$resultado'); window.history.back();</script>";
    }
}
?>