<?php
    if ( isset( $_POST['campo_nome'] ) && isset( $_POST['campo_email'] ) && isset( $_POST['campo_senha'] ) && isset( $_POST['campo_confirmar_senha'] )) {
        $pesNome = trim( $_POST['campo_nome'] );
        $pesEmail = trim( $_POST['campo_email'] );
        $pesSenha = trim( $_POST['campo_senha'] );

        $pesSenhaCod = base64_encode($pesSenha);
        require('conexao.php');

        $query = "INSERT INTO usuarios
                (nome, email, senha)
              VALUES
                ('$pesNome', '$pesEmail', '$pesSenhaCod')";

        mysqli_query($con , $query);

        header('Location: login.php');
        exit;
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoUrban</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>InfoUrban</h1>
        <p>Melhore sua cidade, participe e compartilhe! Em busca da melhoria urbana</p>
    </header>

    <main>
        <section class="sessao-formulario">
            <h2>Cadastro de Usuário</h2>
            <form action="#" method="post" class="formulario-usuario" onsubmit="validarFormulario(event)">
                <div class="grupo-formulario">
                    <label for="campo-nome">Nome Completo:</label>
                    <input type="text" id="campo-nome" name="campo_nome" placeholder="Digite seu nome completo" required>
                </div>

                <div class="grupo-formulario">
                    <label for="campo-email">E-mail:</label>
                    <input type="email" id="campo-email" name="campo_email" placeholder="Digite seu e-mail" required>
                </div>

                <div class="grupo-formulario">
                    <label for="campo-senha">Senha:</label>
                    <input type="password" id="campo-senha" name="campo_senha" placeholder="Digite sua senha" required>
                </div>

                <div class="grupo-formulario">
                    <label for="campo-confirmar-senha">Confirmar Senha:</label>
                    <input type="password" id="campo-confirmar-senha" name="campo_confirmar_senha" placeholder="Confirme sua senha" required>
                </div>

                <ul id="mensagens-erro" style="color: red; list-style: none; padding: 0;"></ul>
                <button type="submit">Cadastrar</button>
                <div class="texto" style="display: flex; justify-content: center;">
                    <a href="login.php">Ja possui conta? Clique aqui</a>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 InfoUrban. Todos os direitos reservados.</p>
    </footer>

    <script>
        function validarFormulario(event) {
            event.preventDefault();

            const nome = document.getElementById("campo-nome").value;
            const email = document.getElementById("campo-email").value;
            const senha = document.getElementById("campo-senha").value;
            const confirmarSenha = document.getElementById("campo-confirmar-senha").value;

            let mensagensErro = [];

            if (nome.length <= 3 || !nome.includes(" ")) {
                mensagensErro.push("\n\nO nome deve ter mais de 3 letras e pelo menos 1 espaço.");
            }

            if (!email.includes("@")) {
                mensagensErro.push("\n\n e-mail deve conter pelo menos 1 '@'.");
            }

            const regexSenha = /^(?=.*[!@#$%^&*(),.?":{}|<>])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{6,}$/;
            if (!regexSenha.test(senha)) {
                mensagensErro.push("\n\nA senha deve ter no mínimo 6 caracteres, incluindo 1 caractere especial, 1 número, 1 letra maiúscula e 1 letra minúscula.");
            }

            if (senha !== confirmarSenha) {
                mensagensErro.push("\n\nAs senhas não coincidem.");
            }

            const mensagens = document.getElementById("mensagens-erro");
            mensagens.innerHTML = "";
            if (mensagensErro.length > 0) {
                mensagensErro.forEach(erro => {
                    const li = document.createElement("li");
                    li.textContent = erro;
                    mensagens.appendChild(li);
                });
            } else {
                alert("Cadastro realizado com sucesso!");
                document.querySelector("form").submit();
            }
        }
    </script>
</body>
</html>