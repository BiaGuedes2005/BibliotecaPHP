<?php
session_start(); // Inicia
session_unset(); // Remove
session_destroy(); // Destroi a sessão completamente

header("Location: login.php");//Manda para o Login
exit();
?>