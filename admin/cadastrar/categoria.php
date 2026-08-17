<?php if (!isset($page))
    exit; ?>
<?php

$id = $param[2] ?? NULL;

if (!empty($id)) {
    $sqlCadastro = "SELECT * FROM categoria WHERE id_categoria = :id LIMIT 1";
    $consultaCadastro = $pdo->prepare($sqlCadastro);
    $consultaCadastro->bindParam(":id", $id);
    $consultaCadastro->execute();

    $dadosCadastro = $consultaCadastro->fetch(PDO::FETCH_OBJ);
}

$id_categoria = $dadosCadastro->id_categoria ?? NULL;
$nome_categoria = $dadosCadastro->nome_categoria ?? NULL;

?>

<div class="container pt-5 pb-5">
    <div class="card shadow">
        <div class="card-header">
            <div class="float-start">
                <h2>Cadastro de Categoria</h2>
            </div>

            <div class="float-end">
                <a href="cadastrar/categoria" class="btn btn-success">
                    Cadastrar Novo
                </a>

                <a href="listar/categoria" class="btn btn-success">
                    Listar Registro
                </a>
            </div>
        </div>
        <div class="card-body">
            <form name="formCadastro" method="post" action="salvar/categoria" data-parsley-validate="">
                <div class="row">
                    <div class="col-12 col-md-2">
                        <label for="id">ID</label>
                        <input type="text" name="id" id="id" value="<?= $id_categoria ?>" class="form-control" readonly>
                    </div>
                    <div class="col-12 col-md-10">
                        <label for="nome_categoria">Categoria</label>
                        <input type="text" name="nome_categoria" id="nome_categoria" value="<?= $nome_categoria ?>"
                            class="form-control" required data-parsley-required-message="Preencha este campo">
                    </div>
                </div>
                <br>
                <div class="float-end">
                    <button type="submit" class="btn btn-success">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>