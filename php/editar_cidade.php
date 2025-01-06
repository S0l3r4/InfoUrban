<?php
    session_start();
    require('conexao.php');

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }

    if (!isset($_GET['id'])) {
        header('Location: principal.php');
        exit;
    }

    $cidadeId = $_GET['id'];

    $queryCidade = "SELECT * FROM cidades WHERE id = '$cidadeId'";
    $resultCidade = mysqli_query($con, $queryCidade);

    if (mysqli_num_rows($resultCidade) == 0) {
        echo "Cidade não encontrada!";
        exit;
    }

    $cidade = mysqli_fetch_assoc($resultCidade);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nomeCidade = $_POST['nome_cidade'];
        $estadoCidade = $_POST['estado_cidade'];

        $updateQuery = "UPDATE cidades SET nome = '$nomeCidade', estado = '$estadoCidade' WHERE id = '$cidadeId'";
        if (mysqli_query($con, $updateQuery)) {
            header('Location: principal.php');
            exit;
        } else {
            echo "Erro ao atualizar a cidade.";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoUrban - Editar Cidade</title>
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
            <h2>Editar Cidade</h2>

            <form action="editar_cidade.php?id=<?php echo $cidadeId; ?>" method="post">
                <div class="grupo-formulario">
                    <label for="nome-cidade">Nome da Cidade:</label>
                    <input type="text" id="nome-cidade" name="nome_cidade" value="<?php echo $cidade['nome']; ?>" required>
                </div>

                <div class="grupo-formulario">
                    <label for="estado-cidade">Estado:</label>
                    <select id="estado-cidade" name="estado_cidade" required>
                        <option value="">Selecione o Estado</option>
                        <option value="AC" <?php echo ($cidade['estado'] == 'AC' ? 'selected' : ''); ?>>Acre (AC)</option>
                        <option value="AL" <?php echo ($cidade['estado'] == 'AL' ? 'selected' : ''); ?>>Alagoas (AL)</option>
                        <option value="AP" <?php echo ($cidade['estado'] == 'AP' ? 'selected' : ''); ?>>Amapá (AP)</option>
                        <option value="AM" <?php echo ($cidade['estado'] == 'AM' ? 'selected' : ''); ?>>Amazonas (AM)</option>
                        <option value="BA" <?php echo ($cidade['estado'] == 'BA' ? 'selected' : ''); ?>>Bahia (BA)</option>
                        <option value="CE" <?php echo ($cidade['estado'] == 'CE' ? 'selected' : ''); ?>>Ceará (CE)</option>
                        <option value="DF" <?php echo ($cidade['estado'] == 'DF' ? 'selected' : ''); ?>>Distrito Federal (DF)</option>
                        <option value="ES" <?php echo ($cidade['estado'] == 'ES' ? 'selected' : ''); ?>>Espírito Santo (ES)</option>
                        <option value="GO" <?php echo ($cidade['estado'] == 'GO' ? 'selected' : ''); ?>>Goiás (GO)</option>
                        <option value="MA" <?php echo ($cidade['estado'] == 'MA' ? 'selected' : ''); ?>>Maranhão (MA)</option>
                        <option value="MT" <?php echo ($cidade['estado'] == 'MT' ? 'selected' : ''); ?>>Mato Grosso (MT)</option>
                        <option value="MS" <?php echo ($cidade['estado'] == 'MS' ? 'selected' : ''); ?>>Mato Grosso do Sul (MS)</option>
                        <option value="MG" <?php echo ($cidade['estado'] == 'MG' ? 'selected' : ''); ?>>Minas Gerais (MG)</option>
                        <option value="PA" <?php echo ($cidade['estado'] == 'PA' ? 'selected' : ''); ?>>Pará (PA)</option>
                        <option value="PB" <?php echo ($cidade['estado'] == 'PB' ? 'selected' : ''); ?>>Paraíba (PB)</option>
                        <option value="PR" <?php echo ($cidade['estado'] == 'PR' ? 'selected' : ''); ?>>Paraná (PR)</option>
                        <option value="PE" <?php echo ($cidade['estado'] == 'PE' ? 'selected' : ''); ?>>Pernambuco (PE)</option>
                        <option value="PI" <?php echo ($cidade['estado'] == 'PI' ? 'selected' : ''); ?>>Piauí (PI)</option>
                        <option value="RJ" <?php echo ($cidade['estado'] == 'RJ' ? 'selected' : ''); ?>>Rio de Janeiro (RJ)</option>
                        <option value="RN" <?php echo ($cidade['estado'] == 'RN' ? 'selected' : ''); ?>>Rio Grande do Norte (RN)</option>
                        <option value="RS" <?php echo ($cidade['estado'] == 'RS' ? 'selected' : ''); ?>>Rio Grande do Sul (RS)</option>
                        <option value="RO" <?php echo ($cidade['estado'] == 'RO' ? 'selected' : ''); ?>>Rondônia (RO)</option>
                        <option value="RR" <?php echo ($cidade['estado'] == 'RR' ? 'selected' : ''); ?>>Roraima (RR)</option>
                        <option value="SC" <?php echo ($cidade['estado'] == 'SC' ? 'selected' : ''); ?>>Santa Catarina (SC)</option>
                        <option value="SP" <?php echo ($cidade['estado'] == 'SP' ? 'selected' : ''); ?>>São Paulo (SP)</option>
                        <option value="SE" <?php echo ($cidade['estado'] == 'SE' ? 'selected' : ''); ?>>Sergipe (SE)</option>
                        <option value="TO" <?php echo ($cidade['estado'] == 'TO' ? 'selected' : ''); ?>>Tocantins (TO)</option>
                    </select>
                </div>

                <button type="submit">Atualizar Cidade</button>
            </form>

            <button onclick="window.location.href='principal.php'">Voltar para a lista de cidades</button>
        </section>
    </main>

    <footer style="display: flex; justify-content: center;">
        <p>© 2025 InfoUrban. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
