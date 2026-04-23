<?php
session_start(); // Inicia a sessão para poder manipulá-la
session_unset(); // Remove todas as variáveis da sessão
session_destroy(); // Destrói a sessão completamente

// Redireciona para o login que está na mesma pasta
header("Location: login.php");
exit();
?>