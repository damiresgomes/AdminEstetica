<?php
if (!isset($page))
    exit;
?>

<div class="container pt-4 pb-5">
    <div class="card mb-4 shadow">
        <div class="card-header">
            <h2 class="m-0">Visão Geral</h2>
        </div>

        <div class="card-body">
            <div class="row g-3">
                <div class="col-12 col-md-3">
                    <?php
                    $sqlCategoria = "SELECT COUNT(id_categoria) as conta FROM categoria";
                    $consultaCategoria = $pdo->prepare($sqlCategoria);
                    $consultaCategoria->execute();

                    $categoria = $consultaCategoria->fetch(PDO::FETCH_OBJ)->conta ?? 0;
                    ?>
                    <div class="alert alert-info text-center p-4 h-100 d-flex flex-column justify-content-between mb-0 shadow-sm">
                        <div>
                            <h2>Categorias</h2>
                            <p class="fs-5">Temos <strong><?= $categoria ?></strong> cadastrada(s)!</p>
                        </div>
                        <a href="cadastrar/categoria" title="Categoria" class="btn btn-info w-100 mt-2">
                            Cadastrar Categorias
                        </a>
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <?php
                    $sqlServicos = "SELECT COUNT(id_servico) as conta FROM servicos";
                    $consultaServicos = $pdo->prepare($sqlServicos);
                    $consultaServicos->execute();

                    $Servicos = $consultaServicos->fetch(PDO::FETCH_OBJ)->conta ?? 0;
                    ?>
                    <div class="alert alert-warning text-center p-4 h-100 d-flex flex-column justify-content-between mb-0 shadow-sm">
                        <div>
                            <h2>Serviços</h2>
                            <p class="fs-5">Temos <strong><?= $Servicos ?></strong> cadastrado(s)!</p>
                        </div>
                        <a href="cadastrar/servicos" title="Serviços" class="btn btn-warning w-100 mt-2">
                            Cadastrar Serviços
                        </a>
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <?php
                    $sqlUsuarios = "SELECT COUNT(id) as conta FROM usuario";
                    $consultaUsuarios = $pdo->prepare($sqlUsuarios);
                    $consultaUsuarios->execute();

                    $Usuarios = $consultaUsuarios->fetch(PDO::FETCH_OBJ)->conta ?? 0;
                    ?>
                    <div class="alert alert-danger text-center p-4 h-100 d-flex flex-column justify-content-between mb-0 shadow-sm">
                        <div>
                            <h2>Usuários</h2>
                            <p class="fs-5">Temos <strong><?= $Usuarios ?></strong> cadastrado(s)!</p>
                        </div>
                        <a href="cadastrar/usuario" title="Usuários" class="btn btn-danger w-100 mt-2">
                            Cadastrar Usuários
                        </a>
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <?php
                    $sqlContatos = "SELECT COUNT(*) as total FROM contatos WHERE lido = 'Nao'";
                    $consultaContatos = $pdo->prepare($sqlContatos);
                    $consultaContatos->execute();

                    $Contatos = $consultaContatos->fetch(PDO::FETCH_OBJ)->total ?? 0;
                    ?>
                    <div class="alert alert-secondary text-center p-4 h-100 d-flex flex-column justify-content-between mb-0 shadow-sm">
                        <div>
                            <h2>Contatos</h2>
                            <p class="fs-5">Temos <strong><?= $Contatos ?></strong> não lido(s)!</p>
                        </div>
                        <a href="listar/contatos" title="Contatos" class="btn btn-secondary text-white w-100 mt-2">
                            Ver Contatos
                        </a>
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <?php
                    $sqlTotal = "SELECT COUNT(*) as total
                                FROM agendamentos";

                    $totalAgendamentos = $pdo->query($sqlTotal)->fetch(PDO::FETCH_OBJ)->total ?? 0;
                    ?>
                    <div class="alert alert-info text-center p-4 h-100 d-flex flex-column justify-content-between mb-0 shadow-sm">
                        <div>
                            <h2>Agendamentos</h2>
                            <p class="fs-5">Temos <strong><?= $totalAgendamentos ?></strong> agendamentos!</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <?php
                    $sqlReceita = "SELECT SUM(s.preco) as total 
                                    FROM agendamentos a 
                                    INNER JOIN agendamento_servico ags ON ags.id_agendamento = a.id_agendamento
                                    INNER JOIN servicos s ON s.id_servico = ags.id_servico
                                    WHERE a.status != 'Cancelado'";
                    $receitaTotal = $pdo->query($sqlReceita)->fetch(PDO::FETCH_OBJ)->total ?? 0;
                    ?>
                    <div class="alert alert-warning text-center p-4 h-100 d-flex flex-column justify-content-between mb-0 shadow-sm">
                        <div>
                            <h2>Receita Total</h2>
                            <p class="fs-5">Temos <strong><?= number_format($receitaTotal, 0, ',', '.') ?></strong> bruta!</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <?php
                    $sqlClientes = "SELECT COUNT(DISTINCT id_cliente) as total
                                    FROM clientes";
                    $clientesUnicos = $pdo->query($sqlClientes)->fetch(PDO::FETCH_OBJ)->total ?? 0;
                    ?>
                    <div class="alert alert-danger text-center bg-ganger-subtle bg-gradient p-4 h-100 d-flex flex-column justify-content-between mb-0 shadow-sm">
                        <div>
                            <h2>Clientes</h2>
                            <p class="fs-5">Temos <strong><?= $clientesUnicos ?></strong> no Sistema!</p>
                        </div>
                    </div>
                </div>

                 <div class="col-12 col-md-3">
                    <?php
                    $ticketMedio = $totalAgendamentos > 0 ? ($receitaTotal / $totalAgendamentos) : 0;
                    ?>
                    <div class="alert alert-secondary text-center p-4 h-100 d-flex flex-column justify-content-between mb-0 shadow-sm">
                        <div>
                            <h2>Ticket Médio</h2>
                            <p class="fs-5">Temos <strong><?= number_format($ticketMedio, 0, ',', '.') ?></strong> por Serviços!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body border-top">
            <h4 class="mb-3">Últimos Agendamentos</h4>
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Cliente</th>
                            <th>Veículo</th>
                            <th>Placa</th>
                            <th>Data / Hora</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlRecentes = "SELECT a.id_agendamento, date_format(a.data_hora, '%d/%m/%Y %H:%i') as data_formatada, a.modelo_veiculo, a.placa_veiculo, a.status, c.nome
                                        FROM agendamentos a
                                        INNER JOIN clientes c ON c.id_cliente = a.id_cliente
                                        ORDER BY a.data_hora DESC
                                        LIMIT 5";
                        $consultaRecentes = $pdo->prepare($sqlRecentes);
                        $consultaRecentes->execute();

                        $dadosRecentes = $consultaRecentes->fetchAll(PDO::FETCH_OBJ);

                        if (count($dadosRecentes) > 0) {
                            foreach ($dadosRecentes as $dados) {
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($dados->nome) ?></td>
                                    <td><?= htmlspecialchars($dados->modelo_veiculo) ?></td>
                                    <td><?= htmlspecialchars($dados->placa_veiculo) ?></td>
                                    <td><?= $dados->data_formatada ?></td>
                                    <td>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($dados->status) ?></span>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Nenhum agendamento recente encontrado.</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>