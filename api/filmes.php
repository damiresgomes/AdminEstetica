<?php
    header('Content-Type: application/json; charset=utf-8');

    include "../config.php";

    $sqlFilmes = "SELECT * FROM filme ORDER BY titulo";
    $consultaFilmes = $pdo->prepare($sqlFilmes);
    $consultaFilmes->execute();

    $filmes = $consultaFilmes->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($filmes);
?>