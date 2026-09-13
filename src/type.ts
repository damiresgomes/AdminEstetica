type Agendamento = {
    id_agendamento: number;
    cliente: string;
    nome_servico?: string;
    modelo_veiculo: string;
    placa_veiculo: string;
    valor: number;
    data_hora: string;
    status: string;
};

type DadosDashboard = {
    agendamentos: Agendamento[];
    totalClientes: number;
    totalServicos: number;
    totalUsuarios: number;
    servicoMaisVendido: string;
    totalVendido: number;
    totalCancelados?: number;
};