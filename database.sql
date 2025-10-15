-- Criar o banco de dados se ele não existir
CREATE DATABASE IF NOT EXISTS cupcakes_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar o banco de dados criado
USE cupcakes_store;

-- Tabela para usuários
-- Armazena informações de login e cadastro dos clientes
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Senhas devem ser sempre armazenadas como hash
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela para produtos (os cupcakes)
-- Pré-populada com os dados que estavam no JavaScript
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL
);

-- Inserir os produtos iniciais na tabela
INSERT INTO products (id, name, price, image) VALUES
(1, 'Cupcake de Chocolate', 8.50, 'cupcake1.png'),
(2, 'Cupcake de Baunilha', 7.50, 'cupcake2.png'),
(3, 'Cupcake Red Velvet', 9.00, 'cupcake3.png'),
(4, 'Cupcake de Morango', 8.00, 'cupcake4.png')
ON DUPLICATE KEY UPDATE name=VALUES(name), price=VALUES(price), image=VALUES(image);


-- Tabela para pedidos (histórico de compras)
-- Cada linha representa um pedido completo de um cliente
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    delivery_method VARCHAR(50) NOT NULL,
    delivery_fee DECIMAL(10, 2) DEFAULT 0.00,
    delivery_address TEXT, -- Armazenará o endereço de entrega como JSON ou texto serializado
    payment_method VARCHAR(50) NOT NULL,
    payment_details TEXT, -- Armazenará detalhes do pagamento (ex: troco para)
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabela para os itens de um pedido
-- Liga os produtos específicos a um pedido, com sua quantidade e preço no momento da compra
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price_per_item DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);


