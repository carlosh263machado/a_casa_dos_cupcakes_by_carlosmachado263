<!-- Modal de Checkout -->
<div id="checkout-modal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <button class="close-modal-btn">&times;</button>
        <h2>Finalizar Compra</h2>
        
        <form id="checkout-form" action="index.php?action=placeOrder" method="post">

            <!-- Passo 1: Método de Entrega -->
            <fieldset>
                <legend>1. Método de Entrega</legend>
                <div class="radio-group">
                    <input type="radio" id="pickup" name="delivery_method" value="pickup" checked>
                    <label for="pickup">Retirar no local (Sem custo)</label>
                </div>
                <div class="radio-group">
                    <input type="radio" id="delivery" name="delivery_method" value="delivery">
                    <label for="delivery">Entrega (Taxa de R$ 7,00)</label>
                </div>
                <!-- Campos de endereço para entrega -->
                <div id="delivery-address-form" style="display: none;">
                    <p class="address-title">Endereço de Entrega:</p>
                    <input type="text" name="address[cep]" id="cep" placeholder="CEP">
                    <input type="text" name="address[street]" id="street" placeholder="Rua / Avenida">
                    <div class="address-line">
                        <input type="text" name="address[number]" id="number" placeholder="Número">
                        <input type="text" name="address[complement]" id="complement" placeholder="Complemento (Opcional)">
                    </div>
                    <input type="text" name="address[neighborhood]" id="neighborhood" placeholder="Bairro">
                    <input type="text" name="address[city]" id="city" placeholder="Cidade">
                    <input type="text" name="address[state]" id="state" placeholder="Estado">
                </div>
            </fieldset>

            <!-- Passo 2: Método de Pagamento -->
            <fieldset>
                <legend>2. Método de Pagamento</legend>
                 <div class="radio-group">
                    <input type="radio" id="cash" name="payment_method" value="cash" checked>
                    <label for="cash">Dinheiro</label>
                </div>
                 <div class="radio-group">
                    <input type="radio" id="pix" name="payment_method" value="pix">
                    <label for="pix">Pix</label>
                </div>
                 <div class="radio-group">
                    <input type="radio" id="credit" name="payment_method" value="credit">
                    <label for="credit">Cartão de Crédito</label>
                </div>
                 <div class="radio-group">
                    <input type="radio" id="debit" name="payment_method" value="debit">
                    <label for="debit">Cartão de Débito</label>
                </div>
            </fieldset>

            <!-- Detalhes do Pagamento (serão exibidos conforme a seleção) -->
            <div id="payment-details">
                <div id="cash-details" class="payment-method-details">
                    <label for="change_for">Precisa de troco para quanto?</label>
                    <input type="number" id="change_for" name="payment_details[change_for]" placeholder="Ex: 50.00">
                </div>
                <div id="pix-details" class="payment-method-details" style="display: none;">
                    <p>Escaneie o QR Code para pagar:</p>
                    <img src="qrcode.png" alt="QR Code para pagamento Pix" width="150">
                    <p>Ou use a chave Pix (Copia e Cola):</p>
                    <input type="text" value="b8a3c1f2-e4d5-4f6a-8b9c-0d1e2f3a4b5c" readonly>
                </div>
                <div id="credit-details" class="payment-method-details" style="display: none;">
                    <input type="text" name="payment_details[card_number]" placeholder="Número do Cartão">
                    <input type="text" name="payment_details[card_name]" placeholder="Nome no Cartão">
                    <div class="card-info">
                        <input type="text" name="payment_details[card_expiry]" placeholder="Validade (MM/AA)">
                        <input type="text" name="payment_details[card_cvv]" placeholder="CVV">
                    </div>
                </div>
                <div id="debit-details" class="payment-method-details" style="display: none;">
                    <input type="text" name="payment_details[card_number_debit]" placeholder="Número do Cartão">
                    <input type="text" name="payment_details[card_name_debit]" placeholder="Nome no Cartão">
                     <div class="card-info">
                        <input type="text" name="payment_details[card_expiry_debit]" placeholder="Validade (MM/AA)">
                        <input type="text" name="payment_details[card_cvv_debit]" placeholder="CVV">
                    </div>
                </div>
            </div>

            <!-- Resumo Final -->
            <div class="final-summary">
                <p>Subtotal: <span id="summary-subtotal">R$ 0.00</span></p>
                <p>Taxa de Entrega: <span id="summary-delivery-fee">R$ 0.00</span></p>
                <h3>Total a Pagar: <span id="summary-total">R$ 0.00</span></h3>
            </div>
            
            <button id="confirm-purchase-btn" type="submit" class="form-btn">Confirmar Pedido</button>
        </form>
    </div>
</div>

<!-- Modal de Login -->
<div id="login-modal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <button class="close-modal-btn">&times;</button>
        <h2>Login</h2>
        <form id="login-form" action="index.php?action=login" method="post">
            <input name="email" type="email" placeholder="Seu E-mail" required>
            <input name="password" type="password" placeholder="Sua Senha" required>
            <button type="submit" class="form-btn">Entrar</button>
            <p class="form-link-p">Esqueceu sua senha? <a href="#" id="forgot-password-link">Recuperar</a></p>
            <p class="form-link-p">Não tem uma conta? <a href="#" id="switch-to-signup-link">Cadastre-se</a></p>
        </form>
    </div>
</div>

<!-- Modal de Cadastro -->
<div id="signup-modal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <button class="close-modal-btn">&times;</button>
        <h2>Cadastro</h2>
        <form id="signup-form" action="index.php?action=signup" method="post">
            <input name="name" type="text" placeholder="Seu Nome Completo" required>
            <input name="email" type="email" placeholder="Seu E-mail" required>
            <input name="password" type="password" placeholder="Crie uma Senha" required>
            <input name="password_confirm" type="password" placeholder="Confirme sua Senha" required>
            <button type="submit" class="form-btn">Criar Conta</button>
            <p class="form-link-p">Já tem uma conta? <a href="#" id="switch-to-login-link">Faça Login</a></p>
        </form>
    </div>
</div>

<!-- Modal de Recuperação de Senha -->
<div id="recovery-modal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <button class="close-modal-btn">&times;</button>
        <h2>Recuperar Senha</h2>
        <form id="recovery-form">
            <p>Insira seu e-mail para enviarmos um link de recuperação.</p>
            <input type="email" placeholder="Seu E-mail" required>
            <button type="submit" class="form-btn">Enviar</button>
        </form>
    </div>
</div>