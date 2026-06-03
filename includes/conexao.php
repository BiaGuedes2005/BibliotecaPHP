<?php
// 1. Conecta primeiro ao MySQL (sem escolher o banco ainda)
$conn = new mysqli("localhost", "root", "");

if ($conn->connect_error) {
    die("Erro na conexão com o servidor: " . $conn->connect_error);
}

// 2. Garante que o banco de dados existe
$sql_banco = "CREATE DATABASE IF NOT EXISTS banco_bibliotecaphp";
if (!$conn->query($sql_banco)) {
    die("Erro ao criar o banco de dados: " . $conn->error);
}

// 3. Agora sim, seleciona o seu banco de dados
$conn->select_db("banco_bibliotecaphp");


// 4. CRIAÇÃO AUTOMÁTICA DA SUA TABELA DE LOGIN
// (Ajuste os nomes das colunas abaixo se o seu projeto usar nomes diferentes!)
$sql_tabela_usuarios = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
)";

if (!$conn->query($sql_tabela_usuarios)) {
    die("Erro ao criar a tabela de usuários: " . $conn->error);
}


// 5. CRIA UM USUÁRIO PADRÃO SE A TABELA ESTIVER VAZIA
// Assim você já consegue fazer login direto no Windows sem precisar cadastrar antes
$verificar_usuarios = $conn->query("SELECT id FROM usuarios");
if ($verificar_usuarios && $verificar_usuarios->num_rows == 0) {
    // Insere o usuário 'admin' com a senha '1234'
    $conn->query("INSERT INTO usuarios (usuario, senha) VALUES ('admin', '1234')");
}
?>