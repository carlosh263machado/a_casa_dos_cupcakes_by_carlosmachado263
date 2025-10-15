<?php
class CartController {
    
    public function add() {
        global $conn;
        $productId = $_POST['product_id'] ?? null;

        if (!$productId) {
            // Se não houver ID do produto, redireciona de volta
            header('Location: index.php');
            exit;
        }

        // Inicializa o carrinho na sessão se não existir
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Verifica se o item já está no carrinho
        if (isset($_SESSION['cart'][$productId])) {
            // Se sim, incrementa a quantidade
            $_SESSION['cart'][$productId]['quantity']++;
        } else {
            // Se não, busca o produto no banco e adiciona ao carrinho
            $stmt = $conn->prepare("SELECT id, name, price FROM products WHERE id = ?");
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($product = $result->fetch_assoc()) {
                $_SESSION['cart'][$productId] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => 1
                ];
            }
        }
        
        // Redireciona para a página inicial
        header('Location: index.php');
        exit;
    }

    public function remove() {
        $productId = $_GET['product_id'] ?? null;

        if ($productId && isset($_SESSION['cart'][$productId])) {
            // Remove o item do carrinho
            unset($_SESSION['cart'][$productId]);
        }

        // Redireciona para a página inicial
        header('Location: index.php');
        exit;
    }
}
?>