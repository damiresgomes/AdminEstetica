<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

require_once 'config.php';

try {
    $termoBusca = $_GET['busca'] ?? '';

    $consultaProcedure = $pdo->prepare("CALL sp_buscar_agendamentos(:termo)");
    $consultaProcedure->bindValue(':termo', $termoBusca);
    $consultaProcedure->execute();
    $agendamentos = $consultaProcedure->fetchAll(PDO::FETCH_ASSOC);
    $consultaProcedure->closeCursor();

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