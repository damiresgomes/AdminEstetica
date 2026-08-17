<?php
    header('Content-Type: application/json; charset=utf-8');

    $id = $_GET["id"] ?? NULL;

    include "../config.php";

    $sqlCategoria = "SELECT * FROM categoria WHERE id = :id LIMIT 1";
    $consultaCategoria = $pdo->prepare($sqlCategoria);
    $consultaCategoria->bindParam(":id", $id);
    $consultaCategoria->execute();

    $Categoria = $consultaCategoria->fetch(PDO::FETCH_OBJ);

    echo json_encode($Categoria);
?>