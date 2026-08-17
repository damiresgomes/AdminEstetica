<?php
if (!isset($page))
    exit;

if ($_POST) {

    $id = trim($_POST["id"] ?? NULL);
    $nome_servico = trim($_POST["nome_servico"] ?? NULL);
    $id_categoria = trim($_POST["id_categoria"] ?? NULL);
    $preco = trim($_POST["valor"] ?? NULL);
    $duracao_horas = trim($_POST["duracao_horas"] ?? NULL);
    $descricao = trim($_POST["servico"] ?? NULL);

    if ($duracao_horas === '') {
        $duracao_horas = null;
    }

    if (empty($nome_servico) || empty($id_categoria) || empty($preco)) {
        echo "<script>mensagem('Preencha os campos obrigatórios','error');</script>";
        exit;
    }

    $preco = str_replace('.', '', $preco);
    $preco = str_replace(',', '.', $preco);

    if (empty($id)) {
        $sqlCadastro = "INSERT INTO servicos (nome_servico, descricao, preco, id_categoria, duracao_horas) 
                        VALUES (:nome_servico, :descricao, :preco, :id_categoria, :duracao_horas)";
                        
        $consultaCadastro = $pdo->prepare($sqlCadastro);
        $consultaCadastro->bindParam(":nome_servico", $nome_servico);
        $consultaCadastro->bindParam(":descricao", $descricao);
        $consultaCadastro->bindParam(":preco", $preco);
        $consultaCadastro->bindParam(":id_categoria", $id_categoria);
        $consultaCadastro->bindParam(":duracao_horas", $duracao_horas);

    } else {
        $sqlCadastro = "UPDATE servicos 
                        SET nome_servico = :nome_servico, 
                            descricao = :descricao, 
                            preco = :preco, 
                            id_categoria = :id_categoria, 
                            duracao_horas = :duracao_horas
                        WHERE id_servico = :id 
                        LIMIT 1";

        $consultaCadastro = $pdo->prepare($sqlCadastro);
        $consultaCadastro->bindParam(":nome_servico", $nome_servico);
        $consultaCadastro->bindParam(":descricao", $descricao);
        $consultaCadastro->bindParam(":preco", $preco);
        $consultaCadastro->bindParam(":id_categoria", $id_categoria);
        $consultaCadastro->bindParam(":duracao_horas", $duracao_horas);
        $consultaCadastro->bindParam(":id", $id);
    }

    if ($consultaCadastro->execute()) {
        echo "<script>mensagem('Registro salvo com sucesso','success','listar/servicos');</script>";
        exit;
    } else {
        echo "<script>mensagem('Falha ao salvar registro','error');</script>";
        exit;
    }

} else {
    echo "<script>mensagem('Requisição inválida','error');</script>";
    exit;
}