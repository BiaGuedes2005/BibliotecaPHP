<?php
// 1. Conecta ao servidor local do Windows
$conn = new mysqli("localhost", "root", "");

if ($conn->connect_error) {
    die("Erro na conexão com o servidor: " . $conn->connect_error);
}

// 2. Cria o banco de dados se ele não existir
$sql_banco = "CREATE DATABASE IF NOT EXISTS banco_bibliotecaphp";
if (!$conn->query($sql_banco)) {
    die("Erro ao criar o banco de dados: " . $conn->error);
}

// 3. Seleciona o banco
$conn->select_db("banco_bibliotecaphp");

// 4. Cria a tabela 'usuarios' com TODAS as colunas necessárias
$sql_tabela_usuarios = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo VARCHAR(20) DEFAULT 'comum',
    tema VARCHAR(20) DEFAULT 'claro'
)";

if (!$conn->query($sql_tabela_usuarios)) {
    die("Erro ao criar a tabela de usuários: " . $conn->error);
}

// 5. Cria um usuário administrador padrão (Nome: admin / Senha: 1234)
$verificar_usuarios = $conn->query("SELECT id FROM usuarios");
if ($verificar_usuarios && $verificar_usuarios->num_rows == 0) {
    // Cria o hash da senha '1234' para que a função password_verify funcione
    $senhaHash = password_hash("1234", PASSWORD_DEFAULT);
    $conn->query("INSERT INTO usuarios (nome, senha, tipo) VALUES ('admin', '$senhaHash', 'admin')");
}
?>