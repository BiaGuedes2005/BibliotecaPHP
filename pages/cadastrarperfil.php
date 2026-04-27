<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Perfil</title>
    <link rel="stylesheet" href="../assets/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>PRIMEIRA VEZ?</h1>
            
            <form action="processacadastro.php" method="POST">
                <div class="input-group">
                    <label for="nome">NOME</label>
                    <input type="text" id="nome" name="nome" required>
                </div>

                <div class="input-group">
                    <label for="senha">SENHA</label>
                    <input type="password" id="senha" name="senha" required>
                </div>

                <div class="input-group">
                    <label for="tipo">Tipo</label>
                    <select id="tipo" name="tipo" onchange="verificarTipo()" required>
                        <option value="usuario">Usuário</option>
                        <option value="adm">ADM</option>
                    </select>
                </div>

                <div id="campo_adm" class="input-group" style="display: none;">
                    <label for="senha_adm">SENHA de adm</label>
                    <input type="password" id="senha_adm" name="senha_adm">
                </div>

                <div class="link-cadastro">
                    <a href="login.php">VOCÊ TEM CONTA?</a>
                </div>

                <button type="submit" class="btn-entrar">ENTRAR</button>
            </form>
        </div>
    </div>

    <script src="../assets/scripts.js"></script>
</body>
</html>