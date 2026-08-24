<<<<<<< HEAD
<?php
    header('Content-Type: application/json; charset=utf-8');

    $id = $_GET["id"] ?? NULL;

    include "../config.php";

    $sqlFilmes = "SELECT * FROM filme WHERE id = :id LIMIT 1";
    $consultaFilmes = $pdo->prepare($sqlFilmes);
    $consultaFilmes->bindParam(":id", $id);
    $consultaFilmes->execute();

    $filmes = $consultaFilmes->fetch(PDO::FETCH_OBJ);

    echo json_encode($filmes);
=======
<?php
    header('Content-Type: application/json; charset=utf-8');

    $id = $_GET["id"] ?? NULL;

    include "../config.php";

    $sqlFilmes = "SELECT * FROM filme WHERE id = :id LIMIT 1";
    $consultaFilmes = $pdo->prepare($sqlFilmes);
    $consultaFilmes->bindParam(":id", $id);
    $consultaFilmes->execute();

    $filmes = $consultaFilmes->fetch(PDO::FETCH_OBJ);

    echo json_encode($filmes);
>>>>>>> eddd8de7493f3753a1b023e2b4f2f88528d02156
?>