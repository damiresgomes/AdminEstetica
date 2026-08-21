<?php
if (!isset($page))
    exit;
?>

<div class="container pt-5 pb-5">
    <div class="card shadow">
        <div class="card-header">
            <div class="float-start">
                <h2>Listagem de <span>Usuários</span></h2>
            </div>

            <div class="float-end">
                <a href="cadastrar/usuario" class="btn btn-success">
                    Novo Registro
                </a>

                <a href="listar/usuario" class="btn btn-success">
                    Listar registros
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>CPF</th>
                        <th>Data de Nascimento</th>
                        <th>Status</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlListar = "SELECT id, nome, email, cpf, datanascimento, ativo
                                FROM usuario
                                ORDER BY nome";

                    $consultaListar = $pdo->prepare($sqlListar);
                    $consultaListar->execute();

                    $dadosListar = $consultaListar->fetchAll(PDO::FETCH_OBJ);

                    foreach ($dadosListar as $dados) 
                        // Formatação da data (YYYY-MM-DD -> DD/MM/YYYY)
                        $dataNasc = '-';
                        if (!empty($dados->datanascimento)) {
                            $dataNasc = date('d/m/Y', strtotime($dados->datanascimento));
                        }

                        $statusBadge = ($dados->ativo == 'Sim' || $dados->ativo == 'S' || $dados->ativo == '1')
                            ? '<span class="badge bg-success">Ativo</span>'
                            : '<span class="badge bg-danger">Inativo</span>';
                        ?>
                        <tr>
                            <td><?= $dados->id ?></td>
                            <td><?= htmlspecialchars($dados->nome) ?></td>
                            <td><?= htmlspecialchars($dados->email) ?></td>
                            <td><?= htmlspecialchars($dados->cpf) ?></td>
                            <td><?= $dataNasc ?></td>
                            <td><?= $statusBadge ?></td>

                            <td>
                                <a href="cadastrar/usuario/<?= $dados->id ?>" class="btn btn-success btn-sm">
                                    Editar
                                </a>
                            </td>
                        </tr>
                        <?php
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