<?php
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
                            150.00 AS valor
                        FROM agendamentos a
                        INNER JOIN clientes c ON a.id_cliente = c.id_cliente
                        ORDER BY a.data_hora DESC";
    
    $stmt = $pdo->prepare($sqlAgendamentos);
    $stmt->execute();
    $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($agendamentos as &$ag) {
        $ag['id_agendamento'] = (int)$ag['id_agendamento'];
        $ag['valor'] = (float)$ag['valor'];
    }

    $sqlServicoMaisVendido = "
    WITH ContagemServicos AS (
        SELECT 
            s.nome_servico,
            COUNT(ags.id_agendamento) AS total_vendas
        FROM servicos s
        LEFT JOIN agendamento_servico ags ON s.id_servico = ags.id_servico
        GROUP BY s.id_servico, s.nome_servico
    )
    SELECT nome_servico 
    FROM ContagemServicos 
    ORDER BY total_vendas DESC 
    LIMIT 1;
    ";

    $stmtServico = $pdo->query($sqlServicoMaisVendido);
    $servicoMaisVendido = $stmtServico ? $stmtServico->fetchColumn() : null;
    $servicoMaisVendido = $servicoMaisVendido ?: 'Nenhum serviço';

    $totalClientes = $pdo->query("SELECT COUNT(*) FROM clientes")->fetchColumn();
    $totalServicos = $pdo->query("SELECT COUNT(*) FROM servicos")->fetchColumn();
    $totalUsuarios = $pdo->query("SELECT COUNT(*) FROM usuario WHERE ativo = 'Sim'")->fetchColumn();

    $resposta = [
        'agendamentos'  => $agendamentos,
        'totalClientes' => (int)$totalClientes,
        'totalServicos' => (int)$totalServicos,
        'totalUsuarios' => (int)$totalUsuarios,
        'servicoMaisVendido'  => $servicoMaisVendido
    ];

    http_response_code(200);
    echo json_encode($resposta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Erro no banco de dados: " . $e->getMessage()]);
}