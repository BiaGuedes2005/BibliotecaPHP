
<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Livro</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/cadastrarlivro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <nav class="sidebar">
        <div class="icon-group">
            <a href="perfil.php"><i class="fas fa-user-circle"></i></a>
            <a href="../index.php"><i class="fas fa-home"></i></a>
            <a href="carrinho.php"><i class="fas fa-shopping-cart"></i></a>
            <a href="cadastrarlivro.php"><i class="fas fa-book-open"></i></a>
            <a href="logout.php" style="margin-top: auto; padding-bottom: 20px;"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </nav>

    <main class="content">
        <header class="top-bar">
            <h1>Cadastrar Livro</h1>
        </header>

        <form action="processa_livro.php" method="POST" class="cadastro-container">
            
            <div class="image-upload-section">
                <label for="img_url">Img URL</label>
                <div class="image-placeholder">
                    <i class="fas fa-camera"></i>
                </div>
                <input type="text" id="img_url" name="img_url" placeholder="http://...">
            </div>

            <div class="form-fields">
                <div class="input-full">
                    <label>Titulo do Livro</label>
                    <input type="text" name="titulo">
                </div>

                <div class="input-row">
                    <div class="input-half">
                        <label>Autor</label>
                        <input type="text" name="autor">
                    </div>
                    <div class="input-half">
                        <label>Editora</label>
                        <input type="text" name="editora">
                    </div>
                </div>

                <div class="input-row">
                    <div class="input-half">
                        <label>Ano</label>
                        <input type="number" name="ano">
                    </div>
                    <div class="input-half">
                        <label>Categoria</label>
                        <input type="text" name="categoria">
                    </div>
                </div>

                <div class="input-full">
                    <label>Sobre o livro</label>
                    <input type="text" name="sobre">
                </div>

                <div class="input-row">
                    <div class="input-half">
                        <label>Descrição</label>
                        <input type="text" name="descricao">
                    </div>
                    <div class="input-half">
                        <label>Valor</label>
                        <input type="text" name="valor">
                    </div>
                </div>

                <div class="button-container">
                    <button type="submit" class="btn-cadastrar">Cadastrar</button>
                </div>
            </div>
        </form>
    </main>
</body>
</html>