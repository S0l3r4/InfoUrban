<?php
session_start();

if (isset($_POST['campo_email']) && isset($_POST['campo_senha'])) {
    $email = trim($_POST['campo_email']);
    $senha = trim($_POST['campo_senha']);

    require('conexao.php');

    $senhaCod = base64_encode($senha);

    $query = "SELECT id, nome, email, senha FROM usuarios WHERE email = '$email' AND senha = '$senhaCod'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $usuario = mysqli_fetch_assoc($result);
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];

        header('Location: principal.php');
        exit;
    } else {
        echo "<script>alert('Email ou senha incorretos.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoUrban - Login</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>InfoUrban</h1>
        <p>Melhore sua cidade, participe e compartilhe! Em busca da melhoria urbana</p>
    </header>

    <main>
        <section class="sessao-formulario">
            <h2>Login de Usuário</h2>
            <form action="#" method="post" class="formulario-usuario">
                <div class="grupo-formulario">
                    <label for="campo-email">E-mail:</label>
                    <input type="email" id="campo-email" name="campo_email" placeholder="Digite seu e-mail" required>
                </div>

                <div class="grupo-formulario">
                    <label for="campo-senha">Senha:</label>
                    <input type="password" id="campo-senha" name="campo_senha" placeholder="Digite sua senha" required>
                </div>
                <button type="submit">Logar</button>
                <div class="texto" style="display: flex; justify-content: center;">
                    <a href="index.php">Não possui conta? Clique aqui</a>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 InfoUrban. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
