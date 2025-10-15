<?php
class AuthController {

    public function login() {
        global $conn;
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            header('Location: index.php?error=login_failed');
            exit;
        }

        // Buscar o usuário pelo e-mail
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($user = $result->fetch_assoc()) {
            // Verificar se a senha corresponde ao hash
            if (password_verify($password, $user['password'])) {
                // Login bem-sucedido
                $_SESSION['user'] = [
                    'id'   => $user['id'],
                    'name' => $user['name'],
                ];
                header('Location: index.php');
                exit;
            }
        }
        
        // Se o e-mail não foi encontrado ou a senha está incorreta
        header('Location: index.php?error=login_failed');
        exit;
    }

    public function signup() {
        global $conn;
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        // Validações simples
        if (empty($name) || empty($email) || empty($password) || $password !== $password_confirm) {
            header('Location: index.php?error=signup_validation');
            exit;
        }

        // Verificar se o e-mail já existe
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            header('Location: index.php?error=email_exists');
            exit;
        }
        $stmt->close();

        // Criar o hash da senha
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Inserir o novo usuário no banco de dados
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password_hash);
        
        if ($stmt->execute()) {
            // Fazer login automaticamente após o cadastro
            $_SESSION['user'] = [
                'id' => $conn->insert_id,
                'name' => $name,
            ];
            header('Location: index.php?signup=success');
        } else {
            header('Location: index.php?error=signup_failed');
        }
        exit;
    }

    public function logout() {
        // Limpa os dados do usuário da sessão
        unset($_SESSION['user']);
        // Opcional: destruir a sessão completamente
        // session_destroy(); 
        header('Location: index.php');
        exit;
    }
}
?>