<?php if (!isset($page)) exit; ?>
<?php

$sqlCadastro = "SELECT id_categoria, nome_categoria
                FROM categoria
                ORDER BY nome_categoria";
$consultaCadastro = $pdo->prepare($sqlCadastro);
$consultaCadastro->execute();

$dadosCadastro = $consultaCadastro->fetchAll(PDO::FETCH_OBJ);

?>
<div class="container pt-5 pb-5">
    <div class="card shadow">
        <div class="card-header">
            <div class="float-start">
                <h2>Listagem de <span>Categoria</span></h2>
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
            <table class="table table-bordered table-striped m-2">
                <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th width="70%">Nome da Categoria</th>
                        <th width="20%">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($dadosCadastro as $dados) {
                        ?>
                        <tr>
                            <td><?= $dados->id_categoria ?></td>
                            <td><?= htmlspecialchars($dados->nome_categoria) ?></td>
                            <td>
                                <a href="cadastrar/categoria/<?= $dados->id_categoria ?>"
                                    class="btn btn-warning">
                                    Editar
                                </a>

                                <a href="javascript:excluir(<?= $dados->id_categoria ?>)"
                                    class="btn btn-danger">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function excluir(id) {
        Swal.fire({
            title: "Deseja realmente excluir esta categoria?",
            showCancelButton: true,
            confirmButtonText: "Excluir",
            cancelButtonText: "Cancelar"
        }).then((result) => {

            if (result.isConfirmed)
                location.href = 'excluir/categoria/' + id;

        });
    }
</script>