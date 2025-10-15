<?php
// Configurações do Banco de Dados
define('DB_HOST', '127.0.0.1'); // ou o host do seu banco de dados
define('DB_USER', 'root');      // seu usuário do MySQL
define('DB_PASS', '');          // sua senha do MySQL
define('DB_NAME', 'cupcakes_store'); // o nome do banco de dados criado

// Tenta estabelecer a conexão
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    // Em um ambiente de produção, seria melhor logar o erro do que exibi-lo
    die("Erro de conexão com o banco de dados: " . $conn->connect_error);
}

// Define o charset para UTF-8 para evitar problemas com acentuação
$conn->set_charset("utf8mb4");

?>