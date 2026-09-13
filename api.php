<?php
//algumas configurações e informando que vai uma aplicação json
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

require_once 'config.php';

try {
    $sqlAgendamentos = "SELECT 
                            a.id_agendamento,
                            a.data_hora,
                            a.placa_veiculo,
                            a.modelo_veiculo,
                            a.status,
                            c.nome AS cliente,
                            s.nome_servico,
                            150.00 AS valor
                        FROM agendamentos a
                        INNER JOIN clientes c ON a.id_cliente = c.id_cliente
                        LEFT JOIN agendamento_servico ags ON a.id_agendamento = ags.id_agendamento
                        LEFT JOIN servicos s ON ags.id_servico = s.id_servico
                        GROUP BY
                            a.id_agendamento
                        ORDER BY a.data_hora DESC";

    $consultaAgendamento = $pdo->prepare($sqlAgendamentos);
    $consultaAgendamento->execute();
    $agendamentos = $consultaAgendamento->fetchAll(PDO::FETCH_ASSOC);

    foreach ($agendamentos as &$ag) {
        $ag['id_agendamento'] = (int) $ag['id_agendamento'];
        $ag['valor'] = (float) $ag['valor'];
    }
    unset($ag);

    $sqlServicoMaisVendido = "SELECT nome_servico, total_vendas FROM vw_servico_mais_vendido";
    $consultaServico = $pdo->query($sqlServicoMaisVendido);
    $dadosServico = $consultaServico ? $consultaServico->fetch(PDO::FETCH_ASSOC) : null;

    if ($dadosServico && isset($dadosServico['nome_servico'])) {
        $servicoMaisVendido = $dadosServico['nome_servico'];
        $totalVendido = (int) $dadosServico['total_vendas'];
    } else {
        $servicoMaisVendido = 'Nenhum serviço';
        $totalVendido = 0;
    }

    $totalClientes = (int) $pdo->query("SELECT COUNT(*) FROM clientes")->fetchColumn();
    $totalServicos = (int) $pdo->query("SELECT COUNT(*) FROM servicos")->fetchColumn();
    $totalUsuarios = (int) $pdo->query("SELECT COUNT(*) FROM usuario WHERE ativo = 'Sim'")->fetchColumn();
    $totalCancelados = (int) $pdo->query("SELECT COUNT(*) FROM agendamentos WHERE LOWER(TRIM(status)) = 'cancelado'")->fetchColumn();

    $resposta = [
        'agendamentos'       => $agendamentos,
        'totalClientes'      => $totalClientes,
        'totalServicos'      => $totalServicos,
        'totalUsuarios'      => $totalUsuarios,
        'servicoMaisVendido' => $servicoMaisVendido,
        'totalVendido'       => $totalVendido,
        'totalCancelados'    => $totalCancelados
    ];

    http_response_code(200);
    echo json_encode($resposta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Erro no banco de dados: " . $e->getMessage()]);
}