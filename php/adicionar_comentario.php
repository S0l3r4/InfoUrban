<?php
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit();
    }
    require('conexao.php');

    if (isset($_POST['comentario']) && isset($_GET['melhoria_id'])) {
        $comentario = mysqli_real_escape_string($con, $_POST['comentario']);
        $melhoria_id = (int)$_GET['melhoria_id'];
        $usuario_id = $_SESSION['usuario_id']; // ID do usuário logado

        $query = "INSERT INTO comentarios (comentario, melhoria_id, usuario_id, data_criacao) 
                VALUES ('$comentario', $melhoria_id, $usuario_id, NOW())";

        if (mysqli_query($con, $query)) {
            header("Location: melhorias_cidade.php?cidade_id=$melhoria_id");
            exit();
        } else {
            echo "Erro ao adicionar comentário: " . mysqli_error($con);
        }
    } else {
        header('Location: melhorias_cidade.php');
        exit();
    }
?>