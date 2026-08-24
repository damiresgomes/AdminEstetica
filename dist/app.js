"use strict";
async function carregarDashboard() {
    try {
        const resposta = await fetch('../api.php');
        if (!resposta.ok) {
            throw new Error(`Erro na requisição: Status ${resposta.status}`);
        }
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
    const receitaTotal = agendamentos.reduce((acumulador, item) => {
        return acumulador + Number(item.valor || 0);
    }, 0);
    const totalAgendamentos = agendamentos.reduce((acumulador) => {
        return acumulador + 1;
    }, 0);
    const elReceita = document.getElementById('card-total-total');
    if (elReceita)
        elReceita.innerText = formatarMoeda(receitaTotal);
    const elAgendamentos = document.getElementById('card-total-agendamentos');
    if (elAgendamentos)
        elAgendamentos.innerText = totalAgendamentos.toString();
    const elClientes = document.getElementById('card-total-clientes');
    if (elClientes)
        elClientes.innerText = dados.totalClientes.toString();
    const elServicos = document.getElementById('card-total-servicos');
    if (elServicos)
        elServicos.innerText = dados.totalServicos.toString();
    const elUsuarios = document.getElementById('card-total-usuarios');
    if (elUsuarios)
        elUsuarios.innerText = dados.totalUsuarios.toString();
    const elMaisVendido = document.getElementById('card-mais-vendido');
    if (elMaisVendido)
        elMaisVendido.innerText = dados.servicoMaisVendido || 'N/A';
}
function exibirTabelaAgendamentos(agendamentos) {
    const tbody = document.getElementById('tabela-agendamentos-body');
    if (!tbody)
        return;
    tbody.innerHTML = '';
    if (agendamentos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">Nenhum agendamento registrado.</td></tr>';
        return;
    }
    agendamentos.forEach((item) => {
        const tr = document.createElement('tr');
        const dataFormatada = new Date(item.data_hora).toLocaleString('pt-BR', {
            dateStyle: 'short',
            timeStyle: 'short'
        });
        tr.innerHTML = `
            <td>#${item.id_agendamento}</td>
            <td class="fw-bold text-dark">${item.cliente}</td>
            <td>${item.modelo_veiculo}</td>
            <td>${item.placa_veiculo}</td>
            <td>${dataFormatada}</td>
            <td>${item.status}</td>
        `;
        tbody.appendChild(tr);
    });
}
function formatarMoeda(valor) {
    return valor.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
}
document.addEventListener('DOMContentLoaded', () => {
    carregarDashboard();
});
