<?php
if (!isset($page))
    exit;

$id = $param[2] ?? NULL;

if (!empty($id)) {
    $sql = "SELECT * FROM servicos WHERE id_servico = :id LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);
}

$id_servico = $dados->id_servico ?? NULL;
$nome_servico = $dados->nome_servico ?? NULL;
$id_categoria = $dados->id_categoria ?? NULL;
$preco = isset($dados->preco) ? number_format($dados->preco, 2, ',', '.') : NULL;
$descricao = $dados->descricao ?? NULL;
$duracao_horas = $dados->duracao_horas ?? NULL;
?>
<div class="container pt-5 pb-5">
    <div class="card shadow">
        <div class="card-header">
            <div class="float-start">
                <h2>Cadastro de Serviços</h2>
            </div>

            <div class="float-end">
                <a href="cadastrar/servicos" class="btn btn-success">
                    Novo Registro
                </a>

                <a href="listar/servicos" class="btn btn-success">
                    Listar Registros
                </a>
            </div>
        </div>
        <div class="card-body">
            <form name="formCadastro" method="post" action="salvar/servicos" data-parsley-validate
                enctype="multipart/form-data">

                <div class="row">
                    <div class="col-12 col-md-1">
                        <label for="id">ID:</label>
                        <input type="number" name="id" id="id" readonly class="form-control" value="<?= $id_servico ?>">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="nome_servico">Nome do Serviço:</label>
                        <input type="text" name="nome_servico" id="nome_servico" class="form-control" required
                            data-parsley-required-message="Preencha este campo" placeholder="Digite o nome do Serviço:"
                            value="<?= htmlspecialchars($nome_servico ?? '') ?>">
                    </div>

                    <div class="col-12 col-md-5">
                        <label for="valor">Valor do Serviço:</label>
                        <input type="text" name="valor" id="valor" class="form-control" required
                            data-parsley-required-message="Preencha este campo" placeholder="Valor do Serviço:"
                            value="<?= $preco ?>">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="id_categoria">Selecione a Categoria:</label>
                        <select name="id_categoria" id="id_categoria" required class="form-control"
                            data-parsley-required-message="Selecione uma Opção">
                            <option value="">Selecione uma Opção</option>
                            <?php

                            $sqlCategoria = "SELECT id_categoria, nome_categoria
                                            FROM categoria
                                            ORDER BY nome_categoria";
                            $consultaCategoria = $pdo->prepare($sqlCategoria);
                            $consultaCategoria->execute();

                            $dadosCategoria = $consultaCategoria->fetchAll(PDO::FETCH_OBJ);

                            foreach ($dadosCategoria as $dados) {
                                $selected = ($dados->id_categoria == $id_categoria) ? 'selected' : '';
                            ?>
                                <option value="<?= $dados->id_categoria ?>" <?= $selected ?>>
                                    <?= htmlspecialchars($dados->nome_categoria) ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="duracao_horas">Duração (Horas):</label>
                        <input type="number" step="0.5" name="duracao_horas" id="duracao_horas" class="form-control"
                            data-parsley-required-message="Preencha este campo" placeholder="Ex: 2.5" value="<?= $duracao_horas ?>">
                    </div>

                    <div class="col-12 col-md-12">
                        <label for="servico">Descrição do Serviço:</label>
                        <textarea name="servico" id="servico" class="form-control"
                            data-parsley-required-message="Preencha este campo"><?= $descricao?></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-success float-end">
                    Salvar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#servico').summernote({
            placeholder: 'Digite a descrição do serviço',
            tabsize: 2,
            height: 300
        });
    })
</script>

<script>
    $(document).ready(function () {
        $('#valor').mask('000.000.000,00', {
            reverse: true
        });
    })
</script>