<?php

require_once '../includes/functions.php'; 

// Inicia a variavel total
$total = 0;

// Verifica o "adicionar" na URL do index
if (isset($_GET['add'])) {
    $tituloParaAdicionar = $_GET['add'];
    adicionarAoCarrinho($tituloParaAdicionar);
    header("Location: carrinho.php");
    exit();
}

//Limpar Carrinho
if (isset($_GET['limpar'])) {
    $_SESSION['carrinho'] = [];
    header("Location: carrinho.php");
    exit();
}

//remove o livro especifico 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_remover'])) {
    $id = $_POST['id_remover'];
    
    if (isset($_SESSION['carrinho'][$id])) {
        unset($_SESSION['carrinho'][$id]);
        // Reorganiza os indices do array para nao quebrar o loop
        $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
    }
    
    header("Location: carrinho.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Seu Carrinho</title>
    <link rel="stylesheet" href="../assets/style.css"> 
    <link rel="stylesheet" href="../assets/carrinho.css"> 
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

    <div class="main-wrapper">
        <header class="top-bar">
            <h1 class="titulo-pagina">Seu carrinho</h1>
        </header>

        <div class="itens-lista">
            <?php 
            if (isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
                
                foreach ($_SESSION['carrinho'] as $chave => $item) {
                    
                    
                    $valorLimpo = str_replace(['R$', ' ', '.'], '', $item['valor']);
                    $valorNumerico = (float)str_replace(',', '.', $valorLimpo);
                    
                    
                    $total += $valorNumerico;
                    ?>
                    
                    <div class="item-carrinho">
                        <div class="item-info" style="display: flex; align-items: center; gap: 15px;">
                            <img src="<?php echo htmlspecialchars($item['img_url']); ?>" style="width: 70px; height: 90px; object-fit: cover; border-radius: 6px;">
                            <div>
                                <h3 style="margin: 0;"><?php echo htmlspecialchars($item['titulo']); ?></h3>
                                <p style="margin: 5px 0; color: #777;"><?php echo htmlspecialchars($item['autor']); ?></p>
                                
                                <form action="carrinho.php" method="POST" style="margin-top: 8px;">
                                    <input type="hidden" name="id_remover" value="<?php echo $chave; ?>">
                                    <button type="submit" style="background:none; border:none; color:#F15256; cursor:pointer; padding:0; font-size: 0.85rem;">
                                        <i class="fas fa-trash-alt"></i> Remover
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="item-preco" style="font-weight: bold; color: #2ecc71; font-size: 1.2rem;">
                            R$ <?php echo htmlspecialchars($item['valor']); ?>
                        </div>
                    </div>

                <?php } 
            } else { ?>
                <div style="text-align: center; padding: 50px;">
                    <i class="fas fa-shopping-basket" style="font-size: 3rem; color: #ccc;"></i>
                    <p style="color: #999; margin-top: 15px;">Seu carrinho está vazio.</p>
                </div>
            <?php } ?>
        </div>
    </div>

    <aside class="checkout-sidebar">
        <h2 style="margin-bottom: 25px;">Finalizar Compra</h2>
        
        <form class="checkout-form" action="processa_pedido.php" method="POST">
            <div class="input-group">
                <label>Nome Completo</label>
                <input type="text" name="nome" value="<?php echo isset($_SESSION['usuario_nome']) ? $_SESSION['usuario_nome'] : ''; ?>" required>
            </div>
            <div class="input-group">
                <label>E-mail</label>
                <input type="email" name="email" required>
            </div>
            <div class="input-group">
                <label>Endereço de Entrega</label>
                <input type="text" name="endereco" required>
            </div>
            <div class="input-group">
                <label>Últimos 4 dígitos do Cartão</label>
                <input type="text" name="cartao" maxlength="4" placeholder="0000" required>
            </div>

            <div class="total-section">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <span style="font-weight: bold; color: #333;">Total:</span>
                    <span style="font-size: 1.8rem; font-weight: bold; color: #2ecc71;">
                        R$ <?php echo number_format($total, 2, ',', '.'); ?>
                    </span>
                </div>
                
                <button type="submit" class="btn-finalizar" style="width: 100%; background: #2ecc71; color: white; border: none; padding: 15px; border-radius: 8px; font-weight: bold; font-size: 1rem; cursor: pointer;">
                    Finalizar Compra
                </button>

                <div style="text-align: center; margin-top: 15px;">
                    <a href="carrinho.php?limpar=1" style="color: #e74c3c; text-decoration: none; font-size: 0.9rem;">
                        <i class="fas fa-trash-alt"></i> Esvaziar Carrinho
                    </a>
                </div>
            </div>
        </form>
    </aside>

</body>
</html>