<?php
// Iniciar a sessão para gerenciar o carrinho e o login do usuário
session_start();

// Incluir o arquivo de configuração do banco de dados
require_once 'config.php';

// Simulação de um autoloader simples para as classes do controller
spl_autoload_register(function ($class_name) {
    // Apenas carrega classes do diretório 'controllers'
    if (strpos($class_name, 'Controller') !== false) {
        require_once 'controllers/' . $class_name . '.php';
    }
});

// Roteamento Básico
// Pega a 'action' da URL, ou define 'home' como padrão
$action = $_GET['action'] ?? 'home';

// Instanciar o controller e chamar o método apropriado
switch ($action) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;
    case 'addToCart':
        $controller = new CartController();
        $controller->add();
        break;
    case 'removeFromCart':
        $controller = new CartController();
        $controller->remove();
        break;
    case 'placeOrder':
        $controller = new OrderController();
        $controller->placeOrder();
        break;
    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;
    case 'signup':
        $controller = new AuthController();
        $controller->signup();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    default:
        // Se a ação não for encontrada, redireciona para a home
        header('Location: index.php');
        exit;
}
?>