<?php
class HomeController {
    public function index() {
        global $conn; // Utiliza a conexão global do config.php

        // Buscar todos os produtos do banco de dados
        $result = $conn->query("SELECT * FROM products ORDER BY id ASC");
        $products = $result->fetch_all(MYSQLI_ASSOC);

        // Funções para calcular totais do carrinho (que está na sessão)
        $cart = $_SESSION['cart'] ?? [];
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        // Carregar a view da página inicial e passar os dados dos produtos
        require 'views/home.php';
    }
}
?>