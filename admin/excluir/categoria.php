<?php
if (!isset($page)) exit;

$id = $param[2] ?? NULL;

if (empty($id)) {
    echo "<script>mensagem('Registro inválido','erro','listar/categoria');</script>";
    exit;
}

$pdo->beginTransaction();

$sqlVerifica = "SELECT id_servico FROM servicos WHERE id_categoria = :id LIMIT 1";
$consultaVerifica = $pdo->prepare($sqlVerifica);
$consultaVerifica->bindParam(":id", $id);
$consultaVerifica->execute();

$dadosServico = $consultaVerifica->fetch(PDO::FETCH_OBJ);

if (!empty($dadosServico->id_servico)) {
    $pdo->rollBack();
    echo "<script>mensagem('Não foi possível excluir, pois existem serviços cadastrados com esta categoria!','erro','listar/categoria');</script>";
    exit;
}

$sqlDelete = "DELETE FROM categoria WHERE id_categoria = :id LIMIT 1";
$consultaDelete = $pdo->prepare($sqlDelete);
$consultaDelete->bindParam(":id", $id);

if ($consultaDelete->execute()) {
    $pdo->commit();
    echo "<script>mensagem('Categoria excluída com sucesso!','success','listar/categoria');</script>";
    exit;
} else {
    $pdo->rollBack();
    echo "<script>mensagem('Erro ao excluir categoria','erro','listar/categoria');</script>";
    exit;
}