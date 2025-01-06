<?php
    session_start();
    require('conexao.php');

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }

    $userId = $_SESSION['usuario_id'];
    $queryUser = "SELECT nome FROM usuarios WHERE id = '$userId'";
    $resultUser = mysqli_query($con, $queryUser);
    $user = mysqli_fetch_assoc($resultUser);

    $query = "SELECT * FROM cidades";
    $result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoUrban - Cidades</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <style>
        .sessao-cidades h2 {
            text-align: center;
            color: #0056b3;
            margin-bottom: 20px;
        }

        .cidades-lista {
            margin-bottom: 20px;
        }

        #campo-busca {
            width: 100%;
            padding: 12px;
            border: 2px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        #campo-busca:focus {
            border-color: #0056b3;
            outline: none;
        }

        #lista-cidades {
            list-style-type: none;
            padding-left: 0;
        }

        #lista-cidades li {
            background-color: #fafafa;
            padding: 10px;
            margin: 5px 0;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        #lista-cidades li:hover {
            background-color: #e7f1ff;
        }

        #lista-cidades a {
            color: #0056b3;
            text-decoration: none;
            font-weight: bold;
            margin-left: 10px;
            transition: color 0.3s ease;
        }

        #lista-cidades a:hover {
            color: #003d80;
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

        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #f4f7fc;
            font-size: 0.9rem;
            color: #555;
            margin-top: 40px;
        }

        @media (max-width: 600px) {
            main {
                padding: 10px;
            }

            header h1 {
                font-size: 2rem;
            }
        }
    </style>

    <header>
        <h1>InfoUrban</h1>
        <p>Melhore sua cidade, participe e compartilhe! Em busca da melhoria urbana</p>
    </header>

    <main>
        <section class="sessao-cidades">
            <h2>Cidades Cadastradas</h2>
            <div class="cidades-lista">
                <input type="text" id="campo-busca" placeholder="Buscar cidade..." onkeyup="buscarCidade()">
                <ul id="lista-cidades">
                    <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<li><a href='melhorias_cidade.php?cidade_id=" . $row['id'] . "'>" . $row['nome'] . " - " . $row['estado'] . "</a> | 
                                    <a href='editar_cidade.php?id=" . $row['id'] . "'>Editar</a> | 
                                    <a href='excluir_cidade.php?id=" . $row['id'] . "'>Excluir</a></li>";
                            }
                        } else {
                            echo "<li>Nenhuma cidade cadastrada.</li>";
                        }
                    ?>
                </ul>
            </div>
            <button onclick="window.location.href='cadastrar_cidade.php'">Cadastrar Nova Cidade</button>
        </section>

    </main>

    <footer>
        <p>&copy; 2025 InfoUrban. Todos os direitos reservados.</p>
    </footer>

    <script>
        function buscarCidade() {
            let filtro = document.getElementById('campo-busca').value.toUpperCase();
            let ul = document.getElementById("lista-cidades");
            let li = ul.getElementsByTagName('li');
            
            for (let i = 0; i < li.length; i++) {
                let texto = li[i].textContent || li[i].innerText;
                if (texto.toUpperCase().indexOf(filtro) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>