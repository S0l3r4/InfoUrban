<?php
    require('conexao.php');
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }

    if (isset($_GET['id'])) {
        $cidadeId = $_GET['id'];
        $queryCidade = "SELECT nome FROM cidades WHERE id = '$cidadeId'";
        $resultCidade = mysqli_query($con, $queryCidade);
        $cidade = mysqli_fetch_assoc($resultCidade);
        
        if (!$cidade) {
            header('Location: principal.php');
            exit;
        }
    } else {
        header('Location: principal.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $categoria = $_POST['categoria'];
        $query = "INSERT INTO melhorias (cidade_id, titulo, descricao, categoria) 
                  VALUES ('$cidadeId', '$titulo', '$descricao', '$categoria')";
        mysqli_query($con, $query);
        
       header('Location: melhorias_cidade.php?cidade_id=' . $cidadeId);
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Melhoria para <?php echo $cidade['nome']; ?></title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
<style>
        button {
            padding: 10px 15px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 15px;
        }
        button:hover {
            background-color: #003d80;
        }
        .sessao-formulario {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .sessao-formulario h2 {
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
        .grupo-formulario input, .grupo-formulario textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }
        .grupo-formulario textarea {
            resize: vertical;
            min-height: 100px;
        }
        .grupo-formulario input:focus, .grupo-formulario textarea:focus {
            outline: none;
            border-color: #0056b3;
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.5);
        }
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            font-size: 1rem;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        select:focus {
            outline: none;
            border-color: #0056b3;
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.5);
        }
    </style>
    <header>
        <h1>InfoUrban</h1>
        <p>Melhore sua cidade, participe e compartilhe! Em busca da melhoria urbana</p>
    </header>

    <main>
        <section class="sessao-formulario">
            <h2>Adicionar Melhoria para <?php echo $cidade['nome']; ?></h2>
            <form action="" method="post">
                <div class="grupo-formulario">
                    <label for="titulo">Título da Melhoria:</label>
                    <input type="text" id="titulo" name="titulo" placeholder="Digite o título da melhoria" required>
                </div>

                <div class="grupo-formulario">
                    <label for="descricao">Descrição da Melhoria:</label>
                    <textarea id="descricao" name="descricao" placeholder="Descreva a melhoria" required></textarea>
                </div>

                <div class="grupo-formulario">
                    <label for="categoria">Categoria da Melhoria:</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Selecione a categoria</option>
                        <option value="Infraestrutura">Infraestrutura</option>
                        <option value="Saúde">Saúde</option>
                        <option value="Educação">Educação</option>
                        <option value="Segurança">Segurança</option>
                        <option value="Meio Ambiente">Meio Ambiente</option>
                    </select>
                </div>
                <div class="botoes" style="display: flex; flex-direction: column;">
                    <button type="submit">Adicionar Melhoria</button>
                </div>            
            </form>
        </section>

        <section>
        <button onclick="window.location.href='melhorias_cidade.php?cidade_id=<?php echo $cidadeId; ?>'">Voltar para a lista de melhorias</button>

        </section>
    </main>

    <footer>
        <p>&copy; 2025 InfoUrban. Todos os direitos reservados.</p>
    </footer>
</body>
</html>

