<<<<<<< HEAD
<?php
    header('Content-Type: application/json; charset=utf-8');

    include "../config.php";

    $sqlCategorias = "SELECT * FROM categoria ORDER BY categoria";
    $consultaCategorias = $pdo->prepare($sqlCategorias);
    $consultaCategorias->execute();

    $categorias = $consultaCategorias->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($categorias);
=======
<?php
    header('Content-Type: application/json; charset=utf-8');

    include "../config.php";

    $sqlCategorias = "SELECT * FROM categoria ORDER BY categoria";
    $consultaCategorias = $pdo->prepare($sqlCategorias);
    $consultaCategorias->execute();

    $categorias = $consultaCategorias->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($categorias);
>>>>>>> eddd8de7493f3753a1b023e2b4f2f88528d02156
?>