<?php
// O '../' é obrigatório porque o functions.php está fora da pasta pages
require_once '../includes/functions.php'; 

// 1. INICIALIZAÇÃO DA VARIÁVEL TOTAL (Essencial para não dar erro na linha 150)
$total = 0;

// Verifica se chegou um pedido de "adicionar" pela URL do index
if (isset($_GET['add'])) {
    $tituloParaAdicionar = $_GET['add'];
    adicionarAoCarrinho($tituloParaAdicionar);
    header("Location: carrinho.php");
    exit();
}

// Lógica de Limpar (Caso você tenha implementado no functions.php)
if (isset($_GET['limpar'])) {
    $_SESSION['carrinho'] = [];
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .main-wrapper {
            margin-left: 80px; 
            margin-right: 350px; 
            padding: 20px;
        }

        .checkout-sidebar {
            position: fixed;
            right: 0;
            top: 0;
            width: 350px;
            height: 100vh;
            background: #f9f9f9;
            border-left: 1px solid #ddd;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
            z-index: 1000;
        }

        .checkout-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            flex-grow: 1;
        }

        .input-group label {
            display: block;
            font-size: 0.85rem;
            color: #555;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .total-section {
            margin-top: auto;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }
    </style>
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
            <h1>Seu carrinho</h1>
        </header>

        <div class="itens-lista">
            <?php 
            if (isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
                foreach ($_SESSION['carrinho'] as $item) {
                    // Lógica de limpeza do valor para cálculo
                    $valorLimpo = str_replace(['R$', ' ', '.'], '', $item['valor']);
                    $valorNumerico = (float)str_replace(',', '.', $valorLimpo);
                    
                    // Soma acumulada
                    $total += $valorNumerico;
                    ?>
                    
                    <div class="item-carrinho" style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 15px; margin-bottom: 15px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <img src="<?php echo htmlspecialchars($item['img_url']); ?>" style="width: 70px; height: 90px; object-fit: cover; border-radius: 6px;">
                            <div>
                                <h3 style="margin: 0;"><?php echo htmlspecialchars($item['titulo']); ?></h3>
                                <p style="margin: 5px 0; color: #777;"><?php echo htmlspecialchars($item['autor']); ?></p>
                            </div>
                        </div>
                        <div style="font-weight: bold; color: #2ecc71; font-size: 1.2rem;">
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
                
                <button type="submit" style="width: 100%; background: #2ecc71; color: white; border: none; padding: 15px; border-radius: 8px; font-weight: bold; font-size: 1rem; cursor: pointer;">
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