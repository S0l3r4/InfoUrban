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

    $deleteQuery = "DELETE FROM cidades WHERE id = '$cidadeId'";
    if (mysqli_query($con, $deleteQuery)) {
        echo "Cidade excluída com sucesso!";
        header('Location: principal.php');
        exit;
    } else {
        echo "Erro ao excluir a cidade.";
    }
?>
