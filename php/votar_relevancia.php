<?php
    require('conexao.php');
    session_start();

    if (isset($_GET['melhoria_id']) && isset($_POST['estrela'])) {
        $melhoriaId = $_GET['melhoria_id'];
        $estrela = $_POST['estrela'];

        $queryMelhoria = "SELECT * FROM melhorias WHERE id = '$melhoriaId'";
        $resultMelhoria = mysqli_query($con, $queryMelhoria);
        $melhoria = mysqli_fetch_assoc($resultMelhoria);

        if (!$melhoria) {
            echo "<script>alert('Não foi possivel encontrar a melhoria selecionada');
                    window.location.href = 'melhorias_cidade.php?cidade_id=" . $_GET['cidade_id'] . "';    
                </script>";
            exit;
        }

        if (!isset($_SESSION['usuario_id'])) {
            echo "<script>alert('Usuario não logado');
                    window.location.href = 'login.php .';
                </script>";
            exit;
        }

        $usuarioId = $_SESSION['usuario_id'];

        if ($estrela < 1 || $estrela > 5) {
            echo "<script>alert('Voto invalido');
                    window.location.href = 'melhorias_cidade.php?cidade_id=" . $_GET['cidade_id'] . "';
                </script>";
            exit;
        }

        $queryVotoExistente = "SELECT * FROM votos_relevancia WHERE melhoria_id = '$melhoriaId' AND usuario_id = '$usuarioId'";
        $resultVotoExistente = mysqli_query($con, $queryVotoExistente);

        if (mysqli_num_rows($resultVotoExistente) > 0) {
            echo "<script>
                    alert('Você já votou nessa melhoria');
                    window.location.href = 'melhorias_cidade.php?cidade_id=" . $_GET['cidade_id'] . "';
                </script>";
        }

        $queryVoto = "INSERT INTO votos_relevancia (melhoria_id, usuario_id, estrelas) 
                      VALUES ('$melhoriaId', '$usuarioId', '$estrela')";
        mysqli_query($con, $queryVoto);

        $queryAtualizarRelevancia = "UPDATE melhorias SET relevancia = 
                                      (SELECT AVG(relevancia) FROM votos_relevancia WHERE melhoria_id = '$melhoriaId') 
                                      WHERE id = '$melhoriaId'";
        mysqli_query($con, $queryAtualizarRelevancia);

        echo "<script>
                alert('Avaliação enviada');
                window.location.href = 'melhorias_cidade.php?cidade_id=" . $_GET['cidade_id'] . "';
            </script>";
    } else {
        echo "<script>
                alert('Erro de parametros');
                window.location.href = 'melhorias_cidade';
            </script>";
        exit;
    }
?>