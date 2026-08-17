<?php
if (!isset($page)) exit;

$id = $param[2] ?? NULL;

if (empty($id)) {
    echo "<script>mensagem('Registro inválido','erro','listar/servicos');</script>";
    exit;
}

$pdo->beginTransaction();

$sqlVerifica = "SELECT id_agendamento FROM agendamento_servico WHERE id_servico = :id LIMIT 1";
$consultaVerifica = $pdo->prepare($sqlVerifica);
$consultaVerifica->bindParam(":id", $id);
$consultaVerifica->execute();

$dadosAgendamento = $consultaVerifica->fetch(PDO::FETCH_OBJ);

if (!empty($dadosAgendamento->id_agendamento)) {
    $pdo->rollBack();
    echo "<script>mensagem('Não foi possível excluir, pois existem agendamentos cadastrados com este serviço!','erro','listar/servicos');</script>";
    exit;
}

$sqlDelete = "DELETE FROM servicos WHERE id_servico = :id LIMIT 1";
$consultaDelete = $pdo->prepare($sqlDelete);
$consultaDelete->bindParam(":id", $id);

if ($consultaDelete->execute()) {
    $pdo->commit();
    echo "<script>mensagem('Serviço excluído com sucesso!','success','listar/servicos');</script>";
    exit;
} else {
    $pdo->rollBack();
    echo "<script>mensagem('Erro ao excluir serviço','erro','listar/servicos');</script>";
    exit;
}