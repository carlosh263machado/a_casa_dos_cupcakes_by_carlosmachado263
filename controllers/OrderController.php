<?php
class OrderController {
    
    public function placeOrder() {
        global $conn;

        // 1. Verificação de segurança e validação de dados
        if (!isset($_SESSION['user']['id']) || empty($_SESSION['cart'])) {
            // Não pode finalizar a compra se não estiver logado ou se o carrinho estiver vazio
            header('Location: index.php');
            exit;
        }

        // 2. Coleta de dados do formulário POST
        $userId = $_SESSION['user']['id'];
        $deliveryMethod = $_POST['delivery_method'] ?? 'pickup';
        $paymentMethod = $_POST['payment_method'] ?? 'cash';
        
        // 3. Calcular totais com base no carrinho da sessão
        $subtotal = 0;
        foreach ($_SESSION['cart'] as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $deliveryFee = ($deliveryMethod === 'delivery') ? 7.00 : 0.00;
        $totalAmount = $subtotal + $deliveryFee;

        // 4. Preparar dados para inserção no banco
        $deliveryAddress = null;
        if ($deliveryMethod === 'delivery' && isset($_POST['address'])) {
            // Serializa o endereço em uma string JSON para fácil armazenamento
            $deliveryAddress = json_encode($_POST['address']);
        }
        
        $paymentDetails = null;
        if (isset($_POST['payment_details'])) {
            // Serializa os detalhes de pagamento em JSON
            $paymentDetails = json_encode($_POST['payment_details']);
        }

        // Inicia uma transação para garantir a consistência dos dados
        $conn->begin_transaction();

        try {
            // 5. Inserir o pedido na tabela 'orders'
            $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, delivery_method, delivery_fee, delivery_address, payment_method, payment_details, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
            $stmt->bind_param("idssdss", $userId, $totalAmount, $deliveryMethod, $deliveryFee, $deliveryAddress, $paymentMethod, $paymentDetails);
            $stmt->execute();
            $orderId = $conn->insert_id; // Pega o ID do pedido recém-criado
            $stmt->close();
            
            // 6. Inserir cada item do carrinho na tabela 'order_items'
            $stmt_items = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_per_item) VALUES (?, ?, ?, ?)");
            foreach ($_SESSION['cart'] as $item) {
                $stmt_items->bind_param("iiid", $orderId, $item['id'], $item['quantity'], $item['price']);
                $stmt_items->execute();
            }
            $stmt_items->close();

            // Se tudo deu certo, confirma a transação
            $conn->commit();

            // 7. Limpar o carrinho e redirecionar para uma página de sucesso
            unset($_SESSION['cart']);
            header('Location: index.php?order=success');
            exit;

        } catch (Exception $e) {
            // Se algo deu errado, reverte a transação
            $conn->rollback();
            // Em um app real, você logaria o erro: error_log($e->getMessage());
            header('Location: index.php?error=order_failed');
            exit;
        }
    }
}
?>