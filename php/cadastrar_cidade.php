<?php
    session_start();
    require('conexao.php');

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }

    if ( isset( $_POST['nome_cidade'] ) && isset( $_POST['estado_cidade'] )) {
        $nomeCidade = mysqli_real_escape_string($con, $_POST['nome_cidade']);
        $estadoCidade = mysqli_real_escape_string($con, $_POST['estado_cidade']);

        $verificarExistencia = "SELECT id FROM cidades WHERE nome = '$nomeCidade'";

        $result = mysqli_query($con, $verificarExistencia);
        if (mysqli_num_rows($result) > 0){
            echo "<script>alert('Cidade já cadastrada');</script>";
        } else {
            $query = "INSERT INTO cidades (nome, estado) VALUES ('$nomeCidade', '$estadoCidade')";
            if (mysqli_query($con, $query)) {
                header('Location: principal.php');
                exit;
            } else {
                echo "<script>alert('Erro ao adicionar cidade');</script>";
                $erro = "Erro ao cadastrar cidade: " . mysqli_error($con);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoUrban - Cadastrar Cidade</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.6;
        }

        header {
            background-color: #0056b3;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        header p {
            font-size: 1rem;
            font-weight: 300;
        }

        main {
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .sessao-cadastro h2 {
            text-align: center;
            color: #0056b3;
            margin-bottom: 20px;
        }

        .grupo-formulario {
            margin-bottom: 15px;
        }

        .grupo-formulario label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .grupo-formulario input,
        .grupo-formulario select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            color: #555;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        .grupo-formulario input:focus,
        .grupo-formulario select:focus {
            border-color: #0056b3;
            outline: none;
        }

        /* Estilo específico para o <select> */
        .grupo-formulario select {
            -webkit-appearance: none; /* Para remover a aparência padrão em navegadores como o Safari */
            -moz-appearance: none; /* Para remover a aparência padrão em navegadores Firefox */
            appearance: none; /* Para remover a aparência padrão em navegadores modernos */
            background-color: #fff;
            background-position: right 10px center;
            background-repeat: no-repeat;
        }

        /* Quando o select recebe o foco */
        .grupo-formulario select:focus {
            background-color: #f0faff;
            border-color: #0056b3;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #0056b3;
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        button:hover {
            background-color: #003d80;
        }
    </style>
</head>
<body>
    <header>
        <h1>InfoUrban</h1>
        <p>Melhore sua cidade, participe e compartilhe! Em busca da melhoria urbana</p>
    </header>

    <main>
        <section class="sessao-cadastro">
            <h2>Cadastrar Nova Cidade</h2>
            
            <?php if (isset($erro)) { echo "<p style='color: red;'>$erro</p>"; } ?>

            <form action="cadastrar_cidade.php" method="post">
                <div class="grupo-formulario">
                    <label for="nome-cidade">Nome da Cidade:</label>
                    <input type="text" id="nome-cidade" name="nome_cidade" placeholder="Digite o nome da cidade" required>
                </div>

                <div class="grupo-formulario">
                    <label for="estado-cidade">Estado:</label>
                    <select id="estado-cidade" name="estado_cidade" required>
                        <option value="">Selecione o Estado</option>
                        <option value="AC">Acre (AC)</option>
                        <option value="AL">Alagoas (AL)</option>
                        <option value="AP">Amapá (AP)</option>
                        <option value="AM">Amazonas (AM)</option>
                        <option value="BA">Bahia (BA)</option>
                        <option value="CE">Ceará (CE)</option>
                        <option value="DF">Distrito Federal (DF)</option>
                        <option value="ES">Espírito Santo (ES)</option>
                        <option value="GO">Goiás (GO)</option>
                        <option value="MA">Maranhão (MA)</option>
                        <option value="MT">Mato Grosso (MT)</option>
                        <option value="MS">Mato Grosso do Sul (MS)</option>
                        <option value="MG">Minas Gerais (MG)</option>
                        <option value="PA">Pará (PA)</option>
                        <option value="PB">Paraíba (PB)</option>
                        <option value="PR">Paraná (PR)</option>
                        <option value="PE">Pernambuco (PE)</option>
                        <option value="PI">Piauí (PI)</option>
                        <option value="RJ">Rio de Janeiro (RJ)</option>
                        <option value="RN">Rio Grande do Norte (RN)</option>
                        <option value="RS">Rio Grande do Sul (RS)</option>
                        <option value="RO">Rondônia (RO)</option>
                        <option value="RR">Roraima (RR)</option>
                        <option value="SC">Santa Catarina (SC)</option>
                        <option value="SP">São Paulo (SP)</option>
                        <option value="SE">Sergipe (SE)</option>
                        <option value="TO">Tocantins (TO)</option>
                    </select>
                </div>

                <button type="submit">Cadastrar Cidade</button>
            </form>

            <button onclick="window.location.href='principal.php'">Voltar para a lista de cidades</button>
        </section>
    </main>

    <footer style="display: flex; justify-content: center;">
        <p>© 2025 InfoUrban. Todos os direitos reservados.</p>
    </footer>
</body>
</html>