<?php 
// Carregar o cabeçalho da página
require 'partials/header.php';
?>

<main>
    <!-- Seção para exibir os produtos (cupcakes) -->
    <section id="products-section">
        <h2>Nossos Sabores</h2>
        <div id="cupcake-list" class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    <div class="product-card-content">
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="price">R$ <?= number_format($product['price'], 2, ',', '.') ?></p>
                        <!-- O botão agora está dentro de um formulário para enviar o ID do produto via POST -->
                        <form action="index.php?action=addToCart" method="post">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <button type="submit" class="add-to-cart-btn">Adicionar ao Carrinho</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Seção para o carrinho de compras -->
    <section id="cart-section">
        <h2>Seu Carrinho</h2>
        <div id="cart-items">
            <?php if (empty($cart)): ?>
                <p>Seu carrinho está vazio.</p>
            <?php else: ?>
                <?php foreach ($cart as $item): ?>
                    <div class="cart-item">
                        <span><?= htmlspecialchars($item['name']) ?> (x<?= $item['quantity'] ?>)</span>
                        <span>R$ <?= number_format($item['price'] * $item['quantity'], 2, ',', '.') ?></span>
                        <!-- O botão de remover agora é um link que chama a ação 'removeFromCart' -->
                        <a href="index.php?action=removeFromCart&product_id=<?= $item['id'] ?>" class="remove-from-cart-btn">&times;</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="cart-summary">
            <p>Subtotal: <span id="cart-subtotal">R$ <?= number_format($subtotal, 2, ',', '.') ?></span></p>
            <button id="checkout-btn" <?= empty($cart) ? 'disabled' : '' ?>>Finalizar Compra</button>
        </div>
    </section>
</main>

<?php
// Carregar os modais
require 'partials/modals.php';
// Carregar o rodapé da página
require 'partials/footer.php'; 
?>