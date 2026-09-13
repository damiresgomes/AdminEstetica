<?php
//algumas configurações e informando que vai uma aplicação json
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

require_once 'config.php';

try {
    // 1. Pega o termo digitado (se não houver nada, envia string vazia '')
    $termoBusca = $_GET['busca'] ?? '';

    // 2. Chama a Stored Procedure passando o termo LIMPO
    // A própria procedure faz o CONCAT('%', p_termo, '%')
    $stmt = $pdo->prepare("CALL sp_buscar_agendamentos(:termo)");
    $stmt->bindValue(':termo', $termoBusca);
    $stmt->execute();

    $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    // Converte tipos numéricos para o JSON/TypeScript
    foreach ($agendamentos as &$ag) {
        $ag['id_agendamento'] = (int) $ag['id_agendamento'];
        $ag['valor'] = (float) $ag['valor'];
    }
    unset($ag);

    $sqlServicoMaisVendido = "SELECT nome_servico, total_vendas FROM vw_servico_mais_vendido";
    $consultaServico = $pdo->query($sqlServicoMaisVendido);
    $dadosServico = $consultaServico ? $consultaServico->fetch(PDO::FETCH_ASSOC) : null;

    $servicoMaisVendido = $dadosServico['nome_servico'] ?? 'Nenhum serviço';
    $totalVendido = (int) ($dadosServico['total_vendas'] ?? 0);

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