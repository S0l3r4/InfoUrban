<?php
    require('conexao.php');
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }

    if (isset($_GET['cidade_id'])) {
        $cidadeId = $_GET['cidade_id'];
        
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

    $orderBy = "ORDER BY data_criacao DESC";
    $filtroData = isset($_GET['data']) ? $_GET['data'] : '';
    $filtroCategoria = isset($_GET['filtroCategoria']) ? $_GET['filtroCategoria'] : '';
    $relevancia = isset($_GET['relevancia']) && $_GET['relevancia'] == 'mais_relevantes' ? 'DESC' : '';

    if (isset($_GET['relevancia']) && $_GET['relevancia'] === 'mais_relevantes') {
        $orderBy = "ORDER BY relevancia DESC, data_criacao DESC";
    }

    $queryMelhorias = "SELECT m.*, COALESCE(SUM(v.estrelas), 0) AS relevancia
                FROM melhorias m 
                LEFT JOIN votos_relevancia v ON m.id = v.melhoria_id
                WHERE m.cidade_id = '$cidadeId'";

    if (isset($filtroData) && $filtroData != '') {
        $queryMelhorias .= " AND m.data_criacao >= '$filtroData'";
    }

    if (isset($filtroCategoria) && $filtroCategoria != '') {
        $queryMelhorias .= " AND m.categoria = '$filtroCategoria'";
    }
    
    $queryMelhorias .= " GROUP BY m.id";

    if (!empty($orderBy)) {
        $queryMelhorias .= " " . $orderBy;
    }
    $resultMelhorias = mysqli_query($con, $queryMelhorias);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melhorias de <?= $cidade['nome']; ?></title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">

</head>
<body>
    <style>
        main{
            display: flex;

        }
        .opcoes{
            margin-right: 20px;
        }
        .sessao-cidades {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .sessao-cidades h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #0056b3;
        }
        #campo-busca {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 1rem;
        }
        #campo-busca:focus {
            outline: none;
            border-color: #0056b3;
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.5);
        }
        .cidades-lista ul {
            list-style-type: none;
            padding: 0;
        }
        .cidades-lista li {
            padding: 10px;
            background-color: #f9f9f9;
            margin: 10px 0;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .cidades-lista li a {
            color: #0056b3;
            text-decoration: none;
            margin-right: 10px;
        }
        .cidades-lista li a:hover {
            text-decoration: underline;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        button:hover {
            background-color: #003d80;
        }
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            font-size: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        select:focus {
            outline: none;
            border-color: #0056b3;
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.5);
        }
        input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
            font-size: 1rem;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        input[type="date"]:focus {
            outline: none;
            border-color: #0056b3;
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.5);
        }
        .form-melhoria{
            display: flex;
            align-items: center;
        }
    </style>

    <header>
        <h1>InfoUrban</h1>
        <p>Melhorias sugeridas para a cidade de <?= $cidade['nome']; ?></p>
    </header>
    <main>
    <div class="opcoes">
            <button onclick="window.location.href='adicionar_melhoria.php?id=<?php echo $_GET['cidade_id']; ?>'">Indicar uma melhoria</button>
            <button onclick="window.location.href='principal.php'">Voltar para a lista de cidades</button>
    </div>
        <div>
            <section class="filtros">
                <h2>Filtros de Melhorias</h2>
                <form method="get" action="melhorias_cidade.php">
                    <label for="relevancia">Filtrar por relevância:</label>
                    <select name="relevancia" id="relevancia">
                        <option value="">Selecione</option>
                        <option value="mais_relevantes" <?= (isset($_GET['relevancia']) && $_GET['relevancia'] === 'mais_relevantes') ? 'selected' : ''; ?>>Mais Relevantes</option>
                    </select>
                    <input type="hidden" name="cidade_id" value="<?= $cidadeId; ?>">
                    <label for="data">Filtrar por data:</label>
                    <input type="date" id="data" name="data" value="<?= $filtroData; ?>">

                    <label for="filtroCategoria">Filtrar por categoria:</label>
                    <select id="filtroCategoria" name="filtroCategoria">
                        <option value="">Selecione a categoria</option>
                        <option value="Infraestrutura" <?= ($filtroCategoria == 'Infraestrutura') ? 'selected' : ''; ?>>Infraestrutura</option>
                        <option value="Saúde" <?= ($filtroCategoria == 'Saúde') ? 'selected' : ''; ?>>Saúde</option>
                        <option value="Educação" <?= ($filtroCategoria == 'Educação') ? 'selected' : ''; ?>>Educação</option>
                        <option value="Segurança" <?= ($filtroCategoria == 'Segurança') ? 'selected' : ''; ?>>Segurança</option>
                        <option value="Meio Ambiente" <?= ($filtroCategoria == 'Meio Ambiente') ? 'selected' : ''; ?>>Meio Ambiente</option>
                    </select>

                    <button type="submit">Aplicar Filtro</button>
                </form>
            </section>
            <section class="melhorias">
                <h2>Melhorias Sugeridas</h2>
                <?php if (mysqli_num_rows($resultMelhorias) > 0): ?>
                    <ul>
                        <?php while ($row = mysqli_fetch_assoc($resultMelhorias)): ?>
                            
                            <li>
                                <strong><?= $row['titulo']; ?></strong> - <?= $row['categoria']; ?> - <small>Data: <?= date('d/m/Y', strtotime($row['data_criacao'])); ?></small>
                                <p><?= $row['descricao']; ?></p>
                                <p>Relevância: <?= $row['relevancia']; ?> estrelas</p>
                                <form method="post" action="votar_relevancia.php?melhoria_id=<?= $row['id'] ?>&cidade_id=<?= $_GET['cidade_id']; ?>" class="form-melhoria">
                                    <input type="hidden" name="melhoria_id" value="<?= $row['id']; ?>">
                                    <label for="estrelas">Avaliar:</label>
                                    <select name="estrela" id="estrelas" style="margin-left: 10px; margin-right: 10px;">
                                        <option value="1">1 estrela</option>
                                        <option value="2">2 estrelas</option>
                                        <option value="3">3 estrelas</option>
                                        <option value="4">4 estrelas</option>
                                        <option value="5">5 estrelas</option>
                                    </select>
                                    <button type="submit" style="margin-top: 0;">Enviar voto</button>
                                </form>

                                <details>
                                    <summary>Ver Comentários</summary>
                                    
                                    <div class="comentarios-lista">
                                        <?php
                                            $queryComentarios = "SELECT c.*, u.nome AS nome_usuario 
                                                                FROM comentarios c 
                                                                LEFT JOIN usuarios u ON c.usuario_id = u.id 
                                                                WHERE c.melhoria_id = {$row['id']} 
                                                                ORDER BY c.data_criacao DESC";
                                            $resultComentarios = mysqli_query($con, $queryComentarios);
                                        ?>
                                        <?php if (mysqli_num_rows($resultComentarios) > 0): ?>
                                            <ul>
                                                <?php while ($comentario = mysqli_fetch_assoc($resultComentarios)): ?>
                                                    <li>
                                                        <strong><?= $comentario['nome_usuario']; ?>:</strong> <?= $comentario['comentario']; ?>
                                                        <br>
                                                        <small>Comentado em: <?= date('d/m/Y H:i', strtotime($comentario['data_criacao'])); ?></small>
                                                    </li>
                                                <?php endwhile; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p>Não há comentários ainda.</p>
                                        <?php endif; ?>
                                        
                                        <form method="post" action="adicionar_comentario.php?melhoria_id=<?= $row['id']; ?>&cidade_id=<?= $cidadeId ?>">
                                            <textarea name="comentario" placeholder="Deixe sua opinião..." required></textarea>
                                            <button type="submit">Adicionar Comentário</button>
                                        </form>
                                    </div>
                                </details>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>Não há melhorias sugeridas para cidade.</p>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 InfoUrban. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
