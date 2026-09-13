"use strict";
//a funcao é do tipo promessa void
//recebe uma promessa da api e nao devolve nada
async function carregarDashboard(termoBusca = '') {
    try {
        //a variavel resposta armazena oq o fetch vai buscar no arquivo api.php, com o await que é de espera
        // esta requisição ser feita para armazenar na variavel
        const resposta = await fetch(`../api.php?busca=${encodeURIComponent(termoBusca)}`);
        //verifica se a resposta é ok, se o protocolo esta no codigo 200 ou seja (funcional)
        if (!resposta.ok) {
            throw new Error(`Erro na requisição: Status ${resposta.status}`);
        }
        //await o javascript sabe que tem que esperar essa promise ser resolvida ou rejeitada
        const dados = await resposta.json();
        atualizarCards(dados);
        exibirTabelaAgendamentos(dados.agendamentos);
    }
    catch (erro) {
        console.error('Falha ao carregar a dashboard:', erro);
        const tabelaBody = document.getElementById('tabela-agendamentos-body');
        if (tabelaBody) {
            tabelaBody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-danger py-4">
                        Erro ao carregar os dados da API PHP. Verifique o console.
                    </td>
                </tr>`;
        }
    }
}
function atualizarCards(dados) {
    const agendamentos = dados.agendamentos;
    const receitaTotal = agendamentos
        .filter(ag => String(ag.status || '').trim().toLowerCase() === 'confirmado')
        .reduce((acumulador, item) => acumulador + Number(item.valor || 0), 0);
    const totalConfirmados = agendamentos.filter(ag => ag.status && ag.status.trim().toLowerCase() === 'confirmado').length;
    const totalPendentes = agendamentos.filter(ag => ag.status && ag.status.trim().toLowerCase() === 'pendente').length;
    const listaCards = [
        { id: 'card-agendamentos-confirmados', valor: totalConfirmados.toString() },
        { id: 'card-agendamentos-pendentes', valor: totalPendentes.toString() },
        { id: 'card-total-total', valor: formatarMoeda(receitaTotal) },
        { id: 'card-total-agendamentos', valor: agendamentos.length.toString() },
        { id: 'card-total-clientes', valor: dados.totalClientes.toString() },
        { id: 'card-total-servicos', valor: dados.totalServicos.toString() },
        { id: 'card-total-usuarios', valor: dados.totalUsuarios.toString() },
        { id: 'card-mais-vendido', valor: dados.servicoMaisVendido },
        { id: 'card-total-vendido', valor: `(${dados.totalVendido} vendas)` },
        { id: 'card-agendamentos-cancelados', valor: (dados.totalCancelados ?? 0).toString() }
    ];
    listaCards.forEach((card) => {
        const elemento = document.getElementById(card.id);
        if (elemento) {
            elemento.innerText = card.valor;
        }
    });
}
function exibirTabelaAgendamentos(agendamentos) {
    const tbody = document.getElementById('tabela-agendamentos-body');
    if (!tbody)
        return;
    tbody.innerHTML = '';
    if (agendamentos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted py-4">Nenhum agendamento registrado.</td></tr>';
        return;
    }
    const linhas = agendamentos.map((item) => {
        //new date = obtendo a date e hora atual em js
        //apresenta datas formatada
        const dataFormatada = new Date(item.data_hora).toLocaleString('pt-BR', {
            //um objeto passado como 2 parametro, onde defino algumas configurações
            //um style de data
            dateStyle: 'short',
            timeStyle: 'short'
        });
        const statusLower = item.status?.trim().toLowerCase();
        let badgeClass = 'bg-warning text-dark';
        if (statusLower === 'confirmado') {
            badgeClass = 'bg-success';
        }
        else if (statusLower === 'cancelado') {
            badgeClass = 'bg-danger';
        }
        return `
            <tr>
                <td>#${item.id_agendamento}</td>
                <td class="fw-bold text-dark">${item.cliente}</td>
                <td>${item.nome_servico}</td>
                <td>${item.modelo_veiculo}</td>
                <td>${item.placa_veiculo}</td>
                <td>${dataFormatada}</td>
                <td><span class="badge ${badgeClass}">${item.status}</span></td>
            </tr>
        `;
    });
    tbody.innerHTML = linhas.join('');
}
function formatarMoeda(valor) {
    return valor.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
}
// Escuta o input do usuário e chama a API a cada caractere
document.addEventListener('DOMContentLoaded', () => {
    carregarDashboard();
    const inputBusca = document.getElementById('input-busca');
    inputBusca?.addEventListener('input', () => {
        carregarDashboard(inputBusca.value);
    });
});
