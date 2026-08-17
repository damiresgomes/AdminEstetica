<?php
if (!isset($page))
    exit;
?>

<div class="container pt-5 pb-5">
    <div class="card shadow">
        <div class="card-header">
            <div class="float-start">
                <h2>Listagem de Serviços</h2>
            </div>

            <div class="float-end">
                <a href="cadastrar/servicos" class="btn btn-success">
                    Novo Registro
                </a>

                <a href="listar/servicos" class="btn btn-success">
                    Listar registros
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th width="35%">Nome do Serviço</th>
                        <th width="20%">Categoria</th>
                        <th width="15%">Preço</th>
                        <th width="10%">Duração (hrs)</th>
                        <th width="10%">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlListar = "SELECT s.id_servico, s.nome_servico, s.preco, s.duracao_horas, c.nome_categoria 
                                  FROM servicos s
                                  INNER JOIN categoria c ON c.id_categoria = s.id_categoria
                                  ORDER BY s.nome_servico";

                    $consultaListar = $pdo->prepare($sqlListar);
                    $consultaListar->execute();

                    $dadosListar = $consultaListar->fetchAll(PDO::FETCH_OBJ);

                    foreach ($dadosListar as $dados) {
                        $precoFormatado = number_format($dados->preco, 2, ',', '.');
                        ?>
                        <tr>
                            <td><?= $dados->id_servico ?></td>
                            <td><?= htmlspecialchars($dados->nome_servico) ?></td>
                            <td><span class="badge bg-info text-dark"><?= htmlspecialchars($dados->nome_categoria) ?></span></td>
                            <td>R$ <?= $precoFormatado ?></td>
                            <td><?= $dados->duracao_horas ? $dados->duracao_horas . ' h' : '-' ?></td>

                            <td>
                                <a href="cadastrar/servicos/<?= $dados->id_servico ?>" class="btn btn-success btn-sm">
                                    Editar
                                </a>

                                <a href="javascript:excluir(<?= $dados->id_servico ?>)" class="btn btn-danger btn-sm">
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
    $(document).ready(function () {
        $('.table').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "Nada encontrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(filtrado de _MAX_ registros no total)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Anterior"
                }
            }
        });
    });
</script>

<script>
    function excluir(id) {
        Swal.fire({
            title: "Deseja realmente excluir esta categoria?",
            showCancelButton: true,
            confirmButtonText: "Excluir",
            cancelButtonText: "Cancelar"
        }).then((result) => {

            if (result.isConfirmed)
                location.href = 'excluir/servicos/' + id;

        });
    }
</script>