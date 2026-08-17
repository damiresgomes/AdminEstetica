<?php
if (!isset($page))
    exit;

if ($_POST) {

    $id_categoria = !empty($_POST["id"]) ? trim($_POST["id"]) : NULL;
    $nome_categoria = trim($_POST["nome_categoria"] ?? '');

    if (empty($nome_categoria)) {
        echo "<script>mensagem('Preencha a categoria','erro');</script>";
        exit;

    } else if (empty($id_categoria)) {
        $sqlSalvar = "INSERT INTO categoria (nome_categoria) VALUES (:nome_categoria)";
        $consultaSalvar = $pdo->prepare($sqlSalvar);
        $consultaSalvar->bindParam(":nome_categoria", $nome_categoria);
    } else {
        $sqlSalvar = "UPDATE categoria SET nome_categoria = :nome_categoria WHERE id_categoria = :id_categoria LIMIT 1";
        $consultaSalvar = $pdo->prepare($sqlSalvar);
        $consultaSalvar->bindParam(":nome_categoria", $nome_categoria);
        $consultaSalvar->bindParam(":id_categoria", $id_categoria);
    }

    if ($consultaSalvar->execute()) {

        echo "<script>mensagem('Categoria salva com sucesso','success','listar/categoria')</script>";

    } else {

        echo "<script>mensagem('Erro ao salvar categoria','erro');</script>";

    }

} else {

    echo "<script>mensagem('Erro ao acessar página','erro');</script>";

}