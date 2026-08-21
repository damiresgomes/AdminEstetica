"use strict";
// ====================================================================
// PASSO 1: FUNÇÃO PARA BUSCAR OS DADOS DO SERVIDOR (API PHP)
// ====================================================================
async function carregarDashboard() {
    try {
        // Faz a requisição HTTP GET usando async/await
        const resposta = await fetch('../api.php');
        if (!resposta.ok) {
            throw new Error(`Erro na requisição: Status ${resposta.status}`);
        }
        // Converte a resposta recebida
        const dados = await resposta.json();
        // Atualiza os Cards (usando reduce para cálculos) e a Tabela
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
// ====================================================================
// PASSO 2: FUNÇÃO PARA CALCULAR AS ESTATÍSTICAS COM .REDUCE() E ATUALIZAR CARDS
// ====================================================================
function atualizarCards(dados) {
    const agendamentos = dados.agendamentos;
    // --- 1. TOTAL DE RECEITA (Calculado com .reduce() para atender a rubrica) ---
    const receitaTotal = agendamentos.reduce((acumulador, item) => {
        return acumulador + Number(item.valor || 0);
    }, 0);
    // --- 2. TOTAL DE AGENDAMENTOS (Calculado com .reduce()) ---
    const totalAgendamentos = agendamentos.reduce((acumulador) => {
        return acumulador + 1;
    }, 0);
    // --- ATUALIZAÇÃO DO HTML (DOM) ---
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
    const elContatos = document.getElementById('card-total-contatos');
    if (elContatos)
        elContatos.innerText = dados.totalContatos.toString();
}
// ====================================================================
// PASSO 3: FUNÇÃO PARA PREENCHER A TABELA USANDO FOR EACH
// ====================================================================
function exibirTabelaAgendamentos(agendamentos) {
    const tbody = document.getElementById('tabela-agendamentos-body');
    if (!tbody)
        return;
    // Limpa a tabela para não duplicar linhas
    tbody.innerHTML = '';
    if (agendamentos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">Nenhum agendamento registrado.</td></tr>';
        return;
    }
    // Cria uma linha <tr> para cada agendamento recebido usando forEach
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
// ====================================================================
// FUNÇÃO AUXILIAR: FORMATAR NÚMERO PARA MOEDA (R$)
// ====================================================================
function formatarMoeda(valor) {
    return valor.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
}
// ====================================================================
// EVENTO: EXECUTA O CÓDIGO ASSIM QUE O HTML TERMINAR DE CARREGAR
// ====================================================================
document.addEventListener('DOMContentLoaded', () => {
    carregarDashboard();
});
