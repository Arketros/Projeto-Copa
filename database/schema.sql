-- Tabela de Usuários (Admin/Operadores/Clientes pré-cadastrados)
CREATE TABLE IF NOT EXISTS usuario (
    id_usuario INTEGER PRIMARY KEY AUTOINCREMENT,
    nome_usuario TEXT NOT NULL,
    email_usuario TEXT NOT NULL UNIQUE,
    senha_usuario TEXT NOT NULL,
    nivel_usuario TEXT DEFAULT 'Cliente',
    prioridade_atendimento INTEGER DEFAULT 3 -- 1 Alta, 2 Media, 3 Baixa
);
-- Tabela do Cardápio
CREATE TABLE IF NOT EXISTS cardapio (
    id_cardapio INTEGER PRIMARY KEY AUTOINCREMENT,
    nome_cardapio TEXT NOT NULL,
    situacao_cardapio TEXT NOT NULL,
    categoria_cardapio TEXT,
    imagem_url TEXT,
    total_pedidos INTEGER DEFAULT 0
);
-- Tabela de Salas (para os QR Codes)
CREATE TABLE IF NOT EXISTS sala (
    id_sala INTEGER PRIMARY KEY AUTOINCREMENT,
    nome_sala TEXT NOT NULL,
    hash_url TEXT NOT NULL UNIQUE,
    capacidade INTEGER DEFAULT 6
);
-- Tabela de Solicitações (Pedidos Consolidados)
CREATE TABLE IF NOT EXISTS solicitacao (
    id_solicitacao INTEGER PRIMARY KEY AUTOINCREMENT,
    id_sala INTEGER,
    email_cliente TEXT NOT NULL,
    tipo_encontro TEXT NOT NULL,
    -- Normal, AGM, etc
    quantidade_pessoas INTEGER DEFAULT 1,
    status TEXT DEFAULT 'Pendente',
    -- Pendente, Recebido, Finalizado
    data_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    prioridade_calculada INTEGER DEFAULT 0,
    FOREIGN KEY(id_sala) REFERENCES sala(id_sala)
);
-- Tabela de Itens de cada Solicitação
CREATE TABLE IF NOT EXISTS solicitacao_item (
    id_solicitacao_item INTEGER PRIMARY KEY AUTOINCREMENT,
    id_solicitacao INTEGER,
    id_cardapio INTEGER,
    quantidade INTEGER NOT NULL,
    FOREIGN KEY(id_solicitacao) REFERENCES solicitacao(id_solicitacao),
    FOREIGN KEY(id_cardapio) REFERENCES cardapio(id_cardapio)
);